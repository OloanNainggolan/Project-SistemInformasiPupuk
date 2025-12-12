<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CEK NOTIFIKASI LAMA vs BARU ===\n\n";

// Get notifications dengan order reference
$notifications = DB::table('notifications')
    ->where('message', 'LIKE', '%ORD-%')
    ->orderBy('created_at', 'desc')
    ->get();

echo "Total notifikasi dengan order: " . $notifications->count() . "\n\n";

foreach ($notifications as $notif) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "ID: {$notif->id}\n";
    echo "Title: {$notif->title}\n";
    echo "Created: {$notif->created_at}\n";
    echo "Related Type: {$notif->related_type}\n";
    echo "Related ID: {$notif->related_id}\n";
    
    // Extract order number from message
    if (preg_match('/ORD-\d{8}-[A-F0-9]{6}/i', $notif->message, $matches)) {
        $orderNumber = $matches[0];
        echo "Order Number (from message): {$orderNumber}\n";
        
        // Find order in database
        $order = DB::table('orders')->where('order_number', $orderNumber)->first();
        if ($order) {
            echo "Order Status (dari DB): {$order->status}\n";
            
            // Check if this is Ready order
            if (in_array($order->status, ['Ready', 'Completed'])) {
                echo "✅ TOMBOL MAPS HARUS MUNCUL!\n";
            } else {
                echo "❌ Tombol maps tidak muncul (status: {$order->status})\n";
            }
        } else {
            echo "⚠️ Order tidak ditemukan di database\n";
        }
    }
    
    // Check message content
    $hasMapsMention = stripos($notif->message, 'LIHAT LOKASI PENGAMBILAN') !== false;
    echo "Pesan menyebut Maps: " . ($hasMapsMention ? "YA (notif baru)" : "TIDAK (notif lama)") . "\n";
    
    echo "\n";
}

echo "\n=== UPDATE RELATED_ID untuk Notifikasi Lama ===\n";
echo "Apakah ingin update related_id untuk notifikasi lama? (y/n): ";
$handle = fopen ("php://stdin","r");
$line = trim(fgets($handle));

if($line == 'y' || $line == 'Y') {
    $updated = 0;
    foreach ($notifications as $notif) {
        if (!$notif->related_id || !$notif->related_type) {
            if (preg_match('/ORD-\d{8}-[A-F0-9]{6}/i', $notif->message, $matches)) {
                $orderNumber = $matches[0];
                $order = DB::table('orders')->where('order_number', $orderNumber)->first();
                
                if ($order) {
                    DB::table('notifications')
                        ->where('id', $notif->id)
                        ->update([
                            'related_id' => $order->id,
                            'related_type' => 'App\\Models\\Order',
                            'updated_at' => now()
                        ]);
                    echo "✓ Updated notification #{$notif->id} → Order #{$order->id}\n";
                    $updated++;
                }
            }
        }
    }
    echo "\nTotal updated: {$updated} notifications\n";
} else {
    echo "Cancelled.\n";
}

echo "\n=== DONE ===\n";
