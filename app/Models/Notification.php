<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'type',
        'title',
        'message',
        'link',
        'status',
        'related_id'
    ];
    
    /**
     * Scope untuk notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }
    
    /**
     * Scope untuk notifikasi terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
