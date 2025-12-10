<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Message;
use App\Traits\TrackAdminActivity;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    use TrackAdminActivity;

    /**
     * Tampilkan halaman manajemen pesanan dengan filter, search, dan pagination
     */
    public function index(Request $request)
    {
        $query = $request->input('search', '');
        $status = $request->input('status', 'all');
        $sort = $request->input('sort', 'newest');
        $type = $request->input('type', 'all');
        
        $ordersQuery = Order::with(['user', 'product'])
            ->where('confirmed_by_user', true);
        
        // Search
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
        
        $orders = $ordersQuery->paginate(15);
        
        // Statistics
        $stats = [
            'total' => Order::where('confirmed_by_user', true)->count(),
            'pending' => Order::where('confirmed_by_user', true)->where('status', 'Pending')->count(),
            'processing' => Order::where('confirmed_by_user', true)->where('status', 'Processing')->count(),
            'ready' => Order::where('confirmed_by_user', true)->where('status', 'Ready')->count(),
            'completed' => Order::where('confirmed_by_user', true)->where('status', 'Completed')->count(),
            'rejected' => Order::where('confirmed_by_user', true)->where('status', 'Rejected')->count(),
        ];
        
        return view('admin.orders.index', compact('orders', 'stats', 'status', 'query', 'sort', 'type'));
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
     * Update order status (Unified method)
     */
    public function updateStatus(Request $request, $orderNumber)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Ready,Completed,Rejected',
            'rejection_reason' => 'nullable|string|required_if:status,Rejected',
        ], [
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
            'rejection_reason.required_if' => 'Alasan penolakan harus diisi jika status ditolak',
        ]);

        // Cari order by order_number
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Update status
        $oldStatus = $order->status;
        $newStatus = $request->status;
        $order->status = $newStatus;

        // Update rejection reason if rejected
        if ($newStatus === 'Rejected' && $request->filled('rejection_reason')) {
            $order->rejection_reason = $request->rejection_reason;
        }

        $order->save();

        // Log activity
        $this->logActivity(
            action: 'update_order_status',
            description: "Mengubah status pesanan #{$orderNumber} dari {$oldStatus} menjadi {$newStatus}",
            module: 'orders',
            related_id: $order->id,
            changes: [
                'order_number' => $orderNumber,
                'status' => ['old' => $oldStatus, 'new' => $newStatus]
            ]
        );

        // Kirim notifikasi ke user bahwa status pesanan telah diupdate
        $this->sendOrderStatusNotification($order, $oldStatus, $newStatus);

        // Jika request adalah JSON/AJAX, return JSON response
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Status pesanan {$orderNumber} berhasil diubah dari {$oldStatus} ke {$newStatus}",
                'order' => $order
            ]);
        }

        return redirect()->route('admin.orders.show', $orderNumber)
            ->with('success', "Status pesanan {$orderNumber} berhasil diubah dari {$oldStatus} ke {$newStatus}");
    }

    /**
     * Hapus pesanan (Unified method)
     */
    public function destroy($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Kirim notifikasi sebelum hapus
        Message::create([
            'user_id' => $order->user_id,
            'sender_type' => 'admin',
            'subject' => "Pesanan #{$order->order_number} Dihapus",
            'message' => "Pesanan Anda dengan nomor <strong>#{$order->order_number}</strong> telah dihapus oleh admin. Jika ada pertanyaan, silakan hubungi customer service kami.",
            'status' => 'unread',
            'reply_to' => null
        ]);

        // Log activity
        $this->logActivity(
            action: 'delete_order',
            description: "Menghapus pesanan nomor: {$order->order_number}",
            module: 'orders',
            related_id: $order->id,
            changes: [
                'order_number' => $order->order_number,
                'status' => 'Deleted'
            ]
        );

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }

    /**
     * Send order status update notification to user (Unified method)
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
            
            if ($order->rejection_reason) {
                $message .= "\n📝 Alasan: {$order->rejection_reason}\n";
            }
            
            $message .= "\nSilakan hubungi admin untuk informasi lebih lanjut.\n";
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
}
