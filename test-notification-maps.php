<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST NOTIFIKASI LENGKAP DENGAN MAPS ===\n\n";

// Cek message terbaru untuk user
$message = \App\Models\Message::orderBy('created_at', 'desc')->first();

if (!$message) {
    echo "❌ Tidak ada message\n";
    exit;
}

echo "Subject: {$message->subject}\n";
echo "Status: {$message->status}\n";
echo "Created: {$message->created_at}\n\n";

echo "=== ISI MESSAGE ===\n";
echo $message->message;
echo "\n\n";

// Detect order number
preg_match('/ORD-\d{8}-[A-F0-9]{6}/i', $message->message, $matches);
$orderNum = $matches[0] ?? null;

echo "=== DETEKSI OTOMATIS ===\n";
echo "Order Number Detected: " . ($orderNum ?? 'TIDAK TERDETEKSI') . "\n";
echo "Kata 'siap' ada?: " . (stripos($message->message, 'siap') !== false ? 'YA' : 'TIDAK') . "\n";
echo "Kata 'ready' ada?: " . (stripos($message->message, 'ready') !== false ? 'YA' : 'TIDAK') . "\n\n";

if ($orderNum && stripos($message->message, 'siap') !== false) {
    echo "✅ MAPS BUTTON AKAN MUNCUL!\n";
    echo "Route: /maps?order={$orderNum}\n";
} else {
    echo "❌ Maps button TIDAK akan muncul\n";
    if (!$orderNum) echo "Alasan: Order number tidak terdeteksi\n";
    if (stripos($message->message, 'siap') === false) echo "Alasan: Kata 'siap' tidak ada\n";
}
