<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "==============================================\n";
echo "    CHECKING USERS IN DATABASE\n";
echo "==============================================\n\n";

try {
    $users = DB::table('users')->get();
    
    if ($users->isEmpty()) {
        echo "❌ Tidak ada user di database\n";
    } else {
        echo "Total users: " . $users->count() . "\n\n";
        
        foreach ($users as $user) {
            echo "ID: {$user->id}\n";
            echo "Nama: {$user->nama_lengkap}\n";
            echo "Email: {$user->email}\n";
            echo "Username: " . ($user->username ?? '-') . "\n";
            echo "Google ID: " . ($user->google_id ?? '-') . "\n";
            echo "Created: {$user->created_at}\n";
            echo "---\n";
        }
    }
    
    // Check for Prisca specifically
    echo "\n==============================================\n";
    echo "Searching for 'Prisca':\n";
    echo "==============================================\n";
    
    $prisca = DB::table('users')
        ->where('nama_lengkap', 'LIKE', '%Prisca%')
        ->orWhere('email', 'LIKE', '%friskarevalinamanurung%')
        ->get();
    
    if ($prisca->isEmpty()) {
        echo "✅ User 'Prisca' TIDAK DITEMUKAN (sudah terhapus)\n";
    } else {
        echo "❌ User 'Prisca' MASIH ADA di database:\n";
        foreach ($prisca as $p) {
            echo "  - ID: {$p->id}, Email: {$p->email}\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n==============================================\n";
