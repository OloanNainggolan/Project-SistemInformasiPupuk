# 📋 Rencana Refactoring: Menghapus API Internal

## 🎯 Tujuan
Menghapus semua API internal dan menggantinya dengan metode server-side rendering (SSR) tradisional untuk menyederhanakan arsitektur aplikasi.

## 📊 Analisis Kondisi Saat Ini

### File yang Akan Dihapus
1. ✅ `app/Http/Controllers/AdminApiController.php` - Controller API internal admin
2. ✅ `app/Http/Controllers/Admin/OrderManagementController.php` - File kosong tidak terpakai
3. ✅ `routes/api.php` - API routes untuk external API (tidak digunakan)

### Method di AdminOrderController yang Akan Dihapus/Digabung
- `getOrders()` - API endpoint, akan diganti dengan pagination di `index()`
- `getStats()` - API endpoint, sudah ada di `index()`
- Duplikasi method:
  - `updateOrderStatus()` vs `updateStatus()` vs `updatePesanStatus()`
  - `showOrder()` vs `show()` vs `showPesan()`
  - `deleteOrder()` vs `deletePesan()`
  - `sendOrderStatusNotification()` vs `sendNotificationToUser()`

### Routes yang Akan Dihapus/Diubah
**web.php:**
- Line 132: `/admin/api/activities` - Ganti dengan server-side
- Line 160-169: Semua route `/admin/api/*` - Hapus
- Line 173-175: `/admin/daftarpesanan/*` - Gabung dengan `/admin/orders`
- Line 178-181: `/admin/pesanmasuk/*` - Gabung dengan `/admin/orders`

### Views yang Perlu Diupdate
1. `admin/dashboard.blade.php` - Hapus fetch API, gunakan data dari controller
2. `admin/orders/detail.blade.php` - Update status via form POST
3. `admin/pesanmasuk.blade.php` - Gabung ke orders/index.blade.php
4. `admin/daftarpesanan.blade.php` - Gabung ke orders/index.blade.php
5. `admin/partials/activity-log.blade.php` - Load data langsung dari controller

## 🔄 Strategi Refactoring

### Fase 1: Konsolidasi AdminOrderController
**Tujuan:** Satu controller, satu tanggung jawab yang jelas

**Actions:**
1. Hapus method duplikat:
   - Gabung `updateOrderStatus()`, `updatePesanStatus()` → `updateStatus()`
   - Gabung `showOrder()`, `showPesan()` → `show()`
   - Gabung `deleteOrder()`, `deletePesan()` → `destroy()`
   - Gabung `sendOrderStatusNotification()`, `sendNotificationToUser()` → satu method

2. Hapus API methods:
   - Hapus `getOrders()` - gunakan pagination di `index()`
   - Hapus `getStats()` - sudah ada di `index()`

3. Simplifikasi routing:
   - Hapus `daftarpesanan()` dan `pesanMasuk()` - gunakan `index()` dengan filter
   - Satu set route untuk orders management

### Fase 2: Update Routes
**File: routes/web.php**

**Hapus:**
```php
// API Routes (line 160-169)
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/metrics', [AdminApiController::class, 'getMetrics']);
    Route::get('/revenue', [AdminApiController::class, 'getRevenue']);
    Route::get('/orders', [AdminOrderController::class, 'getOrders']);
    Route::get('/orders/stats', [AdminOrderController::class, 'getStats']);
});

// Duplicate routes (line 172-181)
Route::get('/daftarpesanan', ...);
Route::get('/pesanmasuk', ...);
```

**Ganti dengan:**
```php
// Order Management Routes (RESTful)
Route::resource('orders', AdminOrderController::class)->except(['create', 'edit']);
Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
```

### Fase 3: Update AdminController
**File: app/Http/Controllers/AdminController.php**

**Update method `dashboard()`:**
- Pindahkan logic dari `AdminApiController::getMetrics()` ke sini
- Return data langsung ke view, bukan JSON

### Fase 4: Update Views
**Strategi:** Ganti AJAX fetch dengan form submission atau load data langsung

1. **admin/dashboard.blade.php**
   - Hapus JavaScript fetch untuk metrics
   - Data sudah ada dari controller

2. **admin/orders/index.blade.php** (gabungan dari pesanmasuk & daftarpesanan)
   - Gunakan Laravel pagination
   - Form untuk filter & search
   - Update status via form POST dengan redirect

3. **admin/orders/detail.blade.php**
   - Update status via form POST
   - Redirect kembali dengan flash message

4. **admin/partials/activity-log.blade.php**
   - Load activities langsung dari controller
   - Gunakan Livewire atau auto-refresh dengan meta refresh

### Fase 5: Cleanup
1. Hapus file tidak terpakai
2. Update dokumentasi
3. Test semua fitur

## 📝 Checklist Implementasi

### ✅ Fase 1: Cleanup Controller
- [ ] Refactor AdminOrderController
  - [ ] Hapus method duplikat
  - [ ] Hapus API methods
  - [ ] Konsolidasi notification methods
  - [ ] Simplifikasi logic

### ✅ Fase 2: Update Routes
- [ ] Hapus API routes di web.php
- [ ] Hapus duplicate routes (daftarpesanan, pesanmasuk)
- [ ] Implement RESTful routes untuk orders
- [ ] Update route names di semua views

### ✅ Fase 3: Update Controllers
- [ ] Update AdminController::dashboard()
- [ ] Pindahkan metrics logic dari AdminApiController
- [ ] Hapus AdminApiController.php
- [ ] Hapus OrderManagementController.php

### ✅ Fase 4: Update Views
- [ ] Gabung pesanmasuk.blade.php & daftarpesanan.blade.php → orders/index.blade.php
- [ ] Update dashboard.blade.php
- [ ] Update orders/detail.blade.php
- [ ] Update activity-log partial
- [ ] Hapus view yang tidak terpakai

### ✅ Fase 5: Testing & Documentation
- [ ] Test semua fitur orders
- [ ] Test dashboard metrics
- [ ] Test notifications
- [ ] Update README
- [ ] Hapus file test API

## 🎨 Struktur Akhir

### Controllers
```
app/Http/Controllers/
├── AdminController.php (dashboard, profile, activities)
├── Admin/
│   ├── AdminOrderController.php (orders CRUD + status update)
│   └── AdminNotificationController.php (notifications)
```

### Routes (Admin)
```php
Route::middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/activities', [AdminController::class, 'activities']);
    
    // Orders (RESTful)
    Route::resource('orders', AdminOrderController::class);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus']);
    
    // Notifications
    Route::resource('notifications', AdminNotificationController::class);
});
```

### Views
```
resources/views/admin/
├── dashboard.blade.php
├── orders/
│   ├── index.blade.php (gabungan pesanmasuk & daftarpesanan)
│   └── detail.blade.php
├── notifications/
│   ├── index.blade.php
│   ├── inbox.blade.php
│   └── show.blade.php
└── partials/
    └── activity-log.blade.php
```

## 🚀 Keuntungan Refactoring

1. **Lebih Sederhana** - Tidak ada API internal yang membingungkan
2. **Lebih Cepat** - Tidak ada overhead JSON serialization
3. **Lebih Mudah Debug** - Server-side rendering lebih straightforward
4. **Lebih Konsisten** - Satu cara untuk handle data
5. **Lebih Maintainable** - Kode lebih sedikit, lebih jelas

## ⚠️ Catatan Penting

- Backup database sebelum testing
- Test setiap fase sebelum lanjut ke fase berikutnya
- Pastikan semua fitur masih berfungsi setelah refactoring
- Update dokumentasi setelah selesai
