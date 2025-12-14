<?php

/**
 * Script untuk simulasi pemesanan produk dan test WhatsApp notification
 * 
 * Usage: php test-order-whatsapp.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\DB;

echo "==============================================\n";
echo "   TEST ORDER + WHATSAPP NOTIFICATION\n";
echo "==============================================\n\n";

// 1. Cek apakah ada user dengan nomor HP
echo "1️⃣ Checking Users dengan Nomor HP...\n";
$users = User::whereNotNull('no_telp')
    ->where('no_telp', '!=', '')
    ->take(5)
    ->get(['id', 'username', 'nama_lengkap', 'no_telp']);

if ($users->isEmpty()) {
    echo "❌ Tidak ada user dengan nomor HP!\n";
    echo "   Silakan tambahkan nomor HP ke user terlebih dahulu.\n\n";
    echo "   Contoh SQL:\n";
    echo "   UPDATE users SET no_telp='6281234567890' WHERE id=1;\n\n";
    exit(1);
}

echo "✅ Ditemukan " . $users->count() . " user dengan nomor HP:\n";
foreach ($users as $user) {
    echo "   - {$user->username} ({$user->nama_lengkap}) → {$user->no_telp}\n";
}
echo "\n";

// 2. Cek produk
echo "2️⃣ Checking Products...\n";
$products = Product::take(3)->get(['id_produk', 'nama_produk', 'harga_subsidi', 'stok_produk']);

if ($products->isEmpty()) {
    echo "❌ Tidak ada produk!\n";
    exit(1);
}

echo "✅ Ditemukan " . $products->count() . " produk:\n";
foreach ($products as $product) {
    echo "   - {$product->nama_produk} (Rp " . number_format($product->harga_subsidi, 0, ',', '.') . ") - Stok: {$product->stok_produk}\n";
}
echo "\n";

// 3. Pilih user dan produk untuk test
$testUser = $users->first();
$testProduct = $products->first();

echo "3️⃣ Simulasi Pemesanan...\n";
echo "   User: {$testUser->nama_lengkap}\n";
echo "   HP: {$testUser->no_telp}\n";
echo "   Produk: {$testProduct->nama_produk}\n";
echo "   Harga: Rp " . number_format($testProduct->harga_subsidi, 0, ',', '.') . "\n";
echo "   Jumlah: 10 unit\n\n";

$quantity = 10;
$price = $testProduct->harga_subsidi;
$subtotal = $quantity * $price;

// 4. Buat order
echo "4️⃣ Membuat Order...\n";

try {
    $order = DB::transaction(function () use ($testUser, $testProduct, $quantity, $price, $subtotal) {
        $order = new Order();
        $order->order_number = Order::generateOrderNumber();
        $order->user_id = $testUser->id;
        $order->village_office = 'Balai Desa Test';
        $order->items = json_encode([
            [
                'product_id' => $testProduct->id_produk,
                'product_name' => $testProduct->nama_produk,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal
            ]
        ]);
        $order->total_amount = $subtotal;
        $order->status = 'Pending';
        $order->confirmed_by_user = false;
        $order->save();
        
        return $order;
    });
    
    echo "✅ Order berhasil dibuat!\n";
    echo "   Order Number: {$order->order_number}\n";
    echo "   Total: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n\n";
    
} catch (\Exception $e) {
    echo "❌ Gagal membuat order: " . $e->getMessage() . "\n\n";
    exit(1);
}

// 5. Load relasi user
$order->load('user');

// 6. Kirim WhatsApp
echo "5️⃣ Mengirim WhatsApp Notifikasi...\n";
echo "   Target: {$testUser->no_telp}\n\n";

try {
    $whatsappService = app(WhatsAppService::class);
    
    echo "⏳ Mengirim pesan...\n\n";
    $result = $whatsappService->sendOrderNotification($order);
    
    if ($result['success']) {
        echo "✅ SUCCESS! WhatsApp konfirmasi pesanan terkirim!\n\n";
        
        echo "📊 Response Details:\n";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n\n";
        
        echo "🎉 Test Berhasil!\n";
        echo "   Order Number: {$order->order_number}\n";
        echo "   User: {$testUser->nama_lengkap}\n";
        echo "   HP: {$testUser->no_telp}\n";
        echo "   Status: Pesan WhatsApp terkirim\n\n";
        
        echo "📱 Cek WhatsApp di nomor: {$testUser->no_telp}\n";
        echo "   Anda akan menerima konfirmasi pemesanan lengkap!\n\n";
        
    } else {
        echo "❌ FAILED! Gagal mengirim WhatsApp\n\n";
        echo "📊 Error Details:\n";
        echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n\n";
        
        echo "💡 Troubleshooting:\n";
        echo "   1. Pastikan token Fonnte benar\n";
        echo "   2. Pastikan device WhatsApp connected\n";
        echo "   3. Verifikasi nomor HP format: 628xxx\n";
        echo "   4. Cek saldo/quota Fonnte\n\n";
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n\n";
    echo $e->getTraceAsString() . "\n\n";
}

echo "==============================================\n";
echo "   TEST SELESAI\n";
echo "==============================================\n\n";

echo "💡 Tips:\n";
echo "   • Order baru sudah tersimpan di database\n";
echo "   • Cek tabel 'orders' untuk melihat data\n";
echo "   • Test update status: php test-status-update.php\n";
echo "   • Hapus test order jika perlu\n\n";
