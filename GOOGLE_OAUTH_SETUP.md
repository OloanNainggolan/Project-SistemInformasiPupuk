# Quick Setup: Google OAuth Credentials

## Langkah Cepat Mendapatkan Google Client ID & Secret

### 1. Buka Google Cloud Console
🔗 https://console.cloud.google.com/

### 2. Buat Project Baru
- Klik dropdown "Select a Project" (atas)
- Klik "NEW PROJECT"
- Nama: `Pupuk & Bibit Subsidi`
- Klik "CREATE"

### 3. Enable API
- Sidebar: **APIs & Services** → **Library**
- Cari: "Google+ API"
- Klik "ENABLE"

### 4. Setup OAuth Consent Screen
- Sidebar: **APIs & Services** → **OAuth consent screen**
- User Type: **External** → "CREATE"
- App name: `Sistem Informasi Pupuk & Bibit Subsidi`
- User support email: [email Anda]
- Developer contact: [email Anda]
- Klik "SAVE AND CONTINUE" (3x sampai selesai)

### 5. Buat Credentials
- Sidebar: **APIs & Services** → **Credentials**
- Klik "+ CREATE CREDENTIALS" → **OAuth client ID**
- Application type: **Web application**
- Name: `Laravel Google OAuth`

**Authorized redirect URIs** - Tambahkan:
```
http://127.0.0.1:8000/auth/google/callback
http://localhost:8000/auth/google/callback
```

- Klik "CREATE"

### 6. Copy Credentials
Akan muncul popup dengan:
- ✅ **Client ID**: `123456789-abcdef.apps.googleusercontent.com`
- ✅ **Client Secret**: `GOCSPX-1234567890abcdef`

**COPY keduanya!**

### 7. Update .env File
Buka `c:\laragon\www\ppw\.env` dan update:

```env
GOOGLE_CLIENT_ID=paste-client-id-disini
GOOGLE_CLIENT_SECRET=paste-client-secret-disini
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

### 8. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

### 9. Test Login
```bash
php artisan serve
```

Buka: http://127.0.0.1:8000/login  
Klik: **Masuk dengan Google**

---

## Troubleshooting

❌ **Error: redirect_uri_mismatch**
- Check Authorized redirect URIs di Google Console
- Pastikan exact match: `http://127.0.0.1:8000/auth/google/callback`

❌ **Error: invalid_client**
- Re-copy Client ID & Secret
- Pastikan tidak ada space/newline
- Run `php artisan config:clear`

❌ **Error: access_denied**
- User harus klik "Allow" di consent screen

---

## Dokumentasi Lengkap
Lihat: `README_GOOGLE_OAUTH.md`
