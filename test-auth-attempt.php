<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "=== TESTING AUTH::ATTEMPT ===\n\n";

// Create a mock request
$request = Request::create('/login', 'POST', [
    'login' => 'admin',
    'password' => 'admin123',
]);

$app->instance('request', $request);

// Test 1: Login dengan username
echo "Test 1: Login dengan username 'admin'\n";
$credentials = ['username' => 'admin', 'password' => 'admin123'];
$result = Auth::attempt($credentials);
echo "Result: " . ($result ? "✓ SUCCESS" : "✗ FAILED") . "\n";
if ($result) {
    echo "Logged in user: " . Auth::user()->nama_lengkap . "\n";
    Auth::logout();
}
echo "\n";

// Test 2: Login dengan email
echo "Test 2: Login dengan email\n";
$user = DB::table('users')->where('username', 'admin')->first();
$credentials = ['email' => $user->email, 'password' => 'admin123'];
$result = Auth::attempt($credentials);
echo "Email: {$user->email}\n";
echo "Result: " . ($result ? "✓ SUCCESS" : "✗ FAILED") . "\n";
if ($result) {
    echo "Logged in user: " . Auth::user()->nama_lengkap . "\n";
    Auth::logout();
}
echo "\n";

// Test 3: Login dengan wrong password
echo "Test 3: Login dengan wrong password\n";
$credentials = ['username' => 'admin', 'password' => 'wrongpassword'];
$result = Auth::attempt($credentials);
echo "Result: " . ($result ? "✓ SUCCESS (TIDAK SEHARUSNYA!)" : "✗ FAILED (benar)") . "\n\n";

// Test 4: Check password hash directly
echo "Test 4: Direct password verification\n";
$user = DB::table('users')->where('username', 'admin')->first();
$hashCheck = Hash::check('admin123', $user->password);
echo "Password hash check: " . ($hashCheck ? "✓ VALID" : "✗ INVALID") . "\n\n";

echo "=== KESIMPULAN ===\n";
echo "Jika semua test di atas SUKSES, maka masalah kemungkinan di:\n";
echo "1. Session/Cookie browser\n";
echo "2. CSRF token\n";
echo "3. Middleware redirect\n";
echo "\nSolusi: Clear browser cache dan cookies, lalu coba login lagi.\n";
