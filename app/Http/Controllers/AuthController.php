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
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
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
        
        // Ambil pesanan user dengan relasi product
        $orders = \App\Models\Order::with(['user', 'product'])
            ->where('user_id', $user->id)
            ->where('confirmed_by_user', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Hitung statistik REAL dari database
        $totalPesanan = $orders->count();
        
        // Hitung total pupuk yang diterima (status Completed atau Ready)
        $pupukDiterima = 0;
        $bibitDiterima = 0;
        $totalPenghematan = 0;
        
        foreach ($orders as $order) {
            // Hitung penghematan dari semua pesanan yang confirmed
            $totalPenghematan += $order->savings ?? 0;
            
            // Hitung pupuk/bibit yang sudah diterima (status Completed atau Ready)
            if (in_array($order->status, ['Completed', 'Ready for Pickup'])) {
                if ($order->product) {
                    $qty = $order->quantity ?? 0;
                    
                    if ($order->product->tipe_produk === 'pupuk') {
                        $pupukDiterima += $qty;
                    } elseif ($order->product->tipe_produk === 'bibit') {
                        $bibitDiterima += $qty;
                    }
                }
            }
        }
        
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
        return view('user.EditProfil');
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telp' => 'required|string|max:20',
            'username' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

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
                return back()->withErrors(['current_password' => 'Sandi saat ini tidak sesuai.'])->withInput();
            }
            // Update with new password
            $validated['password'] = Hash::make($request->password);
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

        // Remove password fields if not changing password
        if (!$request->filled('password')) {
            unset($validated['password']);
        }

        // Update user
        $user->update($validated);

        return redirect()->route('profil.user')->with('success', 'Profil berhasil diperbarui!');
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
}
