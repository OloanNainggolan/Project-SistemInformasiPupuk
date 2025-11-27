<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 🌾 Sistem Informasi Pupuk & Bibit Subsidi Pemerintah

Laravel 12 application untuk mengelola informasi produk pupuk dan bibit bersubsidi dengan sistem dual authentication (User & Admin).

---

## 🚨 UNTUK COLLABORATOR - WAJIB BACA!

### ⚠️ Setelah Pull/Clone Project

**Jika tampilan atau fitur tidak sesuai**, jalankan:

**Windows:**
```bash
clear-all-cache.bat
```

**Linux/Mac:**
```bash
chmod +x clear-all-cache.sh
./clear-all-cache.sh
```

**Manual:**
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
composer dump-autoload
```

📖 **Baca dokumentasi lengkap:** [README_COLLABORATOR.md](README_COLLABORATOR.md)
🔧 **Quick fix:** [QUICK_FIX.md](QUICK_FIX.md)

---

## 📋 Fitur Utama

### 👤 User
- Registrasi & Login
- Lihat katalog pupuk & bibit
- Dashboard user

### 👨‍💼 Admin
- Login khusus admin
- Dashboard admin dengan statistik
- Manajemen produk (CRUD)
- Multi-image upload (1-5 gambar per produk)

---

## 🛠️ Tech Stack

- **Framework:** Laravel 12.28.1
- **PHP:** 8.4.12
- **Database:** MySQL
- **Frontend:** Blade Templates + Tailwind CSS 4 + Vite
- **Icons:** Font Awesome 6.0.0

---

## 🚀 Quick Start

### 1. Clone Repository
```bash
git clone [repository-url]
cd [project-folder]
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
copy .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit `.env`:
```env
DB_DATABASE=sistem_informasi_pupukdanbibit
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:
```sql
CREATE DATABASE sistem_informasi_pupukdanbibit;
```

### 5. Migrate Database
```bash
php artisan migrate
```

### 6. Clear All Cache
```bash
clear-all-cache.bat
```

### 7. Run Development Server
```bash
php artisan serve
npm run dev
```

Akses: `http://127.0.0.1:8000`

---

## 🔑 Default Credentials

### Admin
- URL: `/admin/login`
- Username: `admin`
- Email: `admin@pupuksubsidi.id`
- Password: `admin123`

### User
- URL: `/login`
- Register terlebih dahulu di `/register`

---

## 📁 Struktur Project

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php      # Admin authentication & dashboard
│   │   ├── AuthController.php       # User authentication
│   │   └── ProductController.php    # Product CRUD
│   └── Middleware/
│       └── AdminAuth.php             # Custom admin middleware
├── Models/
│   ├── Product.php                   # Product model
│   ├── ProductImage.php              # Product images (1-5 per product)
│   └── User.php                      # User model

resources/views/
├── auth/
│   ├── login.blade.php               # User login (hijau theme)
│   ├── admin-login.blade.php         # Admin login (hijau theme + effects)
│   └── register.blade.php            # User registration
├── admin/
│   └── overview.blade.php            # Admin dashboard (TODO)
└── products/
    ├── index.blade.php               # Product list
    ├── create.blade.php              # Add product
    └── edit.blade.php                # Edit product
```

---

## 🎨 Design Guidelines

### Color Palette (Hijau Theme)
```css
--green-dark: #065f46
--green: #059669
--green-2: #047857
--green-light: #10b981
--mint: #ecfdf5
--gold: #fbbf24 (untuk admin badge)
```

### Layout
- **2-Column Grid** untuk login pages
- **Left:** Branding dengan animasi
- **Right:** Form dengan card putih
- **Responsive:** Stack vertikal di mobile

---

## 📚 Dokumentasi

- [README_LOGIN_ADMIN.md](README_LOGIN_ADMIN.md) - Sistem login admin
- [README_PRODUK.md](README_PRODUK.md) - CRUD produk & auto-fill
- [README_MULTIPLE_UPLOAD.md](README_MULTIPLE_UPLOAD.md) - Multi-image upload
- [README_ALUR_ADMIN.md](README_ALUR_ADMIN.md) - Alur lengkap admin
- [README_COLLABORATOR.md](README_COLLABORATOR.md) - **Panduan untuk tim**

---

## 🐛 Troubleshooting

### Tampilan tidak berubah setelah pull?
```bash
php artisan view:clear
php artisan cache:clear
# Hard refresh browser: Ctrl + Shift + R
```

### Error "Class not found"?
```bash
composer dump-autoload
```

### CSS/JS tidak update?
```bash
npm run dev
```

### Database error?
```bash
php artisan migrate:fresh
```

---

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request
6. **WAJIB:** Clear cache setelah merge!

---

## 📞 Contact

- **Owner:** OloanNainggolan
- **Repository:** Project-SistemInformasiPupuk
- **Current Branch:** sihiy

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## ⚡ Quick Commands

```bash
# Development
composer run dev          # Run all services (server + vite + logs)
php artisan serve        # Run server only
npm run dev             # Run Vite only

# Cache Management
php artisan optimize:clear    # Clear all cache (quick)
clear-all-cache.bat          # Clear all cache (comprehensive)

# Database
php artisan migrate           # Run migrations
php artisan migrate:fresh     # Fresh migration (reset DB)

# Testing
php artisan test             # Run tests
```

---

**INGAT:** Selalu clear cache setelah pull update! 🔄

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
