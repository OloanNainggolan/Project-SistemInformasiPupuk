<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of user's messages (grouped by threads)
     * Only show parent messages, replies will be shown inside the thread
     */
    public function index()
    {
        // Get parent messages that are actual conversations (from user or replied by admin)
        // EXCLUDE messages that are system notifications (order status updates)
        $messages = Message::where('user_id', Auth::id())
            ->whereNull('reply_to') // Only parent messages
            ->where('subject', 'NOT LIKE', '%Update Status Pesanan%') // Exclude order status updates
            ->where('subject', 'NOT LIKE', '%Status Pesanan Diperbarui%') // Exclude order status updates
            ->with(['replyToMessage', 'replies'])
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'messages_page');

        // Get ALL notifications from notifications table
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Get system messages (order status updates) and merge with notifications
        $systemMessages = Message::where('user_id', Auth::id())
            ->whereNull('reply_to')
            ->where(function($q) {
                $q->where('subject', 'LIKE', '%Update Status Pesanan%')
                  ->orWhere('subject', 'LIKE', '%Status Pesanan Diperbarui%');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($msg) {
                // Convert Message to notification-like object
                return (object) [
                    'id' => 'msg_' . $msg->id,
                    'type' => 'order',
                    'title' => $msg->subject,
                    'message' => $msg->message,
                    'is_read' => $msg->status === 'read',
                    'created_at' => $msg->created_at,
                    'is_message' => true, // Flag to identify source
                    'message_id' => $msg->id
                ];
            });

        // Merge notifications with system messages
        $allNotifications = $notifications->concat($systemMessages)->sortByDesc('created_at');

        $unreadCount = Message::where('user_id', Auth::id())
            ->fromAdmin()
            ->unread()
            ->count();

        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        // Add unread system messages
        $unreadSystemMessages = Message::where('user_id', Auth::id())
            ->whereNull('reply_to')
            ->where(function($q) {
                $q->where('subject', 'LIKE', '%Update Status Pesanan%')
                  ->orWhere('subject', 'LIKE', '%Status Pesanan Diperbarui%');
            })
            ->where('status', 'unread')
            ->count();

        $unreadNotifications += $unreadSystemMessages;

        return view('user.notifications.index', compact('messages', 'allNotifications', 'unreadCount', 'unreadNotifications'));
    }

    /**
     * Display the specified message thread
     */
    public function show($id)
    {
        // Get the parent message
        $message = Message::with(['user', 'replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }, 'replies.user', 'replyToMessage'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

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

    /**
     * Mark all messages as read
     */
    public function markAllAsRead()
    {
        Message::where('user_id', Auth::id())
            ->fromAdmin()
            ->unread()
            ->update(['status' => 'read']);

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
     * Delete message
     */
    public function destroy($id)
    {
        $message = Message::where('user_id', Auth::id())->findOrFail($id);
        
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
     * Mark notification as read
     */
    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        
        $notification->update([
            'is_read' => true,
            'status' => 'read'
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil ditandai sebagai dibaca'
            ]);
        }

        return redirect()->route('notifikasi')
            ->with('success', 'Notifikasi berhasil ditandai sebagai dibaca');
    }

    /**
     * Mark message as read
     */
    public function markMessageAsRead($id)
    {
        $message = Message::where('user_id', Auth::id())->findOrFail($id);
        
        $message->update([
            'status' => 'read'
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil ditandai sebagai dibaca'
            ]);
        }

        return redirect()->route('notifikasi')
            ->with('success', 'Pesan berhasil ditandai sebagai dibaca');
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
