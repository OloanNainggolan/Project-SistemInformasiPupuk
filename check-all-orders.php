<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DAFTAR SEMUA PESANAN ===\n\n";

$orders = \App\Models\Order::orderBy('created_at', 'desc')->get();

foreach($orders as $order) {
    echo "Order: {$order->order_number}\n";
    echo "Status: {$order->status}\n";
    echo "Customer: {$order->nama_lengkap}\n";
    echo "Created: {$order->created_at}\n";
    echo "---\n";
}

echo "\nTotal: " . $orders->count() . " pesanan\n";
