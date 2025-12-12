<?php
// Test API nearest pickup endpoint
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Nearest Pickup API ===\n\n";

// Test with Laguboti coordinates (prisca's address)
$latitude = 2.614;
$longitude = 99.071;

echo "Testing with coordinates: Lat=$latitude, Lng=$longitude\n";
echo "Expected: Should find pickup points\n\n";

// Make HTTP request to API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/api/nearest-pickup");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['lat' => $latitude, 'lng' => $longitude]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Content-Type: application/json']);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n";
echo "Response:\n";
echo $response;
echo "\n\n";

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if (isset($data['success']) && $data['success']) {
        echo "✓ API Working!\n";
        echo "Nearest Pickup: " . $data['nearest']['name'] . "\n";
        echo "Distance: " . number_format($data['nearest']['distance'], 2) . " km\n";
    } else {
        echo "✗ API Error: " . ($data['message'] ?? 'Unknown error') . "\n";
    }
} else {
    echo "✗ HTTP Error: $httpCode\n";
}
