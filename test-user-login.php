<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "=== TESTING USER LOGIN ===\n\n";

// Get all users
$users = DB::table('users')->get();

echo "Total Users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Username: {$user->username}\n";
    echo "Email: {$user->email}\n";
    echo "Nama: {$user->nama_lengkap}\n";
    echo "Password Hash: " . substr($user->password, 0, 30) . "...\n";
    
    // Test password
    $testPasswords = ['password', 'password123', '123456', 'admin123'];
    foreach ($testPasswords as $pwd) {
        if (Hash::check($pwd, $user->password)) {
            echo "✓ PASSWORD MATCH: {$pwd}\n";
        }
    }
    echo "\n---\n\n";
}

// Test admin credentials
echo "=== ADMIN CREDENTIALS ===\n";
echo "Username: admin\n";
echo "Password: admin123\n";
echo "(Hardcoded in AdminController)\n";
