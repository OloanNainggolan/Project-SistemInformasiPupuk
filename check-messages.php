<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING MESSAGES TABLE ===\n\n";

// Get all messages
$messages = \App\Models\Message::orderBy('created_at', 'desc')->get();

echo "Total messages in database: " . $messages->count() . "\n\n";

foreach ($messages as $m) {
    echo "ID: {$m->id}\n";
    echo "User ID: {$m->user_id}\n";
    echo "From Admin: " . ($m->from_admin ? 'YES' : 'NO') . "\n";
    echo "Subject: {$m->subject}\n";
    echo "Status: {$m->status}\n";
    echo "Reply To: {$m->reply_to}\n";
    echo "Created: {$m->created_at}\n";
    echo "---\n\n";
}

// Check unread messages from admin
echo "\n=== UNREAD MESSAGES FROM ADMIN FOR USER 1 ===\n";
$unreadMessages = \App\Models\Message::where('user_id', 1)
    ->where('from_admin', true)
    ->where('status', 'unread')
    ->count();
echo "Total unread from admin: " . $unreadMessages . "\n";
