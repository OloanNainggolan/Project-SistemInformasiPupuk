<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update produk dengan ID 3 (Bibit Jagung Hibrida) sebagai contoh
        DB::table('produk')->where('id_produk', 3)->update([
            'deskripsi' => 'Bibit jagung hibrida bersubsidi dengan produktivitas tinggi. Tahan kekeringan, hasil panen maksimal, dan cocok untuk lahan kering maupun basah.',
            'manfaat' => "Meningkatkan hasil panen hingga 30%\nMemperbaiki tekstur dan ketahanan tanaman hama\nMemperkuat batang dan daun tanaman\nMeningkatkan kualitas buah dan biji\nMembantu pertumbuhan vegetatif",
            'bahan' => "- Gunakan NPK saat tanaman baru tumbuh atau awal produksi tanaman\n- Alam berbaris dan bebas\n- Cara Pakis\n- Tahur di sekeliling tanaman (sekitar 5-10 cm dari batang)\n- Campurkan dengan tanah\n- Siram dengan air secukupnya",
            'cara_penggunaan' => "1. Waktu Pemupukan\n- Gunakan NPK saat tanaman baru tumbuh atau awal produksi tanaman\n- Alam berbaris dan bebas\n- Cara Pakis\n- Tahur di sekeliling tanaman (sekitar 5-10 cm dari batang)\n- Campurkan dengan tanah\n- Siram dengan air secukupnya\n\n2. Pupuk Cair\n- Campur 1 tutup botol NPK cair dengan 1 liter air\n- Semprotkan secara merata pada daun dan tanah\n\n3. Pupuk Padat\n- Gunakan sesuainya (lihat label dosis)\n- Letakkan ampas jeruk, daun kering atau lainnya di atas tanah\n- Ulangi pemupukan tiap 1-2 minggu"
        ]);
    }
}
