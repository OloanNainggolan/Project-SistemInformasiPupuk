<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
        'discount_amount',
        'discount_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_notes',
        'village_office',
        'items',
        'total_amount',
        'status',
        'confirmed_by_user',
        'confirmed_at',
        'processed_by',
        'processed_at',
        'completed_at',
        'admin_notes',
        'rejection_reason'
    ];

    protected $casts = [
        'items' => 'array',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'confirmed_by_user' => 'boolean',
        'confirmed_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_produk');
    }

    /**
     * Relasi ke Discount
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * Relasi ke Admin yang memproses
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope - hanya pesanan yang dikonfirmasi
     */
    public function scopeConfirmed($query)
    {
        return $query->where('confirmed_by_user', true);
    }

    /**
     * Scope - filter by status
     */
    public function scopeByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope - search by name or order number
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        return $query;
    }

    /**
     * Calculate total with discount
     */
    public function calculateTotal(): float
    {
        return max(0, $this->subtotal - $this->discount_amount);
    }

    /**
     * Get savings (discount) percentage
     */
    public function getSavingsPercentAttribute(): float
    {
        if ($this->subtotal <= 0) {
            return 0;
        }
        return round(($this->discount_amount / $this->subtotal) * 100, 2);
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted discount
     */
    public function getFormattedDiscountAttribute()
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Pending' => 'gray',
            'Processing' => 'purple',
            'Ready' => 'lightgreen',
            'Completed' => 'green',
            'Rejected' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get status in Indonesian
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'Pending' => 'Menunggu Konfirmasi',
            'Processing' => 'Sedang Diproses',
            'Ready' => 'Siap Diambil',
            'Completed' => 'Selesai',
            'Rejected' => 'Ditolak',
            default => $this->status
        };
    }

    /**
     * Generate order number
     */
    public static function generateOrderNumber()
    {
        $year = date('Y');
        $lastOrder = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $nextNumber = $lastOrder ? (intval(substr($lastOrder->order_number, -3)) + 1) : 1;
        
        return sprintf('ORD-%s-%03d', $year, $nextNumber);
    }
}
