# ⚠️ UNTUK COLLABORATOR - BACA INI!

## 🔴 Jika Tampilan/Fitur Tidak Sesuai Setelah Pull

Jalankan perintah ini **SATU PER SATU**:

```bash
# 1. Clear semua cache Laravel
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# 2. Autoload ulang composer
composer dump-autoload

# 3. Hard refresh browser
# Tekan: Ctrl + Shift + R (Windows/Linux)
# Tekan: Cmd + Shift + R (Mac)
```

## 🚀 Cara Cepat (Script Otomatis)

### Windows:
```bash
clear-all-cache.bat
```

### Linux/Mac:
```bash
chmod +x clear-all-cache.sh
./clear-all-cache.sh
```

## 📌 File yang WAJIB Ada di Local Anda

1. ✅ `.env` - **TIDAK di-push**, copy dari `.env.example`
2. ✅ `vendor/` - **TIDAK di-push**, install dengan `composer install`
3. ✅ `node_modules/` - **TIDAK di-push**, install dengan `npm install`

## 🔧 Setup Pertama Kali

```bash
# 1. Clone/Pull
git clone [url-repo]
cd [folder-project]

# 2. Copy .env
copy .env.example .env

# 3. Install dependencies
composer install
npm install

# 4. Generate key
php artisan key:generate

# 5. Setup database
# Edit .env, sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 6. Migrate database
php artisan migrate

# 7. Clear cache
php artisan optimize:clear

# 8. Run server
php artisan serve
```

## 📖 Dokumentasi Lengkap

Baca file: **README_COLLABORATOR.md** untuk panduan detail!

---

**Masalah Umum:**
- Tampilan lama? → Clear cache + hard refresh browser
- Error class not found? → `composer dump-autoload`
- Error route? → `php artisan route:clear`
- CSS/JS tidak update? → `npm run dev` atau `npm run build`

**Happy Coding! 🚀**
