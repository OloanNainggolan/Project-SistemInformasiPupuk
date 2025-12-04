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
    public function index()
    {
        return view('admin.orders.index');
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

        $orders = Order::with(['user', 'product']) // Eager load user dan product
            ->confirmed() // Hanya yang confirmed_by_user = true
            ->search($query)
            ->byStatus($status)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        $formattedOrders = $orders->map(function ($order) {
            // Format items dari relasi product (real data dari database)
            $items = [];
            if ($order->product) {
                $items[] = [
                    'name' => $order->product->nama_produk,
                    'qty' => $order->quantity,
                    'price' => $order->unit_price,
                    'subtotal' => $order->subtotal,
                ];
            }

            return [
                'id' => $order->order_number,
                'user_id' => $order->user_id,
                'name' => $order->customer_name ?? ($order->user->name ?? 'Unknown User'),
                'phone' => $order->customer_phone ?? ($order->user->no_telp ?? '-'),
                'village_office' => $order->village_office ?? $order->customer_address ?? '-',
                'date' => $order->created_at->toIso8601String(),
                'date_formatted' => $order->created_at->format('d F Y'),
                'items' => $items, // Data produk dari relasi database
                'total_amount' => $order->total_amount,
                'total_formatted' => $order->formatted_total,
                'status' => $order->status,
                'status_color' => $order->status_color,
                'confirmed_by_user' => $order->confirmed_by_user,
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
     * API: Update order status
     * PATCH /api/admin/orders/:orderId/status
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Ready,Completed,Rejected',
            'rejection_reason' => 'required_if:status,Rejected'
        ], [
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
            'rejection_reason.required_if' => 'Alasan penolakan harus diisi'
        ]);

        // Cari order by order_number
        $order = Order::where('order_number', $orderId)->firstOrFail();

        // Update status
        $order->status = $request->status;
        
        if ($request->status === 'Rejected') {
            $order->rejection_reason = $request->rejection_reason;
        }
        
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diupdate',
            'order' => [
                'id' => $order->order_number,
                'status' => $order->status,
                'status_color' => $order->status_color,
                'rejection_reason' => $order->rejection_reason,
            ]
        ]);
    }

    /**
     * API: Get order statistics
     */
    public function getStats()
    {
        $totalOrders = Order::confirmed()->count();
        $pendingOrders = Order::confirmed()->where('status', 'Pending')->count();
        $processingOrders = Order::confirmed()->where('status', 'Processing')->count();
        $completedOrders = Order::confirmed()->where('status', 'Completed')->count();
        $rejectedOrders = Order::confirmed()->where('status', 'Rejected')->count();

        return response()->json([
            'total' => $totalOrders,
            'pending' => $pendingOrders,
            'processing' => $processingOrders,
            'completed' => $completedOrders,
            'rejected' => $rejectedOrders,
        ]);
    }
}
