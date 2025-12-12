<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATE STATUS PESANAN KE READY ===\n\n";

// Ambil pesanan ORD-20251212-970F2F
$order = \App\Models\Order::where('order_number', 'ORD-20251212-970F2F')->first();

if (!$order) {
    echo "❌ Order tidak ditemukan!\n";
    exit;
}

echo "Order: {$order->order_number}\n";
echo "Status Lama: {$order->status}\n";

// Update status ke Ready
$order->status = 'Ready';
$order->save();

echo "Status Baru: {$order->status}\n";
echo "\n✅ Status berhasil diupdate!\n";
echo "\nSilakan cek notifikasi user untuk melihat pesan dengan instruksi maps.\n";
