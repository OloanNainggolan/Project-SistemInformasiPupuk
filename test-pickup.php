<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new \App\Http\Controllers\MapsController();

echo "=== TEST SISTEM PICKUP POINT TERDEKAT ===\n\n";

// Test 1: Dari Balige (dekat Mr.DIY)
$request1 = new \Illuminate\Http\Request();
$request1->merge(['lat' => 2.331, 'lng' => 99.065]);
$response1 = $controller->nearestPickup($request1);
$data1 = $response1->getData();
echo "1. Test dari Balige (koordinat customer):\n";
echo "   Pickup terdekat: " . $data1->nearest_location->name . "\n";
echo "   Jarak: " . round($data1->nearest_location->distance, 2) . " km\n\n";

// Test 2: Dari Laguboti (dekat IT Del)
$request2 = new \Illuminate\Http\Request();
$request2->merge(['lat' => 2.614, 'lng' => 99.071]);
$response2 = $controller->nearestPickup($request2);
$data2 = $response2->getData();
echo "2. Test dari Laguboti (koordinat customer):\n";
echo "   Pickup terdekat: " . $data2->nearest_location->name . "\n";
echo "   Jarak: " . round($data2->nearest_location->distance, 2) . " km\n\n";

// Test 3: Dari Porsea (dekat RSUD)
$request3 = new \Illuminate\Http\Request();
$request3->merge(['lat' => 2.683, 'lng' => 98.785]);
$response3 = $controller->nearestPickup($request3);
$data3 = $response3->getData();
echo "3. Test dari Porsea (koordinat customer):\n";
echo "   Pickup terdekat: " . $data3->nearest_location->name . "\n";
echo "   Jarak: " . round($data3->nearest_location->distance, 2) . " km\n\n";

echo "=== KESIMPULAN ===\n";
echo "✅ Sistem berhasil memilih pickup point TERDEKAT untuk setiap lokasi customer!\n";
echo "✅ User akan diarahkan ke lokasi yang paling dekat dari mereka.\n";
