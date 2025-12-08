# 📁 Struktur Folder - Admin & User Terpisah

## ✅ Reorganisasi Selesai!

Sistem sekarang sudah diorganisir dengan jelas: **Admin** dan **User** memiliki folder terpisah untuk memudahkan maintenance dan pengembangan.

---

## 📂 Struktur Folder Resources/Views

```
resources/views/
│
├── 🔐 admin/                          # KHUSUS ADMIN
│   ├── dashboard.blade.php           # Dashboard dengan statistik
│   ├── profil.blade.php              # Profil admin
│   ├── profil-edit.blade.php         # Edit profil admin
│   ├── notifications.blade.php       # Kirim notifikasi
│   │
│   ├── partials/                     # Komponen admin
│   │   └── nav.blade.php             # Navigation menu admin
│   │
│   ├── products/                     # ✅ Management Produk
│   │   ├── index.blade.php           # Grid view semua produk
│   │   ├── create.blade.php          # Form tambah produk baru
│   │   └── edit.blade.php            # Form edit produk
│   │
│   └── orders/                       # Management Pesanan
│       ├── index.blade.php           # Daftar pesanan
│       └── detail.blade.php          # Detail pesanan
│
├── 👤 user/                           # KHUSUS USER/PETANI
│   ├── HOME.blade.php                # Landing page
│   ├── dashboard.blade.php           # Dashboard user
│   ├── pupukdanbibit.blade.php       # Katalog produk untuk user
│   ├── lihat-detail-pesan.blade.php  # Detail produk & form pesan
│   ├── konfirmasi-pesanan.blade.php  # Konfirmasi pesanan
│   ├── pesan-berhasil.blade.php      # Sukses pesan
│   ├── kontak.blade.php              # Kontak
│   ├── ProfilUser.blade.php          # Profil user
│   ├── EditProfil.blade.php          # Edit profil user
│   ├── Notifikasi.blade.php          # Notifikasi user
│   └── DetailNotif.blade.php         # Detail notifikasi
│
├── 🎨 layouts/                        # Template Layouts
│   ├── admin.blade.php               # Layout untuk admin
│   └── user.blade.php                # Layout untuk user
│
├── 🧩 partials/                       # Shared Components
│   ├── header.blade.php              # Header user
│   └── footer.blade.php              # Footer user
│
├── 🔑 auth/                           # Authentication
│   ├── login.blade.php               # Login user
│   ├── register.blade.php            # Register user
│   ├── admin-login.blade.php         # Login admin (terpisah!)
│   ├── forgot-password.blade.php     # Lupa password
│   └── resetpw.blade.php             # Reset password
│
└── ⚠️ products/                       # OLD (Deprecated, jangan dipakai!)
    ├── index.blade.php               # ❌ Pindah ke admin/products/
    ├── create.blade.php              # ❌ Pindah ke admin/products/
    └── edit.blade.php                # ❌ Pindah ke admin/products/
```

---

## 🔐 Admin Area

### Lokasi: `resources/views/admin/`

**Fungsi:** Semua halaman yang **hanya bisa diakses admin**

**Middleware:** `admin.auth` (session-based)

**Layout:** `layouts/admin.blade.php`

**Fitur Lengkap:**

#### 1. **Dashboard** (`admin/dashboard.blade.php`)
- Statistik real-time (pesanan, petani, pendapatan, produk)
- Quick actions (4 tombol akses cepat)
- Tabel pesanan terbaru
- Responsive design

#### 2. **Products Management** (`admin/products/`)
**File:**
- ✅ `index.blade.php` - Grid view dengan filter & sort
- ✅ `create.blade.php` - Form tambah produk (layout admin)
- ✅ `edit.blade.php` - Form edit produk (layout admin)

**Fitur:**
- Grid modern dengan card design
- Filter by tipe & kategori
- Sort (newest, name, price, stock)
- Multi-image upload (create)
- Single image update (edit)
- Auto-fill kategori untuk bibit
- Price validation
- Edit & delete buttons

**Routes:**
```php
/admin/products           → index
/admin/products/create    → create
/admin/products/{id}/edit → edit
/admin/products/{id}      → update (PUT)
/admin/products/{id}      → destroy (DELETE)
```

#### 3. **Orders Management** (`admin/orders/`)
- Lihat semua pesanan
- Update status pesanan
- Filter & search

#### 4. **Profile** (`admin/profil.blade.php` & `admin/profil-edit.blade.php`)
- Display profil dengan stats
- Full CRUD editing
- Avatar upload
- Password update

#### 5. **Notifications** (`admin/notifications.blade.php`)
- Kirim notifikasi broadcast
- Pilih recipient (all/active)

---

## 👤 User Area

### Lokasi: `resources/views/user/`

**Fungsi:** Halaman yang **diakses oleh petani** (user biasa)

**Middleware:** `auth` (untuk halaman tertentu)

**Layout:** `layouts/user.blade.php`

**Fitur Lengkap:**

#### 1. **Homepage** (`user/HOME.blade.php`)
- Landing page
- Hero section
- Feature highlights

