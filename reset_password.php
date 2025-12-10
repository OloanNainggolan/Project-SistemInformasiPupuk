<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== PASSWORD RESET UTILITY ===\n\n";

// List all users
echo "Available users:\n";
echo str_repeat("-", 80) . "\n";
$users = User::all(['id', 'name', 'email', 'username']);
foreach ($users as $u) {
    echo "{$u->id}. {$u->name} (Email: {$u->email}, Username: {$u->username})\n";
}
echo str_repeat("-", 80) . "\n\n";

// Prompt for user ID
echo "Enter User ID to reset password: ";
$userId = trim(fgets(STDIN));

$user = User::find($userId);

if (!$user) {
    echo "❌ User not found!\n";
    exit;
}

echo "\nSelected user: {$user->name} ({$user->email})\n";

// Prompt for new password
echo "Enter new password (min 3 characters): ";
$newPassword = trim(fgets(STDIN));

if (strlen($newPassword) < 3) {
    echo "❌ Password must be at least 3 characters!\n";
    exit;
}

// Confirm password
echo "Confirm new password: ";
$confirmPassword = trim(fgets(STDIN));

if ($newPassword !== $confirmPassword) {
    echo "❌ Passwords don't match!\n";
    exit;
}

// Update password
$user->password = Hash::make($newPassword);
$user->save();

echo "\n✓ Password successfully updated!\n";
echo "\nNew login credentials:\n";
echo "Email: {$user->email}\n";
echo "Password: {$newPassword}\n";
echo "\nYou can now login with these credentials.\n";
