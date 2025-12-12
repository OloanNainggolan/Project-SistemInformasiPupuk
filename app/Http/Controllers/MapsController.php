<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PickupPoint;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class MapsController extends Controller
{
    /**
     * Show maps page with nearest pickup point for order
     */
    public function show(Request $request)
    {
        // Get order number from request
        $orderNumber = $request->query('order');
        
        if (!$orderNumber) {
            return redirect()->route('notifikasi')->with('error', 'Nomor pesanan tidak ditemukan');
        }

        // Get order details
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return redirect()->route('notifikasi')->with('error', 'Pesanan tidak ditemukan');
        }

        // Check if order status is Ready
        if ($order->status !== 'Ready') {
            return redirect()->route('notifikasi')->with('error', 'Pesanan belum siap diambil');
        }

        // Get user's address coordinates (default to Laguboti/IT Del area)
        $userLatitude = $request->query('lat', 2.6140);
        $userLongitude = $request->query('lng', 99.0710);

        // Find nearest pickup point
        $nearestData = PickupPoint::findNearest($userLatitude, $userLongitude);

        if (!$nearestData) {
            return redirect()->route('notifikasi')->with('error', 'Titik pengambilan tidak tersedia');
        }

        $nearestPoint = $nearestData['pickup_point'];
        $distance = $nearestData['distance'];

        // Get all pickup points for map display
        $allPickupPoints = PickupPoint::all();

        return view('user.maps', compact(
            'order',
            'nearestPoint',
            'distance',
            'allPickupPoints',
            'userLatitude',
            'userLongitude'
        ));
    }

    public function geocode(Request $request)
    {
        $request->validate([
            'address' => 'required|string'
        ]);

        $address = urlencode($request->address);
        $key = env('GOOGLE_MAPS_KEY');

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$key}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] !== "OK") {
            return response()->json(['message' => 'Alamat tidak ditemukan'], 404);
        }

        $location = $data['results'][0]['geometry']['location'];

        return response()->json([
            'lat' => $location['lat'],
            'lng' => $location['lng'],
            'full_address' => $data['results'][0]['formatted_address']
        ]);
    }

    public function pickupPoints()
    {
        return response()->json([
            'locations' => PickupPoint::all()
        ]);
    }

    public function nearestPickup(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $lat = $request->lat;
        $lng = $request->lng;

        $nearest = DB::table('pickup_points')
            ->select('*',
                DB::raw("(
                    6371 * acos(
                        cos(radians($lat))
                        * cos(radians(latitude))
                        * cos(radians(longitude) - radians($lng))
                        + sin(radians($lat)) * sin(radians(latitude))
                    )
                ) AS distance")
            )
            ->orderBy('distance', 'asc')
            ->first();

        return response()->json([
            'nearest_location' => $nearest
        ]);
    }
}

