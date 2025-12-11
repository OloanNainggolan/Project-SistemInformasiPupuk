# 🧪 Testing Google Login

## ✅ Yang Sudah Dikonfigurasi

### 1. Routes Google OAuth
- ✅ `/auth/google` - Redirect ke Google login
- ✅ `/auth/google/callback` - Handle response dari Google
- ✅ `/auth/google/complete` - Form completion untuk data tambahan

### 2. UI Tombol Google Login

#### Halaman Login (`/login`)
✅ Tombol **"Masuk dengan Google"** sudah ditambahkan
- Posisi: Di bawah form login, setelah divider "atau"
- Style: Authentic Google button dengan logo SVG
- Route: `{{ route('auth.google') }}`

#### Halaman Register (`/register`)
✅ Tombol **"Daftar / Masuk dengan Google"** sudah ada
- Posisi: Di bawah form register
- Route: `{{ route('auth.google') }}`

## 🚀 Cara Testing

### Langkah 1: Pastikan Credentials Sudah Diisi
Buka file `.env` dan pastikan sudah diisi:
```env
GOOGLE_CLIENT_ID=your-actual-client-id-here
GOOGLE_CLIENT_SECRET=your-actual-client-secret-here
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

### Langkah 2: Jalankan Server
```powershell
php artisan serve
```

### Langkah 3: Test di Browser
1. Buka: http://127.0.0.1:8000/login
2. Scroll ke bawah, lihat tombol **"Masuk dengan Google"**
3. Klik tombol tersebut
4. **Harapan:**
   - Jika credentials valid: Redirect ke halaman Google login
   - Jika credentials belum diisi: Error akan muncul

### Langkah 4: Test Flow Lengkap (Setelah dapat credentials)
1. Klik tombol Google
2. Pilih akun Google Anda
3. Izinkan akses aplikasi
4. **Skenario A - User Baru:**
   - Redirect ke `/auth/google/complete`
   - Isi form: Nama Lengkap, No Telp, Alamat, Balai Desa, Username
   - Submit → Login otomatis → Redirect ke `/dashboard`

5. **Skenario B - User Existing:**
   - Langsung login → Redirect ke `/dashboard`

## 🔍 Verifikasi Route

```powershell
php artisan route:list --path=auth/google
```

Output yang benar:
```
GET|HEAD   auth/google ................ auth.google › Auth\GoogleController@redirectToGoogle
GET|HEAD   auth/google/callback ................. Auth\GoogleController@handleGoogleCallback  
GET|HEAD   auth/google/complete register.complete.show › Auth\GoogleController@showComplete…  
POST       auth/google/complete register.complete.process › Auth\GoogleController@completeR…
```

## ❌ Troubleshooting

### Error: "Client ID not found"
**Solusi:** Pastikan `GOOGLE_CLIENT_ID` di `.env` sudah diisi dengan nilai dari Google Cloud Console

### Error: "redirect_uri_mismatch"
**Solusi:**
1. Cek `GOOGLE_REDIRECT_URI` di `.env` → harus: `http://127.0.0.1:8000/auth/google/callback`
2. Cek di Google Cloud Console → Authorized redirect URIs harus sama persis
3. Clear config: `php artisan config:clear`

### Tombol tidak muncul
**Solusi:**
1. Clear cache browser (Ctrl+Shift+Delete)
2. Refresh halaman (Ctrl+F5)
3. Periksa console browser untuk error JavaScript

### Stuck di loading
**Solusi:**
1. Clear cache: `php artisan config:clear`
2. Restart server
3. Cek log: `storage/logs/laravel.log`

## 📸 Preview Tombol Google

Tombol akan terlihat seperti ini:

```
┌─────────────────────────────────────────┐
│  [G]  Masuk dengan Google               │
└─────────────────────────────────────────┘
```

- Background: Putih
- Border: Abu-abu tipis
- Logo: Google colorful G logo (SVG)
- Hover: Background berubah sedikit lebih gelap

## 🎨 Style Guide

Tombol mengikuti **Google's Brand Guidelines**:
- Font: Google Sans / Roboto
- Padding & spacing sesuai standard Google
- Shadow subtle untuk depth
- Transition smooth on hover
- Logo SVG dengan warna official Google

## 📝 Next Steps

1. ✅ Controller dibuat
2. ✅ Routes terdaftar
3. ✅ UI tombol ditambahkan
4. ⏳ **Dapatkan Google OAuth Credentials** (lihat `PANDUAN_KONFIGURASI_GOOGLE_OAUTH.md`)
5. ⏳ Test dengan user nyata
6. ⏳ Deploy ke production (ubah redirect URI)

---

**Update terakhir:** 11 Desember 2025  
**Status:** Siap testing (setelah credentials diisi)
