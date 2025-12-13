<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$products = DB::table('produk')->select('id_produk', 'nama_produk', 'gambar')->get();

echo "=== Produk di Database ===\n\n";
foreach ($products as $product) {
    echo "ID: {$product->id_produk}\n";
    echo "Nama: {$product->nama_produk}\n";
    echo "Gambar: {$product->gambar}\n";
    echo "---\n";
}
