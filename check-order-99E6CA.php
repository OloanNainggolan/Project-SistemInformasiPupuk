<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CEK PESANAN ORD-20251212-99E6CA ===\n\n";

$order = \App\Models\Order::where('order_number', 'ORD-20251212-99E6CA')->first();

if (!$order) {
    echo "❌ Order tidak ditemukan!\n";
    exit;
}

echo "Order Number: {$order->order_number}\n";
echo "Status: {$order->status}\n";
echo "User ID: {$order->user_id}\n\n";

echo "=== DATA ORDER ===\n";
echo "nama_lengkap: " . ($order->nama_lengkap ?? 'NULL') . "\n";
echo "email: " . ($order->email ?? 'NULL') . "\n";
echo "no_hp: " . ($order->no_hp ?? 'NULL') . "\n";
echo "alamat_lengkap: " . ($order->alamat_lengkap ?? 'NULL') . "\n";
echo "catatan: " . ($order->catatan ?? 'NULL') . "\n";
echo "customer_address: " . ($order->customer_address ?? 'NULL') . "\n\n";

echo "=== KOLOM YANG ADA DI TABLE ORDERS ===\n";
$columns = \Schema::getColumnListing('orders');
foreach ($columns as $col) {
    echo "- $col\n";
}

echo "\n=== DATA USER ===\n";
if ($order->user) {
    echo "User Name: {$order->user->name}\n";
    echo "User Email: {$order->user->email}\n";
    echo "User No HP: " . ($order->user->no_hp ?? 'NULL') . "\n";
    echo "User Alamat: " . ($order->user->alamat ?? 'NULL') . "\n";
} else {
    echo "User tidak ditemukan\n";
}
