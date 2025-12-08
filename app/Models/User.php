<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'nama_lengkap',
        'username',
        'alamat',
        'alamat_balai_desa',
        'kabupaten',
        'kode_pos',
        'no_telp',
        'email',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke Orders
     * User bisa memiliki banyak pesanan
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get orders yang sudah dikonfirmasi
     */
    public function confirmedOrders()
    {
        return $this->hasMany(Order::class)->where('confirmed_by_user', true);
    }
}
