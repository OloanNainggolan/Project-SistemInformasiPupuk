<?php

/**
 * Script untuk mengecek konfigurasi Google OAuth
 * Jalankan: php check-google-config.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "==============================================\n";
echo "    GOOGLE OAUTH CONFIGURATION CHECK\n";
echo "==============================================\n\n";

$clientId = config('services.google.client_id');
$clientSecret = config('services.google.client_secret');
$redirect = config('services.google.redirect');

echo "1. Client ID:\n";
if (empty($clientId) || $clientId === 'your-google-client-id-here') {
    echo "   ❌ TIDAK VALID (masih placeholder atau kosong)\n";
    echo "   Nilai: " . ($clientId ?: 'KOSONG') . "\n";
} else {
    echo "   ✅ TERISI\n";
    echo "   Nilai: " . substr($clientId, 0, 20) . "....\n";
    echo "   Panjang: " . strlen($clientId) . " karakter\n";
}

echo "\n2. Client Secret:\n";
if (empty($clientSecret) || $clientSecret === 'your-google-client-secret-here') {
    echo "   ❌ TIDAK VALID (masih placeholder atau kosong)\n";
    echo "   Nilai: " . ($clientSecret ?: 'KOSONG') . "\n";
} else {
    echo "   ✅ TERISI\n";
    echo "   Nilai: " . substr($clientSecret, 0, 10) . "....\n";
    echo "   Panjang: " . strlen($clientSecret) . " karakter\n";
}

echo "\n3. Redirect URI:\n";
echo "   " . ($redirect ?: 'KOSONG') . "\n";

echo "\n==============================================\n";
echo "DIAGNOSIS:\n";
echo "==============================================\n";

$hasError = false;

if (empty($clientId) || $clientId === 'your-google-client-id-here') {
    echo "❌ GOOGLE_CLIENT_ID belum diisi di file .env\n";
    $hasError = true;
}

if (empty($clientSecret) || $clientSecret === 'your-google-client-secret-here') {
    echo "❌ GOOGLE_CLIENT_SECRET belum diisi di file .env\n";
    $hasError = true;
}

if (empty($redirect)) {
    echo "❌ GOOGLE_REDIRECT_URI belum diisi di file .env\n";
    $hasError = true;
}

if (!$hasError) {
    echo "✅ Semua konfigurasi sudah terisi!\n";
    echo "\nJika masih error, kemungkinan masalah:\n";
    echo "1. Client ID/Secret salah (typo saat copy-paste)\n";
    echo "2. Redirect URI di Google Console tidak sama persis:\n";
    echo "   Harus: $redirect\n";
    echo "3. OAuth Consent Screen belum dikonfigurasi\n";
    echo "4. Google+ API belum diaktifkan\n";
} else {
    echo "\nCara perbaikan:\n";
    echo "1. Buka file .env di root project\n";
    echo "2. Cari baris GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET\n";
    echo "3. Ganti dengan credentials asli dari Google Cloud Console\n";
    echo "4. Jalankan: php artisan config:clear\n";
}

echo "\n==============================================\n";
