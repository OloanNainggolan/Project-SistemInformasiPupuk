# Google OAuth Login - Dokumentasi

## Overview

Sistem login menggunakan Google OAuth telah terintegrasi dengan aplikasi Laravel. Pengguna dapat login menggunakan akun Google mereka tanpa perlu membuat password.

## Fitur

### 1. Web-Based Login
- Tombol "Masuk dengan Google" di halaman `/login`
- Otomatis create/update user setelah Google authentication
- Redirect ke dashboard setelah berhasil login
- Avatar dari Google profile disimpan di database

### 2. API-Based Login (Stateless)
- Endpoint: `GET /api/v1/auth/google` - Get redirect URL
- Endpoint: `GET /api/v1/auth/google/callback` - Handle callback
- Returns JWT token untuk mobile/SPA applications
- Stateless authentication menggunakan Laravel Sanctum

## Alur Kerja

### Web Login Flow
1. User klik "Masuk dengan Google" di `/login`
2. Redirect ke Google OAuth consent screen
3. User authorize aplikasi
4. Google redirect ke `/auth/google/callback` dengan authorization code
5. Laravel exchange code untuk user data (nama, email, avatar)
6. Sistem cek apakah user sudah ada:
   - **Jika sudah ada** (by google_id atau email): Update `google_id`, `avatar`, `provider`
   - **Jika belum ada**: Create user baru dengan data dari Google
7. Auto-login user dan redirect ke dashboard

### API Login Flow
1. Client request `GET /api/v1/auth/google` untuk mendapat redirect URL
2. Client open URL di browser/webview
3. Google redirect ke `/api/v1/auth/google/callback`
4. Laravel return JSON dengan user data + Bearer token
5. Client store token untuk authenticated requests

## Instalasi & Setup

### 1. Install Laravel Socialite
Sudah terinstall via composer:
```bash
composer require laravel/socialite
```

### 2. Konfigurasi Google Cloud Console

#### a. Buat Project Baru
1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Klik **Select a Project** → **New Project**
3. Nama project: `Pupuk & Bibit Subsidi` (atau sesuai keinginan)
4. Klik **Create**

#### b. Enable Google+ API
1. Di sidebar kiri, pilih **APIs & Services** → **Library**
2. Cari "Google+ API"
3. Klik **Enable**

#### c. Create OAuth Consent Screen
1. Pilih **APIs & Services** → **OAuth consent screen**
2. User Type: Pilih **External** → **Create**
3. Isi informasi:
   - **App name**: Sistem Informasi Pupuk & Bibit Subsidi
   - **User support email**: Email Anda
   - **Developer contact**: Email Anda
4. Klik **Save and Continue**
5. **Scopes**: Skip (default sudah cukup)
6. **Test users**: Tambahkan email untuk testing (optional)
7. Klik **Save and Continue** sampai selesai

#### d. Create OAuth Credentials
1. Pilih **APIs & Services** → **Credentials**
2. Klik **+ Create Credentials** → **OAuth client ID**
3. Application type: **Web application**
4. Name: `Laravel Google OAuth`
5. **Authorized redirect URIs**: Tambahkan:
   ```
   http://127.0.0.1:8000/auth/google/callback
   http://localhost:8000/auth/google/callback
   ```
   Jika deploy ke production, tambahkan juga:
   ```
   https://yourdomain.com/auth/google/callback
   ```
6. Klik **Create**
7. **SIMPAN** Client ID dan Client Secret

### 3. Update .env File
Buka file `.env` dan update dengan credentials dari Google:

```env
GOOGLE_CLIENT_ID=your-google-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

**Contoh:**
```env
GOOGLE_CLIENT_ID=123456789-abcdefg.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-1234567890abcdefghijklmn
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

### 4. Clear Config Cache
```bash
php artisan config:clear
php artisan cache:clear
```

## Database Schema

Migration `add_google_oauth_to_users_table` sudah dijalankan. Kolom yang ditambahkan:

| Kolom | Tipe | Nullable | Index | Keterangan |
|-------|------|----------|-------|------------|
| `google_id` | string | Yes | Yes | Google unique identifier |
| `avatar` | string | Yes | No | URL avatar dari Google |
| `provider` | string | Yes | No | OAuth provider (google, facebook, dll) |

## Routes

### Web Routes (c:\laragon\www\ppw\routes\web.php)
```php
// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
```

### API Routes (c:\laragon\www\ppw\routes\api.php)
```php
// Inside Route::prefix('auth')->group()
Route::get('/google', [GoogleAuthController::class, 'apiRedirectToGoogle']);
Route::get('/google/callback', [GoogleAuthController::class, 'apiHandleGoogleCallback']);
```

## Controller Methods

### GoogleAuthController

#### `redirectToGoogle()`
Redirect user ke Google OAuth consent screen.

**URL**: `/auth/google`  
**Method**: GET  
**Response**: Redirect to Google

#### `handleGoogleCallback()`
Handle callback dari Google setelah user authorize.

**URL**: `/auth/google/callback`  
**Method**: GET  
**Response**: Redirect to dashboard with success message

**Logic**:
1. Get user data dari Google
2. Find user by `google_id` atau `email`
3. Update atau create user
4. Login user dengan session
5. Redirect ke dashboard

#### `apiRedirectToGoogle()`
API version - return redirect URL (stateless).

