<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Quick Fix: Update ke Gambar Default ===\n\n";

// Update semua pupuk ke pupuk.jpg
$updated1 = DB::table('produk')
    ->whereIn('id_produk', [1, 2, 3])
    ->update(['gambar' => 'images/pupuk.jpg']);
echo "✓ {$updated1} produk pupuk diupdate ke: images/pupuk.jpg\n";

// Update semua bibit ke bibit.jpg
$updated2 = DB::table('produk')
    ->whereIn('id_produk', [4, 5, 6])
    ->update(['gambar' => 'images/bibit.jpg']);
echo "✓ {$updated2} produk bibit diupdate ke: images/bibit.jpg\n";

echo "\n✅ Selesai! Refresh browser (Ctrl+Shift+R) untuk melihat hasilnya\n";
