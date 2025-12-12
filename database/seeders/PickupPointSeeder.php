<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PickupPoint;
use Illuminate\Support\Facades\DB;

class PickupPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama terlebih dahulu
        DB::table('pickup_points')->truncate();

        $pickupPoints = [
            [
                'name' => 'Kampus IT Del Sitoluama',
                'address' => 'Jl. Sisingamangaraja, Sitoluama, Laguboti, Kabupaten Toba, Sumatera Utara',
                'latitude' => 2.6140,
                'longitude' => 99.0710,
            ],
            [
                'name' => 'Mr.DIY Balige',
                'address' => 'Jl. Sisingamangaraja No.168, Balige, Kabupaten Toba, Sumatera Utara',
                'latitude' => 2.3310,
                'longitude' => 99.0650,
            ],
            [
                'name' => 'RSUD Porsea',
                'address' => 'Jl. Sisingamangaraja, Porsea, Kabupaten Toba, Sumatera Utara',
                'latitude' => 2.6830,
                'longitude' => 98.7850,
            ],
        ];

        foreach ($pickupPoints as $point) {
            PickupPoint::create($point);
        }

        echo "✅ Berhasil menambahkan 3 lokasi pengambilan di area Toba\n";
    }
}
