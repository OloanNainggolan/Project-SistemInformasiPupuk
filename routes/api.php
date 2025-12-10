<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Catalog\ProductController;
use App\Http\Controllers\Api\Sales\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes - Separated by Folders
|--------------------------------------------------------------------------
|
| API v1 Routes organized by business domains:
| - Auth: Authentication endpoints
| - Catalog: Product management (read-only for public)
| - Sales: Order management (requires authentication)
|
*/

Route::prefix('v1')->group(function () {
    
    // ========================================
    // AUTH ROUTES (Public)
    // ========================================
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // ========================================
    // CATALOG ROUTES (Public - Products)
    // ========================================
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::get('/{id}/stock', [ProductController::class, 'checkStock']); // Internal untuk Sales
    });

    // ========================================
    // SALES ROUTES (Protected - Orders)
    // ========================================
    Route::prefix('orders')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('api.orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('api.orders.store');
        Route::get('/{id}', [OrderController::class, 'show'])->name('api.orders.show');
        Route::patch('/{id}/status', [OrderController::class, 'updateStatus'])->name('api.orders.updateStatus');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('api.orders.destroy');
    });

    // ========================================
    // HEALTH CHECK
    // ========================================
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is running',
            'version' => '1.0.0',
            'timestamp' => now()
        ]);
    });
});
