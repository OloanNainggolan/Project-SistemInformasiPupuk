<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Contact;
use App\Models\Notification;
use App\Models\Message;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username|alpha_dash',
            'alamat' => 'required|string|max:255',
            'alamat_balai_desa' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|confirmed',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash dan underscore',
        ]);
        
        $user = User::create([
            'name' => $request->nama_lengkap, // Tambahkan field name untuk Laravel Auth
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'alamat' => $request->alamat,
            'alamat_balai_desa' => $request->alamat_balai_desa,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto login setelah registrasi
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->nama_lengkap);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input - form menggunakan field 'login' yang bisa username atau email
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $loginField = $request->input('login');
        $password = $request->input('password');

        // Cek apakah input adalah email atau username
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt login dengan email atau username
        $credentials = [
            $fieldType => $loginField,
            'password' => $password,
        ];

        // Debug logging
        \Log::info('Login attempt', [
            'field_type' => $fieldType,
            'field_value' => $loginField,
            'credentials' => [$fieldType => $loginField, 'password' => '***']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            \Log::info('Login successful', ['user_id' => Auth::id()]);
            return redirect()->route('dashboard');
        }

        \Log::warning('Login failed', ['field' => $loginField]);
        return back()->withErrors(['login' => 'Username/Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function showProfil()
    {
        $user = auth()->user();
        
        // Ambil HANYA pesanan yang sudah COMPLETED untuk statistik
        $completedOrders = \App\Models\Order::with(['product'])
            ->where('user_id', $user->id)
            ->where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->get();
        
        // Hitung statistik REAL dari database
        $totalPesanan = $completedOrders->count();
        
        // Hitung total pupuk dan bibit yang diterima (hanya yang completed)
        $pupukDiterima = 0;
        $bibitDiterima = 0;
        $totalPenghematan = 0;
        
        foreach ($completedOrders as $order) {
            // Ambil quantity dari order
            $quantity = $order->quantity ?? 0;
            
            // Cek tipe produk dari relasi product
            if ($order->product) {
                $productType = strtolower($order->product->tipe_produk ?? '');
                
                // Hitung berdasarkan tipe produk
                if ($productType === 'pupuk') {
                    $pupukDiterima += $quantity;
                } elseif ($productType === 'bibit') {
                    $bibitDiterima += $quantity;
                }
                
                // Hitung penghematan REAL dari harga_normal - harga_subsidi
                $hargaNormal = $order->product->harga_normal ?? 0;
                $hargaSubsidi = $order->product->harga_subsidi ?? 0;
                $penghematanPerUnit = $hargaNormal - $hargaSubsidi;
                
                if ($penghematanPerUnit > 0) {
                    $totalPenghematan += $penghematanPerUnit * $quantity;
                }
            }
        }
        
        // Ambil SEMUA pesanan dengan pagination untuk ditampilkan di riwayat
        // (termasuk Pending, Processing, dll)
        $orders = \App\Models\Order::with(['product'])
            ->where('user_id', $user->id)
            ->where('confirmed_by_user', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Log statistik untuk debugging
        \Log::info('User Profile Statistics', [
            'user_id' => $user->id,
            'totalPesanan' => $totalPesanan,
            'pupukDiterima' => $pupukDiterima,
            'bibitDiterima' => $bibitDiterima,
            'totalPenghematan' => $totalPenghematan,
            'completedOrdersCount' => $completedOrders->count()
        ]);
        
        return view('user.ProfilUser', compact(
            'orders',
            'totalPesanan',
            'pupukDiterima',
            'bibitDiterima',
            'totalPenghematan'
        ));
    }

    public function editProfil()
    {
        $user = auth()->user();
        return view('user.EditProfil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'alamat_balai_desa' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telp' => 'required|string|max:20',
            'kabupaten' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'luas_lahan' => 'nullable|numeric|min:0|max:999999.99',
            'jenis_tanaman' => 'nullable|string|max:255',
            'lokasi_lahan' => 'nullable|string|max:255',
        ];

        // Only add username validation if username is filled
        if ($request->filled('username')) {
            $rules['username'] = 'nullable|string|max:255|unique:users,username,' . $user->id;
        }

        // Only validate password if user fills in the password field
        if ($request->filled('password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:3|confirmed';
        }

        $validated = $request->validate($rules);

        // Check password if user wants to change it
        if ($request->filled('password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
            // Update with new password
            $validated['password'] = Hash::make($request->password);
        }

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto && file_exists(public_path($user->foto))) {
                @unlink(public_path($user->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $filename);
            $validated['foto'] = 'images/profiles/' . $filename;
        }

        // Handle photo removal
        if ($request->has('remove_foto') && $request->input('remove_foto') == '1') {
            if ($user->foto && file_exists(public_path($user->foto))) {
                @unlink(public_path($user->foto));
            }
            $validated['foto'] = null;
        }

        // Remove password fields if not changing password
        if (!$request->filled('password')) {
            unset($validated['password']);
        }

        // Remove password_confirmation from validated data
        unset($validated['password_confirmation'], $validated['current_password']);

        // Update user
        $user->update($validated);

        return redirect()->route('profil.user')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show order detail page
     */
    public function showOrderDetail($id)
    {
        $order = \App\Models\Order::with(['product', 'user'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('user.order-detail', compact('order'));
    }

    public function getOrderDetail($id)
    {
        try {
            $order = \App\Models\Order::with('user')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Parse items dari JSON
            $items = $order->items;
            
            // Jika masih string, decode dulu
            if (is_string($items)) {
                $items = json_decode($items, true);
            }
            
            $productName = 'Produk tidak tersedia';
            $quantity = 0;
            $unitPrice = 0;
            $subtotal = 0;
            
            if (is_array($items) && count($items) > 0) {
                // Ambil item pertama (biasanya hanya 1 item per order)
                $firstItem = $items[0];
                $productName = $firstItem['product_name'] ?? $firstItem['name'] ?? 'Produk tidak tersedia';
                $quantity = (int) ($firstItem['quantity'] ?? $firstItem['qty'] ?? 0);
                $unitPrice = (float) ($firstItem['price'] ?? $firstItem['unit_price'] ?? 0);
                $subtotal = $quantity * $unitPrice;
            }
            
            // Jika masih 0, estimasi dari total_amount
            if ($quantity === 0 && $order->total_amount > 0 && $unitPrice > 0) {
                $quantity = (int) ceil($order->total_amount / $unitPrice);
            }

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('d F Y, H:i'),
                    'product_name' => $productName,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'unit_price_formatted' => number_format($unitPrice, 0, ',', '.'),
                    'subtotal' => $subtotal,
                    'subtotal_formatted' => number_format($subtotal, 0, ',', '.'),
                    'discount_amount' => 0,
                    'discount_formatted' => '0',
                    'total_amount' => $order->total_amount ?? 0,
                    'total_formatted' => number_format($order->total_amount ?? 0, 0, ',', '.'),
                    'customer_name' => $order->user->nama_lengkap ?? '-',
                    'customer_phone' => $order->user->no_telp ?? $order->user->no_hp ?? '-',
                    'customer_address' => $order->user->alamat ?? '-',
                    'village_office' => $order->village_office ?? '-',
                    'customer_notes' => null,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Order Detail Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }
    }

    public function updateProfilSecondMethod(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'alamat_balai_desa' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telp' => 'required|string|max:20',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'kabupaten' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Only validate password if user fills in the password field
        if ($request->filled('password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:3|confirmed';
        }

        $validated = $request->validate($rules, [
            'username.unique' => 'Username sudah digunakan oleh user lain',
            'email.unique' => 'Email sudah digunakan oleh user lain',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Check password if user wants to change it
        if ($request->filled('password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Sandi saat ini tidak sesuai.'])->withInput();
            }
        }

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $filename);
            $validated['foto'] = 'images/profiles/' . $filename;
        }

        // Update user data field by field to avoid SQL issues
        $user->name = $validated['nama_lengkap'];
        $user->nama_lengkap = $validated['nama_lengkap'];
        $user->alamat = $validated['alamat'];
        $user->email = $validated['email'];
        $user->no_telp = $validated['no_telp'];

        // Prepare data for update
        $updateData = [
            'name' => $validated['nama_lengkap'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'alamat' => $validated['alamat'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'],
        ];

        // Add optional fields
        if (isset($validated['username'])) {
            $updateData['username'] = $validated['username'];
        }
        if (isset($validated['kabupaten'])) {
            $updateData['kabupaten'] = $validated['kabupaten'];
        }
        if (isset($validated['kode_pos'])) {
            $updateData['kode_pos'] = $validated['kode_pos'];
        }
        if (isset($validated['foto'])) {
            $updateData['foto'] = $validated['foto'];
        }
        if (isset($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        // Update using query builder for better control
        \DB::table('users')
            ->where('id', $user->id)
            ->update($updateData);

        return redirect()->route('profil.user')->with('success', 'Profil berhasil diperbarui!');
    }

    public function sendKontak(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        // Jika user login, simpan ke tabel messages (sistem notifikasi baru)
        if (Auth::check()) {
            Message::create([
                'user_id' => Auth::id(),
                'sender_type' => 'user',
                'subject' => 'Pesan dari ' . $validated['nama'],
                'message' => $validated['pesan'],
                'status' => 'unread',
            ]);

            return redirect()->route('kontak')->with('success', 'Pesan Anda telah terkirim! Admin akan segera membalasnya.');
        }

        // Jika user tidak login, simpan ke tabel contacts (sistem lama)
        $contact = Contact::create([
            'nama' => $validated['nama'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'pesan' => $validated['pesan'],
            'user_id' => null,
            'status' => 'unread'
        ]);

        // Buat notifikasi untuk admin
        Notification::create([
            'type' => 'contact',
            'title' => 'Pesan Baru dari ' . $validated['nama'],
            'message' => substr($validated['pesan'], 0, 100) . (strlen($validated['pesan']) > 100 ? '...' : ''),
            'link' => route('admin.notifications.index'),
            'status' => 'unread',
            'related_id' => $contact->id
        ]);

        return redirect()->route('kontak')->with('success', 'Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.');
    }

    /**
     * Process a password reset request (simple flow: email + new password + confirm)
     */
    public function processReset(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|string|min:4|confirmed',
        ], [
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 4 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return back()->withInput()->withErrors(['email' => 'Alamat email tidak terdaftar.']);
        }

        // Update password
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }
        
        $userId = $user->id;
        $fotoPath = $user->foto;
        
        try {
            // Log untuk debugging
            \Log::info("Deleting user account", ['user_id' => $userId, 'email' => $user->email]);
            
            // Hapus semua relasi user terlebih dahulu (gunakan DB transaction)
            \DB::transaction(function() use ($userId, $user, $fotoPath) {
                // Hapus semua pesanan user
                \App\Models\Order::where('user_id', $userId)->delete();
                
                // Hapus semua notifikasi user
                \App\Models\Notification::where('user_id', $userId)->delete();
                
                // Hapus semua pesan user
                \App\Models\Message::where('user_id', $userId)->delete();
                
                // Hapus user dari database - INI YANG PENTING!
                \DB::table('users')->where('id', $userId)->delete();
                
                // Log success
                \Log::info("User deleted successfully", ['user_id' => $userId]);
            });
            
            // Hapus foto profil jika ada (di luar transaction)
            if ($fotoPath && file_exists(public_path($fotoPath))) {
                @unlink(public_path($fotoPath));
            }
            
        } catch (\Exception $e) {
            \Log::error("Error deleting user account", [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus akun: ' . $e->getMessage());
        }
        
        // Logout dan clear session SETELAH semua operasi database selesai
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        
        // Redirect ke homepage dengan query parameter untuk pesan sukses
        return redirect('/?deleted=1')->withCookie(\Cookie::forget('laravel_session'));
    }
}
