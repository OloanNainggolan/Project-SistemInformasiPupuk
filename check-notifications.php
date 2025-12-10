<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING NOTIFICATIONS TABLE ===\n\n";

// Get all notifications
$notifications = \App\Models\Notification::orderBy('created_at', 'desc')->get();

echo "Total notifications in database: " . $notifications->count() . "\n\n";

foreach ($notifications as $n) {
    echo "ID: {$n->id}\n";
    echo "User ID: {$n->user_id}\n";
    echo "Type: {$n->type}\n";
    echo "Title: {$n->title}\n";
    echo "Status: {$n->status}\n";
    echo "Is Read: " . ($n->is_read ? 'YES' : 'NO') . "\n";
    echo "Created: {$n->created_at}\n";
    echo "---\n\n";
}

// Check for specific user (assuming user ID 1)
echo "\n=== FOR USER ID 1 ===\n";
$userNotifications = \App\Models\Notification::where('user_id', 1)->orderBy('created_at', 'desc')->get();
echo "Total: " . $userNotifications->count() . "\n";
echo "Unread: " . \App\Models\Notification::where('user_id', 1)->where('is_read', false)->count() . "\n";
