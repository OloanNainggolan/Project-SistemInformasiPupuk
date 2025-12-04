# Struktur Folder Admin & User - Sistem Informasi Pupuk & Bibit

## 📁 Struktur Folder Resources/Views (Terorganisir)

```
resources/views/
├── layouts/
│   ├── admin.blade.php          # Layout untuk semua halaman admin
│   └── user.blade.php           # Layout untuk semua halaman user
│
├── partials/
│   ├── header.blade.php         # Header untuk user
│   └── footer.blade.php         # Footer untuk user
│
├── auth/                        # Halaman Autentikasi
│   ├── login.blade.php          # Login user
│   ├── register.blade.php       # Register user
│   ├── admin-login.blade.php    # Login khusus admin
│   ├── forgot-password.blade.php
│   └── resetpw.blade.php
│
├── admin/                       # 🔐 AREA ADMIN (Dilindungi Middleware)
│   ├── dashboard.blade.php      # Dashboard statistik admin
│   ├── profil.blade.php         # Profil admin
│   ├── profil-edit.blade.php    # Edit profil admin
│   ├── notifications.blade.php  # Kirim notifikasi ke petani
│   │
│   ├── partials/                # Komponen khusus admin
│   │   └── nav.blade.php        # Navigasi admin
│   │
│   ├── products/                # ✅ Manajemen Produk Admin
│   │   ├── index.blade.php      # Daftar semua produk (Grid View)
│   │   ├── create.blade.php     # Form tambah produk
│   │   └── edit.blade.php       # Form edit produk
│   │
│   └── orders/                  # Manajemen Pesanan
│       ├── index.blade.php      # Daftar pesanan
│       └── detail.blade.php     # Detail pesanan
│
└── user/                        # 👤 AREA USER (Publik & Auth)
    ├── HOME.blade.php           # Homepage
    ├── dashboard.blade.php      # Dashboard user setelah login
    ├── pupukdanbibit.blade.php  # Katalog produk untuk user
    ├── lihat-detail-pesan.blade.php  # Detail produk & form pesan
    ├── konfirmasi-pesanan.blade.php  # Konfirmasi pesanan
    ├── pesan-berhasil.blade.php      # Sukses pesan
    ├── kontak.blade.php              # Halaman kontak
    ├── ProfilUser.blade.php          # Profil user
    ├── EditProfil.blade.php          # Edit profil user
    ├── Notifikasi.blade.php          # Notifikasi user
    └── DetailNotif.blade.php         # Detail notifikasi
```

---

## 🗂️ Penjelasan Struktur

### 1. **Admin Area** (`resources/views/admin/`)
**Fungsi:** Semua halaman yang hanya bisa diakses oleh admin

**Middleware:** `admin.auth` - Session-based authentication

**Fitur:**
- ✅ Dashboard dengan statistik real-time
- ✅ Manajemen produk (CRUD lengkap)
- ✅ Manajemen pesanan petani
- ✅ Kirim notifikasi broadcast
- ✅ Profil admin dengan update data

**Route Prefix:** `/admin/`

**Contoh URL:**
```
http://localhost:8000/admin/dashboard
http://localhost:8000/admin/products       → Daftar produk
http://localhost:8000/admin/products/create → Tambah produk
http://localhost:8000/admin/products/1/edit → Edit produk
http://localhost:8000/admin/orders          → Kelola pesanan
http://localhost:8000/admin/profil          → Profil admin
```

---

### 2. **User Area** (`resources/views/user/`)
**Fungsi:** Halaman yang diakses oleh petani (user biasa)

**Middleware:** `auth` (Laravel default) untuk halaman tertentu

**Fitur:**
- ✅ Browse katalog produk pupuk & bibit
- ✅ Lihat detail produk
- ✅ Pesan produk dengan subsidi
- ✅ Lihat notifikasi dari admin
- ✅ Kelola profil sendiri

**Route Prefix:** `/user/` atau `/`

**Contoh URL:**
```
http://localhost:8000/                     → Homepage
http://localhost:8000/user/pupuk-bibit     → Katalog produk
http://localhost:8000/user/pupuk-bibit/1/detail → Detail produk
http://localhost:8000/profil               → Profil user
http://localhost:8000/notifikasi           → Notifikasi
```

