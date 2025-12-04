<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Contact;
use App\Models\Notification;

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
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ], [
            'login.required' => 'Username atau Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Cek apakah ini login admin berdasarkan username atau email
        if ($login === 'admin' || $login === 'admin@pupuksubsidi.id') {
            // Redirect ke halaman login admin
            return redirect()->route('admin.login')
                ->withInput(['username' => 'admin'])
                ->with('info', 'Silakan gunakan halaman login admin.');
        }

        // Tentukan apakah login menggunakan email atau username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        // Attempt login dengan email atau username
        $credentials = [
            $fieldType => $login,
            'password' => $password
        ];

        // Login untuk user biasa
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Cek apakah user ini adalah admin (jika ada field role)
            $user = Auth::user();
            
            // Double check: pastikan bukan admin
            if (isset($user->role) && $user->role === 'admin') {
                Auth::logout();
                return redirect()->route('admin.login')
                    ->with('info', 'Silakan gunakan halaman login admin.');
            }
            
            return redirect()->route('dashboard');
        }

        return back()->withInput(['login' => $login])
            ->withErrors(['login' => 'Username/Email atau password salah.']);
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
        
        // Ambil pesanan user dengan relasi
        $orders = \App\Models\Order::with('user')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Hitung statistik
        $totalPesanan = \App\Models\Order::where('user_id', $user->id)->count();
        $completedOrders = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->get();
        
        $totalPupuk = 0;
        $totalBibit = 0;
        $totalPenghematan = 0;
        
        foreach ($completedOrders as $order) {
            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (isset($item['type'])) {
                        if ($item['type'] === 'pupuk') {
                            $totalPupuk += $item['qty'] ?? 0;
                        } else if ($item['type'] === 'bibit') {
                            $totalBibit += $item['qty'] ?? 0;
                        }
                    }
                }
            }
            $totalPenghematan += $order->total_amount;
        }
        
        return view('user.ProfilUser', compact(
            'orders',
            'totalPesanan',
            'totalPupuk',
            'totalBibit',
            'totalPenghematan'
        ));
    }

    public function editProfil()
    {
        return view('user.EditProfil');
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
        ], [
            'nama.required' => 'Nama wajib diisi',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'pesan.required' => 'Pesan wajib diisi',
        ]);

        // Simpan kontak ke database
        $contact = Contact::create([
            'nama' => $validated['nama'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'pesan' => $validated['pesan'],
            'user_id' => Auth::check() ? Auth::id() : null,
            'status' => 'unread'
        ]);

        // Buat notifikasi untuk admin
        Notification::create([
            'type' => 'contact',
            'title' => 'Pesan Baru dari ' . $validated['nama'],
            'message' => substr($validated['pesan'], 0, 100) . (strlen($validated['pesan']) > 100 ? '...' : ''),
            'link' => route('admin.notifications'),
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
            'new_password' => 'required|string|min:4|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 4 karakter',
            'new_password.regex' => 'Password harus mengandung huruf dan angka',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $validated['email'])->first();
        
        if (!$user) {
            return back()
                ->withInput(['email' => $validated['email']])
                ->withErrors(['email' => 'Alamat email tidak terdaftar dalam sistem.']);
        }

        // Update password dengan hash
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        // Log informasi untuk debugging (optional, bisa dihapus di production)
        \Log::info('Password reset successful for user: ' . $user->email);

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}
