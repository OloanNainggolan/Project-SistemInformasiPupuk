# 📋 GOOGLE OAUTH - QUICK REFERENCE CARD

## 🎯 ERROR ANDA SEKARANG:
```
❌ Missing required parameter: client_id
❌ Error 400: invalid_request
```

## ✅ SOLUSI CEPAT (5 LANGKAH):

### 1️⃣ Buka Google Cloud Console
🔗 https://console.cloud.google.com/

### 2️⃣ Buat Project & Enable API
- NEW PROJECT → Nama: `Pupuk Bibit Subsidi`
- APIs & Services → Library → "Google+ API" → ENABLE

### 3️⃣ Setup OAuth Consent Screen
- OAuth consent screen → External → CREATE
- App name: `Sistem Informasi Pupuk & Bibit`
- User support email: [email Anda]
- Test users: Tambah [email Anda]
- SAVE AND CONTINUE (3x)

### 4️⃣ Buat Credentials (PENTING!)
- Credentials → CREATE CREDENTIALS → OAuth client ID
- Type: **Web application**
- Authorized redirect URIs:
  ```
  http://127.0.0.1:8000/auth/google/callback
  http://localhost:8000/auth/google/callback
  ```
- CREATE → **COPY Client ID & Secret**

### 5️⃣ Update .env & Test
```env
GOOGLE_CLIENT_ID=your-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-your-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

Terminal:
```bash
php artisan config:clear
php artisan serve
```

Browser: http://127.0.0.1:8000/login → Klik "Masuk dengan Google"

---

## 🔑 CREDENTIALS FORMAT:

**Client ID:**
```
123456789-abc123xyz456.apps.googleusercontent.com
```

**Client Secret:**
```
GOCSPX-1234567890abcdefghijklmnop
```

**Redirect URI (HARUS EXACT!):**
```
http://127.0.0.1:8000/auth/google/callback
```
⚠️ Tidak boleh ada trailing slash (/)

---

## ✅ CHECKLIST:

- [ ] Google Cloud project created
- [ ] Google+ API enabled
- [ ] OAuth Consent Screen configured (External)
- [ ] Test users added (email Anda)
- [ ] OAuth Client ID created (Web application)
- [ ] Redirect URIs added (127.0.0.1 & localhost)
- [ ] Client ID copied ke .env
- [ ] Client Secret copied ke .env
- [ ] Config cleared (`php artisan config:clear`)
- [ ] Server running (`php artisan serve`)
- [ ] Test login berhasil

---

## ⚡ TROUBLESHOOTING CEPAT:

| Error | Solusi |
|-------|--------|
| `redirect_uri_mismatch` | Check redirect URI di Google Console exact match |
| `invalid_client` | Re-copy Client ID & Secret, clear config |
| `access_denied` | User harus klik "Allow", pastikan di Test Users |
| `App isn't verified` | Klik "Advanced" → "Go to app (unsafe)" |
| User tidak tercreate | Check logs: `storage/logs/laravel.log` |

---

## 📞 FILES BANTUAN:

1. **CARA_SETUP_GOOGLE_OAUTH.md** ← Panduan detail step-by-step
2. **README_GOOGLE_OAUTH.md** ← Dokumentasi lengkap
3. **GOOGLE_OAUTH_CHECKLIST.md** ← Checklist implementasi

---

## 🎯 HASIL YANG BENAR:

✅ Klik "Masuk dengan Google"  
✅ Redirect ke Google consent screen  
✅ Pilih akun → Allow  
✅ Redirect ke dashboard  
✅ User tercreate dengan google_id  
✅ No error di browser/terminal  

---

**Print card ini atau save untuk referensi cepat!**

Last updated: December 9, 2025