---

### 3. **Auth Area** (`resources/views/auth/`)
**Fungsi:** Halaman autentikasi untuk login/register

**2 Sistem Login Terpisah:**
1. **User Login:** `login.blade.php` → Database `users` table
2. **Admin Login:** `admin-login.blade.php` → Database `admins` table

**Perbedaan:**
| Aspek | User | Admin |
|-------|------|-------|
| **Login URL** | `/login` | `/admin/login` |
| **Middleware** | `auth` | `admin.auth` |
| **Session Key** | Laravel default | Custom session keys |
| **Database Table** | `users` | `admins` |
| **Can Register?** | ✅ Yes | ❌ No (seeder only) |

---

## 🔗 Routing Structure

### Admin Routes (`routes/web.php`)
```php
Route::middleware(['admin.auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/profil', [AdminController::class, 'profil']);
    Route::get('/profil/edit', [AdminController::class, 'editProfil']);
    Route::put('/profil/update', [AdminController::class, 'updateProfil']);
    Route::get('/notifications', [AdminController::class, 'notifications']);
    Route::get('/orders', [AdminOrderController::class, 'index']);
    
    // Product Management
    Route::resource('products', ProductController::class);
});
```

### User Routes
```php
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/pupuk-bibit', [PupukBibitController::class, 'index']);
    Route::get('/pupuk-bibit/{id}/detail', [PupukBibitController::class, 'detail']);
    Route::post('/pupuk-bibit/{id}/konfirmasi', [PupukBibitController::class, 'confirmOrder']);
});
```

---

## 🎨 Layouts

### Admin Layout (`layouts/admin.blade.php`)
**Komponen:**
- ✅ Header dengan logo & navigasi
- ✅ Menu: Overview | Pesanan | Produk | Profil | Notifikasi
- ✅ Active state pada menu
- ✅ Notifikasi badge
- ✅ User avatar & name
- ✅ Footer dengan informasi

