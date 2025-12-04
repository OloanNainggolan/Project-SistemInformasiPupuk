<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman login admin
     */
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    /**
     * Memproses login admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username/Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $identifier = $request->input('username');
        $password = $request->input('password');

        // Cari admin berdasarkan username atau email
        $admin = Admin::where('username', $identifier)
                      ->orWhere('email', $identifier)
                      ->first();

        if ($admin && Hash::check($password, $admin->password)) {
            // Login berhasil - simpan data admin di session
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_username' => $admin->username,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
                'admin_phone' => $admin->phone,
                'admin_address' => $admin->address,
                'admin_avatar' => $admin->avatar,
                'admin_login_time' => now()
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $admin->name . '!');
        } else {
            // Login gagal
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username/Email atau password salah!');
        }
    }

    /**
     * Menampilkan dashboard admin
     */
    public function dashboard()
    {
        // Tanggal untuk perbandingan (bulan ini vs bulan lalu)
        $now = now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $endOfThisMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Statistik bulan ini
        $totalPesanan = Order::confirmed()->count();
        $totalPendapatan = Order::confirmed()
            ->whereIn('status', ['Completed'])
            ->sum('total_amount');
        $totalPetani = User::count();
        $totalProduk = Product::count();

        // Statistik bulan lalu untuk perbandingan
        $pesananBulanLalu = Order::confirmed()
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $pendapatanBulanLalu = Order::confirmed()
            ->whereIn('status', ['Completed'])
            ->whereBetween('updated_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total_amount');
        $petaniBulanLalu = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $produkBulanLalu = Product::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        // Statistik bulan ini untuk perbandingan
        $pesananBulanIni = Order::confirmed()
            ->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])
            ->count();
        $pendapatanBulanIni = Order::confirmed()
            ->whereIn('status', ['Completed'])
            ->whereBetween('updated_at', [$startOfThisMonth, $endOfThisMonth])
            ->sum('total_amount');
        $petaniBulanIni = User::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();
        $produkBulanIni = Product::whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])->count();

        // Hitung persentase pertumbuhan real
        $pertumbuhanPesanan = $pesananBulanLalu > 0 
            ? round((($pesananBulanIni - $pesananBulanLalu) / $pesananBulanLalu) * 100, 1)
            : ($pesananBulanIni > 0 ? 100 : 0);

        $pertumbuhanPendapatan = $pendapatanBulanLalu > 0 
            ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : ($pendapatanBulanIni > 0 ? 100 : 0);

        $pertumbuhanPetani = $petaniBulanLalu > 0 
            ? round((($petaniBulanIni - $petaniBulanLalu) / $petaniBulanLalu) * 100, 1)
            : ($petaniBulanIni > 0 ? 100 : 0);

        $pertumbuhanProduk = $produkBulanLalu > 0 
            ? round((($produkBulanIni - $produkBulanLalu) / $produkBulanLalu) * 100, 1)
            : ($produkBulanIni > 0 ? 100 : 0);

        // Pesanan dalam proses (limit 10) - hanya yang belum selesai
        $recentOrders = Order::with('user')
            ->confirmed()
            ->whereIn('status', ['Pending', 'Processing', 'Ready'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Statistik per status
        $pendingCount = Order::confirmed()->where('status', 'Pending')->count();
        $processingCount = Order::confirmed()->where('status', 'Processing')->count();
        $readyCount = Order::confirmed()->where('status', 'Ready')->count();
        $completedCount = Order::confirmed()->where('status', 'Completed')->count();
        $rejectedCount = Order::confirmed()->where('status', 'Rejected')->count();

        return view('admin.dashboard', compact(
            'totalPesanan',
            'totalPendapatan',
            'totalPetani',
            'totalProduk',
            'pertumbuhanPesanan',
            'pertumbuhanPendapatan',
            'pertumbuhanPetani',
            'pertumbuhanProduk',
            'recentOrders',
            'pendingCount',
            'processingCount',
            'readyCount',
            'completedCount',
            'rejectedCount'
        ));
    }

    /**
     * Halaman Overview Admin dengan statistik dinamis (sama dengan dashboard)
     */
    public function overview()
    {
        // Redirect ke dashboard agar tidak duplikat
        return redirect()->route('admin.dashboard');
    }

    /**
     * Halaman profil admin
     */
    public function profil()
    {
        // Statistik untuk profil admin
        $totalPesanan = Order::confirmed()->count();
        $totalPendapatan = Order::confirmed()->where('status', 'Completed')->sum('total_amount');
        $totalPetani = User::count();
        $totalProduk = Product::count();

        // Pesanan terbaru untuk ditampilkan di profil
        $recentOrders = Order::with('user')
            ->confirmed()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Status counts
        $pendingCount = Order::confirmed()->where('status', 'Pending')->count();
        $processingCount = Order::confirmed()->where('status', 'Processing')->count();
        $readyCount = Order::confirmed()->where('status', 'Ready')->count();
        $completedCount = Order::confirmed()->where('status', 'Completed')->count();
        $rejectedCount = Order::where('status', 'Rejected')->count();

        return view('admin.profil', compact(
            'totalPesanan',
            'totalPendapatan',
            'totalPetani',
            'totalProduk',
            'recentOrders',
            'pendingCount',
            'processingCount',
            'readyCount',
            'completedCount',
            'rejectedCount'
        ));
    }

    /**
     * Halaman kirim notifikasi
     */
    public function notifications()
    {
        $totalUsers = User::count();
        $notificationsSent = 0; // Nanti bisa diambil dari database jika ada tabel notifications
        
        return view('admin.notifications', compact('totalUsers', 'notificationsSent'));
    }

    /**
     * Kirim notifikasi ke users
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'recipient_type' => 'required|in:all,active'
        ], [
            'title.required' => 'Judul notifikasi harus diisi',
            'message.required' => 'Pesan harus diisi',
            'message.min' => 'Pesan minimal 10 karakter',
        ]);

        // Ambil users berdasarkan recipient_type
        if ($request->recipient_type === 'active') {
            // Users yang pernah melakukan pesanan
            $userIds = Order::distinct()->pluck('user_id');
            $users = User::whereIn('id', $userIds)->get();
        } else {
            // Semua users
            $users = User::all();
        }

        // Simpan notifikasi ke session untuk ditampilkan ke user
        // Dalam implementasi real, ini akan disimpan ke database dan dikirim via email/push notification
        $notificationData = [
            'title' => $request->title,
            'message' => $request->message,
            'sent_to' => $users->count(),
            'sent_at' => now()
        ];

        // Simpan ke session (untuk demo)
        session()->put('last_notification', $notificationData);

        return redirect()->route('admin.notifications')
            ->with('success', "Notifikasi berhasil dikirim ke {$users->count()} petani!");
    }

    /**
     * Halaman edit profil admin
     */
    public function editProfil()
    {
        // Get admin data from database
        $adminId = session('admin_id');
        $admin = Admin::find($adminId);
        
        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Session expired. Please login again.');
        }

        return view('admin.profil-edit', compact('admin'));
    }

    /**
     * Update profil admin
     */
    public function updateProfil(Request $request)
    {
        $adminId = session('admin_id');
        $admin = Admin::find($adminId);

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Session expired. Please login again.');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'avatar.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        // Update data admin
        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if ($request->filled('phone')) {
            $admin->phone = $request->phone;
        }
        
        if ($request->filled('address')) {
            $admin->address = $request->address;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($admin->avatar && file_exists(public_path($admin->avatar))) {
                unlink(public_path($admin->avatar));
            }

            $avatarFile = $request->file('avatar');
            $avatarName = 'admin_' . time() . '_' . uniqid() . '.' . $avatarFile->getClientOriginalExtension();
            $avatarFile->move(public_path('images/profiles'), $avatarName);
            $admin->avatar = 'images/profiles/' . $avatarName;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        // Save to database
        $admin->save();

        // Update session data
        session([
            'admin_name' => $admin->name,
            'admin_email' => $admin->email,
            'admin_phone' => $admin->phone,
            'admin_address' => $admin->address,
            'admin_avatar' => $admin->avatar,
        ]);

        return redirect()->route('admin.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        // Hapus semua session admin
        session()->forget([
            'admin_logged_in',
            'admin_id',
            'admin_username',
            'admin_name',
            'admin_email',
            'admin_phone',
            'admin_address',
            'admin_avatar',
            'admin_login_time'
        ]);
        
        return redirect()->route('admin.login')->with('success', 'Anda telah logout');
    }
}
