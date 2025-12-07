# Reset Password User - Documentation

## Fitur Reset Password

Sistem reset password sudah terimplementasi dengan lengkap. User dapat mereset password mereka dan login dengan password baru.

## Alur Kerja

1. **User mengakses halaman reset password**: `/reset-password`
2. **User mengisi form**:
   - Email yang terdaftar
   - Password baru (minimal 4 karakter, harus mengandung huruf dan angka)
   - Konfirmasi password
3. **Sistem memvalidasi**:
   - Email harus terdaftar di database
   - Password harus sesuai format (huruf + angka, minimal 4 karakter)
   - Konfirmasi password harus sama
4. **Password di-hash dan disimpan** menggunakan `Hash::make()`
5. **User diarahkan ke login** dengan notifikasi sukses
6. **User login dengan password baru**

## Cara Testing

### 1. Register User Baru (jika belum punya)
```
URL: http://127.0.0.1:8000/register
- Isi form registrasi
- Login dengan password awal
```

### 2. Reset Password
```
URL: http://127.0.0.1:8000/reset-password

Form input:
- Email: email@user.com (email yang sudah terdaftar)
- Password Baru: pass123 (contoh: kombinasi huruf + angka)
- Konfirmasi Password: pass123
```

### 3. Login dengan Password Baru
```
URL: http://127.0.0.1:8000/login

Form input:
- Username/Email: email@user.com
- Password: pass123 (password BARU)

❌ Jika pakai password lama → GAGAL: "Password salah"
✅ Jika pakai password baru → BERHASIL masuk dashboard
```

## Validasi

### Server-side (Controller)
- Email harus valid dan terdaftar
- Password minimal 4 karakter
- Password harus mengandung huruf DAN angka (regex: `/^(?=.*[A-Za-z])(?=.*\d).+$/`)
- Konfirmasi password harus sama

### Client-side (JavaScript)
- Validasi real-time sebelum submit
- Cek password match
- Tampilkan error message jika tidak valid

## Security

✅ **Password di-hash** menggunakan `bcrypt` (Laravel Hash)
✅ **Verifikasi otomatis** saat login menggunakan `Auth::attempt()`
✅ **CSRF Protection** dengan `@csrf` token
✅ **Input validation** di server dan client

## Error Messages

### Email tidak terdaftar
```
"Alamat email tidak terdaftar dalam sistem."
```

### Password tidak cocok
```
"Konfirmasi password tidak cocok"
```

### Format password salah
```
"Password harus mengandung huruf dan angka"
```

### Login dengan password lama setelah reset
```
"Password salah" (dari Auth::attempt())
```

## File yang Terlibat

1. **Route**: `routes/web.php`
   - GET `/reset-password` → view form
   - POST `/reset-password` → proses reset

2. **Controller**: `app/Http/Controllers/AuthController.php`
   - `processReset()` → handle reset password

3. **View**: `resources/views/auth/resetpw.blade.php`
   - Form reset password dengan validasi

4. **Model**: `app/Models/User.php`
   - User model dengan password hash

## Contoh Flow Lengkap

```
1. User lupa password
   ↓
2. Akses /reset-password
   ↓
3. Input: email@test.com, password: test123, confirm: test123
   ↓
4. Submit → Controller validasi
   ↓
5. Password di-hash: Hash::make('test123')
   ↓
6. Simpan ke database: $user->password = $hashed
   ↓
7. Redirect ke /login dengan success message
   ↓
8. User login dengan email@test.com + test123
   ↓
9. Auth::attempt() verifikasi hash → BERHASIL
   ↓
10. Masuk dashboard
```

## Troubleshooting

### Problem: Password lama masih bisa login
**Solusi**: 
- Pastikan `$user->save()` dipanggil setelah update password
- Clear cache: `php artisan cache:clear`

### Problem: Password baru tidak bisa login
**Solusi**: 
- Pastikan menggunakan `Hash::make()` saat reset
- Pastikan login menggunakan `Auth::attempt()` (bukan manual check)

### Problem: Error "email tidak terdaftar"
**Solusi**: 
- Cek email di database users: `SELECT * FROM users WHERE email = 'xxx'`
- Pastikan email exact match (case-sensitive)

## Log Debugging

Sistem mencatat aktivitas reset password di log:
```php
\Log::info('Password reset successful for user: email@test.com');
```

Cek log: `storage/logs/laravel.log`