**Style:**
- Green gradient theme (#065f46, #059669, #10b981)
- Modern card-based design
- Responsive navigation

### User Layout (`layouts/user.blade.php`)
**Komponen:**
- ✅ Header dengan logo
- ✅ Menu: Home | Pupuk & Bibit | Kontak | Profil
- ✅ Login/Logout button
- ✅ Footer dengan kontak

---

## 📊 Controller Organization

```
app/Http/Controllers/
├── AdminController.php           # Admin panel (dashboard, profil, notifications)
├── ProductController.php         # CRUD produk (untuk admin)
├── PupukBibitController.php      # Browse produk (untuk user)
├── AuthController.php            # User authentication
├── OrderController.php           # User orders
└── Admin/
    └── AdminOrderController.php  # Admin order management
```

---

## 🚀 Navigasi Produk - Connection Flow

### Dari Admin Dashboard → Produk

**Cara 1: Quick Actions (Dashboard)**
```
Dashboard → "Kelola Produk" button → /admin/products (index)
Dashboard → "Tambah Produk" button → /admin/products/create
```

**Cara 2: Navigation Menu**
```
Navigation Bar → "Produk" menu → /admin/products
```

**Cara 3: Direct URL**
```
http://localhost:8000/admin/products
```

### Fitur Product Management (Admin)

**1. Index Page (`admin/products/index.blade.php`)**
- ✅ Grid view dengan card design
- ✅ Filter by type (Pupuk/Bibit)
- ✅ Filter by category
- ✅ Sort (Newest, Name, Price, Stock)
- ✅ Tombol Edit & Delete per produk
- ✅ Tombol "Tambah Produk Baru"

**2. Create Page (`admin/products/create.blade.php`)**
- ✅ Form lengkap dengan validation
- ✅ Multi-image upload (1-5 gambar)
- ✅ Auto-fill kategori untuk bibit
- ✅ Price validation (subsidi < normal)
- ✅ Preview gambar sebelum upload

**3. Edit Page (`admin/products/edit.blade.php`)**
- ✅ Pre-filled form data
- ✅ Update semua field
- ✅ Delete & upload gambar baru
- ✅ Validation sama dengan create

---

## 🔐 Middleware & Security

### Admin Auth Middleware
**File:** `app/Http/Middleware/AdminAuth.php`

**Logic:**
```php
if (!session('admin_logged_in')) {
    return redirect()->route('admin.login');
}
```

**Protected Routes:**
- `/admin/dashboard`
- `/admin/products/*`
- `/admin/orders`
- `/admin/profil`
- `/admin/notifications`

### User Auth Middleware
**Laravel Built-in:** `auth`

**Protected Routes:**
- `/dashboard`
- `/user/pupuk-bibit`
- `/profil`
- `/notifikasi`

---

## 📝 Migration & Database

### Products Table
```sql
produk (table)
├── id_produk (PK, integer)
├── nama_produk
├── tipe_produk (pupuk/bibit)
├── kategori
├── harga_subsidi
├── harga_normal
├── stok_produk
├── gambar (deprecated, use product_images)
├── manfaat
├── bahan
├── cara_penggunaan
└── timestamps
```

### Product Images Table (Relational)
```sql
product_images (table)
├── id (PK)
├── product_id (FK → produk.id_produk)
├── image_path
├── is_primary (boolean)
├── order (integer)
└── timestamps
```

**Relationship:**
```php
Product::images()       // hasMany ProductImage
Product::primaryImage() // hasOne ProductImage where is_primary = true
```

---

## ✅ Testing Checklist

### Admin Area
- [ ] Login dengan `admin` / `admin123`
- [ ] Dashboard menampilkan statistik
- [ ] Klik menu "Produk" → masuk ke product index
- [ ] Klik "Tambah Produk" → form create
- [ ] Submit form → produk tersimpan
- [ ] Klik "Edit" di card produk → form edit
- [ ] Klik "Hapus" → produk terhapus (dengan konfirmasi)
- [ ] Filter & sort berfungsi

### User Area
- [ ] Browse katalog di `/user/pupuk-bibit`
- [ ] Klik detail produk
- [ ] Isi form pemesanan
- [ ] Submit → konfirmasi pesanan
- [ ] Lihat notifikasi dari admin

---

## 🎯 Best Practices

### 1. **Naming Convention**
```
Admin Views:   admin/{feature}/{action}.blade.php
User Views:    user/{page}.blade.php
Layouts:       layouts/{role}.blade.php
Partials:      partials/{component}.blade.php
```

### 2. **Route Naming**
```php
Admin:  admin.{resource}.{action}  → route('admin.products.index')
User:   user.{resource}.{action}   → route('user.pupukbibit')
```

### 3. **Controller Method**
```
index()   → List all
create()  → Show form
store()   → Save data
edit()    → Show edit form
update()  → Update data
destroy() → Delete data
```

---

## 🛠️ Maintenance Guide

### Menambah Fitur Baru untuk Admin

1. **Buat View:** `resources/views/admin/{feature}/index.blade.php`
2. **Buat Controller:** `app/Http/Controllers/Admin/{Feature}Controller.php`
3. **Daftarkan Route:** `routes/web.php` dengan middleware `admin.auth`
4. **Tambah Menu:** Update `resources/views/admin/partials/nav.blade.php`

### Menambah Fitur Baru untuk User

1. **Buat View:** `resources/views/user/{page}.blade.php`
2. **Buat Controller Method:** Existing controller atau buat baru
3. **Daftarkan Route:** `routes/web.php`
4. **Update Navigation:** `resources/views/partials/header.blade.php`

---

## 📖 Summary

✅ **Admin Area:**  
- Folder: `resources/views/admin/`
- Prefix: `/admin/`
- Middleware: `admin.auth`
- Fitur: Dashboard, Products, Orders, Notifications, Profile

✅ **User Area:**  
- Folder: `resources/views/user/`
- Prefix: `/user/` atau `/`
- Middleware: `auth` (optional untuk beberapa halaman)
- Fitur: Browse Products, Order, Profile, Notifications

✅ **Product Management:**  
- Admin bisa CRUD produk di `/admin/products`
- User bisa browse & order di `/user/pupuk-bibit`
- Terpisah controller & view yang jelas

✅ **Navigasi:**  
- Menu admin terintegrasi dengan icon
- Quick actions di dashboard
- Filter & sort di product index

**Semua struktur sudah terorganisir dengan baik dan mudah dipahami!** 🎉
