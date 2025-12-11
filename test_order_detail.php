<?php

// Test script untuk order detail API
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/user/orders/1/detail', 'GET');
$response = $kernel->handle($request);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->getContent() . "\n";

$kernel->terminate($request, $response);
