<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\PupukBibitController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\UserNotificationController;

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
    Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil.user');
    Route::get('/profil/edit', [AuthController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');
    
    // Notification Routes
    Route::get('/notifikasi', [UserNotificationController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/mark-all-read', [UserNotificationController::class, 'markAllAsRead'])->name('user.notifications.markAllRead');
    Route::post('/notifikasi/{id}/mark-read', [UserNotificationController::class, 'markAsRead'])->name('user.notifications.markRead');
    Route::delete('/notifikasi/{id}', [UserNotificationController::class, 'destroy'])->name('user.notifications.destroy');
    Route::post('/notifikasi/bulk-delete', [UserNotificationController::class, 'bulkDelete'])->name('user.notifications.bulkDelete');
    Route::get('/notifikasi/detail/{type?}', function ($type = 'verifikasi') {
        return view('user.DetailNotif', ['type' => $type]);
    })->name('notifikasi.detail');
    Route::get('/notifikasi/{id}', [UserNotificationController::class, 'show'])->name('notifikasi.show')->where('id', '[0-9]+');
    Route::post('/notifikasi/{id}/reply', [UserNotificationController::class, 'reply'])->name('notifikasi.reply')->where('id', '[0-9]+');
    
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
        
        // Message/Notification Routes (2-way communication)
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::get('/notifications/{id}', [AdminNotificationController::class, 'show'])->name('admin.notifications.show');
        Route::get('/notifications/contact/{id}', [AdminNotificationController::class, 'showContact'])->name('admin.notifications.contact');
        Route::post('/notifications/{id}/reply', [AdminNotificationController::class, 'reply'])->name('admin.notifications.reply');
        Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');
        Route::post('/notifications/{id}/mark-read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.markRead');
        Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllRead');
        Route::delete('/notifications/contact/{id}', [AdminNotificationController::class, 'deleteContact'])->name('admin.notifications.deleteContact');
        Route::post('/notifications/bulk-delete', [AdminNotificationController::class, 'bulkDelete'])->name('admin.notifications.bulkDelete');
        
        // Order Management Routes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::patch('/orders/{orderNumber}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::get('/orders/{orderNumber}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        
        // API Routes untuk Metrics & Orders (Real Data dari Database)
        Route::prefix('api')->name('api.')->group(function () {
            // Dashboard Metrics
            Route::get('/metrics', [AdminApiController::class, 'getMetrics'])->name('metrics');
            Route::get('/revenue', [AdminApiController::class, 'getRevenue'])->name('revenue');
            
            // Orders Management API (AdminOrderController)
            Route::get('/orders', [AdminOrderController::class, 'getOrders'])->name('orders');
            Route::get('/orders/stats', [AdminOrderController::class, 'getStats'])->name('orders.stats');
            Route::patch('/orders/{orderId}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
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
