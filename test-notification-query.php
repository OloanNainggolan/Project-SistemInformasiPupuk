<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING NOTIFICATION QUERY ===\n\n";

$userId = 1;

// Test 1: Get conversations (exclude order status updates)
$messages = \App\Models\Message::where('user_id', $userId)
    ->whereNull('reply_to')
    ->where('subject', 'NOT LIKE', '%Update Status Pesanan%')
    ->where('subject', 'NOT LIKE', '%Status Pesanan Diperbarui%')
    ->orderBy('created_at', 'desc')
    ->get();

echo "=== CONVERSATIONS (Messages Table - Exclude Order Status) ===\n";
echo "Total: " . $messages->count() . "\n\n";
foreach ($messages as $msg) {
    echo "- {$msg->subject} ({$msg->status})\n";
}

// Test 2: Get system messages (order status updates)
$systemMessages = \App\Models\Message::where('user_id', $userId)
    ->whereNull('reply_to')
    ->where(function($q) {
        $q->where('subject', 'LIKE', '%Update Status Pesanan%')
          ->orWhere('subject', 'LIKE', '%Status Pesanan Diperbarui%');
    })
    ->orderBy('created_at', 'desc')
    ->get();

echo "\n=== SYSTEM MESSAGES (Order Status Updates) ===\n";
echo "Total: " . $systemMessages->count() . "\n\n";
foreach ($systemMessages as $msg) {
    echo "- {$msg->subject} ({$msg->status}) - Created: {$msg->created_at}\n";
}

// Test 3: Get notifications table
$notifications = \App\Models\Notification::where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->get();

echo "\n=== NOTIFICATIONS TABLE ===\n";
echo "Total: " . $notifications->count() . "\n\n";
foreach ($notifications as $notif) {
    echo "- {$notif->title} (" . ($notif->is_read ? 'read' : 'unread') . ") - Created: {$notif->created_at}\n";
}

// Test 4: Combined
$combined = $notifications->count() + $systemMessages->count();
echo "\n=== TOTAL NOTIFIKASI SISTEM ===\n";
echo "Notifications table: " . $notifications->count() . "\n";
echo "System messages: " . $systemMessages->count() . "\n";
echo "TOTAL: " . $combined . "\n";

// Test 5: Unread count
$unreadNotif = \App\Models\Notification::where('user_id', $userId)->where('is_read', false)->count();
$unreadSystem = \App\Models\Message::where('user_id', $userId)
    ->whereNull('reply_to')
    ->where(function($q) {
        $q->where('subject', 'LIKE', '%Update Status Pesanan%')
          ->orWhere('subject', 'LIKE', '%Status Pesanan Diperbarui%');
    })
    ->where('status', 'unread')
    ->count();

echo "\n=== UNREAD COUNT ===\n";
echo "Notifications: $unreadNotif\n";
echo "System messages: $unreadSystem\n";
echo "TOTAL UNREAD: " . ($unreadNotif + $unreadSystem) . "\n";
