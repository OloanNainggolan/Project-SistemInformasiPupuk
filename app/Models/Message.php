<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'sender_type',
        'subject',
        'message',
        'priority',
        'status',
        'reply_to',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke pesan yang dibalas
    public function replyToMessage()
    {
        return $this->belongsTo(Message::class, 'reply_to');
    }

    // Relasi ke balasan-balasan pesan ini
    public function replies()
    {
        return $this->hasMany(Message::class, 'reply_to');
    }

    // Scope untuk pesan yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    // Scope untuk pesan dari user
    public function scopeFromUser($query)
    {
        return $query->where('sender_type', 'user');
    }

    // Scope untuk pesan dari admin
    public function scopeFromAdmin($query)
    {
        return $query->where('sender_type', 'admin');
    }

    // Get link untuk notifikasi
    public function getLink()
    {
        return route('admin.notifications.show', $this->id);
    }
}
