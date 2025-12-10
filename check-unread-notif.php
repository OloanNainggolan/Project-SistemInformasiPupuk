<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$userId = 1;

echo "=== CHECKING UNREAD NOTIFICATIONS FOR USER $userId ===\n\n";

// 1. Messages from admin (conversations, exclude order status)
$unreadMessages = \App\Models\Message::where('user_id', $userId)
    ->whereNull('reply_to')
    ->where('subject', 'NOT LIKE', '%Update Status Pesanan%')
    ->where('subject', 'NOT LIKE', '%Status Pesanan Diperbarui%')
    ->where('sender_type', 'admin')
    ->where('status', 'unread')
    ->get();

echo "1. UNREAD MESSAGES FROM ADMIN (Conversations):\n";
echo "Count: " . $unreadMessages->count() . "\n";
foreach ($unreadMessages as $msg) {
    echo "  - [{$msg->id}] {$msg->subject} (status: {$msg->status})\n";
}

// 2. Notifications table
$unreadNotifications = \App\Models\Notification::where('user_id', $userId)
    ->where('is_read', false)
    ->get();

echo "\n2. UNREAD NOTIFICATIONS (from notifications table):\n";
echo "Count: " . $unreadNotifications->count() . "\n";
foreach ($unreadNotifications as $notif) {
    echo "  - [{$notif->id}] {$notif->title} (is_read: " . ($notif->is_read ? 'true' : 'false') . ")\n";
}

// 3. System messages (order status updates)
$unreadSystemMessages = \App\Models\Message::where('user_id', $userId)
    ->whereNull('reply_to')
    ->where(function($q) {
        $q->where('subject', 'LIKE', '%Update Status Pesanan%')
          ->orWhere('subject', 'LIKE', '%Status Pesanan Diperbarui%');
    })
    ->where('status', 'unread')
    ->get();

echo "\n3. UNREAD SYSTEM MESSAGES (Order Status Updates):\n";
echo "Count: " . $unreadSystemMessages->count() . "\n";
foreach ($unreadSystemMessages as $msg) {
    echo "  - [{$msg->id}] {$msg->subject} (status: {$msg->status})\n";
}

$total = $unreadMessages->count() + $unreadNotifications->count() + $unreadSystemMessages->count();
echo "\n=== TOTAL UNREAD: $total ===\n";
