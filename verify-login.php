<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

echo "=== VERIFY USER LOGIN ===\n\n";

// Test credentials
$testCases = [
    ['username' => 'admin', 'password' => 'admin123'],
    ['username' => 'testuser', 'password' => 'password123'],
];

foreach ($testCases as $test) {
    echo "Testing: {$test['username']} / {$test['password']}\n";
    
    $user = DB::table('users')->where('username', $test['username'])->first();
    
    if ($user) {
        $match = Hash::check($test['password'], $user->password);
        if ($match) {
            echo "  ✓ PASSWORD VALID\n";
            echo "  User: {$user->nama_lengkap}\n";
            echo "  Email: {$user->email}\n";
        } else {
            echo "  ✗ PASSWORD INVALID\n";
        }
    } else {
        echo "  ✗ USER NOT FOUND\n";
    }
    echo "\n";
}

echo "=== ADMIN LOGIN (Hardcoded) ===\n";
echo "Username: admin\n";
echo "Password: admin123\n";
echo "Route: /admin/login\n";
echo "Controller: AdminController (hardcoded credentials)\n\n";

echo "=== USER LOGIN ===\n";
echo "Username/Email: admin atau chrismansyaht19@gmail.com\n";
echo "Password: admin123\n";
echo "Route: /login\n";
echo "Controller: AuthController (database authentication)\n";
