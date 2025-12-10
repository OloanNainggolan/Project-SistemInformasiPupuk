<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ALL MESSAGES FOR USER 1 ===\n\n";

$messages = \App\Models\Message::where('user_id', 1)
    ->whereNull('reply_to')
    ->orderBy('id', 'desc')
    ->get();

foreach ($messages as $msg) {
    echo "ID: {$msg->id} | Status: {$msg->status} | Subject: {$msg->subject}\n";
}