#### 2. **Product Catalog** (`user/pupukdanbibit.blade.php`)
- Browse semua produk (pupuk & bibit)
- Card grid responsive
- Filter & search
- Lihat detail produk

#### 3. **Product Detail** (`user/lihat-detail-pesan.blade.php`)
- Detail lengkap produk
- Gallery gambar
- Form pemesanan
- Info harga subsidi

#### 4. **Order Flow**
- `user/konfirmasi-pesanan.blade.php` - Konfirmasi
- `user/pesan-berhasil.blade.php` - Success page

#### 5. **Profile** (`user/ProfilUser.blade.php` & `user/EditProfil.blade.php`)
- Lihat profil
- Edit data pribadi

#### 6. **Notifications** (`user/Notifikasi.blade.php` & `user/DetailNotif.blade.php`)
- Lihat notifikasi dari admin
- Detail notifikasi

---

## 🎨 Layouts

### Admin Layout (`layouts/admin.blade.php`)

**Komponen:**
```blade
┌─────────────────────────────────────┐
│  Header (Logo + Nav + Profile)      │
├─────────────────────────────────────┤
│  Navigation Menu:                   │
│  Overview | Pesanan | Produk |      │
│  Profil | Notifikasi                │
├─────────────────────────────────────┤
│  @yield('content')                  │
│  (Main Content Area)                │
├─────────────────────────────────────┤
│  Footer                             │
└─────────────────────────────────────┘
```

**Features:**
- Responsive navigation dengan icons
- Active state detection
- Mobile menu toggle
- Gradient green theme
- Font: Inter

### User Layout (`layouts/user.blade.php`)

**Komponen:**
```blade
┌─────────────────────────────────────┐
│  Header (Logo + Menu + Login)       │
├─────────────────────────────────────┤
│  @yield('content')                  │
│  (Main Content Area)                │
├─────────────────────────────────────┤
│  Footer (Kontak & Links)            │
└─────────────────────────────────────┘
```

---

## 🔗 Controllers Organization

```
app/Http/Controllers/
│
├── AdminController.php              # Admin panel
│   ├── dashboard()                  # Dashboard stats
│   ├── profil()                     # View profil
│   ├── editProfil()                 # Edit form
│   ├── updateProfil()               # Update data
│   ├── notifications()              # Notification page
│   └── sendNotification()           # Send broadcast
│
├── ProductController.php            # ADMIN Product CRUD
│   ├── index()         → admin/products/index.blade.php
│   ├── create()        → admin/products/create.blade.php
│   ├── store()         → Save product
│   ├── edit()          → admin/products/edit.blade.php
│   ├── update()        → Update product
│   └── destroy()       → Delete product
│
├── PupukBibitController.php        # USER Product Browse
│   ├── index()         → user/pupukdanbibit.blade.php
│   └── detail()        → user/lihat-detail-pesan.blade.php
│
├── AuthController.php               # User auth
│   ├── showLogin()     → auth/login.blade.php
│   ├── login()         → Process login
│   ├── showRegister()  → auth/register.blade.php
│   ├── register()      → Process register
│   ├── dashboard()     → user/dashboard.blade.php
│   ├── editProfil()    → user/EditProfil.blade.php
│   └── updateProfil()  → Update user profile
│
└── Admin/
    └── AdminOrderController.php     # Admin order management
        ├── index()                  # List orders
        ├── getOrders()              # API: Get orders
        ├── getStats()               # API: Statistics
        └── updateStatus()           # API: Update status
```

---

## 🛣️ Routes Structure

### Admin Routes
```php
Route::prefix('admin')->middleware('admin.auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Products (Resource routes dengan prefix admin)
    Route::resource('products', ProductController::class)
         ->names([
             'index' => 'admin.products.index',
             'create' => 'admin.products.create',
             'store' => 'admin.products.store',
             'edit' => 'admin.products.edit',
             'update' => 'admin.products.update',
             'destroy' => 'admin.products.destroy',
         ]);
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index']);
    
    // Profile
    Route::get('/profil', [AdminController::class, 'profil']);
    Route::get('/profil/edit', [AdminController::class, 'editProfil']);
    Route::put('/profil/update', [AdminController::class, 'updateProfil']);
    
    // Notifications
    Route::get('/notifications', [AdminController::class, 'notifications']);
    Route::post('/notifications/send', [AdminController::class, 'sendNotification']);
});
```

### User Routes
```php
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    // Products
    Route::get('/pupuk-bibit', [PupukBibitController::class, 'index']);
    Route::get('/pupuk-bibit/{id}/detail', [PupukBibitController::class, 'detail']);
    
    // Orders
    Route::post('/pupuk-bibit/{id}/konfirmasi', [PupukBibitController::class, 'confirmOrder']);
});

// Profile (global auth)
Route::middleware('auth')->group(function () {
    Route::get('/profil', fn() => view('user.ProfilUser'));
    Route::get('/profil/edit', [AuthController::class, 'editProfil']);
    Route::put('/profil/update', [AuthController::class, 'updateProfil']);
    
    Route::get('/notifikasi', fn() => view('user.Notifikasi'));
});
```

