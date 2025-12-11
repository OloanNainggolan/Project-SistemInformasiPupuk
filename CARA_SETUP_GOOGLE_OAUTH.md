# 🚀 CARA SETUP GOOGLE OAUTH - STEP BY STEP

## ❌ ERROR YANG ANDA ALAMI:

```
Akses diblokir: Error Otorisasi
Missing required parameter: client_id
Error 400: invalid_request
```

**PENYEBAB:** File `.env` belum diisi dengan Client ID dan Client Secret dari Google.

---

## ✅ SOLUSI: Ikuti Langkah Berikut (15 Menit)

### 📌 STEP 1: Buka Google Cloud Console

1. Buka browser, masuk ke: **https://console.cloud.google.com/**
2. Login dengan akun Google Anda (gunakan akun yang sama dengan yang ingin Anda test)

---

### 📌 STEP 2: Buat Project Baru

1. Di pojok kiri atas, klik **"Select a project"** (dropdown)
2. Di popup yang muncul, klik tombol **"NEW PROJECT"** (pojok kanan atas)
3. Isi form:
   - **Project name**: `Pupuk Bibit Subsidi` (atau nama terserah Anda)
   - **Organization**: Biarkan kosong (No organization)
4. Klik tombol **"CREATE"**
5. Tunggu beberapa detik sampai project dibuat
6. Pastikan project sudah terpilih (cek di dropdown atas, harus ada nama project Anda)

---

### 📌 STEP 3: Enable Google+ API

1. Di sidebar kiri, klik **"APIs & Services"** → **"Library"**
   - Atau langsung buka: https://console.cloud.google.com/apis/library
   
2. Di kotak search, ketik: **"Google+ API"**

3. Klik pada **"Google+ API"** hasil pencarian

4. Klik tombol biru **"ENABLE"**

5. Tunggu sampai muncul halaman API enabled

---

### 📌 STEP 4: Setup OAuth Consent Screen (PENTING!)

1. Di sidebar kiri, klik **"APIs & Services"** → **"OAuth consent screen"**
   - Atau buka: https://console.cloud.google.com/apis/credentials/consent

2. Pilih **"External"** (centang radio button)

3. Klik tombol **"CREATE"**

4. **Halaman 1 - OAuth consent screen:**
   - **App name**: `Sistem Informasi Pupuk & Bibit Subsidi`
   - **User support email**: Pilih email Anda dari dropdown
   - **App logo**: Skip (optional)
   - **Application home page**: Biarkan kosong atau isi `http://127.0.0.1:8000`
   - **Authorized domains**: Biarkan kosong (untuk development)
   - **Developer contact information**: Isi email Anda
   - Klik **"SAVE AND CONTINUE"**

5. **Halaman 2 - Scopes:**
   - Langsung klik **"SAVE AND CONTINUE"** (skip, default scope sudah cukup)

6. **Halaman 3 - Test users:**
   - Klik **"+ ADD USERS"**
   - Masukkan email Google Anda (email yang akan Anda pakai untuk test login)
   - Klik **"ADD"**
   - Klik **"SAVE AND CONTINUE"**

7. **Halaman 4 - Summary:**
   - Review, lalu klik **"BACK TO DASHBOARD"**

---

### 📌 STEP 5: Buat OAuth Client ID (INTI NYA DI SINI!)

1. Di sidebar kiri, klik **"APIs & Services"** → **"Credentials"**
   - Atau buka: https://console.cloud.google.com/apis/credentials

2. Di bagian atas, klik **"+ CREATE CREDENTIALS"**

3. Pilih **"OAuth client ID"**

4. Isi form:
   - **Application type**: Pilih **"Web application"** (dari dropdown)
   
   - **Name**: `Laravel Google OAuth` (atau nama terserah)
   
   - **Authorized JavaScript origins**: SKIP (biarkan kosong)
   
   - **Authorized redirect URIs**: Klik **"+ ADD URI"**, lalu masukkan:
     ```
     http://127.0.0.1:8000/auth/google/callback
     ```
     
     Klik **"+ ADD URI"** lagi, masukkan:
     ```
     http://localhost:8000/auth/google/callback
     ```

5. Klik tombol biru **"CREATE"**

6. **POPUP MUNCUL** dengan informasi:
   - ✅ **Your Client ID**: `123456789-abcdefg.apps.googleusercontent.com`
   - ✅ **Your Client Secret**: `GOCSPX-1234567890abcdef`

7. **COPY DUA-DUANYA!** (atau klik "Download JSON" untuk backup)

---

### 📌 STEP 6: Update File .env (COPY PASTE CREDENTIALS)

1. Buka VS Code, buka file: **`.env`**

2. Cari baris ini (sekitar baris paling bawah):
   ```env
   GOOGLE_CLIENT_ID=
   GOOGLE_CLIENT_SECRET=
   GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
   ```

3. **PASTE** Client ID dan Client Secret yang Anda copy tadi:
   ```env
   GOOGLE_CLIENT_ID=123456789-abcdefg.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=GOCSPX-1234567890abcdef
   GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
   ```

4. **SAVE FILE** (Ctrl+S)

---

### 📌 STEP 7: Clear Cache Laravel

Buka terminal di VS Code, jalankan perintah ini:

```bash
php artisan config:clear
php artisan cache:clear
```

**Output yang benar:**
```
Configuration cache cleared successfully.
Application cache cleared successfully.
```

---

### 📌 STEP 8: Test Login Google

