<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== TESTING AUTHENTICATION ===\n\n";

// Test dengan email dan password
$testEmail = 'test@example.com';
$testPassword = '123'; // Password yang di-hash adalah '123'

echo "Testing login with:\n";
echo "Email: {$testEmail}\n";
echo "Password: {$testPassword}\n\n";

$user = User::where('email', $testEmail)->first();

if ($user) {
    echo "✓ User found in database\n";
    echo "User ID: {$user->id}\n";
    echo "User Name: {$user->name}\n";
    echo "User Email: {$user->email}\n\n";
    
    // Test password verification
    echo "Testing password verification...\n";
    if (Hash::check($testPassword, $user->password)) {
        echo "✓ Password is CORRECT!\n";
        echo "Auth::attempt() should work with these credentials.\n";
    } else {
        echo "✗ Password is INCORRECT!\n";
        echo "The password in database doesn't match '{$testPassword}'\n";
        
        // Try common passwords
        $commonPasswords = ['123', 'password', 'test', 'test123', '12345678'];
        echo "\nTrying common passwords:\n";
        foreach ($commonPasswords as $pwd) {
            if (Hash::check($pwd, $user->password)) {
                echo "✓ Found matching password: '{$pwd}'\n";
                break;
            }
        }
    }
} else {
    echo "✗ User NOT found with email: {$testEmail}\n";
}

echo "\n" . str_repeat("=", 60) . "\n\n";

// List all users with basic info
echo "All registered users:\n";
$users = User::all(['id', 'name', 'email', 'username']);
foreach ($users as $u) {
    echo "- ID: {$u->id} | Email: {$u->email} | Username: {$u->username}\n";
}
