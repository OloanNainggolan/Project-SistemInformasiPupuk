<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class MapController extends Controller
{
    /**
     * Display pickup location map for an order
     */
    public function show(Request $request, $orderNumber)
    {
        // Find order by order_number
        $order = Order::where('order_number', $orderNumber)
            ->with(['user', 'product'])
            ->first();

        if (!$order) {
            abort(404, 'Pesanan tidak ditemukan');
        }

        // Check if user is authorized to view this order
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini');
        }

        // Get pickup address (customer_address or user's alamat)
        $pickupAddress = $order->customer_address ?? $order->user->alamat ?? null;

        if (!$pickupAddress) {
            return back()->with('error', 'Alamat pengambilan tidak tersedia untuk pesanan ini');
        }

        return view('user.maps.show', [
            'order' => $order,
            'pickupAddress' => $pickupAddress,
            'googleMapsKey' => config('services.google.maps_key') ?? env('GOOGLE_MAPS_KEY')
        ]);
    }
}
