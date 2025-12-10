<?php
// Test login functionality
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;

echo "=== LOGIN TESTING TOOL ===\n\n";

// Get username/email to test
echo "Enter username or email to test: ";
$login = trim(fgets(STDIN));

// Get password to test
echo "Enter password: ";
$password = trim(fgets(STDIN));

// Determine login type
$loginType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
echo "\nLogin type detected: $loginType\n";

// Find user
$user = DB::table('users')->where($loginType, $login)->first();

if (!$user) {
    echo "❌ ERROR: User not found!\n";
    exit(1);
}

echo "\n✅ User found:\n";
echo "  ID: {$user->id}\n";
echo "  Name: {$user->name}\n";
echo "  Email: {$user->email}\n";
echo "  Username: {$user->username}\n";

// Check password
echo "\n=== PASSWORD CHECK ===\n";
echo "Password in database (first 60 chars): " . substr($user->password, 0, 60) . "\n";
echo "Password is hashed? " . (str_starts_with($user->password, '$2y$') ? 'YES' : 'NO') . "\n";

if (str_starts_with($user->password, '$2y$')) {
    // Hashed password
    $match = Hash::check($password, $user->password);
    echo "Password match (using Hash::check)? " . ($match ? '✅ YES' : '❌ NO') . "\n";
} else {
    // Plain text
    $match = ($password === $user->password);
    echo "Password match (plain text)? " . ($match ? '✅ YES' : '❌ NO') . "\n";
}

if ($match) {
    echo "\n🎉 LOGIN SUCCESSFUL!\n";
    echo "You should be able to login with these credentials.\n";
} else {
    echo "\n❌ LOGIN FAILED!\n";
    echo "Password does not match. Please try again or reset your password.\n";
}
