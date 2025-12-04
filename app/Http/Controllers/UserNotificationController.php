<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    /**
     * Display a listing of user's messages (grouped by threads)
     * Only show parent messages, replies will be shown inside the thread
     */
    public function index()
    {
        // Only get parent messages (not replies)
        $messages = Message::where('user_id', Auth::id())
            ->whereNull('reply_to') // Only parent messages
            ->with(['replyToMessage', 'replies'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $unreadCount = Message::where('user_id', Auth::id())
            ->fromAdmin()
            ->unread()
            ->count();

        return view('user.notifications.index', compact('messages', 'unreadCount'));
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

        return redirect()->route('user.notifications.index')
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

        return redirect()->route('user.notifications.index')
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

        return redirect()->route('user.notifications.index')
            ->with('success', "{$deleted} pesan berhasil dihapus");
    }
}
