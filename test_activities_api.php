<?php

// Test API endpoint
$apiUrl = "http://127.0.0.1:8000/admin/api/activities";

echo "Testing Admin Activity API\n";
echo "==========================\n\n";

// Create a curl request with admin session headers
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_HEADER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status Code: $httpCode\n";
echo "Response:\n";

if ($httpCode == 200 || $httpCode == 401) {
    $data = json_decode($response, true);
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
} else {
    echo $response . "\n";
}

echo "\n✓ Test completed\n";
