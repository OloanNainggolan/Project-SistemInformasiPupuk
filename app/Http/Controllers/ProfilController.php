<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Cek struktur tabel orders dulu untuk memastikan kolom yang ada
        // Gunakan query yang lebih safe tanpa assumsi kolom
        
        try {
            // Total pesanan dari user ini
            $totalPesanan = DB::table('orders')
                ->where('user_id', $user->id)
                ->where('confirmed_by_user', true)
                ->count();
            
            // Ambil semua pesanan completed dengan join ke produk
            $completedOrders = DB::table('orders')
                ->join('produk', 'produk.id_produk', '=', 'orders.id_produk')
                ->where('orders.user_id', $user->id)
                ->where('orders.confirmed_by_user', true)
                ->where('orders.status', 'Completed')
                ->select('produk.tipe_produk', 'produk.harga_normal', 'produk.harga_subsidi')
                ->get();
            
            // Hitung pupuk dan bibit dari completed orders
            $pupukDiterima = $completedOrders->where('tipe_produk', 'pupuk')->count();
            $bibitDiterima = $completedOrders->where('tipe_produk', 'bibit')->count();
            
            // Hitung total penghematan
            $totalPenghematan = $completedOrders->sum(function($order) {
                return ($order->harga_normal - $order->harga_subsidi);
            });
            
            // Riwayat Pesanan (10 terakhir) - gunakan join manual
            $recentOrders = DB::table('orders')
                ->leftJoin('produk', 'produk.id_produk', '=', 'orders.id_produk')
                ->leftJoin('product_images', function($join) {
                    $join->on('product_images.product_id', '=', 'produk.id_produk')
                         ->where('product_images.is_primary', true);
                })
                ->where('orders.user_id', $user->id)
                ->where('orders.confirmed_by_user', true)
                ->select(
                    'orders.id',
                    'orders.status',
                    'orders.total_amount',
                    'orders.created_at',
                    'produk.nama_produk',
                    'produk.tipe_produk',
                    'produk.kategori',
                    'product_images.image_path'
                )
                ->orderBy('orders.created_at', 'desc')
                ->limit(10)
                ->get();
            
        } catch (\Exception $e) {
            // Jika error, set default values
            $totalPesanan = 0;
            $pupukDiterima = 0;
            $bibitDiterima = 0;
            $totalPenghematan = 0;
            $recentOrders = collect([]);
            
            // Log error untuk debugging
            \Log::error('Profil Controller Error: ' . $e->getMessage());
        }
        
        return view('user.ProfilUser', compact(
            'user',
            'totalPesanan',
            'pupukDiterima',
            'bibitDiterima',
            'totalPenghematan',
            'recentOrders'
        ));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.EditProfil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'alamat_balai_desa' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:5',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/users'), $filename);
            $validated['foto'] = 'images/users/' . $filename;
        }

        // Handle password change
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai'])->withInput();
            }
            
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            }
        }

        // Remove password fields if not changing password
        if (!$request->filled('password')) {
            unset($validated['password']);
        }
        unset($validated['current_password']);

        $user->update($validated);

        return redirect()->route('profil.user')->with('success', 'Profil berhasil diperbarui!');
    }
}