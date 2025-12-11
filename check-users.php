<?php
// Check user data
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$users = DB::table('users')->select('id', 'name', 'username', 'email', 'password', 'created_at')->get();

echo "Total users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "=================================\n";
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Username: {$user->username}\n";
    echo "Email: {$user->email}\n";
    echo "Password (first 60 chars): " . substr($user->password, 0, 60) . "\n";
    echo "Password is hashed? " . (str_starts_with($user->password, '$2y$') ? 'YES (bcrypt)' : 'NO (plain text or other)') . "\n";
    echo "Created: {$user->created_at}\n";
    echo "\n";
}
