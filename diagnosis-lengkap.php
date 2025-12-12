<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "╔══════════════════════════════════════╗\n";
echo "║   DATABASE CONNECTION TEST           ║\n";
echo "╚══════════════════════════════════════╝\n\n";

// 1. Test koneksi database
try {
    DB::connection()->getPdo();
    echo "✅ Database TERHUBUNG\n";
    $dbName = DB::connection()->getDatabaseName();
    echo "   Database: {$dbName}\n\n";
} catch (\Exception $e) {
    echo "❌ Database TIDAK TERHUBUNG!\n";
    echo "   Error: " . $e->getMessage() . "\n";
    exit(1);
}

// 2. Cek tabel penting
echo "╔══════════════════════════════════════╗\n";
echo "║   CEK TABEL                          ║\n";
echo "╚══════════════════════════════════════╝\n\n";

$tables = ['users', 'orders', 'notifications', 'pickup_points'];
foreach ($tables as $table) {
    try {
        $count = DB::table($table)->count();
        echo "✅ {$table}: {$count} rows\n";
    } catch (\Exception $e) {
        echo "❌ {$table}: ERROR - " . $e->getMessage() . "\n";
    }
}

// 3. Cek users
echo "\n╔══════════════════════════════════════╗\n";
echo "║   DATA USERS                         ║\n";
echo "╚══════════════════════════════════════╝\n\n";

$users = DB::table('users')->get(['id', 'name', 'email']);
foreach ($users as $user) {
    echo "User #{$user->id}: {$user->name} ({$user->email})\n";
}

// 4. Cek orders dengan status Ready
echo "\n╔══════════════════════════════════════╗\n";
echo "║   ORDERS STATUS READY                ║\n";
echo "╚══════════════════════════════════════╝\n\n";

$readyOrders = DB::table('orders')
    ->where('status', 'Ready')
    ->get(['id', 'order_number', 'user_id', 'status', 'created_at']);

if ($readyOrders->count() > 0) {
    foreach ($readyOrders as $order) {
        echo "Order #{$order->id}: {$order->order_number}\n";
        echo "  User ID: {$order->user_id}\n";
        echo "  Status: {$order->status}\n";
        echo "  Created: {$order->created_at}\n\n";
    }
} else {
    echo "❌ TIDAK ADA ORDER DENGAN STATUS READY!\n";
    echo "   Ini masalahnya! Tidak ada order Ready = tidak ada yang bisa ditampilkan.\n\n";
}

// 5. Cek notifications
echo "╔══════════════════════════════════════╗\n";
echo "║   NOTIFICATIONS                      ║\n";
echo "╚══════════════════════════════════════╝\n\n";

$notifications = DB::table('notifications')
    ->orderBy('created_at', 'desc')
    ->get();

if ($notifications->count() > 0) {
    foreach ($notifications as $notif) {
        echo "Notif #{$notif->id}: {$notif->title}\n";
        echo "  User ID: {$notif->user_id}\n";
        echo "  Type: {$notif->type}\n";
        echo "  Is Read: {$notif->is_read}\n";
        echo "  Related: {$notif->related_type} #{$notif->related_id}\n";
        
        // Extract order number
        if (preg_match('/ORD-\d{8}-[A-F0-9]{6}/i', $notif->message, $matches)) {
            echo "  Order: {$matches[0]}\n";
        }
        
        echo "  Created: {$notif->created_at}\n\n";
    }
} else {
    echo "❌ TIDAK ADA NOTIFICATIONS!\n";
    echo "   Tabel notifications kosong.\n\n";
}

// 6. Cek pickup points
echo "╔══════════════════════════════════════╗\n";
echo "║   PICKUP POINTS                      ║\n";
echo "╚══════════════════════════════════════╝\n\n";

$pickups = DB::table('pickup_points')->get();
if ($pickups->count() > 0) {
    foreach ($pickups as $p) {
        echo "📍 {$p->name}\n";
        echo "   {$p->address}\n";
        echo "   Lat: {$p->latitude}, Lng: {$p->longitude}\n\n";
    }
} else {
    echo "❌ TIDAK ADA PICKUP POINTS!\n\n";
}

// 7. DIAGNOSIS
echo "╔══════════════════════════════════════╗\n";
echo "║   DIAGNOSIS                          ║\n";
echo "╚══════════════════════════════════════╝\n\n";

$issues = [];

if (DB::table('orders')->where('status', 'Ready')->count() == 0) {
    $issues[] = "❌ Tidak ada order dengan status Ready";
}

if (DB::table('notifications')->count() == 0) {
    $issues[] = "❌ Tabel notifications kosong";
}

if (DB::table('pickup_points')->count() == 0) {
    $issues[] = "❌ Tabel pickup_points kosong";
}

if (count($issues) > 0) {
    echo "MASALAH DITEMUKAN:\n";
    foreach ($issues as $issue) {
        echo "  {$issue}\n";
    }
    
    echo "\n💡 SOLUSI:\n";
    if (in_array("❌ Tidak ada order dengan status Ready", $issues)) {
        echo "  1. Buka Admin Panel\n";
        echo "  2. Pergi ke Pesanan\n";
        echo "  3. Ubah status pesanan ke 'Ready'\n\n";
    }
    if (in_array("❌ Tabel pickup_points kosong", $issues)) {
        echo "  Run: php artisan db:seed --class=PickupPointSeeder\n\n";
    }
} else {
    echo "✅ Semua data lengkap!\n";
    echo "   Masalahnya mungkin di browser cache.\n";
    echo "   Coba: Ctrl+Shift+R atau buka Incognito\n";
}
