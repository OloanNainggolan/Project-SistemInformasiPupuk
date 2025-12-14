<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Message;
use App\Models\Notification;
use App\Traits\TrackAdminActivity;
use App\Services\WhatsAppService;
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
        $order = Order::with([
                'user',
                'product.images' => function($query) {
                    $query->orderBy('order');
                },
                'product.primaryImage'
            ])
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

        // Kirim WhatsApp notifikasi update status
        try {
            $order->load('user');
            $whatsappService = app(WhatsAppService::class);
            $whatsappResult = $whatsappService->sendStatusUpdateNotification($order, $oldStatus);
            
            if ($whatsappResult['success']) {
                \Log::info('WhatsApp status update sent', [
                    'order_number' => $order->order_number,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'phone' => $order->user->no_telp ?? 'N/A'
                ]);
            } else {
                \Log::warning('WhatsApp status update failed', [
                    'order_number' => $order->order_number,
                    'error' => $whatsappResult['message']
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp status update error', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
        }

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
            'Rejected' => 'Ditolak',
        ];

        // Buat pesan yang menarik dan informatif
        
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
        $message .= "[UPDATE] STATUS PESANAN\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $message .= "No. Pesanan: #{$order->order_number}\n";
        $message .= "Produk: {$productName}\n";
        $message .= "Jumlah: {$order->quantity} kg\n";
        
        // Tampilkan balai desa jika ada dari customer_address
        if (!empty($order->customer_address) && stripos($order->customer_address, 'balai desa') !== false) {
            $message .= "Balai Desa: {$order->customer_address}\n";
        }
        
        $message .= "\n";
        
        $message .= "Status Lama: {$statusMessages[$oldStatus]}\n";
        $message .= "Status Baru: {$statusMessages[$newStatus]}\n\n";
        
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        
        // Pesan khusus berdasarkan status
        if ($newStatus === 'Processing') {
            $message .= "[INFO] SEDANG DIPROSES:\n";
            $message .= "Pesanan Anda sedang diproses oleh tim kami.\n";
            $message .= "Harap menunggu informasi selanjutnya.\n";
            $message .= "Estimasi proses: 1-3 hari kerja.\n\n";
            
            $message .= "Lokasi Pengambilan Nantinya:\n";
            $message .= "Balai Desa (Akan dikonfirmasi)\n";
        } elseif ($newStatus === 'Ready') {
            $message .= "[SIAP] PESANAN SIAP DIAMBIL!\n";
            $message .= "Pesanan Anda sudah siap.\n";
            $message .= "Silakan datang untuk mengambil pesanan.\n\n";
            
            $message .= "INFORMASI PENGAMBILAN:\n";
            $message .= "Sistem akan menunjukkan titik pengambilan terdekat dari lokasi Anda.\n";
            $message .= "Jam Operasional: 08.00 - 17.00 WIB\n";
            $message .= "Harap bawa bukti pesanan dan identitas diri\n";
            $message .= "Pembayaran: Tunai di Lokasi\n\n";
            
            $message .= "LIHAT LOKASI PENGAMBILAN:\n";
            $message .= ">> Klik notifikasi ini untuk melihat PETA lokasi pengambilan terdekat\n";
            $message .= ">> Sistem otomatis menampilkan titik pengambilan paling dekat dari Anda\n";
            $message .= ">> Lihat jarak dan rute Google Maps langsung dari halaman notifikasi\n\n";
            
            $message .= "CARA AKSES:\n";
            $message .= "1. Buka menu Notifikasi\n";
            $message .= "2. Klik notifikasi ini\n";
            $message .= "3. Scroll ke bawah - lihat card hijau dengan tombol 'Buka Peta Lokasi Pengambilan'\n";
            $message .= "4. Klik tombol untuk melihat peta interaktif\n";
        } elseif ($newStatus === 'Completed') {
            $message .= "[SELESAI] PESANAN SELESAI!\n";
            $message .= "Pesanan telah diambil di Balai Desa.\n";
            $message .= "Terima kasih atas kepercayaan Anda!\n";
            $message .= "Semoga produk kami bermanfaat.\n\n";
            $message .= "Silakan berikan ulasan Anda untuk membantu kami meningkatkan layanan.\n";
        } elseif ($newStatus === 'Rejected') {
            $message .= "[DITOLAK] PESANAN DITOLAK\n";
            $message .= "Mohon maaf, pesanan Anda tidak dapat diproses.\n";
            
            if ($order->rejection_reason) {
                $message .= "\nAlasan: {$order->rejection_reason}\n";
            }
            
            $message .= "\nSilakan hubungi admin untuk informasi lebih lanjut.\n";
            $message .= "Hubungi kami untuk klarifikasi.\n";
        } elseif ($newStatus === 'Pending') {
            $message .= "[PENDING] MENUNGGU KONFIRMASI\n";
            $message .= "Pesanan Anda telah diterima dan menunggu konfirmasi.\n";
            $message .= "Tim kami akan segera memproses pesanan Anda.\n\n";
            $message .= "Rencana Pengambilan:\n";
            $message .= "Balai Desa (Sesuai alamat pengiriman)\n";
        }
        
        $message .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "Tip: Anda dapat membalas pesan ini jika ada pertanyaan.\n";

        // Buat subject yang menarik
        $subject = "[UPDATE] Status Pesanan #{$order->order_number} - {$statusMessages[$newStatus]}";

        // KIRIM HANYA 1 NOTIFIKASI (System Notification dengan data lengkap)
        // Tentukan tipe notifikasi berdasarkan status
        $notificationType = 'info';
        if ($newStatus === 'Ready') {
            $notificationType = 'success';
        } elseif ($newStatus === 'Rejected') {
            $notificationType = 'important';
        } elseif ($newStatus === 'Completed') {
            $notificationType = 'success';
        }

        // Untuk status Ready/Completed, ambil data pickup point terdekat
        $pickupData = null;
        if ($newStatus === 'Ready' || $newStatus === 'Completed') {
            try {
                $customerAddress = $order->customer_address ?? $order->user->alamat ?? null;
                
                if ($customerAddress) {
                    // Tentukan koordinat customer berdasarkan alamat
                    $areaCoordinates = [
                        'flyover' => ['lat' => 2.5950, 'lng' => 99.0300],
                        'pasar' => ['lat' => 2.5800, 'lng' => 99.0450],
                        'pantai' => ['lat' => 2.6400, 'lng' => 99.1200],
                        'desa' => ['lat' => 2.5700, 'lng' => 99.0600],
                        'balai' => ['lat' => 2.5700, 'lng' => 99.0600],
                        'kota' => ['lat' => 2.5900, 'lng' => 99.0500],
                        'default' => ['lat' => 2.5850, 'lng' => 99.0550]
                    ];
                    
                    $customerCoords = $areaCoordinates['default'];
                    $addressLower = strtolower($customerAddress);
                    
                    foreach ($areaCoordinates as $keyword => $coords) {
                        if ($keyword !== 'default' && strpos($addressLower, $keyword) !== false) {
                            $customerCoords = $coords;
                            break;
                        }
                    }
                    
                    // Ambil nearest pickup point menggunakan internal call
                    $mapsController = new \App\Http\Controllers\MapsController();
                    $request = new \Illuminate\Http\Request();
                    $request->merge([
                        'lat' => $customerCoords['lat'],
                        'lng' => $customerCoords['lng']
                    ]);
                    
                    try {
                        $response = $mapsController->nearestPickup($request);
                        $result = $response->getData(true);
                        
                        if (isset($result['nearest_location'])) {
                            $pickupData = [
                                'customer_address' => $customerAddress,
                                'customer_lat' => $customerCoords['lat'],
                                'customer_lng' => $customerCoords['lng'],
                                'pickup_name' => $result['nearest_location']['name'],
                                'pickup_address' => $result['nearest_location']['address'],
                                'pickup_lat' => $result['nearest_location']['latitude'],
                                'pickup_lng' => $result['nearest_location']['longitude'],
                                'distance' => round($result['nearest_location']['distance'], 2),
                                'maps_url' => "https://www.google.com/maps/dir/?api=1&origin={$customerCoords['lat']},{$customerCoords['lng']}&destination={$result['nearest_location']['latitude']},{$result['nearest_location']['longitude']}&travelmode=driving"
                            ];
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error fetching pickup point for notification: ' . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error preparing pickup data for notification: ' . $e->getMessage());
            }
        }

        Notification::create([
            'type' => $notificationType,
            'title' => $subject,
            'message' => $message,
            'status' => 'unread',
            'related_id' => $order->id,
            'link' => null,
        ]);
    }

    /**
     * Send notification to user about status change
     * Uses the same detailed format as sendOrderStatusNotification
     */
    private function getStatusColor($status)
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
        
        return $colors[$status] ?? '#9e9e9e';
    }
}
