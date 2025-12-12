<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check for Ready orders
$orders = App\Models\Order::where('status', 'Ready')->get();

echo "Orders with Ready status: " . $orders->count() . PHP_EOL;

foreach($orders as $order) {
    echo "- " . $order->order_number . " (User: " . $order->user_id . ")" . PHP_EOL;
}

// Check pickup points
echo PHP_EOL . "=== PICKUP POINTS ===" . PHP_EOL;
$pickupPoints = App\Models\PickupPoint::all();
echo "Total Pickup Points: " . $pickupPoints->count() . PHP_EOL . PHP_EOL;

foreach($pickupPoints as $point) {
    echo "📍 " . $point->name . PHP_EOL;
    echo "   Alamat: " . $point->address . PHP_EOL;
    echo "   Koordinat: " . $point->latitude . ", " . $point->longitude . PHP_EOL . PHP_EOL;
}

// Test nearest calculation
echo "=== TEST PENCARIAN TERDEKAT ===" . PHP_EOL;
echo "Contoh: User di Laguboti (sekitar IT Del)" . PHP_EOL;
$userLat = 2.6100;
$userLng = 99.0700;

$nearest = App\Models\PickupPoint::findNearest($userLat, $userLng);
if ($nearest) {
    echo "Titik Terdekat: " . $nearest['pickup_point']->name . PHP_EOL;
    echo "Jarak: " . $nearest['distance'] . " km" . PHP_EOL;
}

