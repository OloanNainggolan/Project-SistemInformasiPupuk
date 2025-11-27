# Sistem Admin Terintegrasi Database

## Overview
Sistem admin sekarang sudah terintegrasi penuh dengan database MySQL. Semua data admin (profil, kredensial, avatar) disimpan di tabel `admins`.

## Struktur Database

### Tabel: `admins`
```sql
- id (bigint, primary key, auto increment)
- username (varchar, unique) 
- name (varchar)
- email (varchar, unique)
- password (varchar, hashed)
- phone (varchar, nullable)
- address (text, nullable)
- avatar (varchar, nullable)
- remember_token (varchar, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Kredensial Admin Default

Setelah menjalankan seeder, admin default adalah:
- **Username:** `admin`
- **Email:** `admin@pupuksubsidi.id`
- **Password:** `admin123`
- **Nama:** Administrator Sistem
- **Telepon:** +62 812-3456-7890
- **Alamat:** Jl. Sitoluama, Laguboti, Toba Samosir

## Setup & Installation

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Seed Data Admin
```bash
php artisan db:seed --class=AdminSeeder
```

### 3. Login Admin
Akses: `http://127.0.0.1:8000/admin/login`
- Gunakan username: `admin` dan password: `admin123`
- Atau gunakan email: `admin@pupuksubsidi.id` dan password: `admin123`

## Fitur-Fitur

### 1. Login Admin (Database-based)
- ✅ Validasi kredensial dari database
- ✅ Password di-hash menggunakan bcrypt
- ✅ Support login dengan username atau email
- ✅ Session management yang aman

### 2. Profil Admin
- ✅ Menampilkan data profil dari database
- ✅ Avatar dinamis (upload & display)
- ✅ Informasi lengkap: nama, email, telepon, alamat
- ✅ Statistik dashboard terintegrasi

### 3. Edit Profil Admin
- ✅ Form edit dengan validasi lengkap
- ✅ Update nama, email, telepon, alamat
- ✅ Upload avatar (max 2MB, format: jpeg/png/jpg/gif)
- ✅ Ubah password (opsional, min 8 karakter)
- ✅ Preview avatar sebelum upload
- ✅ Real-time update ke database

### 4. Session Management
Data yang disimpan di session setelah login:
- `admin_logged_in` (boolean)
- `admin_id` (integer)
- `admin_username` (string)
- `admin_name` (string)
- `admin_email` (string)
- `admin_phone` (string)
- `admin_address` (string)
- `admin_avatar` (string path)
- `admin_login_time` (timestamp)

## File yang Dimodifikasi

### Controllers
- `app/Http/Controllers/AdminController.php`
  - `login()` - Autentikasi dari database
  - `editProfil()` - Load data dari database
  - `updateProfil()` - Update & sync dengan database
  - `logout()` - Clear session lengkap

### Models
- `app/Models/Admin.php` - Eloquent model untuk tabel admins

### Migrations
- `database/migrations/2025_11_27_073042_create_admins_table.php`

### Seeders
- `database/seeders/AdminSeeder.php` - Data admin default

### Views
- `resources/views/admin/profil.blade.php` - Display data dari session
- `resources/views/admin/profil-edit.blade.php` - Form edit dengan old values
- `resources/views/layouts/admin.blade.php` - Header dengan avatar dinamis

## Upload Avatar

Avatar disimpan di: `public/images/profiles/`

Format nama file: `admin_{timestamp}_{uniqid}.{extension}`

Contoh: `admin_1732692345_6547a2b1c3d4e.jpg`

## Validasi Form Edit Profil

### Required Fields
- Nama lengkap (max 255 karakter)
- Email (format email valid, unique)

### Optional Fields
- Telepon (max 20 karakter)
- Alamat (max 500 karakter)
- Password (min 8 karakter, dengan konfirmasi)
- Avatar (image, max 2MB, jpeg/png/jpg/gif)

## Security Features

1. **Password Hashing**: Menggunakan bcrypt via Laravel Hash
2. **Session Validation**: Cek admin_id di setiap request
3. **CSRF Protection**: Token validation di semua form
4. **Email Uniqueness**: Validasi email tidak duplikat
5. **File Validation**: Upload avatar dengan size & type check
6. **Old Avatar Cleanup**: Hapus avatar lama saat upload baru

## Testing

### Test Login
```bash
# Via browser
http://127.0.0.1:8000/admin/login
Username: admin
Password: admin123
```

### Test Update Profil
1. Login sebagai admin
2. Klik avatar/profil di header
3. Klik "Edit Profil"
4. Ubah nama, email, telepon, atau upload avatar
5. Klik "Simpan Perubahan"
6. Verifikasi perubahan tersimpan di database

### Verify Database
```bash
php artisan tinker
>>> App\Models\Admin::first()
>>> App\Models\Admin::find(1)->name
>>> App\Models\Admin::find(1)->avatar
```

## Troubleshooting

### Error: Session expired
**Penyebab:** admin_id tidak ada di session
**Solusi:** Logout dan login ulang

### Error: Avatar tidak muncul
**Penyebab:** Path file salah atau file tidak ada
**Solusi:** 
- Cek folder `public/images/profiles/` ada
- Verifikasi path di database: `SELECT avatar FROM admins WHERE id=1`
- Pastikan file exists di public path

### Error: Email already taken
**Penyebab:** Email sudah digunakan admin lain
**Solusi:** Gunakan email berbeda atau edit admin yang sudah ada

## Migration Commands

### Fresh Migration (CAUTION: Deletes all data!)
```bash
php artisan migrate:fresh --seed
```

### Rollback Last Migration
```bash
php artisan migrate:rollback
```

### Check Migration Status
```bash
php artisan migrate:status
```

## Best Practices

1. **Backup Database**: Sebelum migrate fresh
2. **Strong Password**: Ubah password default di production
3. **Avatar Optimization**: Resize image sebelum upload (client-side)
4. **Session Timeout**: Set di `config/session.php`
5. **HTTPS Only**: Di production, gunakan SSL certificate

## Future Enhancements

- [ ] Multi-admin support dengan role (Super Admin, Admin, Moderator)
- [ ] Email verification untuk admin baru
- [ ] Two-Factor Authentication (2FA)
- [ ] Activity log untuk audit trail
- [ ] Password reset via email
- [ ] Avatar crop & resize otomatis
- [ ] Admin permissions & ACL

## Support

Jika ada masalah atau pertanyaan, cek:
1. Laravel log: `storage/logs/laravel.log`
2. Database connection: `.env` file
3. Migration status: `php artisan migrate:status`
4. Session driver: `config/session.php`
