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
        
        $message = "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "{$emoji} UPDATE STATUS PESANAN {$emoji}\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $message .= "📋 No. Pesanan: #{$order->order_number}\n";
        $message .= "📦 Produk: {$order->product_name}\n";
        $message .= "📊 Jumlah: {$order->quantity} {$order->unit}\n";
        
        // Tampilkan balai desa jika ada
        if ($order->village_office) {
            $message .= "🏛️ Balai Desa: {$order->village_office}\n";
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
            
            if ($order->village_office) {
                $message .= "📍 Lokasi Pengambilan Nantinya:\n";
                $message .= "Balai Desa {$order->village_office}\n";
            }
        } elseif ($newStatus === 'Ready') {
            $message .= "✅ PESANAN SIAP DIAMBIL!\n";
            $message .= "Pesanan Anda sudah siap.\n";
            $message .= "Silakan datang untuk mengambil pesanan.\n\n";
            
            // Tampilkan lokasi pengambilan sesuai pilihan user
            if ($order->village_office) {
                $message .= "📍 Lokasi Pengambilan:\n";
                $message .= "🏛️ Balai Desa {$order->village_office}\n";
            } else {
                $message .= "📍 Lokasi Pengambilan:\n";
                $message .= "Akan dikonfirmasi lebih lanjut\n";
            }
            $message .= "⏰ Jam Operasional: 08.00 - 17.00 WIB\n";
            $message .= "📋 Harap bawa bukti pesanan dan identitas diri\n";
        } elseif ($newStatus === 'Completed') {
            $message .= "🎉 PESANAN SELESAI!\n";
            
            if ($order->village_office) {
                $message .= "Pesanan telah diambil di Balai Desa {$order->village_office}.\n";
            }
            
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
            
            if ($order->village_office) {
                $message .= "📍 Rencana Pengambilan:\n";
                $message .= "Balai Desa {$order->village_office}\n";
            }
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
        $order = Order::with('user')
            ->where('order_number', $orderNumber)
            ->firstOrFail();
        
        return view('admin.orders.detail', compact('order'));
    }
}
