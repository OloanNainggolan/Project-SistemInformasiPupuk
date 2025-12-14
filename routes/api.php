<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Catalog\ProductController;
use App\Http\Controllers\Api\Sales\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\MapsController;

/*
 API Routes - Separated by Folders

 API v1 Routes organized by business domains:
 - Auth: Authentication endpoints
 - Catalog: Product management (read-only for public)
 - Sales: Order management (requires authentication)
*/


Route::prefix('v1')->group(function () {
    
    // AUTH ROUTES (Public)
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    // PASSWORD RESET ROUTES (Public)
    Route::prefix('password')->group(function () {
        Route::post('/send-code', [PasswordResetController::class, 'sendCode']);
        Route::post('/verify-code', [PasswordResetController::class, 'verifyCode']);
        Route::post('/reset', [PasswordResetController::class, 'resetPassword']);
    });

    // CATALOG ROUTES (Public - Products)
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::get('/{id}/stock', [ProductController::class, 'checkStock']); // Internal untuk Sales
    });

    // SALES ROUTES (Protected - Orders)
    Route::prefix('orders')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('api.orders.index');
        Route::post('/', [OrderController::class, 'store'])->name('api.orders.store');
        Route::get('/{id}', [OrderController::class, 'show'])->name('api.orders.show');
        Route::patch('/{id}/status', [OrderController::class, 'updateStatus'])->name('api.orders.updateStatus');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('api.orders.destroy');
    });

    // MAPS ROUTES (Public)
    Route::post('/geocode', [MapsController::class, 'geocode']);
    Route::get('/pickup-points', [MapsController::class, 'pickupPoints']);
    Route::post('/nearest-pickup', [MapsController::class, 'nearestPickup']);

    // WHATSAPP TEST ROUTES (For testing only)
    Route::post('/whatsapp/test', function (Illuminate\Http\Request $request) {
        $whatsappService = app(\App\Services\WhatsAppService::class);
        
        $phoneNumber = $request->input('phone');
        if (!$phoneNumber) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number is required'
            ], 400);
        }
        
        $result = $whatsappService->testConnection($phoneNumber);
        
        return response()->json($result);
    });

    // HEALTH CHECK
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'API is running',
            'version' => '1.0.0',
            'timestamp' => now()
        ]);
    });
});
