<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== SIMULASI UPDATE STATUS VIA CONTROLLER ===\n\n";

// Simulate request
$request = new \Illuminate\Http\Request();
$request->replace([
    'status' => 'Ready'
]);

// Get controller
$controller = new \App\Http\Controllers\Admin\AdminOrderController();

try {
    // Ambil pesanan Processing
    $order = \App\Models\Order::where('order_number', 'ORD-20251212-E2BDCB')->first();
    
    if (!$order) {
        echo "❌ Order tidak ditemukan!\n";
        exit;
    }
    
    echo "Order: {$order->order_number}\n";
    echo "Status Lama: {$order->status}\n";
    
    // Update via controller method
    $response = $controller->updateStatus($request, $order->order_number);
    
    // Refresh order
    $order->refresh();
    
    echo "Status Baru: {$order->status}\n";
    echo "\n✅ Update berhasil!\n";
    
    // Cek notification yang terkirim
    $notifications = \App\Models\UserNotification::where('order_number', $order->order_number)
        ->orderBy('created_at', 'desc')
        ->first();
    
    if ($notifications) {
        echo "\n📧 NOTIFICATION TERKIRIM:\n";
        echo "Title: {$notifications->title}\n";
        echo "Message (50 karakter pertama): " . substr($notifications->message, 0, 100) . "...\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
