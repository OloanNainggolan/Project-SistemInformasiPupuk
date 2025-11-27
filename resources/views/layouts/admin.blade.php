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

        /* Modern Header - Matching User Header Style */
        .admin-header {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid #10b981;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .header-logo:hover {
            transform: translateY(-2px);
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }

        .logo-icon i {
            font-size: 24px;
            color: white;
        }

        .logo-text h1 {
            font-size: 17px;
            font-weight: 700;
            color: #065f46;
            letter-spacing: 0.3px;
            margin: 0;
        }

        .logo-text p {
            font-size: 12px;
            color: #059669;
            font-weight: 500;
            margin: 0;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 10px;
            color: #374151;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: relative;
        }

        .nav-link i {
            font-size: 16px;
            color: #10b981;
            transition: all 0.3s ease;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(135deg, #10b981, #059669);
            transition: width 0.3s ease;
            border-radius: 10px 10px 0 0;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            color: #065f46;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16,185,129,0.2);
        }

        .nav-link:hover i {
            transform: scale(1.2);
            color: #059669;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }

        .nav-link.active i {
            color: white;
        }

        .nav-link.active::before {
            display: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-link {
            position: relative;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            color: #374151;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .notification-link i {
            font-size: 18px;
            color: #10b981;
            transition: all 0.3s ease;
        }

        .notification-link:hover {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16,185,129,0.2);
        }

        .notification-link:hover i {
            transform: scale(1.2);
            color: #059669;
        }

        .notification-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 50%;
            width: 8px;
            height: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }

        /* Admin Profile Section */
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .admin-profile:hover {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16,185,129,0.2);
        }

        .admin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 15px;
            box-shadow: 0 2px 8px rgba(16,185,129,0.3);
            border: 2px solid white;
        }

        .admin-info .admin-name {
            font-size: 14px;
            font-weight: 600;
            color: #065f46;
            line-height: 1;
        }

        .admin-info .admin-role {
            font-size: 11px;
            color: #059669;
            font-weight: 500;
        }

        .admin-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            min-width: 200px;
            margin-top: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
            overflow: hidden;
        }

        .admin-profile:hover .admin-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s;
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item i {
            width: 20px;
            color: #10b981;
            font-size: 16px;
        }

        .dropdown-item.logout {
            color: #ef4444;
        }

        .dropdown-item.logout i {
            color: #ef4444;
        }

        .dropdown-item.logout:hover {
            background-color: #fee2e2;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }

        /* Main Container */
        .admin-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
            min-height: calc(100vh - 250px);
        }

        /* Modern Footer */
        .admin-footer {
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
            color: white;
            padding: 50px 0 0;
            margin-top: 60px;
            position: relative;
            overflow: hidden;
        }

        .admin-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #34d399, #6ee7b7, #34d399, #10b981);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-logo {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .footer-logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            margin-bottom: 10px;
        }

        .footer-logo-icon i {
            font-size: 30px;
            color: white;
        }

        .footer-logo h2 {
            color: #FFF;
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .footer-logo p {
            line-height: 1.8;
            color: #d1fae5;
            font-size: 14px;
            margin-top: 10px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
            color: #FFF;
            font-size: 18px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #34d399);
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 14px;
        }

        .footer-links a {
            color: #d1fae5;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .footer-links a:hover {
            color: #FFF;
            transform: translateX(5px);
        }

        .footer-links i {
            width: 20px;
            color: #10b981;
            font-size: 16px;
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            color: #d1fae5;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-contact-item i {
            color: #10b981;
            font-size: 18px;
            margin-top: 2px;
            min-width: 20px;
        }

        .footer-bottom {
            text-align: center;
            padding: 25px 40px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #d1fae5;
            font-size: 14px;
            background: rgba(0, 0, 0, 0.2);
        }

        .footer-bottom a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .footer-bottom a:hover {
            color: #34d399;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }

            .footer-logo {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 15px 20px;
            }

            .header-nav {
                display: none;
                position: fixed;
                top: 80px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                align-items: stretch;
                padding: 20px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                gap: 10px;
            }

            .header-nav.mobile-active {
                display: flex;
            }

            .header-nav .nav-link {
                width: 100%;
                justify-content: flex-start;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .admin-info {
                display: none;
            }

            .admin-container {
                padding: 0 15px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                padding: 0 20px;
            }

            .footer-logo {
                grid-column: auto;
            }

            .footer-bottom {
                padding: 20px;
                font-size: 12px;
            }
        }

        @stack('styles')
    </style>
</head>
<body>
    <!-- Modern Header -->
    <header class="admin-header">
        <div class="header-container">
            <!-- Logo Section -->
            <a href="{{ route('admin.dashboard') }}" class="header-logo">
                <div class="logo-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="logo-text">
                    <h1>Pupuk & Bibit Subsidi</h1>
                    <p>Panel Admin</p>
                </div>
            </a>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navigation -->
            <nav class="header-nav" id="headerNav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard', 'admin.overview') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Overview</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>Produk</span>
                </a>
            </nav>
            
            <!-- Right Section -->
            <div class="header-right">
                <!-- Notification -->
                <a href="{{ route('admin.notifications') }}" class="notification-link" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge"></span>
                </a>

                <!-- Admin Profile -->
                <div class="admin-profile">
                    <div class="admin-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="admin-info">
                        <div class="admin-name">Administrator</div>
                        <div class="admin-role">Admin Panel</div>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="admin-dropdown">
                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout" style="width: 100%; border: none; background: none; text-align: left; cursor: pointer; font-family: inherit; font-size: inherit;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="footer-content">
            <!-- Branding Section -->
            <div class="footer-logo">
                <div class="footer-logo-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h2>Pupuk Subsidi Indonesia</h2>
                <p>Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkelanjutan.</p>
            </div>
            <div class="footer-section">
                <h3>Menu Admin</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                    <li><a href="{{ route('admin.orders') }}"><i class="fas fa-shopping-cart"></i>Pesanan</a></li>
                    <li><a href="{{ route('products.index') }}"><i class="fas fa-box"></i>Produk</a></li>
                    <li><a href="{{ route('admin.notifications') }}"><i class="fas fa-bell"></i>Notifikasi</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Hubungi Kami</h3>
                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Jl. Sitoluama, Laguboti, Toba</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+62 812-3456-7890</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>admin@pupukbibit.com</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} INFORMATION SYSTEMS - <a href="https://www.del.ac.id" target="_blank">Del Institute of Technology</a>. All rights reserved.</p>
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

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const nav = document.getElementById('headerNav');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (nav && toggle && !nav.contains(event.target) && !toggle.contains(event.target)) {
                nav.classList.remove('mobile-active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
