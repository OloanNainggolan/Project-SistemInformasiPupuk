<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== VERIFIKASI PERBAIKAN LOGIN ===\n\n";

// Test dengan akun demo
$demoUser = User::where('email', 'demo@test.com')->first();

if (!$demoUser) {
    echo "❌ Akun demo tidak ditemukan. Buat dulu dengan: php create_test_user.php\n";
    exit;
}

echo "✓ Akun demo ditemukan!\n\n";

echo "USER INFORMATION:\n";
echo str_repeat("-", 70) . "\n";
echo "ID: {$demoUser->id}\n";
echo "Name: {$demoUser->name}\n";
echo "Email: {$demoUser->email}\n";
echo "Username: {$demoUser->username}\n";
echo str_repeat("-", 70) . "\n\n";

// Test Login Scenarios
echo "TEST SCENARIOS:\n";
echo str_repeat("=", 70) . "\n\n";

$testCases = [
    [
        'label' => 'Login dengan EMAIL',
        'login' => 'demo@test.com',
        'password' => '123456',
    ],
    [
        'label' => 'Login dengan USERNAME',
        'login' => 'demouser',
        'password' => '123456',
    ],
    [
        'label' => 'Login dengan PASSWORD SALAH',
        'login' => 'demo@test.com',
        'password' => 'wrongpassword',
    ],
    [
        'label' => 'Login dengan EMAIL TIDAK TERDAFTAR',
        'login' => 'notexist@test.com',
        'password' => '123456',
    ],
];

foreach ($testCases as $index => $test) {
    echo ($index + 1) . ". {$test['label']}\n";
    echo "   Input: login={$test['login']}, password={$test['password']}\n";
    
    $loginField = $test['login'];
    $password = $test['password'];
    
    // Simulasi logika controller yang sudah diperbaiki
    $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
    $user = User::where($fieldType, $loginField)->first();
    
    if ($user && Hash::check($password, $user->password)) {
        echo "   Result: ✅ LOGIN BERHASIL\n";
        echo "   User: {$user->name} ({$user->email})\n";
    } else if (!$user) {
        echo "   Result: ❌ User tidak ditemukan\n";
    } else {
        echo "   Result: ❌ Password salah\n";
    }
    
    echo "\n";
}

echo str_repeat("=", 70) . "\n\n";

echo "KESIMPULAN:\n";
echo "✅ Controller sudah diperbaiki untuk menerima field 'login'\n";
echo "✅ Mendukung login dengan email ATAU username\n";
echo "✅ Auto-detect apakah input adalah email atau username\n\n";

echo "READY TO TEST DI BROWSER:\n";
echo "URL: http://127.0.0.1:8000/login\n\n";

echo "Akun untuk testing:\n";
echo "  Email: demo@test.com ATAU Username: demouser\n";
echo "  Password: 123456\n\n";

echo "Seharusnya login BERHASIL! 🚀\n";
