<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "==============================================\n";
echo "    CHECKING USERS TABLE STRUCTURE\n";
echo "==============================================\n\n";

try {
    $columns = DB::select("SHOW COLUMNS FROM users");
    
    echo "Kolom yang ada di tabel users:\n";
    echo "--------------------------------\n";
    
    $hasName = false;
    foreach ($columns as $column) {
        $nullable = $column->Null === 'YES' ? '(nullable)' : '(required)';
        echo "- {$column->Field} [{$column->Type}] $nullable\n";
        
        if ($column->Field === 'name') {
            $hasName = true;
        }
    }
    
    echo "\n==============================================\n";
    echo "DIAGNOSIS:\n";
    echo "==============================================\n";
    
    if ($hasName) {
        echo "✅ Kolom 'name' SUDAH ADA di tabel users\n";
        echo "\nError mungkin karena:\n";
        echo "1. Cache model Laravel belum di-refresh\n";
        echo "2. Field 'name' tidak ada di Model fillable\n";
    } else {
        echo "❌ Kolom 'name' TIDAK ADA di tabel users\n";
        echo "\nSolusi:\n";
        echo "1. Jalankan: php artisan migrate:fresh\n";
        echo "   (WARNING: Ini akan menghapus semua data!)\n";
        echo "2. Atau buat migration baru untuk menambah kolom 'name'\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n==============================================\n";
