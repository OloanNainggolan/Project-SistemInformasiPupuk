<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        return view('admin.notifications.send', compact('users', 'totalUsers'));
    }

    /**
     * Alias untuk create() - untuk backward compatibility
     */
    public function createSend()
    {
        return $this->create();
    }

    /**
     * Kirim notifikasi ke user tertentu atau semua user
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'recipient_type' => 'required|in:all,specific',
            'user_id' => 'required_if:recipient_type,specific|nullable|exists:users,id',
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,important'
        ], [
            'recipient_type.required' => 'Tipe penerima wajib dipilih',
            'user_id.required_if' => 'User wajib dipilih ketika mengirim ke user tertentu',
            'title.required' => 'Judul notifikasi wajib diisi',
            'message.required' => 'Isi pesan wajib diisi',
            'type.required' => 'Tipe notifikasi wajib dipilih'
        ]);

        // Format pesan dengan template yang menarik
        $formattedMessage = $this->formatAnnouncementMessage(
            $validated['title'],
            $validated['message'],
            $validated['type']
        );

        // Jika kirim ke semua user
        if ($validated['recipient_type'] === 'all') {
            $users = User::all();
            $count = 0;

            foreach ($users as $user) {
                Message::create([
                    'user_id' => $user->id,
                    'subject' => $validated['title'],
                    'message' => $formattedMessage,
                    'status' => 'unread'
                ]);
                $count++;
            }

            return redirect()->route('admin.notifications.send')
                ->with('success', "📢 Pengumuman berhasil dikirim ke {$count} user");
        }

        // Jika kirim ke user spesifik
        $user = User::findOrFail($validated['user_id']);

        Message::create([
            'user_id' => $validated['user_id'],
            'subject' => $validated['title'],
            'message' => $formattedMessage,
            'status' => 'unread'
        ]);

        return redirect()->route('admin.notifications.send')
            ->with('success', "📢 Pengumuman berhasil dikirim ke {$user->nama_lengkap}");
    }

    /**
     * Alias untuk send() - untuk route compatibility
     */
    public function sendNotification(Request $request)
    {
        return $this->send($request);
    }

    /**
     * Broadcast notifikasi ke semua user dengan format yang menarik
     */
    public function sendBroadcast(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,important'
        ]);

        // Format pesan dengan template yang menarik
        $formattedMessage = $this->formatAnnouncementMessage(
            $validated['title'],
            $validated['message'],
            $validated['type']
        );

        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            // Create preview: combine title and message content
            $preview = $validated['title'] . ': ' . Str::limit($validated['message'], 80);
            
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => $preview, // Combined title + message for list preview
                'message' => $formattedMessage, // Full formatted message for detail
                'type' => $validated['type'],
                'is_read' => false,
                'status' => 'unread'
            ]);
            $count++;
        }

        return redirect()->route('admin.notifications.send')
            ->with('success', "📢 Pengumuman berhasil dikirim ke {$count} user");
    }

    /**
     * Format announcement message dengan template yang menarik
     */
    private function formatAnnouncementMessage($title, $message, $type)
    {
        // Icon dan warna berdasarkan tipe
        $typeConfig = [
            'info' => [
                'emoji' => 'ℹ️',
                'label' => '[INFO] INFORMASI',
                'border' => '━'
            ],
            'success' => [
                'emoji' => '✅',
                'label' => '[SUKSES] PENGUMUMAN PENTING',
                'border' => '━'
            ],
            'warning' => [
                'emoji' => '⚠️',
                'label' => '[PERINGATAN] PERHATIAN',
                'border' => '━'
            ],
            'important' => [
                'emoji' => '🔴',
                'label' => '[URGENT] PENGUMUMAN URGENT',
                'border' => '━'
            ]
        ];

        $config = $typeConfig[$type] ?? $typeConfig['info'];
        $emoji = $config['emoji'] ?? '';
        $label = $config['label'];
        $border = str_repeat($config['border'], 30);

        // Build formatted message
        $formatted = "{$border}\n";
        $formatted .= "{$label}\n";
        $formatted .= "{$border}\n\n";
        
        $formatted .= "{$title}\n\n";
        $formatted .= "{$border}\n\n";
        
        // Format message content
        $formatted .= $message . "\n\n";
        
        $formatted .= "{$border}\n";
        $formatted .= "Dikirim: " . now()->format('d M Y, H:i') . " WIB\n";
        $formatted .= "Dari: Admin Sistem\n";
        $formatted .= "{$border}\n\n";
        
        // Add footer based on type
        if ($type === 'important' || $type === 'warning') {
            $formatted .= ">> Harap membaca dengan seksama!\n";
        } else {
            $formatted .= "💡 Terima kasih atas perhatiannya.\n";
        }
        
        $formatted .= "📞 Hubungi admin jika ada pertanyaan.\n";

        return $formatted;
    }

    /**
     * Tampilkan halaman pesan masuk (inbox)
     */
    public function inbox(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $sortBy = $request->get('sort', 'latest');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        // Query dasar untuk messages dari user
        $query = Message::with('user')
            ->fromUser()
            ->whereNull('reply_to');

        // Filter berdasarkan tanggal
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

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

        // Sorting
        if ($sortBy == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sortBy == 'name_asc') {
            $query->join('users', 'messages.user_id', '=', 'users.id')
                ->orderBy('users.nama_lengkap', 'asc')
                ->select('messages.*');
        } elseif ($sortBy == 'name_desc') {
            $query->join('users', 'messages.user_id', '=', 'users.id')
                ->orderBy('users.nama_lengkap', 'desc')
                ->select('messages.*');
        } else {
            // Default: latest
            $query->orderBy('created_at', 'desc');
        }

        $messages = $query->paginate(20);

        // Transform messages to notifications format
        $notifications = collect($messages->items())->map(function($message) {
            $hasUnreadReply = $message->replies->where('sender_type', 'user')->where('status', 'unread')->count() > 0;
            $isUnread = ($message->sender_type === 'user' && $message->status === 'unread') || $hasUnreadReply;
            $lastActivity = $message->replies->count() > 0 ? $message->replies->last()->created_at : $message->created_at;
            $previewText = $message->replies->count() > 0 ? $message->replies->last()->message : $message->message;
            
            return [
                'id' => $message->id,
                'type' => 'message',
                'status' => $isUnread ? 'unread' : 'read',
                'sender_name' => $message->user ? $message->user->nama_lengkap : 'Unknown',
                'content' => $previewText,
                'time' => $lastActivity->diffForHumans(),
                'link' => route('admin.notifications.show', $message->id),
                'order_number' => null,
            ];
        });

        // Create paginator for notifications
        $notifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $notifications,
            $messages->total(),
            $messages->perPage(),
            $messages->currentPage(),
            ['path' => $messages->path(), 'query' => $messages->getOptions()['query'] ?? []]
        );

        // Hitung total untuk setiap filter
        $totalAll = Message::fromUser()->whereNull('reply_to')->count();
        $totalUnread = Message::fromUser()->whereNull('reply_to')->unread()->count();
        $totalContactMessages = Message::fromUser()->whereNull('reply_to')->whereHas('user')->count();
        $totalNewUsers = User::whereDate('created_at', today())->count();
        $totalNewOrders = Order::where('confirmed_by_user', true)->where('status', 'Pending')->count();

        // Total count dan unread count untuk header
        $totalCount = $totalAll;
        $unreadCount = $totalUnread;

        return view('admin.notifications.inbox', compact(
            'notifications',
            'filter',
            'sortBy',
            'dateFrom',
            'dateTo',
            'totalAll',
            'totalUnread',
            'totalContactMessages',
            'totalNewUsers',
            'totalNewOrders',
            'totalCount',
            'unreadCount'
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

        return view('admin.notifications.show', compact('message'));
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

        return redirect()->route('admin.notifications.show', $id)
            ->with('success', 'Balasan berhasil dikirim');
    }

    /**
     * Hapus pesan
     */
    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.notifications.inbox')
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
