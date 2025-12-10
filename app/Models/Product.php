<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'nama_produk',
        'tipe_produk',
        'kategori',
        'harga_subsidi',
        'harga_normal',
        'stok_produk',
        'gambar',
        'deskripsi',
        'manfaat',
        'bahan',
        'cara_penggunaan'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_produk';
    }

    /**
     * Relasi ke ProductImage (multiple images)
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id_produk')->orderBy('order');
    }

    /**
     * Get primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id_produk')
                    ->where('is_primary', true);
    }

    /**
     * Relasi ke Orders
     * Product bisa memiliki banyak pesanan
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id_produk');
    }

    /**
     * Get total quantity sold
     */
    public function getTotalSoldAttribute()
    {
        return $this->orders()
            ->where('confirmed_by_user', true)
            ->whereIn('status', ['Completed', 'Processing', 'Ready'])
            ->sum('quantity');
    }
}
