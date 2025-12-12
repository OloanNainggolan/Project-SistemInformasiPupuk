<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check order data
$orders = App\Models\Order::with('user')->where('confirmed_by_user', true)->get();

echo "=== ORDER DATA CHECK ===" . PHP_EOL . PHP_EOL;

foreach($orders as $order) {
    echo "Order: " . $order->order_number . PHP_EOL;
    echo "  customer_name: " . ($order->customer_name ?? 'NULL') . PHP_EOL;
    echo "  customer_phone: " . ($order->customer_phone ?? 'NULL') . PHP_EOL;
    echo "  customer_address: " . ($order->customer_address ?? 'NULL') . PHP_EOL;
    echo "  user_email: " . ($order->user->email ?? 'NULL') . PHP_EOL;
    echo "  quantity: " . ($order->quantity ?? 'NULL') . PHP_EOL;
    echo "  unit_price: " . ($order->unit_price ?? 'NULL') . PHP_EOL;
    echo "  subtotal: " . ($order->subtotal ?? 'NULL') . PHP_EOL;
    echo "  total_amount: " . ($order->total_amount ?? 'NULL') . PHP_EOL;
    echo PHP_EOL;
}
