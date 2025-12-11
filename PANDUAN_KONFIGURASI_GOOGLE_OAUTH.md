# 📋 PANDUAN LENGKAP KONFIGURASI GOOGLE OAUTH

## ✅ Apa yang Sudah Dikerjakan

File `.env` Anda sudah dikonfigurasi dengan template Google OAuth:

```env
GOOGLE_CLIENT_ID=your-google-client-id-here
GOOGLE_CLIENT_SECRET=your-google-client-secret-here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

---

## 🎯 LANGKAH 1: Dapatkan Credentials dari Google Cloud

### A. Buka Google Cloud Console

1. Kunjungi: **https://console.cloud.google.com/**
2. Login dengan akun Google Anda

### B. Buat Project Baru (jika belum punya)

1. Klik dropdown project di bagian atas (sebelah kiri logo Google Cloud)
2. Klik **"NEW PROJECT"**
3. Isi nama project: **"Sistem Informasi Pupuk"**
4. Klik **"CREATE"**

### C. Aktifkan Google+ API

1. Di menu kiri, pilih **"APIs & Services"** → **"Library"**
2. Cari **"Google+ API"** atau **"Google Identity"**
3. Klik dan pilih **"ENABLE"**

### D. Buat OAuth Credentials

1. Di menu kiri, pilih **"APIs & Services"** → **"Credentials"**
2. Klik **"CREATE CREDENTIALS"** → pilih **"OAuth client ID"**
3. Jika diminta, konfigurasi **OAuth consent screen** terlebih dahulu:
   - User Type: **External**
   - App name: **Sistem Informasi Pupuk**
   - User support email: email Anda
   - Developer contact: email Anda
   - Klik **"SAVE AND CONTINUE"** sampai selesai

4. Kembali ke **Credentials** → **"CREATE CREDENTIALS"** → **"OAuth client ID"**
5. Application type: **Web application**
6. Name: **Laravel OAuth Client**
7. **Authorized redirect URIs**, klik **"ADD URI"** dan masukkan:
   ```
   http://127.0.0.1:8000/auth/google/callback
   ```
8. Klik **"CREATE"**

### E. Salin Credentials

Setelah berhasil dibuat, akan muncul popup dengan:
- **Your Client ID**: `123456789-abc123xyz.apps.googleusercontent.com`
- **Your Client Secret**: `GOCSPX-abc123xyz789`

**PENTING**: Salin kedua nilai ini! ⚠️

---

## 🎯 LANGKAH 2: Update File .env

Buka file `.env` di project Anda (sudah ada di root folder) dan ganti:

```env
# SEBELUM (template)
GOOGLE_CLIENT_ID=your-google-client-id-here
GOOGLE_CLIENT_SECRET=your-google-client-secret-here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback

# SESUDAH (isi dengan credentials Anda)
GOOGLE_CLIENT_ID=123456789-abc123xyz.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-abc123xyz789
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

---

## 🎯 LANGKAH 3: Install Package Laravel Socialite

Jalankan perintah ini di terminal (PowerShell):

```powershell
composer require laravel/socialite
```

---

## 🎯 LANGKAH 4: Konfigurasi Laravel

### A. Update `config/services.php`

Tambahkan konfigurasi Google di file `config/services.php`:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

### B. Generate Application Key (jika belum)

```powershell
php artisan key:generate
```

### C. Clear Cache

```powershell
php artisan config:clear
php artisan cache:clear
```

---

## 🎯 LANGKAH 5: Pengujian

### A. Jalankan Server

```powershell
php artisan serve
```

Server akan berjalan di: **http://127.0.0.1:8000**

### B. Test Login

1. Buka browser
2. Akses halaman login Anda
3. Klik tombol **"Login dengan Google"**
4. Pilih akun Google
5. Seharusnya berhasil redirect dan login!

---

## 📝 CATATAN PENTING

### Untuk Development (Localhost)

```env
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

### Untuk Production (Domain Real)

Jika Anda deploy ke server production, ganti dengan domain Anda:

```env
GOOGLE_REDIRECT_URI=https://domainmu.com/auth/google/callback
```

**Jangan lupa tambahkan URL ini juga di Google Cloud Console** → Credentials → Edit OAuth Client → Authorized redirect URIs

---

## ❓ TROUBLESHOOTING

### Error: "redirect_uri_mismatch"

**Penyebab**: URL redirect tidak sama dengan yang didaftarkan di Google Cloud

**Solusi**:
1. Pastikan `GOOGLE_REDIRECT_URI` di `.env` sama persis dengan yang di Google Cloud Console
2. Clear cache: `php artisan config:clear`
3. Periksa tidak ada typo atau spasi

### Error: "invalid_client"

**Penyebab**: Client ID atau Client Secret salah

**Solusi**:
1. Cek kembali credentials di Google Cloud Console
2. Pastikan tidak ada spasi di awal/akhir saat copy-paste
3. Pastikan sudah clear cache

### Error: "Access blocked: This app's request is invalid"

**Penyebab**: OAuth consent screen belum dikonfigurasi

**Solusi**:
1. Konfigurasi OAuth consent screen di Google Cloud Console
2. Tambahkan test users jika app masih dalam mode testing

---

## 🔒 KEAMANAN

1. **JANGAN** commit file `.env` ke Git
2. File `.env` sudah ada di `.gitignore`
3. **JANGAN** share Client Secret ke publik
4. Gunakan HTTPS untuk production

---

## 📚 Referensi

- **Google Cloud Console**: https://console.cloud.google.com/
- **Laravel Socialite Docs**: https://laravel.com/docs/socialite
- **File Setup Project**: Lihat `CARA_SETUP_GOOGLE_OAUTH.md` dan `GOOGLE_OAUTH_SETUP.md`

---

**Dibuat**: 11 Desember 2025  
**Project**: Sistem Informasi Pupuk & Bibit Subsidi
