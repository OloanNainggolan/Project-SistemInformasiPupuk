<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$notifications = App\Models\Notification::all(['id', 'title', 'is_read', 'status', 'user_id']);

echo "Notifications in database:\n";
echo str_repeat("=", 80) . "\n";

foreach ($notifications as $notif) {
    echo sprintf(
        "ID: %d | User: %d | Title: %s\n  is_read: %s | status: %s\n",
        $notif->id,
        $notif->user_id,
        substr($notif->title, 0, 40),
        var_export($notif->is_read, true),
        $notif->status
    );
    echo str_repeat("-", 80) . "\n";
}
