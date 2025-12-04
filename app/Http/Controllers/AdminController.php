<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Hardcoded admin credentials
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_PASSWORD = 'admin123';
    private const ADMIN_NAME = 'Administrator';
    private const ADMIN_EMAIL = 'admin@pupukbibit.com';

    /**
     * Menampilkan halaman login admin
     */
    public function showLogin()
    {
        // Redirect jika sudah login
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.admin-login');
    }

    /**
     * Memproses login admin (hardcoded credentials)
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Cek hardcoded credentials
        if ($username === self::ADMIN_USERNAME && $password === self::ADMIN_PASSWORD) {
            // Login berhasil - simpan data admin di session
            session([
                'admin_logged_in' => true,
                'admin_username' => self::ADMIN_USERNAME,
                'admin_name' => self::ADMIN_NAME,
                'admin_email' => self::ADMIN_EMAIL,
                'admin_login_time' => now()
            ]);

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, ' . self::ADMIN_NAME . '!');
        }

        // Login gagal
        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password salah!');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        // Hapus semua session admin
        session()->forget([
            'admin_logged_in',
            'admin_username',
            'admin_name',
            'admin_email',
            'admin_login_time'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda berhasil logout');
    }

    /**
     * Menampilkan dashboard admin
     * SEMUA DATA DARI DATABASE - NO DUMMY DATA
     */
    public function dashboard()
    {
        // Tanggal untuk perbandingan (bulan ini vs bulan lalu)
        $now = now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $endOfThisMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // ==========================================
        // 1. TOTAL PESANAN - Real dari database
        // ==========================================
        $totalPesanan = Order::where('confirmed_by_user', true)->count();

        // ==========================================
        // 2. TOTAL PENDAPATAN - Hanya order Completed
        // ==========================================
        $totalPendapatan = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->sum('total_amount');

        // ==========================================
        // 3. TOTAL PETANI - Semua registered users
        // ==========================================
        $totalPetani = User::count();

        // ==========================================
        // 4. TOTAL PRODUK - Dari tabel products
        // ==========================================
        $totalProduk = Product::count();

        // ==========================================
        // STATISTIK BULAN LALU (untuk pertumbuhan)
        // ==========================================
        $pesananBulanLalu = Order::where('confirmed_by_user', true)
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $pendapatanBulanLalu = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->whereBetween('completed_at', [$startOfLastMonth, $endOfLastMonth])
            ->sum('total_amount');
        $petaniBulanLalu = User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $produkBulanLalu = Product::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        // ==========================================
        // STATISTIK BULAN INI (untuk pertumbuhan)
        // ==========================================
        $pesananBulanIni = Order::where('confirmed_by_user', true)
            ->whereBetween('created_at', [$startOfThisMonth, $endOfThisMonth])
            ->count();
        $pendapatanBulanIni = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->whereBetween('completed_at', [$startOfThisMonth, $endOfThisMonth])
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

        // ==========================================
        // PESANAN TERBARU - Real order dari users
        // ==========================================
        $recentOrders = Order::with(['user', 'product'])
            ->where('confirmed_by_user', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // ==========================================
        // STATISTIK PER STATUS - Count real orders
        // ==========================================
        $pendingCount = Order::where('confirmed_by_user', true)
            ->where('status', 'Pending')
            ->count();
        $processingCount = Order::where('confirmed_by_user', true)
            ->where('status', 'Processing')
            ->count();
        $readyCount = Order::where('confirmed_by_user', true)
            ->where('status', 'Ready')
            ->count();
        $completedCount = Order::where('confirmed_by_user', true)
            ->where('status', 'Completed')
            ->count();
        $rejectedCount = Order::where('confirmed_by_user', true)
            ->where('status', 'Rejected')
            ->count();

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
     * Halaman kirim notifikasi & lihat pesan kontak
     */
    public function notifications()
    {
        $totalUsers = User::count();
        
        // Ambil semua notifikasi (termasuk dari kontak)
        $notifications = Notification::latest()->paginate(10);
        
        // Ambil pesan kontak terbaru
        $contacts = Contact::with('user')->latest()->paginate(10);
        
        // Hitung notifikasi yang belum dibaca
        $unreadCount = Notification::unread()->count();
        $unreadContactsCount = Contact::where('status', 'unread')->count();
        
        return view('admin.notifications', compact(
            'totalUsers', 
            'notifications', 
            'contacts',
            'unreadCount',
            'unreadContactsCount'
        ));
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

        return redirect()->route('admin.notifications.index')
            ->with('success', "Notifikasi berhasil dikirim ke {$users->count()} petani!");
    }

    /**
     * Halaman edit profil admin
     */
    public function editProfil()
    {
        // Get admin data from session (hardcoded system)
        $admin = (object)[
            'username' => session('admin_username', self::ADMIN_USERNAME),
            'name' => session('admin_name', self::ADMIN_NAME),
            'email' => session('admin_email', self::ADMIN_EMAIL),
        ];

        return view('admin.profil-edit', compact('admin'));
    }

    /**
     * Update profil admin
     */
    public function updateProfil(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Jika ingin update password, validasi password lama
        if ($request->filled('password')) {
            if (!$request->filled('current_password')) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini harus diisi untuk mengubah password'
                ])->withInput();
            }

            // Cek password saat ini
            if ($request->current_password !== self::ADMIN_PASSWORD) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai'
                ])->withInput();
            }

            // Note: Untuk sistem hardcoded, password tidak bisa diubah
            // Jika ingin mengubah password, harus edit konstanta ADMIN_PASSWORD di controller
            return back()->with('error', 'Untuk keamanan, password admin hanya bisa diubah melalui konfigurasi sistem. Silakan hubungi developer.');
        }

        // Update session admin (hanya name dan email yang bisa diubah via UI)
        session([
            'admin_name' => $request->name,
            'admin_email' => $request->email,
        ]);

        return redirect()->route('admin.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
