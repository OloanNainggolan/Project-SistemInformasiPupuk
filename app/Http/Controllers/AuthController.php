<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        // Update optional fields if present
        if (isset($validated['alamat_balai_desa'])) {
            $user->alamat_balai_desa = $validated['alamat_balai_desa'];
        }
        if (isset($validated['username'])) {
            $user->username = $validated['username'];
        }
        if (isset($validated['kabupaten'])) {
            $user->kabupaten = $validated['kabupaten'];
        }
        if (isset($validated['kode_pos'])) {
            $user->kode_pos = $validated['kode_pos'];
        }
        if (isset($validated['foto'])) {
            $user->foto = $validated['foto'];
        }
        
        // Update password if being changed
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the changes
        $user->save();

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

        // Di sini Anda bisa menambahkan logika untuk menyimpan pesan ke database
        // atau mengirim email ke admin
        // Untuk sementara, kita hanya redirect dengan pesan sukses

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
}
