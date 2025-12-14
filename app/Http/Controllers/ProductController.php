<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['primaryImage', 'images' => function($query) {
            $query->orderBy('order');
        }])->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'tipe_produk' => 'required|in:pupuk,bibit',
            'kategori' => 'required|string|max:100',
            'harga_subsidi' => 'required|numeric|min:0',
            'harga_normal' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'gambar' => 'required|array|min:1|max:5',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
            'manfaat' => 'nullable|string',
            'bahan' => 'nullable|string',
            'cara_penggunaan' => 'nullable|string'
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'tipe_produk.required' => 'Tipe produk wajib dipilih',
            'tipe_produk.in' => 'Tipe produk harus Pupuk atau Bibit',
            'kategori.required' => 'Kategori wajib diisi',
            'harga_subsidi.required' => 'Harga subsidi wajib diisi',
            'harga_subsidi.numeric' => 'Harga subsidi harus berupa angka',
            'harga_subsidi.min' => 'Harga subsidi tidak boleh negatif',
            'harga_normal.required' => 'Harga normal wajib diisi',
            'harga_normal.numeric' => 'Harga normal harus berupa angka',
            'harga_normal.min' => 'Harga normal tidak boleh negatif',
            'stok_produk.required' => 'Stok wajib diisi',
            'stok_produk.integer' => 'Stok harus berupa angka bulat',
            'stok_produk.min' => 'Stok tidak boleh negatif',
            'gambar.required' => 'Minimal 1 gambar produk wajib diupload',
            'gambar.array' => 'Gambar harus berupa array',
            'gambar.min' => 'Minimal upload 1 gambar',
            'gambar.max' => 'Maksimal upload 5 gambar',
            'gambar.*.required' => 'Setiap gambar wajib diisi',
            'gambar.*.image' => 'File harus berupa gambar',
            'gambar.*.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
            'gambar.*.max' => 'Ukuran setiap gambar maksimal 2MB'
        ]);

        // Validasi tambahan: harga subsidi harus lebih kecil dari harga normal
        if ($validated['harga_subsidi'] >= $validated['harga_normal']) {
            return back()
                ->withInput()
                ->withErrors(['harga_subsidi' => 'Harga subsidi harus lebih kecil dari harga normal']);
        }

        // Auto-fill kategori jika tipe bibit
        if ($validated['tipe_produk'] === 'bibit') {
            $validated['kategori'] = 'Organik';
        }

        try {
            // Gunakan transaction untuk memastikan data konsisten
            DB::beginTransaction();

            // Simpan produk ke database (tanpa gambar di tabel produk)
            $product = Product::create([
                'nama_produk' => $validated['nama_produk'],
                'tipe_produk' => $validated['tipe_produk'],
                'kategori' => $validated['kategori'],
                'harga_subsidi' => $validated['harga_subsidi'],
                'harga_normal' => $validated['harga_normal'],
                'stok_produk' => $validated['stok_produk'],
                'gambar' => '', // Field ini akan deprecated, pakai relasi images
                'deskripsi' => $validated['deskripsi'] ?? null,
                'manfaat' => $validated['manfaat'] ?? null,
                'bahan' => $validated['bahan'] ?? null,
                'cara_penggunaan' => $validated['cara_penggunaan'] ?? null
            ]);

            // Upload dan simpan gambar-gambar
            if ($request->hasFile('gambar')) {
                $images = $request->file('gambar');
                
                foreach ($images as $index => $image) {
                    // Generate nama file unik
                    $imageName = time() . '_' . uniqid() . '_' . $index . '.' . $image->extension();
                    
                    // Pindahkan file ke folder public/images/products
                    $image->move(public_path('images/products'), $imageName);
                    
                    // Simpan ke tabel product_images
                    ProductImage::create([
                        'product_id' => $product->id_produk,
                        'image_path' => 'images/products/' . $imageName,
                        'is_primary' => ($index === 0), // Gambar pertama sebagai primary
                        'order' => $index
                    ]);
                }

                // Update field gambar di tabel produk dengan gambar pertama (untuk backward compatibility)
                $firstImage = ProductImage::where('product_id', $product->id_produk)
                                         ->where('is_primary', true)
                                         ->first();
                if ($firstImage) {
                    $product->update(['gambar' => $firstImage->image_path]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan dengan ' . count($request->file('gambar')) . ' gambar!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'tipe_produk' => 'required|in:pupuk,bibit',
            'kategori' => 'required|string|max:100',
            'harga_subsidi' => 'required|numeric|min:0',
            'harga_normal' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'manfaat' => 'nullable|string',
            'bahan' => 'nullable|string',
            'cara_penggunaan' => 'nullable|string'
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'tipe_produk.required' => 'Tipe produk wajib dipilih',
            'tipe_produk.in' => 'Tipe produk harus Pupuk atau Bibit',
            'kategori.required' => 'Kategori wajib diisi',
            'harga_subsidi.required' => 'Harga subsidi wajib diisi',
            'harga_subsidi.numeric' => 'Harga subsidi harus berupa angka',
            'harga_subsidi.min' => 'Harga subsidi tidak boleh negatif',
            'harga_normal.required' => 'Harga normal wajib diisi',
            'harga_normal.numeric' => 'Harga normal harus berupa angka',
            'harga_normal.min' => 'Harga normal tidak boleh negatif',
            'stok_produk.required' => 'Stok wajib diisi',
            'stok_produk.integer' => 'Stok harus berupa angka bulat',
            'stok_produk.min' => 'Stok tidak boleh negatif',
            'gambar.array' => 'Gambar harus berupa array',
            'gambar.max' => 'Maksimal upload 5 gambar',
            'gambar.*.image' => 'File harus berupa gambar',
            'gambar.*.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif',
            'gambar.*.max' => 'Ukuran setiap gambar maksimal 2MB'
        ]);

        // Validasi tambahan: harga subsidi harus lebih kecil dari harga normal
        if ($validated['harga_subsidi'] >= $validated['harga_normal']) {
            return back()
                ->withInput()
                ->withErrors(['harga_subsidi' => 'Harga subsidi harus lebih kecil dari harga normal']);
        }

        // Auto-fill kategori jika tipe bibit
        if ($validated['tipe_produk'] === 'bibit') {
            $validated['kategori'] = 'Organik';
        }

        try {
            DB::beginTransaction();

            // Update data produk
            $product->update([
                'nama_produk' => $validated['nama_produk'],
                'tipe_produk' => $validated['tipe_produk'],
                'kategori' => $validated['kategori'],
                'harga_subsidi' => $validated['harga_subsidi'],
                'harga_normal' => $validated['harga_normal'],
                'stok_produk' => $validated['stok_produk'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'manfaat' => $validated['manfaat'] ?? null,
                'bahan' => $validated['bahan'] ?? null,
                'cara_penggunaan' => $validated['cara_penggunaan'] ?? null
            ]);

            // Ambil ID gambar yang masih ada (tidak dihapus user)
            $existingImageIds = $request->input('existing_images', []);
            
            // Hapus gambar yang tidak ada di existing_images
            $imagesToDelete = ProductImage::where('product_id', $product->id_produk)
                ->whereNotIn('id', $existingImageIds)
                ->get();
            
            foreach ($imagesToDelete as $imageToDelete) {
                // Hapus file dari storage
                if ($imageToDelete->image_path && file_exists(public_path($imageToDelete->image_path))) {
                    unlink(public_path($imageToDelete->image_path));
                }
                $imageToDelete->delete();
            }

            // Upload gambar baru jika ada
            if ($request->hasFile('gambar')) {
                $images = $request->file('gambar');
                $currentImageCount = ProductImage::where('product_id', $product->id_produk)->count();
                
                foreach ($images as $index => $image) {
                    // Generate nama file unik
                    $imageName = time() . '_' . uniqid() . '_' . ($currentImageCount + $index) . '.' . $image->extension();
                    
                    // Pindahkan file ke folder public/images/products
                    $image->move(public_path('images/products'), $imageName);
                    
                    // Simpan ke tabel product_images
                    ProductImage::create([
                        'product_id' => $product->id_produk,
                        'image_path' => 'images/products/' . $imageName,
                        'is_primary' => ($currentImageCount === 0 && $index === 0), // Jika tidak ada gambar lama, gambar baru pertama jadi primary
                        'order' => $currentImageCount + $index
                    ]);
                }
            }

            // Update field gambar di tabel produk dengan gambar primary (untuk backward compatibility)
            $primaryImage = ProductImage::where('product_id', $product->id_produk)
                                       ->where('is_primary', true)
                                       ->first();
            
            // Jika tidak ada primary, set gambar pertama sebagai primary
            if (!$primaryImage) {
                $firstImage = ProductImage::where('product_id', $product->id_produk)
                                         ->orderBy('order', 'asc')
                                         ->first();
                if ($firstImage) {
                    $firstImage->update(['is_primary' => true]);
                    $primaryImage = $firstImage;
                }
            }
            
            if ($primaryImage) {
                $product->update(['gambar' => $primaryImage->image_path]);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Hapus semua gambar dari storage
            foreach ($product->images as $image) {
                if ($image->image_path && file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
            }

            // Hapus gambar lama di field gambar (backward compatibility)
            if ($product->gambar && file_exists(public_path($product->gambar))) {
                unlink(public_path($product->gambar));
            }

            // Hapus record dari database (cascade akan hapus product_images)
            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.products.index')
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage()]);
        }
    }
}
