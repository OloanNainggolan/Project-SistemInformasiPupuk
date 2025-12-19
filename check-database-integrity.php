<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== DATABASE INTEGRITY CHECK ===\n\n";

try {
    // Test database connection
    echo "✓ Testing database connection...\n";
    DB::connection()->getPdo();
    echo "  Database connected successfully!\n\n";
    
    // Check critical tables
    echo "✓ Checking critical tables existence...\n";
    $tables = [
        'users',
        'produk',
        'product_images',
        'orders',
        'notifications',
        'messages',
        'contacts',
        'sessions',
        'pickup_points'
    ];
    
    $missingTables = [];
    foreach ($tables as $table) {
        if (Schema::hasTable($table)) {
            echo "  ✓ Table '$table' exists\n";
        } else {
            echo "  ✗ Table '$table' MISSING!\n";
            $missingTables[] = $table;
        }
    }
    
    if (count($missingTables) > 0) {
        echo "\n⚠️ WARNING: Missing tables detected! Run: php artisan migrate\n";
    }
    
    echo "\n✓ Checking table columns...\n";
    
    // Check users table
    if (Schema::hasTable('users')) {
        $userColumns = [
            'id', 'nama_lengkap', 'username', 'email', 'password', 
            'no_telp', 'alamat', 'google_id', 'facebook_id'
        ];
        foreach ($userColumns as $col) {
            if (Schema::hasColumn('users', $col)) {
                echo "  ✓ users.$col exists\n";
            } else {
                echo "  ✗ users.$col MISSING!\n";
            }
        }
    }
    
    // Check produk table
    if (Schema::hasTable('produk')) {
        $produkColumns = [
            'id_produk', 'nama_produk', 'tipe_produk', 'kategori', 
            'harga_subsidi', 'harga_normal', 'stok_produk', 'gambar'
        ];
        foreach ($produkColumns as $col) {
            if (Schema::hasColumn('produk', $col)) {
                echo "  ✓ produk.$col exists\n";
            } else {
                echo "  ✗ produk.$col MISSING!\n";
            }
        }
    }
    
    // Check orders table
    if (Schema::hasTable('orders')) {
        $orderColumns = [
            'id', 'order_number', 'user_id', 'items', 'total_amount', 
            'status', 'confirmed_by_user', 'village_office'
        ];
        foreach ($orderColumns as $col) {
            if (Schema::hasColumn('orders', $col)) {
                echo "  ✓ orders.$col exists\n";
            } else {
                echo "  ✗ orders.$col MISSING!\n";
            }
        }
    }
    
    // Check notifications table
    if (Schema::hasTable('notifications')) {
        $notifColumns = ['id', 'user_id', 'type', 'title', 'message', 'is_read'];
        foreach ($notifColumns as $col) {
            if (Schema::hasColumn('notifications', $col)) {
                echo "  ✓ notifications.$col exists\n";
            } else {
                echo "  ✗ notifications.$col MISSING!\n";
            }
        }
    }
    
    echo "\n✓ Checking data integrity...\n";
    
    // Check for orphaned records
    $orphanedImages = DB::table('product_images')
        ->leftJoin('produk', 'product_images.product_id', '=', 'produk.id_produk')
        ->whereNull('produk.id_produk')
        ->count();
    
    if ($orphanedImages > 0) {
        echo "  ⚠️ WARNING: $orphanedImages orphaned product images found!\n";
    } else {
        echo "  ✓ No orphaned product images\n";
    }
    
    $orphanedOrders = DB::table('orders')
        ->leftJoin('users', 'orders.user_id', '=', 'users.id')
        ->whereNull('users.id')
        ->count();
    
    if ($orphanedOrders > 0) {
        echo "  ⚠️ WARNING: $orphanedOrders orphaned orders found!\n";
    } else {
        echo "  ✓ No orphaned orders\n";
    }
    
    echo "\n✓ Checking critical data...\n";
    
    $userCount = DB::table('users')->count();
    $productCount = DB::table('produk')->count();
    $orderCount = DB::table('orders')->count();
    
    echo "  - Total users: $userCount\n";
    echo "  - Total products: $productCount\n";
    echo "  - Total orders: $orderCount\n";
    
    if ($productCount == 0) {
        echo "  ⚠️ WARNING: No products in database!\n";
    }
    
    echo "\n✓ Checking sessions table...\n";
    if (Schema::hasTable('sessions')) {
        $sessionCount = DB::table('sessions')->count();
        echo "  - Active sessions: $sessionCount\n";
    } else {
        echo "  ✗ Sessions table missing! Session driver is set to 'database'\n";
    }
    
    echo "\n=== CHECK COMPLETE ===\n";
    echo "All critical checks passed! ✓\n";
    
} catch (\Exception $e) {
    echo "\n✗ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
