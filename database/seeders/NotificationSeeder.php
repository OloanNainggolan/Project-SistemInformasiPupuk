<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'title' => 'Selamat Datang',
                'message' => 'Selamat datang di Sistem Informasi Pupuk & Bibit Subsidi',
                'type' => 'success',
                'status' => 'unread',
            ],
            [
                'title' => 'Pesanan Baru',
                'message' => 'Ada 5 pesanan baru yang perlu diproses',
                'type' => 'info',
                'status' => 'unread',
            ],
            [
                'title' => 'Stok Rendah',
                'message' => 'Beberapa produk memiliki stok yang rendah',
                'type' => 'warning',
                'status' => 'unread',
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
