<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check notification full message
$message = \App\Models\Message::find(6);

if (!$message) {
    echo "❌ Message tidak ditemukan\n";
    exit;
}

echo "=== FULL MESSAGE CONTENT (ID: 6) ===\n\n";
echo $message->message;
echo "\n\n=== END ===\n";
