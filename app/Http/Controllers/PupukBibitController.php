<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;

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
        // Ambil produk dari database dengan eager loading
        $produk = Product::with(['images' => function($query) {
            $query->orderBy('order');
        }, 'primaryImage'])->findOrFail($id);
        
        // Cari diskon aktif yang berlaku
        $bestDiscount = null;
        $discountAmount = 0;
        
        if (class_exists('\App\Models\Discount')) {
            $availableDiscounts = \App\Models\Discount::where('status', 'active')
                ->where(function($query) use ($id) {
                    $query->whereNull('product_id')
                          ->orWhere('product_id', $id);
                })
                ->get();
            
            // Pilih diskon terbaik
            $maxDiscount = 0;
            foreach ($availableDiscounts as $discount) {
                if (method_exists($discount, 'isValid') && $discount->isValid()) {
                    $testAmount = $discount->calculateDiscount($produk->harga_subsidi);
                    if ($testAmount > $maxDiscount) {
                        $maxDiscount = $testAmount;
                        $bestDiscount = $discount;
                        $discountAmount = $testAmount;
                    }
                }
            }
        }
        
        // Hitung subsidi pemerintah
        $subsidyAmount = $produk->harga_normal - $produk->harga_subsidi;
        $subsidyPercent = $produk->harga_normal > 0 
            ? round(($subsidyAmount / $produk->harga_normal) * 100, 1)
            : 0;
        
        return view('user.lihat-detail-pesan', compact(
            'produk',
            'bestDiscount',
            'discountAmount',
            'subsidyAmount',
            'subsidyPercent'
        ));
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
        // Validasi input
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'sometimes|exists:produk,id_produk',
        ], [
            'quantity.required' => 'Jumlah produk harus diisi',
            'quantity.integer' => 'Jumlah produk harus berupa angka',
            'quantity.min' => 'Jumlah produk minimal 1',
        ]);
        
        // Ambil produk dari database
        $produk = Product::with(['images', 'primaryImage'])->findOrFail($id);
        
        // Validasi stok
        $quantity = $validated['quantity'];
        if ($quantity > $produk->stok_produk) {
            return back()->withErrors([
                'quantity' => "Stok tidak mencukupi. Tersedia: {$produk->stok_produk} unit"
            ])->withInput();
        }
        
        if ($produk->stok_produk <= 0) {
            return back()->withErrors([
                'stock' => 'Maaf, produk ini sedang habis.'
            ])->withInput();
        }
        
        // Hitung subtotal
        $subtotal = $produk->harga_subsidi * $quantity;
        
        // Cek diskon yang tersedia
        $bestDiscount = null;
        $discountAmount = 0;
        
        if (class_exists('\App\Models\Discount')) {
            $availableDiscounts = \App\Models\Discount::where('status', 'active')
                ->where(function($query) use ($id) {
                    $query->whereNull('product_id')
                          ->orWhere('product_id', $id);
                })
                ->get();
            
            $maxDiscount = 0;
            foreach ($availableDiscounts as $discount) {
                if (method_exists($discount, 'isValid') && $discount->isValid()) {
                    if ($subtotal >= ($discount->min_purchase ?? 0)) {
                        $testAmount = $discount->calculateDiscount($subtotal);
                        if ($testAmount > $maxDiscount) {
                            $maxDiscount = $testAmount;
                            $bestDiscount = $discount;
                            $discountAmount = $testAmount;
                        }
                    }
                }
            }
        }
        
        // Hitung subsidi
        $subsidyAmount = ($produk->harga_normal - $produk->harga_subsidi) * $quantity;
        
        // Total akhir
        $total = $subtotal - $discountAmount;
        
        return view('user.konfirmasi-pesanan', compact(
            'produk',
            'quantity',
            'subtotal',
            'discountAmount',
            'bestDiscount',
            'subsidyAmount',
            'total'
        ));
    }
    
    /**
     * Simpan pesanan ke database
     */
    public function storeOrder(Request $request, $id)
    {
        try {
            // Log request untuk debugging
            \Log::info('Store Order Request', [
                'user_id' => auth()->id(),
                'product_id' => $id,
                'request_data' => $request->all()
            ]);

            // Validasi input
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:20',
                'customer_address' => 'required|string',
                'customer_notes' => 'nullable|string',
                'village_office' => 'required|string|max:255',
            ]);
            
            // Ambil produk
            $produk = Product::findOrFail($id);
            
            // Validasi stok
            if ($validated['quantity'] > $produk->stok_produk) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok tidak mencukupi. Tersedia: {$produk->stok_produk} unit"
                ], 422);
            }
        
        // Hitung harga
        $quantity = $validated['quantity'];
        $unitPrice = $produk->harga_subsidi;
        $subtotal = $unitPrice * $quantity;
        $discountAmount = 0;
        $discountId = null;
        
        // Cek diskon yang tersedia
        if (class_exists('\App\Models\Discount')) {
            $availableDiscounts = \App\Models\Discount::where('status', 'active')
                ->where(function($query) use ($id) {
                    $query->whereNull('product_id')
                          ->orWhere('product_id', $id);
                })
                ->get();
            
            $maxDiscount = 0;
            foreach ($availableDiscounts as $discount) {
                if (method_exists($discount, 'isValid') && $discount->isValid()) {
                    if ($subtotal >= ($discount->min_purchase ?? 0)) {
                        $testAmount = $discount->calculateDiscount($subtotal);
                        if ($testAmount > $maxDiscount) {
                            $maxDiscount = $testAmount;
                            $discountAmount = $testAmount;
                            $discountId = $discount->id;
                        }
                    }
                }
            }
        }
        
        $totalAmount = $subtotal - $discountAmount;
        
        // Generate nomor pesanan
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        
        // Simpan ke database dengan DB transaction
        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'product_id' => $produk->id_produk,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'discount_id' => $discountId,
                'total_amount' => $totalAmount,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'customer_notes' => $validated['customer_notes'] ?? null,
                'village_office' => $validated['village_office'],
                'items' => json_encode([[
                    'product_id' => $produk->id_produk,
                    'product_name' => $produk->nama_produk,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal
                ]]),
                'status' => 'Pending',
                'confirmed_by_user' => true,
                'confirmed_at' => now(),
            ]);
            
            // PENTING: Kurangi stok produk saat order dibuat
            $produk->decrement('stok_produk', $quantity);
            
            DB::commit();
            
            \Log::info('Order Created Successfully', [
                'order_id' => $order->id,
                'order_number' => $orderNumber
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order Creation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pesanan: ' . $e->getMessage()
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil disimpan',
            'order_number' => $orderNumber,
            'total_amount' => $totalAmount,
            'order_id' => $order->id
        ]);
        
        } catch (\Exception $e) {
            \Log::error('Store Order Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}

