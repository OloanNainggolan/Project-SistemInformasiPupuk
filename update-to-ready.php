<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATE STATUS KE READY ===\n\n";

$order = \App\Models\Order::where('order_number', 'ORD-20251212-99E6CA')->first();

if (!$order) {
    echo "❌ Order tidak ditemukan!\n";
    exit;
}

echo "Order: {$order->order_number}\n";
echo "Status Lama: {$order->status}\n";
echo "Alamat Customer: {$order->customer_address}\n\n";

// Update status
$order->status = 'Ready';
$order->save();

echo "Status Baru: {$order->status}\n";
echo "\n✅ Status berhasil diupdate ke Ready!\n";
echo "Silakan refresh halaman admin untuk melihat maps dengan jarak yang benar.\n";
