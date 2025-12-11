<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Tampilkan halaman manajemen pesanan
     */
    public function index(Request $request)
    {
        $query = $request->input('search', '');
        $status = $request->input('status', 'all');
        
        $ordersQuery = Order::with(['user', 'product'])
            ->where('confirmed_by_user', true);
        
        // Search
        if (!empty($query)) {
            $ordersQuery->where(function($q) use ($query) {
                $q->where('order_number', 'like', "%{$query}%")
                  ->orWhere('customer_name', 'like', "%{$query}%")
                  ->orWhere('customer_phone', 'like', "%{$query}%");
            });
        }
        
        // Filter by status
        if ($status !== 'all') {
            $ordersQuery->where('status', $status);
        }
        
        $orders = $ordersQuery->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistics
        $stats = [
            'total' => Order::where('confirmed_by_user', true)->count(),
            'pending' => Order::where('confirmed_by_user', true)->where('status', 'Pending')->count(),
            'processing' => Order::where('confirmed_by_user', true)->where('status', 'Processing')->count(),
            'ready' => Order::where('confirmed_by_user', true)->where('status', 'Ready')->count(),
            'completed' => Order::where('confirmed_by_user', true)->where('status', 'Completed')->count(),
            'rejected' => Order::where('confirmed_by_user', true)->where('status', 'Rejected')->count(),
        ];
        
        return view('admin.orders.index', compact('orders', 'stats', 'status', 'query'));
    }

    /**
     * API: Get orders list dengan search, filter, pagination
     * GET /api/admin/orders?query=&status=&page=1&limit=10
     */
    public function getOrders(Request $request)
    {
        $query = $request->input('query', '');
        $status = $request->input('status', 'all');
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $sort = $request->input('sort', 'newest');
        $type = $request->input('type', 'all');

        $ordersQuery = Order::with(['user', 'product']) // Eager load user dan product
            ->where('confirmed_by_user', true); // Hanya yang confirmed

        // Search query
        if (!empty($query)) {
            $ordersQuery->where(function($q) use ($query) {
                $q->where('order_number', 'like', "%{$query}%")
                  ->orWhere('customer_name', 'like', "%{$query}%")
                  ->orWhere('customer_phone', 'like', "%{$query}%")
                  ->orWhereHas('user', function($userQuery) use ($query) {
                      $userQuery->where('name', 'like', "%{$query}%");
                  });
            });
        }

        // Filter by status
        if ($status !== 'all') {
            $ordersQuery->where('status', $status);
        }

        // Filter by product type (pupuk/bibit)
        if ($type !== 'all') {
            $ordersQuery->whereHas('product', function($productQuery) use ($type) {
                $productQuery->where('tipe_produk', $type);
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $ordersQuery->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $ordersQuery->orderBy('customer_name', 'asc');
                break;
            case 'name_desc':
                $ordersQuery->orderBy('customer_name', 'desc');
                break;
            case 'amount_low':
                $ordersQuery->orderBy('total_amount', 'asc');
                break;
            case 'amount_high':
                $ordersQuery->orderBy('total_amount', 'desc');
                break;
            case 'newest':
            default:
                $ordersQuery->orderBy('created_at', 'desc');
                break;
        }

        $orders = $ordersQuery->paginate($limit);

        $formattedOrders = $orders->map(function ($order) {
            // Format items dari relasi product (real data dari database)
            $items = [];
            if ($order->product) {
                $items[] = [
                    'name' => $order->product->nama_produk,
                    'type' => $order->product->tipe_produk, // pupuk atau bibit
                    'category' => $order->product->kategori,
                    'qty' => $order->quantity,
                    'price' => $order->unit_price,
                    'subtotal' => $order->subtotal,
                    'image' => $order->product->gambar ? asset('images/products/' . $order->product->gambar) : null,
                ];
            }

            return [
                'id' => $order->order_number,
                'user_id' => $order->user_id,
                'name' => $order->customer_name ?? ($order->user->name ?? 'Unknown User'),
                'phone' => $order->customer_phone ?? ($order->user->no_telp ?? '-'),
                'address' => $order->customer_address ?? '-',
                'notes' => $order->customer_notes ?? '-',
                'date' => $order->created_at->toIso8601String(),
                'date_formatted' => $order->created_at->format('d M Y, H:i'),
                'items' => $items, // Data produk dari relasi database
                'total_amount' => $order->total_amount,
                'total_formatted' => 'Rp ' . number_format($order->total_amount, 0, ',', '.'),
                'status' => $order->status,
                'status_color' => $this->getStatusColor($order->status),
                'confirmed_by_user' => $order->confirmed_by_user,
                'rejection_reason' => $order->rejection_reason,
            ];
        });

        return response()->json([
            'page' => $orders->currentPage(),
            'limit' => $orders->perPage(),
            'total' => $orders->total(),
            'last_page' => $orders->lastPage(),
            'orders' => $formattedOrders,
        ]);
    }

    /**
     * Update order status
     * PATCH /admin/orders/:orderId/status
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Ready,Completed,Rejected',
        ], [
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        // Cari order by order_number
        $order = Order::where('order_number', $orderId)->firstOrFail();

        // Update status
        $oldStatus = $order->status;
        $newStatus = $request->status;
        $order->status = $newStatus;
        $order->save();

        // Kirim notifikasi ke user bahwa status pesanan telah diupdate
        $this->sendOrderStatusNotification($order, $oldStatus, $newStatus);

        // Jika request adalah JSON/AJAX, return JSON response
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Status pesanan {$orderId} berhasil diubah dari {$oldStatus} ke {$newStatus}",
                'order' => $order
            ]);
        }

        return redirect()->route('admin.orders')
            ->with('success', "Status pesanan {$orderId} berhasil diubah dari {$oldStatus} ke {$newStatus}");
    }

    /**
     * Get status color helper
     */
    private function getStatusColor($status)
    {
        $colors = [
            'Pending' => '#9e9e9e',
            'Processing' => '#9c27b0',
            'Ready' => '#4caf50',
            'Completed' => '#2e7d32',
            'Rejected' => '#f44336',
        ];
        
        return $colors[$status] ?? '#9e9e9e';
    }

    /**
     * API: Get order statistics
     */
    public function getStats()
    {
        $totalOrders = Order::where('confirmed_by_user', true)->count();
        $pendingOrders = Order::where('confirmed_by_user', true)->where('status', 'Pending')->count();
        $processingOrders = Order::where('confirmed_by_user', true)->where('status', 'Processing')->count();
        $readyOrders = Order::where('confirmed_by_user', true)->where('status', 'Ready')->count();
        $completedOrders = Order::where('confirmed_by_user', true)->where('status', 'Completed')->count();
        $rejectedOrders = Order::where('confirmed_by_user', true)->where('status', 'Rejected')->count();

        return response()->json([
            'total' => $totalOrders,
            'pending' => $pendingOrders,
            'processing' => $processingOrders,
            'ready' => $readyOrders,
            'completed' => $completedOrders,
            'rejected' => $rejectedOrders,
        ]);
    }

    /**
     * Send order status update notification to user
     */
    private function sendOrderStatusNotification($order, $oldStatus, $newStatus)
    {
        // Status messages dalam Bahasa Indonesia
        $statusMessages = [
            'Pending' => 'Menunggu Konfirmasi',
            'Processing' => 'Sedang Diproses',
            'Ready' => 'Siap Diambil',
            'Completed' => 'Selesai',
            'Rejected' => 'Ditolak',
        ];

        // Emoji untuk setiap status
        $statusEmoji = [
            'Pending' => '⏳',
            'Processing' => '⚙️',
            'Ready' => '✅',
            'Completed' => '🎉',
            'Rejected' => '❌',
        ];

        // Buat pesan yang menarik dan informatif
        $emoji = $statusEmoji[$newStatus] ?? '📦';
        
        // Get product name from relationship or items JSON
        $productName = 'Produk';
        if ($order->product && $order->product->nama_produk) {
            $productName = $order->product->nama_produk;
        } else {
            // Try to get from items JSON
            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
            if (is_array($items) && count($items) > 0 && isset($items[0]['product_name'])) {
                $productName = $items[0]['product_name'];
            }
        }
        
        $message = "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "{$emoji} UPDATE STATUS PESANAN {$emoji}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $message .= "📋 No. Pesanan: #{$order->order_number}\n";
        $message .= "📦 Produk: {$productName}\n";
        $message .= "📊 Jumlah: {$order->quantity} kg\n";
        
        // Tampilkan balai desa jika ada dari customer_address
        if (!empty($order->customer_address) && stripos($order->customer_address, 'balai desa') !== false) {
            $message .= "🏛️ Balai Desa: {$order->customer_address}\n";
        }
        
        $message .= "\n";
        
        $message .= "🔄 Status Lama: {$statusEmoji[$oldStatus]} {$statusMessages[$oldStatus]}\n";
        $message .= "✨ Status Baru: {$emoji} {$statusMessages[$newStatus]}\n\n";
        
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        
        // Pesan khusus berdasarkan status
        if ($newStatus === 'Processing') {
            $message .= "⚙️ INFORMASI:\n";
            $message .= "Pesanan Anda sedang diproses oleh tim kami.\n";
            $message .= "Harap menunggu informasi selanjutnya.\n";
            $message .= "Estimasi proses: 1-3 hari kerja.\n\n";
            
            $message .= "📍 Lokasi Pengambilan Nantinya:\n";
            $message .= "Balai Desa (Akan dikonfirmasi)\n";
        } elseif ($newStatus === 'Ready') {
            $message .= "✅ PESANAN SIAP DIAMBIL!\n";
            $message .= "Pesanan Anda sudah siap.\n";
            $message .= "Silakan datang untuk mengambil pesanan.\n\n";
            
            $message .= "📍 Lokasi Pengambilan:\n";
            $message .= "Balai Desa (Sesuai alamat pengiriman)\n";
            $message .= "⏰ Jam Operasional: 08.00 - 17.00 WIB\n";
            $message .= "📋 Harap bawa bukti pesanan dan identitas diri\n";
        } elseif ($newStatus === 'Completed') {
            $message .= "🎉 PESANAN SELESAI!\n";
            $message .= "Pesanan telah diambil di Balai Desa.\n";
            $message .= "Terima kasih atas kepercayaan Anda!\n";
            $message .= "Semoga produk kami bermanfaat.\n\n";
            $message .= "💬 Silakan berikan ulasan Anda untuk membantu kami meningkatkan layanan.\n";
        } elseif ($newStatus === 'Rejected') {
            $message .= "❌ PESANAN DITOLAK\n";
            $message .= "Mohon maaf, pesanan Anda tidak dapat diproses.\n";
            $message .= "Silakan hubungi admin untuk informasi lebih lanjut.\n\n";
            $message .= "📞 Hubungi kami untuk klarifikasi.\n";
        } elseif ($newStatus === 'Pending') {
            $message .= "⏳ MENUNGGU KONFIRMASI\n";
            $message .= "Pesanan Anda telah diterima dan menunggu konfirmasi.\n";
            $message .= "Tim kami akan segera memproses pesanan Anda.\n\n";
            $message .= "📍 Rencana Pengambilan:\n";
            $message .= "Balai Desa (Sesuai alamat pengiriman)\n";
        }
        
        $message .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "💡 Tip: Anda dapat membalas pesan ini jika ada pertanyaan.\n";

        // Buat subject yang menarik
        $subject = "{$emoji} Update Status Pesanan #{$order->order_number} - {$statusMessages[$newStatus]}";

        Message::create([
            'user_id' => $order->user_id,
            'sender_type' => 'admin',
            'subject' => $subject,
            'message' => $message,
            'status' => 'unread',
            'reply_to' => null,
        ]);
    }
    
    /**
     * Tampilkan detail pesanan
     */
    public function show($orderNumber)
    {
        $order = Order::with(['user', 'product'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();
        
        return view('admin.orders.detail', compact('order'));
    }

    /**
     * Halaman Daftar Pesanan
     */
    public function daftarpesanan(Request $request)
    {
        $query = Order::with(['user', 'product']);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search by order ID or user name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nama_lengkap', 'like', "%{$search}%")
                                ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        // Sort by created_at desc (newest first)
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.daftarpesanan', compact('orders'));
    }

    /**
     * Update order status via AJAX
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Processing,Ready for Pickup,Completed,Cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        // Update status
        $order->status = $newStatus;
        $order->save();

        // Kirim notifikasi ke user
        $this->sendNotificationToUser($order, $oldStatus, $newStatus);

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diupdate',
            'new_status' => $newStatus
        ]);
    }

    /**
     * Show order details via AJAX
     */
    public function showOrder($id)
    {
        $order = Order::with(['user', 'product'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'user_name' => $order->user->nama_lengkap ?? 'N/A',
                'user_phone' => $order->user->no_telp ?? 'N/A',
                'user_address' => $order->user->alamat ?? 'N/A',
                'product_name' => $order->product->nama_produk ?? 'N/A',
                'quantity' => $order->quantity,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'items' => $order->items ? json_decode($order->items, true) : [],
                'created_at' => $order->created_at->format('d M Y H:i'),
                'updated_at' => $order->updated_at->format('d M Y H:i')
            ]
        ]);
    }

    /**
     * Delete order via AJAX
     */
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Kirim notifikasi sebelum hapus
        Message::create([
            'user_id' => $order->user_id,
            'sender_type' => 'admin',
            'subject' => "Pesanan #{$order->id} Dihapus",
            'message' => "Pesanan Anda dengan ID #{$order->id} telah dihapus oleh admin.",
            'status' => 'unread',
            'reply_to' => null
        ]);

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }

    /**
     * Send notification to user about status change
     * Uses the same detailed format as sendOrderStatusNotification
     */
    private function sendNotificationToUser($order, $oldStatus, $newStatus)
    {
        // Panggil method yang sama untuk konsistensi
        $this->sendOrderStatusNotification($order, $oldStatus, $newStatus);
    }

    /**
     * Halaman Pesan Masuk - Kelola Pesanan
     */
    public function pesanMasuk(Request $request)
    {
        $query = Order::with(['user', 'product'])
            ->where('confirmed_by_user', true);

        // Filter pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistik
        $totalPesanan = Order::where('confirmed_by_user', true)->count();
        $pendingCount = Order::where('confirmed_by_user', true)->where('status', 'Pending')->count();
        $processingCount = Order::where('confirmed_by_user', true)->where('status', 'Processing')->count();
        $readyCount = Order::where('confirmed_by_user', true)->where('status', 'Ready')->count();
        $completedCount = Order::where('confirmed_by_user', true)->where('status', 'Completed')->count();
        $rejectedCount = Order::where('confirmed_by_user', true)->where('status', 'Rejected')->count();

        return view('admin.pesanmasuk', compact(
            'orders',
            'totalPesanan',
            'pendingCount',
            'processingCount',
            'readyCount',
            'completedCount',
            'rejectedCount'
        ));
    }

    /**
     * Update status pesanan dari halaman pesan masuk
     */
    public function updatePesanStatus(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        $request->validate([
            'status' => 'required|in:Pending,Processing,Ready,Completed,Rejected'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->status = $newStatus;
        $order->save();

        // Kirim notifikasi ke user
        $this->sendNotificationToUser($order, $oldStatus, $newStatus);

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diubah'
        ]);
    }

    /**
     * Tampilkan detail pesanan (JSON)
     */
    public function showPesan($orderNumber)
    {
        $order = Order::with(['user', 'product'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'quantity' => $order->quantity,
                'total_amount' => $order->total_amount,
                'delivery_address' => $order->delivery_address,
                'delivery_notes' => $order->delivery_notes,
                'payment_method' => $order->payment_method,
                'created_at' => $order->created_at->toIso8601String(),
                'user' => [
                    'id' => $order->user->id,
                    'name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone ?? '-'
                ],
                'product' => [
                    'id' => $order->product->id_produk,
                    'nama_produk' => $order->product->nama_produk,
                    'kategori' => $order->product->kategori,
                    'tipe_produk' => $order->product->tipe_produk,
                    'harga_subsidi' => $order->product->harga_subsidi,
                    'satuan' => $order->product->satuan,
                    'gambar' => $order->product->gambar
                ]
            ]
        ]);
    }

    /**
     * Hapus pesanan dari halaman pesan masuk
     */
    public function deletePesan($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Kirim notifikasi penghapusan ke user
        Message::create([
            'user_id' => $order->user_id,
            'sender_type' => 'admin',
            'subject' => "Pesanan #{$order->order_number} Dihapus",
            'message' => "Pesanan Anda dengan nomor <strong>#{$order->order_number}</strong> telah dihapus oleh admin. Jika ada pertanyaan, silakan hubungi customer service kami.",
            'status' => 'unread',
            'reply_to' => null
        ]);

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }
}
