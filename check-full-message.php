<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check notification full message
$notification = \App\Models\Notification::find(5);

echo "=== FULL MESSAGE CONTENT (ID: 5) ===\n\n";
echo $notification->message;
echo "\n\n=== END ===\n";
