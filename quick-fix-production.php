<?php

/**
 * Quick Fix Script untuk masalah umum di production
 * Jalankan: php quick-fix-production.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "\n=== QUICK FIX FOR COMMON PRODUCTION ISSUES ===\n\n";

// Menu
echo "Pilih fix yang ingin dijalankan:\n";
echo "1. Fix CSRF Token / Page Expired Error\n";
echo "2. Fix Storage Link Issues\n";
echo "3. Fix Permissions (direktori)\n";
echo "4. Fix Session Issues\n";
echo "5. Fix Database Connection\n";
echo "6. Clear All Caches\n";
echo "7. Fix Missing Migrations\n";
echo "8. Fix Empty Notifications\n";
echo "9. Run All Fixes\n";
echo "0. Exit\n\n";

$choice = readline("Pilih (0-9): ");

switch ($choice) {
    case '1':
        fixCsrfToken();
        break;
    case '2':
        fixStorageLink();
        break;
    case '3':
        fixPermissions();
        break;
    case '4':
        fixSession();
        break;
    case '5':
        fixDatabase();
        break;
    case '6':
        clearAllCaches();
        break;
    case '7':
        fixMigrations();
        break;
    case '8':
        fixEmptyNotifications();
        break;
    case '9':
        runAllFixes();
        break;
    case '0':
        echo "Keluar...\n";
        exit(0);
    default:
        echo "Pilihan tidak valid!\n";
        exit(1);
}

function fixCsrfToken() {
    echo "\n[FIX] Memperbaiki CSRF Token Issues...\n";
    
    // 1. Clear config
    Artisan::call('config:clear');
    echo "✓ Config cleared\n";
    
    // 2. Clear cache
    Artisan::call('cache:clear');
    echo "✓ Cache cleared\n";
    
    // 3. Clear views
    Artisan::call('view:clear');
    echo "✓ Views cleared\n";
    
    // 4. Check session driver
    $sessionDriver = config('session.driver');
    echo "✓ Session driver: $sessionDriver\n";
    
    if ($sessionDriver === 'database') {
        if (Schema::hasTable('sessions')) {
            echo "✓ Sessions table exists\n";
            
            // Clear old sessions
            $deleted = DB::table('sessions')->where('last_activity', '<', time() - 7200)->delete();
            echo "✓ Cleared $deleted old sessions\n";
        } else {
            echo "✗ Sessions table NOT found! Run: php artisan migrate\n";
        }
    }
    
    echo "\n✓ CSRF Token fix completed!\n";
    echo "Silakan refresh browser dan coba lagi.\n";
}

function fixStorageLink() {
    echo "\n[FIX] Memperbaiki Storage Link...\n";
    
    $publicStorage = public_path('storage');
    
    // Hapus link lama jika ada
    if (file_exists($publicStorage)) {
        if (is_link($publicStorage)) {
            unlink($publicStorage);
            echo "✓ Old storage link removed\n";
        } else {
            echo "⚠️ public/storage exists but not a symlink\n";
        }
    }
    
    // Buat link baru
    Artisan::call('storage:link');
    echo Artisan::output();
    
    echo "✓ Storage link fix completed!\n";
}

function fixPermissions() {
    echo "\n[FIX] Memperbaiki Permissions...\n";
    
    $directories = [
        'storage',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'storage/app',
        'storage/app/public',
        'bootstrap/cache',
        'public/images',
        'public/images/products',
    ];
    
    foreach ($directories as $dir) {
        $path = base_path($dir);
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
            echo "✓ Created: $dir\n";
        } else {
            chmod($path, 0775);
            echo "✓ Fixed permissions: $dir\n";
        }
    }
    
    echo "\n✓ Permissions fix completed!\n";
    echo "Note: Pada Linux, jalankan juga: chown -R www-data:www-data storage bootstrap/cache\n";
}

function fixSession() {
    echo "\n[FIX] Memperbaiki Session Issues...\n";
    
    // Check session configuration
    $driver = config('session.driver');
    echo "Session driver: $driver\n";
    
    if ($driver === 'database') {
        // Ensure sessions table exists
        if (Schema::hasTable('sessions')) {
            echo "✓ Sessions table exists\n";
            
            // Clear expired sessions
            $deleted = DB::table('sessions')
                ->where('last_activity', '<', time() - config('session.lifetime') * 60)
                ->delete();
            echo "✓ Cleared $deleted expired sessions\n";
        } else {
            echo "✗ Sessions table missing! Run: php artisan migrate\n";
        }
    } elseif ($driver === 'file') {
        $path = storage_path('framework/sessions');
        if (file_exists($path)) {
            $files = glob($path . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            echo "✓ Cleared file sessions\n";
        }
    }
    
    Artisan::call('config:clear');
    echo "✓ Config cleared\n";
    
    echo "\n✓ Session fix completed!\n";
}

function fixDatabase() {
    echo "\n[FIX] Memeriksa Database Connection...\n";
    
    try {
        DB::connection()->getPdo();
        echo "✓ Database connected successfully!\n";
        
        // Check critical tables
        $tables = ['users', 'produk', 'orders', 'notifications', 'sessions'];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                echo "✓ Table '$table' exists ($count rows)\n";
            } else {
                echo "✗ Table '$table' missing!\n";
            }
        }
        
    } catch (\Exception $e) {
        echo "✗ Database connection failed!\n";
        echo "Error: " . $e->getMessage() . "\n";
        echo "\nCheck your .env file:\n";
        echo "- DB_HOST\n";
        echo "- DB_PORT\n";
        echo "- DB_DATABASE\n";
        echo "- DB_USERNAME\n";
        echo "- DB_PASSWORD\n";
    }
}

function clearAllCaches() {
    echo "\n[FIX] Clearing All Caches...\n";
    
    Artisan::call('config:clear');
    echo "✓ Config cache cleared\n";
    
    Artisan::call('route:clear');
    echo "✓ Route cache cleared\n";
    
    Artisan::call('view:clear');
    echo "✓ View cache cleared\n";
    
    Artisan::call('cache:clear');
    echo "✓ Application cache cleared\n";
    
    echo "\n✓ All caches cleared!\n";
}

function fixMigrations() {
    echo "\n[FIX] Checking Migrations...\n";
    
    Artisan::call('migrate:status');
    echo Artisan::output();
    
    $response = readline("\nRun pending migrations? (y/N): ");
    if (strtolower($response) === 'y') {
        Artisan::call('migrate --force');
        echo Artisan::output();
        echo "✓ Migrations completed!\n";
    } else {
        echo "Skipped migrations.\n";
    }
}

function fixEmptyNotifications() {
    echo "\n[FIX] Fixing Empty Notifications...\n";
    
    try {
        // Check for notifications with empty or null data
        $emptyNotifs = DB::table('notifications')
            ->whereNull('data')
            ->orWhere('data', '')
            ->orWhere('data', '{}')
            ->count();
        
        if ($emptyNotifs > 0) {
            echo "Found $emptyNotifs notifications with empty data\n";
            
            $response = readline("Delete these notifications? (y/N): ");
            if (strtolower($response) === 'y') {
                $deleted = DB::table('notifications')
                    ->whereNull('data')
                    ->orWhere('data', '')
                    ->orWhere('data', '{}')
                    ->delete();
                echo "✓ Deleted $deleted empty notifications\n";
            }
        } else {
            echo "✓ No empty notifications found\n";
        }
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
    }
}

function runAllFixes() {
    echo "\n[FIX] Running All Fixes...\n\n";
    
    clearAllCaches();
    fixPermissions();
    fixStorageLink();
    fixSession();
    fixDatabase();
    
    echo "\n=== ALL FIXES COMPLETED ===\n";
    echo "Silakan test aplikasi Anda.\n";
}

echo "\n";
