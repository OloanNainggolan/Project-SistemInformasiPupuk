<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING ORDER ID 3 ===\n\n";

$order = \App\Models\Order::find(3);

if ($order) {
    echo "Order Number: {$order->order_number}\n";
    echo "User ID: {$order->user_id}\n";
    echo "Customer Name: " . ($order->customer_name ?? 'NULL') . "\n";
    echo "Customer Phone: " . ($order->customer_phone ?? 'NULL') . "\n";
    echo "Customer Address: " . ($order->customer_address ?? 'NULL') . "\n";
    echo "Customer Notes: " . ($order->customer_notes ?? 'NULL') . "\n";
    echo "\nUser Data:\n";
    echo "User Name: " . ($order->user->name ?? 'NULL') . "\n";
    echo "User Phone: " . ($order->user->no_telp ?? 'NULL') . "\n";
    echo "User Address: " . ($order->user->alamat ?? 'NULL') . "\n";
} else {
    echo "Order not found!\n";
}
