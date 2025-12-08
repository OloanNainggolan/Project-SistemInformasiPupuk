<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== VERIFIKASI AKUN DEMO ===\n\n";

$email = 'demo@test.com';
$password = '123456';

$user = User::where('email', $email)->first();

if (!$user) {
    echo "❌ User tidak ditemukan!\n";
    exit;
}

echo "User Information:\n";
echo str_repeat("-", 60) . "\n";
echo "ID: {$user->id}\n";
echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Username: {$user->username}\n";
echo "Created: {$user->created_at}\n";
echo str_repeat("-", 60) . "\n\n";

echo "Testing Login Credentials:\n";
echo "Email: {$email}\n";
echo "Password: {$password}\n\n";

if (Hash::check($password, $user->password)) {
    echo "✅ PASSWORD COCOK!\n\n";
    echo "Credentials ini BISA digunakan untuk login:\n";
    echo "1. Buka: http://127.0.0.1:8000/login\n";
    echo "2. Email: {$email}\n";
    echo "3. Password: {$password}\n";
    echo "4. Klik Login\n\n";
    echo "Setelah login berhasil:\n";
    echo "- Anda akan masuk ke dashboard\n";
    echo "- Bisa logout\n";
    echo "- Bisa login lagi dengan kredensial yang sama\n";
} else {
    echo "❌ PASSWORD TIDAK COCOK!\n";
    echo "Ada masalah dalam pembuatan user.\n";
}
