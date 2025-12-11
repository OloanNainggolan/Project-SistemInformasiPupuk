<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Simulate mark all as read for user_id = 1
$userId = 1;

echo "=== BEFORE MARK ALL AS READ ===\n";
$notifications = \App\Models\Notification::where('user_id', $userId)
    ->get(['id', 'title', 'is_read', 'status']);

foreach ($notifications as $n) {
    echo "ID: {$n->id} | is_read: {$n->is_read} | status: {$n->status}\n";
}

echo "\n=== UPDATING ALL TO READ ===\n";
$affected = \DB::table('notifications')
    ->where('user_id', $userId)
    ->where('is_read', 0)
    ->update([
        'is_read' => 1,
        'status' => 'read',
        'updated_at' => now()
    ]);

echo "Updated {$affected} notifications\n\n";

echo "=== AFTER UPDATE ===\n";
$notifications = \App\Models\Notification::where('user_id', $userId)
    ->get(['id', 'title', 'is_read', 'status']);

foreach ($notifications as $n) {
    echo "ID: {$n->id} | is_read: {$n->is_read} | status: {$n->status}\n";
}
