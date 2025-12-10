# LOGIN CREDENTIALS - SISTEM PUPUK & BIBIT SUBSIDI

## Status: ✅ PASSWORD SUDAH DIRESET

Semua password user telah direset pada: **10 Desember 2025, 10:30 WIB**

---

## USER LOGIN (http://127.0.0.1:8000/login)

### Akun 1:
- **Username:** `admin`
- **Email:** `chrismansyaht19@gmail.com`  
- **Password:** `admin123`
- **Nama:** Chrismansyah

### Akun 2:
- **Username:** `testuser`
- **Email:** `test@gmail.com`
- **Password:** `password123`
- **Nama:** cts

**Catatan:** Anda bisa login menggunakan username ATAU email

---

## ADMIN LOGIN (http://127.0.0.1:8000/admin/login)

- **Username:** `admin`
- **Password:** `admin123`

**Catatan:** Ini adalah sistem hardcoded di AdminController, bukan dari database

---

## TROUBLESHOOTING

### Jika masih muncul "Username/Email atau password salah":

1. **Clear Browser Cache & Cookies**
   - Tekan `Ctrl + Shift + Delete`
   - Pilih "Cookies and other site data" dan "Cached images and files"
   - Klik "Clear data"

2. **Gunakan Incognito/Private Window**
   - Chrome: `Ctrl + Shift + N`
   - Edge: `Ctrl + Shift + P`

3. **Cek Log Error**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Reset Password Manual (jika masih gagal)**
   ```bash
   php reset-user-password.php
   ```

---

## VERIFIKASI PASSWORD

Untuk memverifikasi password yang tersimpan di database:

```bash
php verify-login.php
```

Output akan menunjukkan apakah password valid atau tidak.

---

## CATATAN PENTING

- Session lifetime: 12 jam (720 menit)
- CSRF protection: Aktif di semua form
- Password hashing: Bcrypt (Laravel default)
- Authentication guard: 'web' (session-based)

---

**Terakhir diupdate:** 10 Desember 2025, 10:30 WIB
