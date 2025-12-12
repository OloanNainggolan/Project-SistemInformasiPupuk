<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST PERHITUNGAN JARAK ===\n\n";

// Koordinat IT Del (Pickup Point)
$itDelLat = 2.6140;
$itDelLng = 99.0710;

// Koordinat Flyover (Customer) - Updated to realistic distance
$flyoverLat = 2.5950;
$flyoverLng = 99.0300;

echo "IT Del Coordinates: ($itDelLat, $itDelLng)\n";
echo "Flyover Coordinates (NEW): ($flyoverLat, $flyoverLng)\n\n";

// Haversine formula
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Radius bumi dalam km
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $R * $c;
    
    return $distance;
}

$distance = calculateDistance($flyoverLat, $flyoverLng, $itDelLat, $itDelLng);

echo "Calculated Distance: " . round($distance, 2) . " km\n\n";

// Test dengan database query
$nearest = DB::table('pickup_points')
    ->select('*',
        DB::raw("(
            6371 * acos(
                cos(radians($flyoverLat))
                * cos(radians(latitude))
                * cos(radians(longitude) - radians($flyoverLng))
                + sin(radians($flyoverLat)) * sin(radians(latitude))
            )
        ) AS distance")
    )
    ->orderBy('distance', 'asc')
    ->first();

if ($nearest) {
    echo "=== NEAREST PICKUP POINT ===\n";
    echo "Name: {$nearest->name}\n";
    echo "Distance: " . round($nearest->distance, 2) . " km\n";
} else {
    echo "No pickup points found\n";
}
