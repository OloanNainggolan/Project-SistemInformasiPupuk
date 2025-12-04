<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{
    /**
     * Get dashboard metrics
     * Endpoint: GET /admin/api/metrics
     */
    public function getMetrics()
    {
        $now = now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $endOfThisMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Total Metrics
        $totalPesanan = Order::where('confirmed_by_user', true)->count();
        $totalPendapatan = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->sum('total_amount');
        $totalPetani = User::count();
        $totalProduk = Product::count();

        // This Month
        $pesananBulanIni = Order::where('confirmed_by_user', true)
            ->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])
            ->count();
        $pendapatanBulanIni = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->whereBetween('completed_at', [$startOfThisMonth, $endOfThisMonth])
            ->sum('total_amount');

        // Last Month
        $pesananBulanLalu = Order::where('confirmed_by_user', true)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $pendapatanBulanLalu = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->whereBetween('completed_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total_amount');

        // Growth Calculation
        $pertumbuhanPesanan = $pesananBulanLalu > 0 
            ? round((($pesananBulanIni - $pesananBulanLalu) / $pesananBulanLalu) * 100, 1)
            : ($pesananBulanIni > 0 ? 100 : 0);

        $pertumbuhanPendapatan = $pendapatanBulanLalu > 0 
            ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : ($pendapatanBulanIni > 0 ? 100 : 0);

        // Status Breakdown
        $statusBreakdown = [
            'pending' => Order::where('confirmed_by_user', true)->where('status', 'Pending')->count(),
            'processing' => Order::where('confirmed_by_user', true)->where('status', 'Processing')->count(),
            'ready' => Order::where('confirmed_by_user', true)->where('status', 'Ready')->count(),
            'completed' => Order::where('confirmed_by_user', true)->where('status', 'Completed')->count(),
            'rejected' => Order::where('confirmed_by_user', true)->where('status', 'Rejected')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'metrics' => [
                    'total_pesanan' => $totalPesanan,
                    'total_pendapatan' => $totalPendapatan,
                    'total_petani' => $totalPetani,
                    'total_produk' => $totalProduk,
                ],
                'growth' => [
                    'pesanan' => $pertumbuhanPesanan,
                    'pendapatan' => $pertumbuhanPendapatan,
                ],
                'this_month' => [
                    'pesanan' => $pesananBulanIni,
                    'pendapatan' => $pendapatanBulanIni,
                ],
                'last_month' => [
                    'pesanan' => $pesananBulanLalu,
                    'pendapatan' => $pendapatanBulanLalu,
                ],
                'status_breakdown' => $statusBreakdown,
            ],
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Get orders list with pagination
     * Endpoint: GET /admin/api/orders
     */
    public function getOrders(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $status = $request->input('status');
        $search = $request->input('search');

        $query = Order::with(['user', 'product'])
            ->where('confirmed_by_user', true);

        // Filter by status
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $orders,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Update order status
     * Endpoint: PATCH /admin/api/orders/{id}/status
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Processing,Ready,Completed,Rejected',
            'admin_notes' => 'nullable|string',
            'rejection_reason' => 'nullable|string|required_if:status,Rejected',
        ]);

        $order = Order::findOrFail($id);

        // Update status
        $order->status = $validated['status'];
        
        if (isset($validated['admin_notes'])) {
            $order->admin_notes = $validated['admin_notes'];
        }

        if ($validated['status'] === 'Rejected' && isset($validated['rejection_reason'])) {
            $order->rejection_reason = $validated['rejection_reason'];
        }

        // Update timestamps based on status
        if ($validated['status'] === 'Processing' && !$order->processed_at) {
            $order->processed_at = now();
            $order->processed_by = session('admin_id');
        }

        if ($validated['status'] === 'Completed' && !$order->completed_at) {
            $order->completed_at = now();
        }

        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui',
            'data' => $order->load(['user', 'product']),
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Get order detail
     * Endpoint: GET /admin/api/orders/{id}
     */
    public function getOrderDetail($id)
    {
        $order = Order::with(['user', 'product', 'discount'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Get revenue statistics
     * Endpoint: GET /admin/api/revenue
     */
    public function getRevenue(Request $request)
    {
        $period = $request->input('period', 'month'); // month, week, year
        $now = now();

        switch ($period) {
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            default: // month
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                break;
        }

        $revenue = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->whereBetween('completed_at', [$startDate, $endDate])
            ->sum('total_amount');

        $orderCount = Order::where('confirmed_by_user', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $averageOrderValue = $orderCount > 0 ? $revenue / $orderCount : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'period' => $period,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_revenue' => $revenue,
                'order_count' => $orderCount,
                'average_order_value' => $averageOrderValue,
            ],
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
