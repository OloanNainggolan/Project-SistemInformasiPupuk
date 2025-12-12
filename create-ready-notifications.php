<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BUAT NOTIFIKASI TEST UNTUK ORDER READY ===\n\n";

// Get Ready orders
$readyOrders = DB::table('orders')
    ->where('status', 'Ready')
    ->get();

echo "Orders dengan status Ready: " . $readyOrders->count() . "\n\n";

if ($readyOrders->count() == 0) {
    echo "Tidak ada order dengan status Ready!\n";
    echo "Silakan ubah status order melalui admin panel dulu.\n";
    exit;
}

foreach ($readyOrders as $order) {
    echo "Order: {$order->order_number} (ID: {$order->id})\n";
    echo "User ID: {$order->user_id}\n";
    echo "Status: {$order->status}\n";
    
    // Check if notification already exists
    $existingNotif = DB::table('notifications')
        ->where('user_id', $order->user_id)
        ->where('related_id', $order->id)
        ->where('related_type', 'App\\Models\\Order')
        ->first();
    
    if ($existingNotif) {
        echo "✓ Notifikasi sudah ada (ID: {$existingNotif->id})\n";
    } else {
        echo "⚠️ Notifikasi belum ada - akan dibuat...\n";
        
        // Create notification dengan format BARU (ada mention maps)
        $message = "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "✅ UPDATE STATUS PESANAN ✅\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "📋 No. Pesanan: #{$order->order_number}\n";
        $message .= "📦 Produk: " . ($order->product_name ?? 'Produk') . "\n";
        $message .= "📊 Jumlah: {$order->quantity} kg\n\n";
        $message .= "✨ Status Baru: ✅ Siap Diambil\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "✅ PESANAN SIAP DIAMBIL!\n";
        $message .= "Pesanan Anda sudah siap.\n";
        $message .= "Silakan datang untuk mengambil pesanan.\n\n";
        $message .= "📍 INFORMASI PENGAMBILAN:\n";
        $message .= "Sistem akan menunjukkan titik pengambilan terdekat dari lokasi Anda.\n";
        $message .= "⏰ Jam Operasional: 08.00 - 17.00 WIB\n";
        $message .= "📋 Harap bawa bukti pesanan dan identitas diri\n\n";
        $message .= "🗺️ LIHAT LOKASI PENGAMBILAN:\n";
        $message .= "Klik notifikasi ini untuk melihat peta lokasi pengambilan terdekat dari Anda.\n";
        $message .= "Atau buka profil Anda > Detail Pesanan > Lihat Lokasi Pengambilan\n";
        
        $notifId = DB::table('notifications')->insertGetId([
            'user_id' => $order->user_id,
            'type' => 'info',
            'title' => 'Pesanan Siap Diambil - ' . $order->order_number,
            'message' => $message,
            'link' => null,
            'status' => 'unread',
            'is_read' => 0,
            'related_id' => $order->id,
            'related_type' => 'App\\Models\\Order',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        echo "✓ Notifikasi berhasil dibuat (ID: {$notifId})\n";
    }
    
    echo "\n";
}

echo "=== DONE ===\n";
echo "\nSekarang login sebagai user dan cek notifikasi!\n";
echo "Tombol maps harus muncul di notifikasi Ready.\n";
