<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Kredensial admin yang sudah ditentukan (hardcoded)
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_EMAIL = 'admin@pupuksubsidi.id';
    private const ADMIN_PASSWORD = 'admin123';

    /**
     * Menampilkan halaman login admin
     */
    public function showLogin()
    {
        // Jika sudah login sebagai admin, tampilkan info dan tombol ke dashboard
        // Tidak auto-redirect agar user bisa logout jika perlu
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

        $identifier = $request->input('username'); // bisa username atau email
        $password = $request->input('password');

        // Validasi kredensial admin - support username atau email
        $isValidUsername = ($identifier === self::ADMIN_USERNAME && $password === self::ADMIN_PASSWORD);
        $isValidEmail = ($identifier === self::ADMIN_EMAIL && $password === self::ADMIN_PASSWORD);

        if ($isValidUsername || $isValidEmail) {
            // Login berhasil - simpan status login di session
            session([
                'admin_logged_in' => true,
                'admin_username' => self::ADMIN_USERNAME,
                'admin_email' => self::ADMIN_EMAIL,
                'admin_login_time' => now()
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
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
        // Redirect ke overview
        return redirect()->route('admin.overview');
    }

    /**
     * Halaman Overview Admin dengan statistik dinamis
     */
    public function overview()
    {
        // Statistik dinamis dari database
        $totalPesanan = Order::confirmed()->count();
        $totalPendapatan = Order::confirmed()
            ->whereIn('status', ['Completed'])
            ->sum('total_amount');
        $totalPetani = User::count();
        $totalProduk = Product::count();

        // Pesanan terbaru (limit 10)
        $recentOrders = Order::with('user')
            ->confirmed()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Statistik per status
        $pendingCount = Order::confirmed()->where('status', 'Pending')->count();
        $processingCount = Order::confirmed()->where('status', 'Processing')->count();
        $readyCount = Order::confirmed()->where('status', 'Ready')->count();
        $completedCount = Order::confirmed()->where('status', 'Completed')->count();
        $rejectedCount = Order::confirmed()->where('status', 'Rejected')->count();

        return view('admin.overview', compact(
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
     * Logout admin
     */
    public function logout()
    {
        // Hapus semua session admin
        session()->forget(['admin_logged_in', 'admin_username', 'admin_login_time']);
        
        return redirect()->route('admin.login')->with('success', 'Anda telah logout');
    }
}
