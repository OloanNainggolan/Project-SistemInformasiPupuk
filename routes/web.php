<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\PupukBibitController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::get('/', function () {
    // Jika user sudah login, redirect ke dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('user.HOME');
})->name('home');

// User Registration Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.process')->middleware('guest');

// User Login Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.process')->middleware('guest');

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('web');

// Password Reset Routes
Route::get('/reset-password', function () {
    return view('auth.resetpw');
})->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'processReset'])->name('password.reset.post');

// Public Routes
Route::get('/pupuk-bibit', [PupukBibitController::class, 'index'])->name('pupuk.bibit');
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
    
    // Simpan Pesanan ke Database
    Route::post('/pupuk-bibit/{id}/simpan-pesanan', [PupukBibitController::class, 'storeOrder'])->name('pupukbibit.store');
    
    // Halaman Pesan Berhasil
    Route::get('/pesan-berhasil', function () {
        return view('user.pesan-berhasil');
    })->name('pesan-berhasil');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profil', function () {
        return view('user.ProfilUser');
    })->name('profil.user');
    Route::get('/profil/edit', [AuthController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');
    
    // Notification Routes
    Route::get('/notifikasi', function () {
        return view('user.Notifikasi');
    })->name('notifikasi');
    Route::get('/notifikasi/detail/{type?}', function ($type = 'verifikasi') {
        return view('user.DetailNotif', ['type' => $type]);
    })->name('notifikasi.detail');
    
    // Product Order Routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/pupuk-bibit', [PupukBibitController::class, 'index'])->name('pupukbibit');
        Route::get('/pupuk-bibit/{id}/detail', [PupukBibitController::class, 'detail'])->name('pupukbibit.detail');
        Route::post('/pupuk-bibit/{id}/konfirmasi', [PupukBibitController::class, 'confirmOrder'])->name('pupukbibit.konfirmasi');
        Route::get('/pesan-berhasil', function () {
            return view('user.pesan-berhasil');
        })->name('pesan-berhasil');
    });
    
    // Static route for order detail
    Route::get('/lihat-detail-pesanan', function () {
        return view('user.lihat-detail-pesan');
    })->name('lihat-detail-pesanan');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    // Guest routes (tidak bisa diakses jika sudah login)
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    });

    // Protected routes (harus login)
    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Profile Routes
        Route::get('/profil', [AdminController::class, 'profil'])->name('admin.profil');
        Route::get('/profil/edit', [AdminController::class, 'editProfil'])->name('admin.profil.edit');
        Route::post('/profil/update', [AdminController::class, 'updateProfil'])->name('admin.profil.update');
        
        // Notification Routes
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
        Route::post('/notifications/send', [AdminController::class, 'sendNotification'])->name('admin.notifications.send');
        
        // Order Management Routes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('/orders/{orderNumber}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        
        // API Routes untuk Metrics & Orders (Real Data dari Database)
        Route::prefix('api')->name('api.')->group(function () {
            // Dashboard Metrics
            Route::get('/metrics', [AdminApiController::class, 'getMetrics'])->name('metrics');
            Route::get('/revenue', [AdminApiController::class, 'getRevenue'])->name('revenue');
            
            // Orders Management
            Route::get('/orders', [AdminApiController::class, 'getOrders'])->name('orders');
            Route::get('/orders/{id}', [AdminApiController::class, 'getOrderDetail'])->name('orders.detail');
            Route::patch('/orders/{id}/status', [AdminApiController::class, 'updateOrderStatus'])->name('orders.status');
            
            // Legacy routes (backward compatibility)
            Route::get('/orders/stats', [AdminOrderController::class, 'getStats'])->name('orders.stats');
        });
        
        // Product Management Routes - PERBAIKAN: Tambah name untuk resource
        Route::resource('products', ProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
    });
});
