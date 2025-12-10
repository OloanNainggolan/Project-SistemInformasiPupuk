<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Tampilkan halaman notifikasi admin
     */
    public function index()
    {
        // Ambil pesan dari user (messages table) - hanya parent messages
        $messages = Message::with('user')
            ->fromUser()
            ->whereNull('reply_to') // Only parent messages, not replies
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Ambil kontak dari non-registered user (contacts table)
        $contacts = Contact::orderBy('created_at', 'desc')
            ->get();
        
        // Ambil pesanan baru yang belum dikonfirmasi admin (orders table)
        $newOrders = Order::with(['user', 'product'])
            ->where('confirmed_by_user', true)
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Gabungkan semua notifikasi dengan type
        $notifications = collect();
        
        // Tambahkan messages
        foreach ($messages as $message) {
            // Check if there are unread replies
            $hasUnreadReply = $message->replies->where('sender_type', 'user')->where('status', 'unread')->count() > 0;
            $isUnread = ($message->sender_type === 'user' && $message->status === 'unread') || $hasUnreadReply;
            
            // Get last activity
            $lastActivity = $message->replies->count() > 0 ? $message->replies->last()->created_at : $message->created_at;
            
            // Get preview text from last message in thread
            $previewText = $message->replies->count() > 0 ? $message->replies->last()->message : $message->message;
            
            $notifications->push([
                'id' => $message->id,
                'type' => 'message',
                'status' => $isUnread ? 'unread' : 'read',
                'created_at' => $lastActivity,
                'user' => $message->user,
                'subject' => $message->subject,
                'preview' => $previewText,
                'reply_count' => $message->replies->count(),
                'data' => $message,
            ]);
        }
        
        // Tambahkan contacts
        foreach ($contacts as $contact) {
            $notifications->push([
                'id' => $contact->id,
                'type' => 'contact',
                'status' => $contact->status,
                'created_at' => $contact->created_at,
                'user' => null, // Contact dari non-registered user
                'subject' => 'Pesan dari ' . $contact->nama,
                'preview' => $contact->pesan,
                'data' => $contact,
            ]);
        }
        
        // Tambahkan new orders
        foreach ($newOrders as $order) {
            $notifications->push([
                'id' => $order->id,
                'type' => 'order',
                'status' => 'unread', // Order baru selalu unread
                'created_at' => $order->created_at,
                'user' => $order->user,
                'subject' => 'Pesanan Baru: ' . $order->order_number,
                'preview' => $order->product ? $order->product->nama_produk . ' - ' . $order->quantity . ' Kg' : 'Produk',
                'data' => $order,
            ]);
        }
        
        // Sort by created_at descending
        $notifications = $notifications->sortByDesc('created_at');
        
        // Paginate manually
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $notifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $notifications->forPage($currentPage, $perPage),
            $notifications->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        // Hitung unread
        $unreadCount = Message::fromUser()->unread()->count() + 
                      Contact::where('status', 'unread')->count() +
                      $newOrders->count();
        
        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Tampilkan detail pesan dan thread balasan
     */
    public function show($id)
    {
        $message = Message::with(['user', 'replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }, 'replies.user'])
            ->findOrFail($id);
        
        // Tandai sebagai dibaca jika dari user
        if ($message->sender_type === 'user' && $message->status === 'unread') {
            $message->update(['status' => 'read']);
        }
        
        // Tandai semua replies yang unread sebagai read
        $message->replies()
            ->where('sender_type', 'user')
            ->where('status', 'unread')
            ->update(['status' => 'read']);
        
        return view('admin.notifications.show', compact('message'));
    }

    /**
     * Tampilkan detail kontak
     */
    public function showContact($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Tandai sebagai dibaca
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }
        
        return view('admin.notifications.contact', compact('contact'));
    }

    /**
     * Balas pesan user
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:10',
        ], [
            'message.required' => 'Pesan balasan harus diisi',
            'message.min' => 'Pesan balasan minimal 10 karakter',
        ]);

        $originalMessage = Message::findOrFail($id);

        // Buat pesan balasan dari admin
        Message::create([
            'user_id' => $originalMessage->user_id,
            'sender_type' => 'admin',
            'subject' => 'Re: ' . $originalMessage->subject,
            'message' => $request->message,
            'reply_to' => $id,
            'status' => 'unread', // Unread untuk user
        ]);

        return redirect()->route('admin.notifications.show', $id)
            ->with('success', 'Balasan berhasil dikirim ke user!');
    }

    /**
     * Hapus pesan
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        
        // Delete all replies
        $message->replies()->delete();
        
        // Delete the message
        $message->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dihapus'
            ]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Pesan berhasil dihapus');
    }

    /**
     * Mark message as read
     */
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        
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
     * Mark all messages as read
     */
    public function markAllAsRead()
    {
        Message::fromUser()->unread()->update(['status' => 'read']);
        Contact::where('status', 'unread')->update(['status' => 'read']);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * Delete contact
     */
    public function deleteContact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kontak berhasil dihapus'
            ]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Kontak berhasil dihapus');
    }

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'type' => 'required|in:message,contact,all',
            'ids' => 'required|array',
        ]);

        $deleted = 0;

        if ($request->type === 'message' || $request->type === 'all') {
            $deleted += Message::whereIn('id', $request->ids)->delete();
        }

        if ($request->type === 'contact' || $request->type === 'all') {
            $deleted += Contact::whereIn('id', $request->ids)->delete();
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$deleted} item berhasil dihapus"
            ]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', "{$deleted} item berhasil dihapus");
    }

    /**
     * Tampilkan form kirim notifikasi
     */
    public function create()
    {
        $users = User::orderBy('nama_lengkap')->get();
        $totalUsers = User::count();

        return view('admin.notifications.create', compact('users', 'totalUsers'));
    }

    /**
     * Alias untuk create() - untuk backward compatibility
     */
    public function createSend()
    {
        return $this->create();
    }

    /**
     * Kirim notifikasi ke user tertentu
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,important'
        ]);

        $user = User::findOrFail($validated['user_id']);

        \App\Models\Notification::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'is_read' => false
        ]);

        return redirect()->route('admin.notifications.create')
            ->with('success', "Notifikasi berhasil dikirim ke {$user->nama_lengkap}");
    }

    /**
     * Alias untuk send() - untuk route compatibility
     */
    public function sendNotification(Request $request)
    {
        return $this->send($request);
    }

    /**
     * Broadcast notifikasi ke semua user
     */
    public function sendBroadcast(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,important'
        ]);

        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'message' => $validated['message'],
                'type' => $validated['type'],
                'is_read' => false
            ]);
            $count++;
        }

        return redirect()->route('admin.notifications.create')
            ->with('success', "Notifikasi berhasil dikirim ke {$count} user");
    }

    /**
     * Tampilkan halaman pesan masuk (inbox)
     */
    public function inbox(Request $request)
    {
        $filter = $request->get('filter', 'all');

        // Query dasar untuk messages dari user
        $query = Message::with('user')
            ->fromUser()
            ->whereNull('reply_to');

        // Filter berdasarkan tipe
        if ($filter == 'unread') {
            $query->unread();
        } elseif ($filter == 'contact') {
            // Hanya pesan dari contact form
            $query->whereHas('user', function($q) {
                $q->whereNotNull('id');
            });
        } elseif ($filter == 'new_user') {
            // Notifikasi user baru (simulasi)
            $query->where('subject', 'LIKE', '%User Baru%');
        } elseif ($filter == 'order') {
            // Notifikasi pesanan baru
            $query->where('subject', 'LIKE', '%Pesanan Baru%');
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(20);

        // Hitung total untuk setiap filter
        $totalAll = Message::fromUser()->whereNull('reply_to')->count();
        $totalUnread = Message::fromUser()->whereNull('reply_to')->unread()->count();
        $totalContactMessages = Message::fromUser()->whereNull('reply_to')->whereHas('user')->count();
        $totalNewUsers = User::whereDate('created_at', today())->count();
        $totalNewOrders = Order::where('confirmed_by_user', true)->where('status', 'Pending')->count();

        return view('admin.messages.inbox', compact(
            'messages',
            'filter',
            'totalAll',
            'totalUnread',
            'totalContactMessages',
            'totalNewUsers',
            'totalNewOrders'
        ));
    }

    /**
     * Tampilkan detail pesan
     */
    public function showMessage($id)
    {
        $message = Message::with(['user', 'replies.user'])->findOrFail($id);

        // Tandai sebagai dibaca
        if ($message->sender_type === 'user' && $message->status === 'unread') {
            $message->update(['status' => 'read']);
        }

        // Mark unread replies as read
        $message->replies()
            ->where('sender_type', 'user')
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Balas pesan
     */
    public function replyMessage(Request $request, $id)
    {
        $validated = $request->validate([
            'message' => 'required|string'
        ]);

        $parentMessage = Message::findOrFail($id);

        Message::create([
            'user_id' => $parentMessage->user_id,
            'message' => $validated['message'],
            'sender_type' => 'admin',
            'reply_to' => $parentMessage->id,
            'status' => 'unread'
        ]);

        return redirect()->route('admin.messages.show', $id)
            ->with('success', 'Balasan berhasil dikirim');
    }

    /**
     * Hapus pesan
     */
    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.inbox')
            ->with('success', 'Pesan berhasil dihapus');
    }

    /**
     * Tandai pesan sebagai dibaca
     */
    public function markMessageAsRead($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_type === 'user') {
            $message->update(['status' => 'read']);
        }

        // Also mark replies as read
        $message->replies()
            ->where('sender_type', 'user')
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        return redirect()->back()
            ->with('success', 'Pesan ditandai sebagai dibaca');
    }

    /**
     * Tandai semua pesan sebagai dibaca
     */
    public function markAllMessagesAsRead()
    {
        Message::fromUser()
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        return redirect()->back()
            ->with('success', 'Semua pesan ditandai sebagai dibaca');
    }
}
