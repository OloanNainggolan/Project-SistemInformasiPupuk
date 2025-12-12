<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'link',
        'status',
        'is_read',
        'related_id',
        'related_type'
    ];
    
    /**
     * Scope untuk notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    
    /**
     * Scope untuk notifikasi terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
    
    /**
     * Get the related order if exists
     */
    public function order()
    {
        if ($this->related_type === 'App\\Models\\Order') {
            return $this->belongsTo(\App\Models\Order::class, 'related_id');
        }
        return null;
    }
}