**URL**: `/api/v1/auth/google`  
**Method**: GET  
**Response**:
```json
{
  "success": true,
  "url": "https://accounts.google.com/o/oauth2/auth?client_id=..."
}
```

#### `apiHandleGoogleCallback(Request $request)`
API version - handle callback dan return token (stateless).

**URL**: `/api/v1/auth/google/callback`  
**Method**: GET  
**Response**:
```json
{
  "success": true,
  "message": "Login dengan Google berhasil",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "avatar": "https://lh3.googleusercontent.com/...",
      "provider": "google"
    },
    "token": "1|abcdef123456...",
    "token_type": "Bearer"
  }
}
```

## Testing

### Test Web Login
1. Jalankan development server:
   ```bash
   php artisan serve
   ```
2. Buka browser: `http://127.0.0.1:8000/login`
3. Klik tombol "Masuk dengan Google"
4. Login dengan akun Google test user
5. Verify redirect ke dashboard
6. Check database `users` table untuk user baru

### Test API Login
```bash
# 1. Get redirect URL
curl http://127.0.0.1:8000/api/v1/auth/google

# Response:
# {
#   "success": true,
#   "url": "https://accounts.google.com/o/oauth2/auth?..."
# }

# 2. Open URL di browser, login, dan note callback URL dengan code
# 3. Call callback endpoint (biasanya handle otomatis oleh Google)
```

### Test dengan Postman
Import collection dari `POSTMAN_COLLECTION_CATALOG_SALES.json` dan tambahkan request:

**Request**: Get Google OAuth URL
- Method: GET
- URL: `http://127.0.0.1:8000/api/v1/auth/google`

## User Data Handling

### New User Creation
Saat user baru login dengan Google, sistem create user dengan data:

```php
[
    'name' => Google Name,
    'nama_lengkap' => Google Name,
    'email' => Google Email,
    'google_id' => Google ID,
    'avatar' => Google Avatar URL,
    'provider' => 'google',
    'password' => Random Hash (24 chars),
    'email_verified_at' => now(),
    'alamat' => 'Belum diisi',
    'alamat_balai_desa' => 'Belum diisi',
    'no_telp' => '0000000000',
]
```

**Note**: Password di-generate random karena user tidak perlu password (login via Google).

### Existing User Update
Jika user sudah ada (match by `google_id` atau `email`), update:
- `google_id` (jika belum ada)
- `avatar` (update ke avatar terbaru dari Google)
- `provider` = 'google'

## Security

### Password Handling
User yang login via Google mendapat random password 24 karakter yang di-hash. Mereka tidak perlu tahu password ini karena login selalu via Google.

### Email Verification
User dari Google otomatis `email_verified_at = now()` karena email sudah terverifikasi oleh Google.

### Error Handling
Semua error di-log ke `storage/logs/laravel.log`:
```php
\Log::error('Google OAuth Error: ' . $e->getMessage());
```

User mendapat pesan error friendly:
- Web: Redirect ke login dengan flash message error
- API: JSON response dengan status 500

## Troubleshooting

### Error: "redirect_uri_mismatch"
**Penyebab**: Redirect URI di `.env` tidak match dengan yang di Google Console

**Solusi**:
1. Check exact URL di Google Console → Credentials
2. Pastikan tidak ada trailing slash
3. Match exactly: `http://127.0.0.1:8000/auth/google/callback`

### Error: "invalid_client"
**Penyebab**: Client ID atau Secret salah

**Solusi**:
1. Re-copy credentials dari Google Console
2. Pastikan tidak ada space/newline di `.env`
3. Run `php artisan config:clear`

### Error: "access_denied"
**Penyebab**: User cancel consent screen atau tidak authorize

**Solusi**: User harus klik "Allow" di consent screen

### User tidak ter-create
**Penyebab**: Required fields di database tidak match

**Solusi**: Check migration dan pastikan default values sesuai dengan model User

### Avatar tidak muncul
**Penyebab**: Google avatar URL expired atau blocked

**Solusi**: 
1. Check apakah `avatar` field tersimpan di database
2. Verify URL masih accessible
3. Consider download & simpan avatar ke local storage

## Production Deployment

### 1. Update Google Console
Tambahkan production redirect URI:
```
https://yourdomain.com/auth/google/callback
```

### 2. Update .env Production
```env
GOOGLE_CLIENT_ID=your-production-client-id
GOOGLE_CLIENT_SECRET=your-production-secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

### 3. Verify Consent Screen
Jika production, submit OAuth consent screen untuk verification (diperlukan jika ingin user non-test dapat login).

## Referensi

- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth 2.0 Guide](https://developers.google.com/identity/protocols/oauth2)
- [Google Cloud Console](https://console.cloud.google.com/)

## File yang Diubah

1. `composer.json` - Added laravel/socialite dependency
2. `config/services.php` - Added Google OAuth config
3. `.env` - Added GOOGLE_* environment variables
4. `database/migrations/2025_12_09_083244_add_google_oauth_to_users_table.php` - Migration
5. `app/Models/User.php` - Added fillable fields
6. `app/Http/Controllers/GoogleAuthController.php` - OAuth logic
7. `routes/web.php` - Web routes
8. `routes/api.php` - API routes
9. `resources/views/auth/login.blade.php` - Already has Google button

## Support

Untuk pertanyaan atau issue, check:
1. `storage/logs/laravel.log` untuk error details
2. Google Cloud Console logs untuk OAuth errors
3. Browser console untuk frontend errors
