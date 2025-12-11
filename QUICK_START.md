# Quick Start Guide - 5 Menit Setup

## 1️⃣ Setup Database (1 menit)
```bash
# Buat database
mysql -u root -e "CREATE DATABASE sistem_informasi_pupukdanbibit;"

# Jalankan migration
php artisan migrate
```

## 2️⃣ Install Dependencies (2 menit)
```bash
composer install
npm install
```

## 3️⃣ Jalankan Server (1 menit)
```bash
# Opsi 1: All-in-one (Recommended)
composer run dev

# Opsi 2: Manual
php artisan serve    # Terminal 1
npm run dev          # Terminal 2
```

## 4️⃣ Akses Aplikasi (1 menit)

**Pengguna Biasa:**
- URL: http://127.0.0.1:8000
- Klik "Register" untuk daftar akun baru

**Admin:**
- URL: http://127.0.0.1:8000/admin/login
- Username: `admin`
- Password: `admin123`

## ✅ Selesai!

Baca `MANUAL_PENGGUNAAN.md` untuk panduan lengkap.
