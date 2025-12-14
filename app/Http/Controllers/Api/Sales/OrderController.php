<?php

namespace App\Http\Controllers\Api\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Requests\Api\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        // auth is applied on routes
    }

    /**
     * List orders (paginated). Admins can see all, users see own orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user','product');
        // if not admin, limit to user
        if (! $request->user() || ! $request->user()->can('viewAny', Order::class)) {
            $query->where('user_id', $request->user()->id);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at','desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    /**
     * Store a new order
     */
    public function store(StoreOrderRequest $request, WhatsAppService $whatsappService)
    {
        $data = $request->validated();

        $order = DB::transaction(function () use ($data) {
            $order = new Order();
            $order->order_number = Order::generateOrderNumber();
            $order->user_id = $data['user_id'];
            $order->village_office = $data['village_office'] ?? null;
            $order->items = $data['items'];
            $order->total_amount = $data['total_amount'];
            $order->status = $data['status'] ?? 'Pending';
            $order->confirmed_by_user = $data['confirmed_by_user'] ?? false;
            $order->rejection_reason = $data['rejection_reason'] ?? null;
            $order->save();
            return $order;
        });

        // Load relasi untuk WhatsApp message
        $order->load('user');

        // Kirim WhatsApp notifikasi
        $whatsappResult = $whatsappService->sendOrderNotification($order);
        
        // Log hasil pengiriman WA
        if ($whatsappResult['success']) {
            \Log::info('WhatsApp notification sent for order', [
                'order_number' => $order->order_number,
                'user_id' => $order->user_id
            ]);
        }

        return response()->json([
            "success" => true, 
            "order" => new OrderResource($order),
            "whatsapp_sent" => $whatsappResult['success'],
            "whatsapp_message" => $whatsappResult['message']
        ], 201);
    }

    /**
     * Show an order
     */
    public function show($id)
    {
        $order = Order::with('user','product')->where('order_number', $id)->first();
        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        return response()->json(['success' => true, 'order' => new OrderResource($order)]);
    }

    /**
     * Update order status
     */
    public function updateStatus(UpdateOrderStatusRequest $request, $orderNumber, WhatsAppService $whatsappService)
    {
        $order = Order::where('order_number', $orderNumber)->first();
        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        $oldStatus = $order->status;
        $order->status = $request->validated()['status'];
        $order->save();

        // Load relasi untuk WhatsApp message
        $order->load('user');

        // Kirim WhatsApp notifikasi jika status berubah
        if ($oldStatus !== $order->status) {
            $whatsappResult = $whatsappService->sendStatusUpdateNotification($order, $oldStatus);
            
            if ($whatsappResult['success']) {
                \Log::info('WhatsApp status update sent', [
                    'order_number' => $order->order_number,
                    'old_status' => $oldStatus,
                    'new_status' => $order->status
                ]);
            }
        }

        return response()->json(['success' => true, 'order' => new OrderResource($order)]);
    }

    /**
     * Delete order
     */
    public function destroy($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();
        if (! $order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['success' => true]);
    }
}

