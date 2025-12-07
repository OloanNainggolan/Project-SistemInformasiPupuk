<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders')
            ->with('success', "Status pesanan {$orderId} berhasil diubah dari {$oldStatus} ke {$request->status}");
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
