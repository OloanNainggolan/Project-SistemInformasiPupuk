<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== CREATE TEST USER WITH KNOWN PASSWORD ===\n\n";

$email = 'demo@test.com';
$password = '123456';

// Check if user exists
$existingUser = User::where('email', $email)->first();

if ($existingUser) {
    echo "User with email {$email} already exists!\n";
    echo "Updating password to: {$password}\n\n";
    
    $existingUser->password = Hash::make($password);
    $existingUser->save();
    
    echo "✓ Password updated!\n";
} else {
    echo "Creating new user...\n\n";
    
    $user = User::create([
        'name' => 'Demo User',
        'nama_lengkap' => 'Demo User',
        'username' => 'demouser',
        'alamat' => 'Jl. Test No. 123',
        'alamat_balai_desa' => 'Balai Desa Test',
        'no_telp' => '081234567890',
        'email' => $email,
        'password' => Hash::make($password),
    ]);
    
    echo "✓ User created successfully!\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "LOGIN CREDENTIALS:\n";
echo str_repeat("=", 60) . "\n";
echo "Email: {$email}\n";
echo "Password: {$password}\n";
echo str_repeat("=", 60) . "\n";
echo "\nYou can now login at: http://127.0.0.1:8000/login\n";
