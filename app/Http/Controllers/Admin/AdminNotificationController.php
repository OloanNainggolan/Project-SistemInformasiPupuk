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
     * Tampilkan form kirim notifikasi ke user
     */
    public function createSend()
    {
        // Ambil users, urutkan berdasarkan nama_lengkap atau name
        $users = User::orderBy('nama_lengkap', 'asc')->get();
        return view('admin.notifications.send', compact('users'));
    }

    /**
     * Kirim notifikasi ke user
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:all,specific',
            'user_id' => 'required_if:recipient_type,specific',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
            'priority' => 'required|in:low,normal,high,urgent',
        ], [
            'recipient_type.required' => 'Tipe penerima harus dipilih',
            'user_id.required_if' => 'User harus dipilih ketika mengirim ke user tertentu',
            'subject.required' => 'Judul notifikasi harus diisi',
            'subject.max' => 'Judul notifikasi maksimal 100 karakter',
            'message.required' => 'Isi pesan harus diisi',
            'message.max' => 'Isi pesan maksimal 1000 karakter',
            'priority.required' => 'Prioritas harus dipilih',
        ]);

        $recipients = [];

        // Tentukan penerima
        if ($request->recipient_type === 'all') {
            $recipients = User::all();
        } else {
            $recipients = User::where('id', $request->user_id)->get();
        }

        // Kirim notifikasi ke setiap penerima
        $sentCount = 0;
        foreach ($recipients as $user) {
            Message::create([
                'user_id' => $user->id,
                'sender_type' => 'admin',
                'subject' => $request->subject,
                'message' => $request->message,
                'priority' => $request->priority,
                'status' => 'unread',
            ]);
            $sentCount++;
        }

        return redirect()->route('admin.notifications.send')
            ->with('success', "Notifikasi berhasil dikirim ke {$sentCount} user!");
    }

    /**
     * Tampilkan kotak masuk notifikasi dari user
     */
    public function inbox(Request $request)
    {
        // Get filter parameters
        $sortBy = $request->get('sort', 'latest'); // latest, oldest, name_asc, name_desc
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        
        // Ambil pesan dari user (messages table) - hanya parent messages
        $messagesQuery = Message::with('user')->fromUser()->whereNull('reply_to');
        if ($dateFrom) $messagesQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $messagesQuery->whereDate('created_at', '<=', $dateTo);
        $messages = $messagesQuery->get();
        
        // Ambil kontak dari non-registered user (contacts table)
        $contactsQuery = Contact::query();
        if ($dateFrom) $contactsQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $contactsQuery->whereDate('created_at', '<=', $dateTo);
        $contacts = $contactsQuery->get();
        
        // Ambil SEMUA pesanan dari user (tidak hanya pending)
        $ordersQuery = Order::with(['user', 'product'])->where('confirmed_by_user', true);
        if ($dateFrom) $ordersQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo) $ordersQuery->whereDate('created_at', '<=', $dateTo);
        $orders = $ordersQuery->get();
        
        // Ambil user baru yang mendaftar (30 hari terakhir atau berdasarkan filter tanggal)
        $newUsersQuery = User::query();
        if ($dateFrom) {
            $newUsersQuery->whereDate('created_at', '>=', $dateFrom);
        } else {
            $newUsersQuery->where('created_at', '>=', now()->subDays(30));
        }
        if ($dateTo) $newUsersQuery->whereDate('created_at', '<=', $dateTo);
        $newUsers = $newUsersQuery->get();
        
        // Gabungkan semua notifikasi
        $notifications = collect();
        
        // Tambahkan messages
        foreach ($messages as $message) {
            $hasUnreadReply = $message->replies->where('sender_type', 'user')->where('status', 'unread')->count() > 0;
            $isUnread = ($message->sender_type === 'user' && $message->status === 'unread') || $hasUnreadReply;
            $lastActivity = $message->replies->count() > 0 ? $message->replies->last()->created_at : $message->created_at;
            
            $notifications->push([
                'id' => $message->id,
                'type' => 'message',
                'status' => $isUnread ? 'unread' : 'read',
                'sender_name' => $message->user->name ?? 'User',
                'content' => $message->message,
                'time' => $lastActivity->diffForHumans(),
                'link' => route('admin.notifications.show', $message->id),
                'order_number' => null,
            ]);
        }
        
        // Tambahkan contacts
        foreach ($contacts as $contact) {
            $notifications->push([
                'id' => 'contact_' . $contact->id,
                'type' => 'contact',
                'status' => $contact->status,
                'sender_name' => $contact->nama,
                'content' => $contact->pesan,
                'created_at' => $contact->created_at,
                'time' => $contact->created_at->diffForHumans(),
                'link' => route('admin.notifications.contact', $contact->id),
                'order_number' => null,
            ]);
        }
        
        // Tambahkan SEMUA orders (tidak hanya pending)
        foreach ($orders as $order) {
            $statusLabel = $order->status == 'Pending' ? 'Pesanan baru' : 'Pesanan ' . $order->status;
            $notifications->push([
                'id' => 'order_' . $order->id,
                'type' => 'order',
                'status' => $order->status == 'Pending' ? 'unread' : 'read',
                'sender_name' => $order->user->nama_lengkap ?? $order->user->name ?? 'User',
                'content' => $statusLabel . ': ' . ($order->product ? $order->product->nama_produk : 'Produk') . ' - ' . $order->quantity . ' Kg',
                'created_at' => $order->created_at,
                'time' => $order->created_at->diffForHumans(),
                'link' => route('admin.orders.show', $order->order_number),
                'order_number' => $order->order_number,
            ]);
        }
        
        // Tambahkan user baru yang mendaftar
        foreach ($newUsers as $user) {
            $notifications->push([
                'id' => 'user_' . $user->id,
                'type' => 'new_user',
                'status' => 'read',
                'sender_name' => $user->nama_lengkap ?? $user->name ?? 'User Baru',
                'content' => 'Pengguna baru mendaftar: ' . ($user->email ?? 'Email tidak tersedia'),
                'created_at' => $user->created_at,
                'time' => $user->created_at->diffForHumans(),
                'link' => '#',
                'order_number' => null,
            ]);
        }
        
        // Apply sorting
        if ($sortBy === 'latest') {
            $notifications = $notifications->sortByDesc('created_at');
        } elseif ($sortBy === 'oldest') {
            $notifications = $notifications->sortBy('created_at');
        } elseif ($sortBy === 'name_asc') {
            $notifications = $notifications->sortBy('sender_name');
        } elseif ($sortBy === 'name_desc') {
            $notifications = $notifications->sortByDesc('sender_name');
        }
        
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
        
        // Hitung stats
        $totalCount = $notifications->total();
        $unreadCount = Message::fromUser()->unread()->count() + 
                      Contact::where('status', 'unread')->count() +
                      Order::where('confirmed_by_user', true)->where('status', 'Pending')->count();
        
        return view('admin.notifications.inbox', compact(
            'notifications', 
            'totalCount',
            'unreadCount',
            'sortBy',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Tampilkan halaman notifikasi admin (redirect ke inbox)
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
}
