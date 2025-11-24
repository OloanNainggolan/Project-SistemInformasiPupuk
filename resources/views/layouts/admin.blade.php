<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Pupuk & Bibit Subsidi')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);
            min-height: 100vh;
            color: #333;
        }

        /* Header */
        .admin-header {
            background: #ffffff;
            padding: 15px 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-logo i {
            font-size: 30px;
            color: #4CAF50;
        }

        .header-logo h1 {
            font-size: 20px;
            font-weight: 700;
            color: #2d5016;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .header-nav a {
            color: #555;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s;
            position: relative;
        }

        .header-nav a:hover,
        .header-nav a.active {
            color: #4CAF50;
        }

        .header-nav a.active::after {
            content: '';
            position: absolute;
            bottom: -18px;
            left: 0;
            right: 0;
            height: 3px;
            background: #4CAF50;
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
        }

        .notification-icon i {
            font-size: 20px;
            color: #555;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f44336;
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Main Container */
        .admin-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
            min-height: calc(100vh - 250px);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
        }

        /* Footer */
        .admin-footer {
            background: #065f46;
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-section h3 {
            color: #fff;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 600;
        }

        .footer-section p {
            color: #d1fae5;
            line-height: 1.8;
            font-size: 14px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #d1fae5;
            text-decoration: none;
            transition: color 0.3s;
            font-size: 14px;
        }

        .footer-links a:hover {
            color: #fff;
        }

        .footer-links i {
            margin-right: 8px;
            width: 18px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
            color: #d1fae5;
            font-size: 13px;
            max-width: 1400px;
            margin: 0 auto;
            padding-left: 40px;
            padding-right: 40px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .admin-header {
                padding: 15px 20px;
            }

            .header-nav {
                display: none;
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                gap: 15px;
            }

            .header-nav.mobile-active {
                display: flex;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .admin-container {
                padding: 0 15px;
            }

            .footer-content {
                padding: 0 20px;
            }

            .footer-bottom {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        @stack('styles')
    </style>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-logo">
            <i class="fas fa-leaf"></i>
            <h1>Pupuk & Bibit Subsidi</h1>
        </div>
        
        <nav class="header-nav" id="headerNav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard', 'admin.overview') ? 'active' : '' }}">
                Overview
            </a>
            <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                Pesanan
            </a>
            <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
                Produk
            </a>
        </nav>
        
        <div class="header-icons">
            <a href="{{ route('admin.notifications') }}" class="notification-icon" title="Notifikasi" style="text-decoration: none;">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">0</span>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Pupuk Subsidi Indonesia</h3>
                <p>Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkelanjutan.</p>
            </div>
            <div class="footer-section">
                <h3>Menu Utama</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.orders') }}"><i class="fas fa-shopping-cart"></i> Pesanan</a></li>
                    <li><a href="{{ route('products.index') }}"><i class="fas fa-box"></i> Produk</a></li>
                    <li><a href="{{ route('admin.notifications') }}"><i class="fas fa-bell"></i> Notifikasi</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Sitoluama, Laguboti, Toba</li>
                    <li><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                    <li><i class="fas fa-envelope"></i> admin@pupukbibit.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} INFORMATION SYSTEMS - Del Institute of Technology. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // CSRF Token untuk semua AJAX request
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const nav = document.getElementById('headerNav');
            nav.classList.toggle('mobile-active');
        }
    </script>

    @stack('scripts')
</body>
</html>
