# 🚀 PANDUAN HOSTING & DEPLOYMENT

## ✅ Pre-Deployment Checklist

### 1. Database Structure
- ✅ Semua tabel sudah ada dan terstruktur dengan benar
- ✅ Foreign keys sudah terkonfigurasi dengan benar
- ✅ Tidak ada orphaned data
- ✅ Migration files sudah clean (duplikat sudah dihapus)

### 2. Environment Configuration (.env)
```env
# PRODUCTION SETTINGS - WAJIB DIUBAH!
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database - Sesuaikan dengan hosting
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Session - WAJIB database untuk multi-server
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache - Gunakan database atau redis
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail Configuration (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. File Permissions (Linux/Unix hosting)
```bash
# Set permissions untuk storage dan cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (adjust based on your hosting)
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
chown -R 775 public/images
```

### 4. .htaccess Configuration
Pastikan file `.htaccess` ada di folder `public/`:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## 🔧 Deployment Steps

### Step 1: Upload Files
```bash
# Upload semua file kecuali:
- .env (buat baru di server)
- node_modules/ (install ulang)
- vendor/ (install ulang)
- storage/framework/sessions/* (auto-generate)
- storage/framework/views/* (auto-generate)
- storage/logs/* (auto-generate)
```

### Step 2: Install Dependencies
```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies (optional, jika pakai Vite)
npm install
npm run build
```

### Step 3: Setup Environment
```bash
# Copy .env.example ke .env
cp .env.example .env

# Edit .env dengan konfigurasi production
nano .env

# Generate APP_KEY
php artisan key:generate
```

### Step 4: Database Setup
```bash
# Run migrations
php artisan migrate --force

# (Optional) Seed data jika diperlukan
php artisan db:seed --force
```

### Step 5: Optimize for Production
```bash
# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache config, routes, views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link
```

### Step 6: Set Web Server Document Root
**PENTING:** Arahkan document root ke folder `/public`

#### Apache (cPanel/DirectAdmin)
```
Document Root: /home/username/public_html/your-app/public
```

#### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your-app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🐛 Common Issues & Solutions

### Issue 1: Page Expired Error (CSRF Token Mismatch)
**Cause:** Session tidak tersimpan dengan benar
**Solution:**
```bash
# 1. Pastikan SESSION_DRIVER=database di .env
# 2. Check tabel sessions ada di database
php artisan migrate:status

# 3. Clear semua cache
php artisan config:clear
php artisan cache:clear

# 4. Restart web server
```

### Issue 2: Storage Images Not Loading
**Cause:** Storage link belum dibuat
**Solution:**
```bash
php artisan storage:link
```

### Issue 3: 500 Internal Server Error
**Cause:** Permission error atau .env tidak benar
**Solution:**
```bash
# Check error log
tail -f storage/logs/laravel.log

# Fix permissions
chmod -R 775 storage bootstrap/cache

# Check .env
php artisan config:clear
```

### Issue 4: Database Connection Error
**Cause:** Kredensial database salah
**Solution:**
```bash
# Edit .env dengan kredensial yang benar
nano .env

# Test koneksi
php artisan migrate:status
```

### Issue 5: "Mix Manifest Not Found"
**Cause:** Assets belum di-build
**Solution:**
```bash
npm install
npm run build
```

## 🔒 Security Checklist

- ✅ `APP_DEBUG=false` di production
- ✅ `APP_ENV=production`
- ✅ APP_KEY sudah di-generate
- ✅ Database credentials aman
- ✅ `.env` tidak di-commit ke Git
- ✅ File permissions sudah benar (775 untuk storage)
- ✅ Web server document root di `/public`
- ✅ Disable directory listing
- ✅ HTTPS enabled (SSL certificate)

## 📊 Monitoring & Maintenance

### Daily Checks
```bash
# Check error logs
tail -f storage/logs/laravel.log

# Check disk space
df -h

# Check database size
php artisan db:show
```

### Weekly Maintenance
```bash
# Clear old logs (manual)
# Backup database
mysqldump -u user -p database > backup.sql

# Clear old sessions (auto-cleaned by Laravel)
```

### Performance Optimization
```bash
# Enable OPcache di php.ini
opcache.enable=1
opcache.memory_consumption=128

# Use Redis for cache (if available)
CACHE_STORE=redis
SESSION_DRIVER=redis

# Queue processing
php artisan queue:work --daemon
```

## 📞 Support

Jika ada masalah, cek:
1. `storage/logs/laravel.log` - Application errors
2. Web server error log (Apache/Nginx)
3. Browser console - JavaScript errors
4. Network tab - AJAX request errors

## ✅ Verification Tests

Setelah deploy, test semua fitur:

### User Features
- [ ] Register akun baru
- [ ] Login user
- [ ] Edit profil
- [ ] Lihat daftar produk
- [ ] Buat pesanan
- [ ] Konfirmasi pesanan
- [ ] Lihat notifikasi
- [ ] Kirim pesan ke admin
- [ ] Google OAuth login

### Admin Features
- [ ] Login admin
- [ ] Lihat dashboard
- [ ] Manage produk (CRUD + multi-image)
- [ ] Manage pesanan (approve/reject)
- [ ] Lihat pesan dari user
- [ ] Kirim notifikasi broadcast
- [ ] View activity logs

### Critical Tests
- [ ] CSRF protection bekerja
- [ ] Session persistence
- [ ] File uploads (gambar produk)
- [ ] Database transactions
- [ ] Email notifications (jika enabled)
- [ ] WhatsApp integration (jika enabled)

---

**Last Updated:** December 19, 2025
**Application:** Sistem Informasi Pupuk & Bibit Subsidi
**Framework:** Laravel 12 + Tailwind CSS 4
