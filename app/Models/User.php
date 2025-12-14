<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
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
        'google_id',
        'facebook_id',
        'luas_lahan',
        'jenis_tanaman',
        'lokasi_lahan',
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
