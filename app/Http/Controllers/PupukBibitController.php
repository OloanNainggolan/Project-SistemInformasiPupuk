<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PupukBibitController extends Controller
{
    /**
     * Halaman daftar pupuk & bibit
     */
    public function index()
    {
        $products = Product::with('primaryImage')->get();
        return view('user.pupukdanbibit', compact('products'));
    }

    /**
     * Halaman detail & pesan produk
     */
    public function detail($id)
    {
        // Coba cari produk di database
        $produk = Product::with('images')->find($id);
        
        // Jika tidak ada produk di database, buat data statis
        if (!$produk) {
            $produk = $this->getStaticProduct($id);
        }
        
        return view('user.lihat-detail-pesan', compact('produk'));
    }
    
    /**
     * Data produk statis untuk contoh
     */
    private function getStaticProduct($id)
    {
        $staticProducts = [
            1 => [
                'id_produk' => 1,
                'nama_produk' => 'Urea',
                'tipe_produk' => 'pupuk',
                'kategori' => 'Anorganik',
                'deskripsi' => 'Urea adalah pupuk nitrogen bersubsidi tinggi yang berperan penting dalam mendukung pertumbuhan daun dan batang tanaman secara optimal. Dengan kandungan nitrogen yang mudah diserap, urea membantu mempercepat proses fotosintesis sehingga tanaman dapat tumbuh lebih hijau dan mendukung perkembangan vegetatif.',
                'stok' => 1000,
                'stok_produk' => 1000,
                'harga_normal' => 2300,
                'harga_subsidi' => 1800,
                'gambar' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            ],
            2 => [
                'id_produk' => 2,
                'nama_produk' => 'NPK Phonska',
                'tipe_produk' => 'pupuk',
                'kategori' => 'Anorganik',
                'deskripsi' => 'Pupuk NPK Phonska mengandung unsur nitrogen, fosfor, dan kalium yang lengkap untuk mendukung pertumbuhan tanaman. Cocok untuk berbagai jenis tanaman dan meningkatkan produktivitas hasil panen.',
                'stok' => 800,
                'stok_produk' => 800,
                'harga_normal' => 2500,
                'harga_subsidi' => 2000,
                'gambar' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            ],
            3 => [
                'id_produk' => 3,
                'nama_produk' => 'ZA (Zwavelzure Ammoniak)',
                'tipe_produk' => 'pupuk',
                'kategori' => 'Anorganik',
                'deskripsi' => 'Pupuk ZA mengandung nitrogen dan belerang yang baik untuk tanaman. Cocok untuk tanah sawah dan dapat meningkatkan kualitas tanaman padi serta sayuran.',
                'stok' => 750,
                'stok_produk' => 750,
                'harga_normal' => 1900,
                'harga_subsidi' => 1400,
                'gambar' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop',
            ],
            4 => [
                'id_produk' => 4,
                'nama_produk' => 'Bibit Padi Unggul',
                'tipe_produk' => 'bibit',
                'kategori' => 'Organik',
                'deskripsi' => 'Bibit padi unggul bersertifikat dengan kualitas terbaik. Tahan terhadap hama dan penyakit, hasil panen melimpah, dan cocok untuk berbagai jenis lahan.',
                'stok' => 500,
                'stok_produk' => 500,
                'harga_normal' => 15000,
                'harga_subsidi' => 10000,
                'gambar' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400&h=300&fit=crop',
            ],
            5 => [
                'id_produk' => 5,
                'nama_produk' => 'Bibit Jagung Hibrida',
                'tipe_produk' => 'bibit',
                'kategori' => 'Organik',
                'deskripsi' => 'Bibit jagung hibrida bersubsidi dengan produktivitas tinggi. Tahan kekeringan, hasil panen maksimal, dan cocok untuk lahan kering maupun basah.',
                'stok' => 600,
                'stok_produk' => 600,
                'harga_normal' => 35000,
                'harga_subsidi' => 25000,
                'gambar' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400&h=300&fit=crop',
            ],
            6 => [
                'id_produk' => 6,
                'nama_produk' => 'Bibit Kedelai Berkualitas',
                'tipe_produk' => 'bibit',
                'kategori' => 'Organik',
                'deskripsi' => 'Bibit kedelai unggul bersertifikat dengan hasil panen optimal. Kaya protein, tahan penyakit, dan cocok untuk rotasi tanaman padi.',
                'stok' => 450,
                'stok_produk' => 450,
                'harga_normal' => 18000,
                'harga_subsidi' => 12000,
                'gambar' => 'https://images.unsplash.com/photo-1594623930572-300a3011d9ae?w=400&h=300&fit=crop',
            ],
        ];
        
        if (isset($staticProducts[$id])) {
            // Convert array to object untuk kompatibilitas dengan view
            return (object) $staticProducts[$id];
        }
        
        // Jika ID tidak ditemukan, abort 404
        abort(404, 'Produk tidak ditemukan');
    }
    
    /**
     * Halaman konfirmasi pesanan
     */
    public function confirmOrder(Request $request, $id)
    {
        // Coba cari produk di database
        $produk = Product::with('images')->find($id);
        
        // Jika tidak ada produk di database, buat data statis
        if (!$produk) {
            $produk = $this->getStaticProduct($id);
        }
        
        // Ambil quantity dari request
        $quantity = $request->input('quantity', 1);
        $catatan = $request->input('catatan', '');
        
        return view('user.konfirmasi-pesanan', compact('produk', 'quantity', 'catatan'));
    }
    
    /**
     * Simpan pesanan ke database
     */
    public function storeOrder(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'quantity' => 'required|integer|min:1|max:100',
            'catatan' => 'nullable|string',
            'village_office' => 'nullable|string|max:255',
        ]);
        
        // Cari produk
        $produk = Product::find($id);
        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }
        
        // Hitung total
        $total = $produk->harga_subsidi * $validated['quantity'];
        
        // Generate order number
        $orderNumber = \App\Models\Order::generateOrderNumber();
        
        // Buat pesanan baru
        $order = \App\Models\Order::create([
            'order_number' => $orderNumber,
            'user_id' => auth()->id(),
            'village_office' => $validated['village_office'] ?? 'Balai Desa',
            'items' => json_encode([[
                'product_id' => $produk->id_produk,
                'product_name' => $produk->nama_produk,
                'type' => $produk->tipe_produk,
                'category' => $produk->kategori,
                'quantity' => $validated['quantity'],
                'price' => $produk->harga_subsidi,
                'subtotal' => $total,
            ]]),
            'total_amount' => $total,
            'status' => 'Pending',
            'confirmed_by_user' => true,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat',
            'order_number' => $orderNumber,
            'total' => $total,
        ]);
    }
}
