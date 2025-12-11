<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test update notification
$notifId = 5;

echo "=== BEFORE UPDATE ===\n";
$notif = \App\Models\Notification::find($notifId);
echo "ID: {$notif->id}\n";
echo "is_read: {$notif->is_read}\n";
echo "status: {$notif->status}\n\n";

echo "=== UPDATING ===\n";
\DB::table('notifications')
    ->where('id', $notifId)
    ->update([
        'is_read' => 1,
        'status' => 'read',
        'updated_at' => now()
    ]);

echo "=== AFTER UPDATE ===\n";
$notif = \App\Models\Notification::find($notifId);
echo "ID: {$notif->id}\n";
echo "is_read: {$notif->is_read}\n";
echo "status: {$notif->status}\n";
