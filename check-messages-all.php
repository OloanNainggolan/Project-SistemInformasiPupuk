<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CEK MESSAGES UNTUK SEMUA USER ===\n\n";

$messages = \App\Models\Message::orderBy('created_at', 'desc')->get();

if ($messages->count() === 0) {
    echo "❌ Tidak ada messages di database\n";
} else {
    foreach($messages as $msg) {
        echo "ID: {$msg->id}\n";
        echo "User ID: {$msg->user_id}\n";
        echo "Subject: {$msg->subject}\n";
        echo "Status: {$msg->status}\n";
        echo "Created: {$msg->created_at}\n";
        echo "---\n";
    }
    echo "\nTotal: " . $messages->count() . " messages\n";
}