---

## 🎯 URL Mapping

### Admin URLs
```
http://localhost:8000/admin/login
http://localhost:8000/admin/dashboard
http://localhost:8000/admin/products              ← Grid view
http://localhost:8000/admin/products/create       ← Form tambah
http://localhost:8000/admin/products/1/edit       ← Form edit
http://localhost:8000/admin/orders
http://localhost:8000/admin/profil
http://localhost:8000/admin/profil/edit
http://localhost:8000/admin/notifications
```

### User URLs
```
http://localhost:8000/                            ← Homepage
http://localhost:8000/login
http://localhost:8000/register
http://localhost:8000/dashboard                   ← User dashboard
http://localhost:8000/user/pupuk-bibit            ← Katalog
http://localhost:8000/user/pupuk-bibit/1/detail   ← Detail produk
http://localhost:8000/profil
http://localhost:8000/profil/edit
http://localhost:8000/notifikasi
http://localhost:8000/kontak
```

---

## 📝 View Usage Guide

### Untuk Admin:

**1. Login:**
```
URL: /admin/login
View: auth/admin-login.blade.php
Credentials: admin / admin123
```

**2. Manage Products:**
```
Lihat semua:   /admin/products          (admin/products/index.blade.php)
Tambah baru:   /admin/products/create   (admin/products/create.blade.php)
Edit produk:   /admin/products/1/edit   (admin/products/edit.blade.php)
```

**3. Manage Orders:**
```
URL: /admin/orders
View: admin/orders/index.blade.php
```

**4. Send Notifications:**
```
URL: /admin/notifications
View: admin/notifications.blade.php
```

### Untuk User:

**1. Login:**
```
URL: /login
View: auth/login.blade.php
```

**2. Browse Products:**
```
URL: /user/pupuk-bibit
View: user/pupukdanbibit.blade.php
```

**3. Order Product:**
```
Detail: /user/pupuk-bibit/1/detail  (user/lihat-detail-pesan.blade.php)
Konfirmasi: POST → user/konfirmasi-pesanan.blade.php
Success: user/pesan-berhasil.blade.php
```

---

## ✅ Keuntungan Struktur Baru

### 1. **Pemisahan Jelas**
- ✅ Admin punya folder `admin/`
- ✅ User punya folder `user/`
- ✅ Auth terpisah di folder `auth/`
- ✅ Layouts terpisah per role

### 2. **Mudah Maintenance**
- ✅ Tahu persis dimana file berada
- ✅ Tidak bingung file untuk siapa
- ✅ Scalable untuk fitur baru

### 3. **Best Practice**
- ✅ Follow Laravel convention
- ✅ RESTful resource routes
- ✅ Middleware protection
- ✅ Consistent naming

### 4. **Developer Friendly**
- ✅ Dokumentasi jelas
- ✅ Struktur terorganisir
- ✅ Easy collaboration
- ✅ Onboarding cepat

---

## 🚀 Next Steps

### Menambah Fitur Admin Baru:
1. Buat file di `resources/views/admin/{feature}/`
2. Buat controller di `app/Http/Controllers/`
3. Daftarkan route dengan prefix `admin` + middleware `admin.auth`
4. Update navigation di `admin/partials/nav.blade.php`

### Menambah Fitur User Baru:
1. Buat file di `resources/views/user/`
2. Tambah method di controller existing atau buat baru
3. Daftarkan route (dengan/tanpa middleware `auth`)
4. Update navigation di `partials/header.blade.php`

---

## 📖 File Reference

### Admin Product Views (GUNAKAN INI!)
```
✅ resources/views/admin/products/index.blade.php   (Grid view)
✅ resources/views/admin/products/create.blade.php  (Form create)
✅ resources/views/admin/products/edit.blade.php    (Form edit)
```

### Old Product Views (JANGAN DIPAKAI!)
```
❌ resources/views/products/index.blade.php
❌ resources/views/products/create.blade.php
❌ resources/views/products/edit.blade.php
```

**Catatan:** File di folder `products/` lama bisa dihapus setelah memastikan semua berjalan dengan baik.

---

## 🎨 Design Consistency

### Admin Theme:
- **Colors:** Green gradient (#065f46, #059669, #10b981)
- **Font:** Inter (Google Fonts)
- **Style:** Modern cards, smooth animations
- **Layout:** Navigation di top dengan icons

### User Theme:
- **Colors:** Green/Blue dual theme
- **Font:** System fonts
- **Style:** Card-based, user-friendly
- **Layout:** Traditional header/footer

---

## 🔒 Security

### Admin Protection:
```php
Middleware: admin.auth
Session: admin_logged_in, admin_id, admin_name, etc.
Login: /admin/login (terpisah dari user)
Table: admins
```

### User Protection:
```php
Middleware: auth (Laravel default)
Session: Laravel session default
Login: /login
Table: users
```

---

**Struktur folder sekarang RAPI, TERORGANISIR, dan MUDAH DIMENGERTI!** ✅

Semua code admin ada di folder `admin/`, code user ada di folder `user/`. Tidak ada lagi kebingungan! 🎉
