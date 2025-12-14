<?php
/**
 * Script untuk update gambar produk sesuai dengan nama produk
 * Jalankan: php update_product_images.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Update Product Images ===\n\n";

// Mapping produk dengan nama file gambar
$productImages = [
    // PUPUK
    'Pupuk Urea' => 'pupuk-urea.jpg',
    'NPK Phonska' => 'pupuk-phonska.jpg', 
    'Pupuk ZA (Zwavelzure Ammoniak)' => 'pupuk-za.jpg',
    
    // BIBIT
    'Bibit Padi Inpari' => 'bibit-padi-inpari.jpg',
    'Bibit Jagung Hibrida' => 'bibit-jagung-hibrida.jpg',
    'Bibit Kedelai Unggul' => 'bibit-kedelai-unggul.jpg',
];

foreach ($productImages as $productName => $imageName) {
    $updated = DB::table('produk')
        ->where('nama_produk', 'LIKE', '%' . $productName . '%')
        ->update(['gambar' => 'images/products/' . $imageName]);
    
    if ($updated > 0) {
        echo "✓ Updated: $productName -> $imageName\n";
    } else {
        echo "✗ Not found: $productName\n";
    }
}

echo "\n=== Update Complete ===\n";
echo "\nCATATAN: Pastikan file gambar sudah ada di folder public/images/products/:\n";
foreach ($productImages as $productName => $imageName) {
    echo "  - $imageName\n";
}