1. **Start development server** (jika belum jalan):
   ```bash
   php artisan serve
   ```

2. **Buka browser**, masuk ke:
   ```
   http://127.0.0.1:8000/login
   ```

3. **Klik tombol "Masuk dengan Google"**

4. **Google akan tampilkan consent screen:**
   - Pilih akun Google Anda
   - Klik **"Continue"** atau **"Allow"**

5. **Anda akan redirect ke dashboard!** ✅

6. **Check database:**
   - Buka phpMyAdmin atau database tool
   - Lihat tabel `users`
   - User baru sudah ada dengan `google_id` terisi!

---

## 🎯 VERIFIKASI BERHASIL:

✅ **No error "Missing required parameter: client_id"**  
✅ **Google consent screen muncul**  
✅ **Redirect ke dashboard setelah login**  
✅ **User baru tercreate di database dengan google_id**  
✅ **Avatar dari Google tersimpan di field avatar**  

---

## ❓ TROUBLESHOOTING

### Error: "redirect_uri_mismatch"

**Penyebab:** Redirect URI di Google Console tidak sama persis dengan yang di .env

**Solusi:**
1. Buka Google Console → Credentials → Edit OAuth Client
2. Pastikan **Authorized redirect URIs** ada:
   ```
   http://127.0.0.1:8000/auth/google/callback
   http://localhost:8000/auth/google/callback
   ```
3. Pastikan TIDAK ada trailing slash (/)
4. Save, lalu test lagi

---

### Error: "invalid_client"

**Penyebab:** Client ID atau Secret salah/typo

**Solusi:**
1. Buka Google Console → Credentials
2. Klik OAuth Client yang Anda buat
3. Copy ulang Client ID dan Client Secret (gunakan icon copy)
4. Paste ke `.env` (pastikan tidak ada spasi atau enter)
5. Run: `php artisan config:clear`
6. Test lagi

---

### Error: "access_denied"

**Penyebab:** User tidak mengklik "Allow" di consent screen, atau user tidak ada di Test Users

**Solusi:**
1. Pastikan email Anda ada di **OAuth Consent Screen → Test Users**
2. Login dengan email yang sama
3. Klik "Continue" atau "Allow" (JANGAN klik "Cancel")

---

### Consent Screen Tampil "This app isn't verified"

**Ini NORMAL untuk development!**

**Solusi:**
- Klik **"Advanced"** (link kecil di bawah)
- Klik **"Go to [App Name] (unsafe)"**
- Ini aman karena Anda developer nya sendiri

---

### User Tidak Tercreate di Database

**Check:**
1. Buka `storage/logs/laravel.log`
2. Cari error message terbaru
3. Biasanya karena field required di database

**Solusi:**
- Check migrasi sudah jalan: `php artisan migrate:status`
- Check field default values di `GoogleAuthController`

---

## 📸 SCREENSHOT PANDUAN (Jika Masih Bingung)

### 1. Google Cloud Console - Create Project
```
[Select a Project] → NEW PROJECT → Isi nama → CREATE
```

### 2. Enable API
```
APIs & Services → Library → Search "Google+ API" → ENABLE
```

### 3. OAuth Consent Screen
```
APIs & Services → OAuth consent screen → External → CREATE
Isi App name, emails → SAVE AND CONTINUE (3x)
```

### 4. Create Credentials
```
APIs & Services → Credentials → + CREATE CREDENTIALS
→ OAuth client ID → Web application
→ Authorized redirect URIs: http://127.0.0.1:8000/auth/google/callback
→ CREATE
```

### 5. Copy Credentials
```
Popup muncul:
- Client ID: 123456...apps.googleusercontent.com (COPY)
- Client Secret: GOCSPX-123... (COPY)
```

### 6. Paste ke .env
```
GOOGLE_CLIENT_ID=paste-disini
GOOGLE_CLIENT_SECRET=paste-disini
```

### 7. Clear Cache & Test
```bash
php artisan config:clear
php artisan serve
```
Buka: http://127.0.0.1:8000/login

---

## 🎉 SELESAI!

Setelah mengikuti semua step, tombol "Masuk dengan Google" akan berfungsi sempurna!

**Total waktu:** ~10-15 menit (first time)

**File penting:**
- `.env` - Tempat credentials
- `GOOGLE_OAUTH_SETUP.md` - Quick reference
- `README_GOOGLE_OAUTH.md` - Dokumentasi lengkap

---

## 📞 Need Help?

Jika masih error, check:
1. `storage/logs/laravel.log` - Laravel error logs
2. Browser Console (F12) - JavaScript errors
3. Google Cloud Console Logs - OAuth errors

**Common mistake:**
- ❌ Lupa enable Google+ API
- ❌ Tidak setup OAuth Consent Screen
- ❌ Redirect URI tidak exact match
- ❌ Copy credentials dengan spasi/enter
- ❌ Lupa clear config cache

**Pastikan:**
- ✅ Google+ API enabled
- ✅ OAuth Consent Screen configured
- ✅ Test Users added (email Anda)
- ✅ OAuth Client created (Web application)
- ✅ Redirect URI exact match
- ✅ Credentials di .env correct
- ✅ Config cleared

---

## 🚀 Next: Production Deployment

Untuk production (domain asli), tambahkan redirect URI:
```
https://yourdomain.com/auth/google/callback
```

Dan submit OAuth Consent Screen untuk verification (agar semua orang bisa login, bukan hanya test users).

---

**Good luck! 🎯**
