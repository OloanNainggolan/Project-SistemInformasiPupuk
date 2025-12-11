<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check notification content
$notifications = \App\Models\Notification::whereIn('id', [4, 5])
    ->get();

echo "=== NOTIFICATION CONTENT CHECK ===\n\n";
foreach ($notifications as $n) {
    echo "ID: {$n->id}\n";
    echo "Title: {$n->title}\n";
    echo "Message Preview (first 200 chars):\n";
    echo substr($n->message, 0, 200) . "...\n";
    echo "\n---\n\n";
}
