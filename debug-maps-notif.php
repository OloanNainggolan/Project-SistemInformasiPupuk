<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG NOTIFIKASI READY ===" . PHP_EOL . PHP_EOL;

// Cari notifikasi Ready terbaru untuk user ID 2
$notification = \App\Models\Notification::where('user_id', 2)
    ->where('type', 'success')
    ->where('title', 'LIKE', '%Siap%')
    ->latest()
    ->first();

if ($notification) {
    echo "📋 NOTIFIKASI READY:" . PHP_EOL;
    echo "   ID: " . $notification->id . PHP_EOL;
    echo "   Title: " . $notification->title . PHP_EOL;
    echo "   Type: " . $notification->type . PHP_EOL;
    echo "   Related ID: " . ($notification->related_id ?? 'NULL') . PHP_EOL;
    echo "   Related Type: " . ($notification->related_type ?? 'NULL') . PHP_EOL;
    echo "   Created: " . $notification->created_at . PHP_EOL;
    
    echo PHP_EOL . "🗺️ DATA PICKUP POINT:" . PHP_EOL;
    if ($notification->data) {
        $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
        echo "   Has Data: YES ✅" . PHP_EOL;
        echo "   Data Content:" . PHP_EOL;
        print_r($data);
    } else {
        echo "   Has Data: NO ❌" . PHP_EOL;
        echo "   ERROR: Data pickup point tidak tersimpan!" . PHP_EOL;
    }
    
    // Cek related order
    if ($notification->related_id) {
        $order = \App\Models\Order::find($notification->related_id);
        if ($order) {
            echo PHP_EOL . "📦 RELATED ORDER:" . PHP_EOL;
            echo "   Order Number: " . $order->order_number . PHP_EOL;
            echo "   Status: " . $order->status . PHP_EOL;
            echo "   Customer Address: " . ($order->customer_address ?? $order->user->alamat ?? 'NULL') . PHP_EOL;
        }
    }
} else {
    echo "❌ Tidak ada notifikasi Ready untuk user ID 2" . PHP_EOL;
    
    // Cari semua notifikasi terbaru
    echo PHP_EOL . "📋 NOTIFIKASI TERBARU:" . PHP_EOL;
    $allNotifications = \App\Models\Notification::where('user_id', 2)
        ->latest()
        ->take(3)
        ->get();
    
    foreach ($allNotifications as $notif) {
        echo "   - " . $notif->title . " (" . $notif->type . ") - " . $notif->created_at . PHP_EOL;
        echo "     Has Data: " . ($notif->data ? 'YES' : 'NO') . PHP_EOL;
    }
}

echo PHP_EOL . "==============================" . PHP_EOL;
