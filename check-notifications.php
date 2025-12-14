<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK NOTIFIKASI USER ===" . PHP_EOL . PHP_EOL;

// Cari notifikasi terakhir untuk user ID 2
$notification = \App\Models\Notification::where('user_id', 2)->latest()->first();

if ($notification) {
    echo "📋 NOTIFIKASI TERAKHIR:" . PHP_EOL;
    echo "   Title: " . $notification->title . PHP_EOL;
    echo "   Type: " . $notification->type . PHP_EOL;
    echo "   Created: " . $notification->created_at . PHP_EOL;
    echo "   Has Data: " . ($notification->data ? 'YES ✅' : 'NO ❌') . PHP_EOL;
    
    if ($notification->data) {
        $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
        if (isset($data['pickup_name'])) {
            echo "   📍 Pickup Point: " . $data['pickup_name'] . PHP_EOL;
            echo "   📏 Distance: " . $data['distance'] . " km" . PHP_EOL;
        }
    }
    
    echo PHP_EOL . "📝 Message Preview:" . PHP_EOL;
    echo "   " . substr($notification->message, 0, 150) . "..." . PHP_EOL;
    
    // Cek apakah ada Message dengan subject yang sama (double notification)
    $messageCount = \App\Models\Message::where('user_id', 2)
        ->where('created_at', '>=', $notification->created_at->copy()->subSeconds(5))
        ->where('created_at', '<=', $notification->created_at->copy()->addSeconds(5))
        ->count();
    
    echo PHP_EOL . "🔍 CHECK DOUBLE NOTIFICATION:" . PHP_EOL;
    echo "   Notification: 1" . PHP_EOL;
    echo "   Message (waktu sama): " . $messageCount . PHP_EOL;
    echo "   Status: " . ($messageCount > 0 ? '⚠️ MASIH DOUBLE (Notification + Message)' : '✅ TIDAK DOUBLE (Hanya Notification)') . PHP_EOL;
} else {
    echo "❌ Tidak ada notifikasi untuk user ID 2" . PHP_EOL;
}

echo PHP_EOL . "==============================" . PHP_EOL;
