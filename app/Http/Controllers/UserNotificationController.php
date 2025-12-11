<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of user's messages (grouped by threads)
     * Only show parent messages, replies will be shown inside the thread
     */
    public function index()
    {
        // Prevent caching
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Get parent messages (conversations) - always fresh
        $messages = Message::where('user_id', Auth::id())
            ->whereNull('reply_to') // Only parent messages
            ->with(['replyToMessage', 'replies'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get system notifications from notifications table - always fresh
        $systemNotifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Debug: Check notification status
        \Log::info('System Notifications:', $systemNotifications->map(function($n) {
            return ['id' => $n->id, 'title' => $n->title, 'is_read' => $n->is_read, 'status' => $n->status];
        })->toArray());

        // Merge and sort by created_at
        $allNotifications = $messages->concat($systemNotifications)
            ->sortByDesc('created_at')
            ->values();

        // Paginate manually
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $notifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $allNotifications->forPage($currentPage, $perPage),
            $allNotifications->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Count unread
        $unreadMessagesCount = Message::where('user_id', Auth::id())
            ->fromAdmin()
            ->unread()
            ->count();
        
        $unreadNotificationsCount = Notification::where('user_id', Auth::id())
            ->where('is_read', 0)
            ->count();

        $unreadCount = $unreadMessagesCount + $unreadNotificationsCount;

        return view('user.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Display the specified notification (Message or System Notification)
     */
    public function show($id)
    {
        // Try to find as Message first
        $message = Message::with(['user', 'replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }, 'replies.user', 'replyToMessage'])
            ->where('user_id', Auth::id())
            ->find($id);

        if ($message) {
            // Mark this message and all unread replies as read
            if ($message->sender_type === 'admin' && $message->status === 'unread') {
                $message->update(['status' => 'read']);
            }
            
            // Mark all unread replies as read
            $message->replies()
                ->where('sender_type', 'admin')
                ->where('status', 'unread')
                ->update(['status' => 'read']);

            return view('user.notifications.show', compact('message'));
        }

        // Try to find as System Notification
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        \Log::info("Notification accessed", [
            'notification_id' => $id,
            'user_id' => Auth::id(),
            'is_read_before' => $notification->is_read,
            'status_before' => $notification->status
        ]);

        // Mark as read - force update with timestamps
        if ($notification->is_read == 0) {
            \DB::table('notifications')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->update([
                    'is_read' => 1,
                    'status' => 'read',
                    'updated_at' => now()
                ]);
            
            // Refresh model to get updated data
            $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
            
            \Log::info("Notification marked as read", [
                'notification_id' => $id,
                'user_id' => Auth::id(),
                'is_read_after' => $notification->is_read,
                'status_after' => $notification->status
            ]);
        }

        return view('user.notifications.show-notification', compact('notification'));
    }

    /**
     * Mark all messages and notifications as read
     */
    public function markAllAsRead()
    {
        // Mark all messages as read
        Message::where('user_id', Auth::id())
            ->fromAdmin()
            ->unread()
            ->update(['status' => 'read']);

        // Mark all system notifications as read - use DB query for reliability
        \DB::table('notifications')
            ->where('user_id', Auth::id())
            ->where('is_read', 0)
            ->update([
                'is_read' => 1,
                'status' => 'read',
                'updated_at' => now()
            ]);

        \Log::info('All notifications marked as read', [
            'user_id' => Auth::id(),
            'timestamp' => now()
        ]);

        return redirect()->route('notifikasi')
            ->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Mark single message as read
     */
    public function markAsRead($id)
    {
        $message = Message::where('user_id', Auth::id())->findOrFail($id);
        
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan telah ditandai sebagai dibaca'
            ]);
        }

        return redirect()->back()->with('success', 'Pesan telah ditandai sebagai dibaca');
    }

    /**
     * Delete message or notification
     */
    public function destroy($id)
    {
        // Try to find as Message first
        $message = Message::where('user_id', Auth::id())->find($id);
        
        if ($message) {
            // Delete all replies first
            $message->replies()->delete();
            
            // Delete the message
            $message->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dihapus'
                ]);
            }

            return redirect()->route('notifikasi')
                ->with('success', 'Pesan berhasil dihapus');
        }

        // Try as Notification
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil dihapus'
            ]);
        }

        return redirect()->route('notifikasi')
            ->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * Bulk delete messages
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:messages,id'
        ]);

        $deleted = Message::where('user_id', Auth::id())
            ->whereIn('id', $request->ids)
            ->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$deleted} pesan berhasil dihapus"
            ]);
        }

        return redirect()->route('notifikasi')
            ->with('success', "{$deleted} pesan berhasil dihapus");
    }

    /**
     * Mark system notification as read
     */
    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        
        if ($notification->is_read == 0) {
            $notification->update(['is_read' => 1, 'status' => 'read']);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi telah ditandai sebagai dibaca'
            ]);
        }

        return redirect()->back()->with('success', 'Notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Delete system notification
     */
    public function destroyNotification($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        
        $notification->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil dihapus'
            ]);
        }

        return redirect()->route('notifikasi')
            ->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * Store a reply to existing message thread
     */
    public function reply(Request $request, $id)
    {
        $parentMessage = Message::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'message' => 'required|string|max:1000'
        ], [
            'message.required' => 'Pesan balasan tidak boleh kosong',
            'message.max' => 'Pesan balasan maksimal 1000 karakter'
        ]);

        $reply = Message::create([
            'user_id' => Auth::id(),
            'subject' => 'Re: ' . $parentMessage->subject,
            'message' => $request->message,
            'sender_type' => 'user',
            'status' => 'unread',
            'reply_to' => $parentMessage->id
        ]);

        return redirect()->route('notifikasi.show', $parentMessage->id)
            ->with('success', 'Balasan berhasil dikirim!');
    }
}
