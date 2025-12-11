<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "==============================================\n";
echo "    FORCE DELETE USER PRISCA\n";
echo "==============================================\n\n";

try {
    // Find Prisca
    $prisca = DB::table('users')
        ->where('email', 'friskarevalinamanurung@gmail.com')
        ->first();
    
    if (!$prisca) {
        echo "✅ User Prisca sudah tidak ada\n";
        exit;
    }
    
    echo "Found user:\n";
    echo "  ID: {$prisca->id}\n";
    echo "  Nama: {$prisca->nama_lengkap}\n";
    echo "  Email: {$prisca->email}\n\n";
    
    // Delete related data
    echo "Deleting related data...\n";
    
    $ordersDeleted = DB::table('orders')->where('user_id', $prisca->id)->delete();
    echo "  - Orders deleted: {$ordersDeleted}\n";
    
    $notifDeleted = DB::table('notifications')->where('user_id', $prisca->id)->delete();
    echo "  - Notifications deleted: {$notifDeleted}\n";
    
    $messagesDeleted = DB::table('messages')->where('user_id', $prisca->id)->delete();
    echo "  - Messages deleted: {$messagesDeleted}\n";
    
    // Delete user
    echo "\nDeleting user...\n";
    $deleted = DB::table('users')->where('id', $prisca->id)->delete();
    
    if ($deleted) {
        echo "✅ User Prisca berhasil dihapus dari database!\n";
    } else {
        echo "❌ Gagal menghapus user\n";
    }
    
    // Verify
    echo "\nVerifying...\n";
    $check = DB::table('users')->where('id', $prisca->id)->first();
    if (!$check) {
        echo "✅ Verified: User tidak ada lagi di database\n";
    } else {
        echo "❌ User masih ada!\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n==============================================\n";
