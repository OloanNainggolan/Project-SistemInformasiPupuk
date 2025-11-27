# 🚀 Panduan untuk Collaborator - Setup Project

## ⚠️ PENTING! Baca Ini Sebelum Mulai

Jika Anda **baru pull/clone** project atau ada **perubahan besar** dari push terbaru, ikuti langkah berikut:

---

## 📋 Langkah-Langkah Setup

### 1️⃣ **Pull Update Terbaru**
```bash
git pull origin [nama-branch]
```
Contoh:
```bash
git pull origin sihiy
```

### 2️⃣ **Install/Update Dependencies**

**Composer (PHP):**
```bash
composer install
```
Atau jika sudah ada, update:
```bash
composer update
```

**NPM (JavaScript/CSS):**
```bash
npm install
```

### 3️⃣ **Copy File Environment**

Jika file `.env` belum ada:
```bash
copy .env.example .env
```

**Linux/Mac:**
```bash
cp .env.example .env
```

### 4️⃣ **Generate Application Key**
```bash
php artisan key:generate
```

### 5️⃣ **Setup Database**

Edit file `.env` dan sesuaikan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_informasi_pupukdanbibit
DB_USERNAME=root
DB_PASSWORD=
```

Buat database di MySQL:
```sql
CREATE DATABASE sistem_informasi_pupukdanbibit;
```

### 6️⃣ **Jalankan Migrasi**
```bash
php artisan migrate
```

Jika muncul error, reset:
```bash
php artisan migrate:fresh
```

### 7️⃣ **CLEAR SEMUA CACHE** ⚡

Ini yang **PALING PENTING**!

**Windows:**
```bash
clear-all-cache.bat
```

**Linux/Mac:**
```bash
chmod +x clear-all-cache.sh
./clear-all-cache.sh
```

**Manual (jika script tidak berfungsi):**
```bash
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan clear-compiled
composer dump-autoload
```

### 8️⃣ **Compile Assets (Jika Ada Perubahan CSS/JS)**
```bash
npm run dev
```

Atau untuk production:
```bash
npm run build
```

### 9️⃣ **Jalankan Server**
```bash
php artisan serve
```

Buka browser: `http://127.0.0.1:8000`

---

## 🔄 Setiap Kali Ada Update dari Push

**Minimal jalankan ini:**
```bash
git pull
php artisan view:clear
php artisan cache:clear
composer dump-autoload
```

**Atau langsung pakai script:**
```bash
clear-all-cache.bat
```

---

## 🐛 Troubleshooting

### Problem: Tampilan tidak berubah setelah pull
**Solusi:**
```bash
php artisan view:clear
php artisan cache:clear
```
Refresh browser dengan `Ctrl + Shift + R` (hard refresh)

---

### Problem: Error "Class not found"
**Solusi:**
```bash
composer dump-autoload
```

---

### Problem: Error "Route not found"
**Solusi:**
```bash
php artisan route:clear
php artisan route:cache
```

---

### Problem: Error "Config cache"
**Solusi:**
```bash
php artisan config:clear
```

---

### Problem: CSS/JS tidak berubah
**Solusi:**
```bash
npm run dev
```
Atau restart Vite:
```bash
npm run dev
```
Pastikan Vite berjalan saat development!

---

### Problem: Session/Authentication error
**Solusi:**
```bash
php artisan cache:clear
php artisan config:clear
```
Hapus session browser atau gunakan Incognito mode

---

## 📁 File Penting yang Harus Ada

✅ `.env` - Environment configuration
✅ `vendor/` - Composer dependencies
✅ `node_modules/` - NPM dependencies
✅ `public/images/` - Upload folder
✅ `storage/framework/cache/` - Cache folder
✅ `storage/framework/sessions/` - Session folder
✅ `storage/framework/views/` - Compiled views

---

## 🚫 File yang TIDAK di-push ke Git

❌ `.env` - Setiap orang buat sendiri
❌ `vendor/` - Install dengan `composer install`
❌ `node_modules/` - Install dengan `npm install`
❌ `storage/framework/cache/` - Auto generated
❌ `storage/framework/sessions/` - Auto generated
❌ `storage/framework/views/` - Auto generated
❌ `public/images/products/` - Upload folder (bisa berbeda tiap dev)

---

## 🔑 Kredensial Default

### Admin Login:
- URL: `/admin/login`
- Username: `admin`
- Email: `admin@pupuksubsidi.id`
- Password: `admin123`

### User Login:
- URL: `/login`
- Daftar dulu di `/register`

---

## 📞 Kontak

Jika masih ada masalah, hubungi:
- **Owner:** OloanNainggolan
- **Repository:** Project-SistemInformasiPupuk
- **Branch:** sihiy

---

## ⚡ Quick Commands

**Full Reset (jika benar-benar bermasalah):**
```bash
# 1. Pull update
git pull

# 2. Clear semua
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload

# 3. Fresh install
composer install
npm install

# 4. Rebuild database (HATI-HATI: Hapus semua data!)
php artisan migrate:fresh

# 5. Run server
php artisan serve
```

**Quick Cache Clear:**
```bash
php artisan optimize:clear
```

---

## 📝 Best Practice untuk Collaborator

1. ✅ **Selalu pull** sebelum mulai coding
2. ✅ **Clear cache** setelah pull
3. ✅ **Hard refresh** browser (`Ctrl + Shift + R`)
4. ✅ **Commit & push** perubahan Anda
5. ✅ **Komunikasi** dengan tim jika ada konflik

---

## 🎯 Checklist Setelah Pull Update

- [ ] Git pull berhasil
- [ ] Composer install/update
- [ ] NPM install/update (jika ada package.json changes)
- [ ] Clear all cache (artisan cache:clear, view:clear, dll)
- [ ] Database migrate (jika ada migration baru)
- [ ] Hard refresh browser
- [ ] Test halaman yang berubah
- [ ] Cek terminal untuk error

---

**INGAT:** Cache adalah masalah #1 ketika tampilan tidak sesuai! Selalu clear cache setelah pull! 🔄
