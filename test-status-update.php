<?php

/**
 * Script untuk test update status order dan WhatsApp notification
 * 
 * Usage: php test-status-update.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Order;
use App\Services\WhatsAppService;

echo "==============================================\n";
echo "   TEST STATUS UPDATE + WHATSAPP\n";
echo "==============================================\n\n";

// 1. Cari order terbaru
echo "1️⃣ Mencari Order Terbaru...\n";
$order = Order::with('user')->latest()->first();

if (!$order) {
    echo "❌ Tidak ada order!\n";
    echo "   Jalankan: php test-order-whatsapp.php dulu\n\n";
    exit(1);
}

echo "✅ Order ditemukan:\n";
echo "   Order Number: {$order->order_number}\n";
echo "   User: {$order->user->nama_lengkap}\n";
echo "   HP: {$order->user->no_telp}\n";
echo "   Status Saat Ini: {$order->status}\n";
echo "   Total: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n\n";

// 2. Tentukan status baru
$availableStatuses = ['Pending', 'Processing', 'Ready', 'Completed', 'Cancelled'];
$currentIndex = array_search($order->status, $availableStatuses);
$newStatus = null;

if ($currentIndex !== false && $currentIndex < count($availableStatuses) - 2) {
    $newStatus = $availableStatuses[$currentIndex + 1];
} else if ($order->status === 'Pending') {
    $newStatus = 'Processing';
} else {
    $newStatus = 'Ready';
}

echo "2️⃣ Update Status...\n";
echo "   Status Lama: {$order->status}\n";
echo "   Status Baru: {$newStatus}\n\n";

$oldStatus = $order->status;

// 3. Update status
$order->status = $newStatus;
$order->save();

echo "✅ Status berhasil diupdate!\n\n";

// 4. Kirim WhatsApp
echo "3️⃣ Mengirim WhatsApp Notifikasi Update Status...\n";
echo "   Target: {$order->user->no_telp}\n\n";

try {
    $whatsappService = app(WhatsAppService::class);
    
    echo "⏳ Mengirim pesan...\n\n";
    $result = $whatsappService->sendStatusUpdateNotification($order, $oldStatus);
    
    if ($result['success']) {
        echo "✅ SUCCESS! WhatsApp notifikasi update status terkirim!\n\n";
        
        echo "📊 Response Details:\n";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n\n";
        
        echo "🎉 Test Berhasil!\n";
        echo "   Order Number: {$order->order_number}\n";
        echo "   Status: {$oldStatus} ➜ {$newStatus}\n";
        echo "   User: {$order->user->nama_lengkap}\n";
        echo "   HP: {$order->user->no_telp}\n\n";
        
        echo "📱 Cek WhatsApp di nomor: {$order->user->no_telp}\n";
        echo "   Anda akan menerima notifikasi update status!\n\n";
        
    } else {
        echo "❌ FAILED! Gagal mengirim WhatsApp\n\n";
        echo "📊 Error Details:\n";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n\n";
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n\n";
}

echo "==============================================\n";
echo "   TEST SELESAI\n";
echo "==============================================\n\n";

echo "💡 Tips:\n";
echo "   • Jalankan ulang untuk update ke status berikutnya\n";
echo "   • Status flow: Pending → Processing → Ready → Completed\n";
echo "   • Cek database untuk verifikasi perubahan\n\n";
