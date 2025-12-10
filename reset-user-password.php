<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "=== RESET USER PASSWORDS ===\n\n";

// Reset password untuk user dengan username 'admin'
$updated = DB::table('users')
    ->where('username', 'admin')
    ->update([
        'password' => Hash::make('admin123')
    ]);

if ($updated) {
    echo "✓ Password reset untuk username 'admin'\n";
    echo "  Username: admin\n";
    echo "  Password: admin123\n\n";
}

// Reset password untuk user dengan username 'testuser'
$updated = DB::table('users')
    ->where('username', 'testuser')
    ->update([
        'password' => Hash::make('password123')
    ]);

if ($updated) {
    echo "✓ Password reset untuk username 'testuser'\n";
    echo "  Username: testuser\n";
    echo "  Password: password123\n\n";
}

// Tampilkan semua users
echo "=== ALL USERS ===\n";
$users = DB::table('users')->select('id', 'username', 'email', 'nama_lengkap')->get();
foreach ($users as $user) {
    echo "- ID: {$user->id} | Username: {$user->username} | Email: {$user->email} | Nama: {$user->nama_lengkap}\n";
}

echo "\n✓ Password reset selesai!\n";
echo "\nAnda bisa login dengan:\n";
echo "1. Username: admin / Password: admin123\n";
echo "2. Username: testuser / Password: password123\n";
echo "\nUntuk login admin panel: http://127.0.0.1:8000/admin/login\n";
echo "  Username: admin\n";
echo "  Password: admin123\n";
