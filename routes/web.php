<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PupukBibitController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::get('/', function () {
    // Jika user sudah login, redirect ke dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('user.HOME');
})->name('home');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.process')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman reset password (view statis sementara)
Route::get('/reset-password', function () {
    return view('auth.resetpw');
})->name('password.reset');

// Proses reset password (POST)
Route::post('/reset-password', [AuthController::class, 'processReset'])->name('password.reset.post');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Route untuk halaman Pupuk & Bibit (gabungan)
Route::get('/pupuk-bibit', function () {
    return view('user.pupukdanbibit');
})->name('pupuk.bibit');

// Route untuk halaman Kontak (dapat diakses tanpa login)
Route::get('/kontak', function () {
    return view('user.kontak');
})->name('kontak');
Route::post('/kontak/send', [AuthController::class, 'sendKontak'])->name('kontak.send');

// Route untuk halaman Profil User
Route::get('/profil', function () {
    return view('user.ProfilUser');
})->name('profil.user')->middleware('auth');

// Route untuk Edit Profil
Route::get('/profil/edit', [AuthController::class, 'editProfil'])->name('profil.edit')->middleware('auth');
Route::put('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update')->middleware('auth');

// Routes yang memerlukan autentikasi
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    // Halaman Pupuk & Bibit
    Route::get('/pupuk-bibit', [PupukBibitController::class, 'index'])->name('pupukbibit');
    
    // Halaman Detail & Pesan Produk
    Route::get('/pupuk-bibit/{id}/detail', [PupukBibitController::class, 'detail'])->name('pupukbibit.detail');
    
    // Halaman Konfirmasi Pesanan
    Route::post('/pupuk-bibit/{id}/konfirmasi', [PupukBibitController::class, 'confirmOrder'])->name('pupukbibit.konfirmasi');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Route untuk halaman Pupuk & Bibit (gabungan) - backward compatibility
    Route::get('/pupuk-bibit', [PupukBibitController::class, 'index'])->name('pupuk.bibit');
    
    // Route untuk halaman Profil User
    Route::get('/profil', function () {
        return view('user.ProfilUser');
    })->name('profil.user');
    
    // Route untuk Edit Profil
    Route::get('/profil/edit', [AuthController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');
    
    // Route untuk halaman Notifikasi
    Route::get('/notifikasi', function () {
        return view('user.Notifikasi');
    })->name('notifikasi');
    Route::get('/notifikasi/detail', function () {
        return view('user.DetailNotif');
    })->name('notifikasi.detail');
});

Route::get('/forgot-password-test', function () {
    return view('auth.forgot-password');
});

// Route untuk halaman Lihat Detail & Pesan (statik ke view sementara)
Route::get('/lihat-detail-pesanan', function () {
    return view('user.lihat-detail-pesan');
})->name('lihat-detail-pesanan');

// Routes untuk Admin
Route::prefix('admin')->group(function () {
    // Halaman login (tidak perlu auth)
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.process');
    
    // Halaman yang memerlukan auth
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/overview', [AdminController::class, 'overview'])->name('admin.overview');
        Route::get('/profil', [AdminController::class, 'profil'])->name('admin.profil');
        Route::get('/profil/edit', [AdminController::class, 'editProfil'])->name('admin.profil.edit');
        Route::put('/profil/update', [AdminController::class, 'updateProfil'])->name('admin.profil.update');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Notifikasi
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
        Route::post('/notifications/send', [AdminController::class, 'sendNotification'])->name('admin.notifications.send');
        
        // Manajemen Pesanan
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        
        // API Routes untuk Orders
        Route::prefix('api')->group(function () {
            Route::get('/orders', [AdminOrderController::class, 'getOrders'])->name('admin.api.orders');
            Route::get('/orders/stats', [AdminOrderController::class, 'getStats'])->name('admin.api.orders.stats');
            Route::patch('/orders/{orderId}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.api.orders.status');
        });
    });
});

// Routes untuk Manajemen Produk (Admin only - dilindungi middleware)
Route::middleware('admin.auth')->group(function () {
    Route::resource('products', ProductController::class);
});
