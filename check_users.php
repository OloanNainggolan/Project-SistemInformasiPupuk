<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING USERS TABLE ===\n\n";

$users = DB::table('users')->get();

echo "Total users: " . $users->count() . "\n\n";

if ($users->count() > 0) {
    echo "Users List:\n";
    echo str_repeat("-", 80) . "\n";
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Username: " . ($user->username ?? 'N/A') . "\n";
        echo "Created: {$user->created_at}\n";
        echo "Password (hashed): " . substr($user->password, 0, 50) . "...\n";
        echo str_repeat("-", 80) . "\n";
    }
} else {
    echo "No users found in database.\n";
}

echo "\n=== CHECKING SESSIONS TABLE ===\n\n";

$sessions = DB::table('sessions')->count();
echo "Total active sessions: {$sessions}\n";
