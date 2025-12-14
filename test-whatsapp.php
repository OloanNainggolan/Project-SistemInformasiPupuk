<?php

/**
 * Script untuk test koneksi WhatsApp Fonnte
 * 
 * Usage: php test-whatsapp.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

echo "==============================================\n";
echo "   TEST WHATSAPP FONNTE CONNECTION\n";
echo "==============================================\n\n";

// Check configuration
echo "📋 Checking Configuration...\n";
$token = config('services.fonnte.token');
$url = config('services.fonnte.url');
$enabled = config('services.fonnte.enabled');

if (empty($token)) {
    echo "❌ ERROR: FONNTE_API_TOKEN tidak ditemukan di .env\n";
    echo "   Silakan tambahkan: FONNTE_API_TOKEN=your_token\n\n";
    exit(1);
}

echo "✅ Token: " . substr($token, 0, 10) . "...\n";
echo "✅ URL: $url\n";
echo "✅ Enabled: " . ($enabled ? 'Yes' : 'No') . "\n\n";

if (!$enabled) {
    echo "⚠️  WARNING: WhatsApp disabled (WHATSAPP_ENABLED=false)\n";
    echo "   Set WHATSAPP_ENABLED=true di .env untuk enable\n\n";
}

// Test connection
echo "📱 Testing WhatsApp Connection...\n";
echo "   Nomor Test: 6281362817992 (dari Fonnte)\n\n";

try {
    $whatsappService = app(WhatsAppService::class);
    
    echo "⏳ Mengirim pesan test...\n";
    $result = $whatsappService->testConnection('6281362817992');
    
    if ($result['success']) {
        echo "\n✅ SUCCESS! Pesan WhatsApp berhasil dikirim!\n\n";
        echo "📊 Response Details:\n";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";
        
        echo "🎉 Setup Fonnte berhasil!\n";
        echo "   Cek WhatsApp Anda di nomor: 6281362817992\n\n";
    } else {
        echo "\n❌ FAILED! Gagal mengirim pesan WhatsApp\n\n";
        echo "📊 Error Details:\n";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";
        
        echo "💡 Troubleshooting:\n";
        echo "   1. Pastikan token benar: cLHsdazxqiJJQkEEUP7Y\n";
        echo "   2. Pastikan device WhatsApp connected di dashboard Fonnte\n";
        echo "   3. Cek saldo/credit Fonnte mencukupi\n";
        echo "   4. Verifikasi nomor 6281362817992 aktif\n\n";
    }
    
} catch (\Exception $e) {
    echo "\n❌ EXCEPTION: " . $e->getMessage() . "\n\n";
    echo "Stack Trace:\n";
    echo $e->getTraceAsString() . "\n\n";
}

echo "==============================================\n";
echo "   TEST SELESAI\n";
echo "==============================================\n";
