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

        :root {
            --green-dark: #065f46;
            --green: #059669;
            --green-light: #10b981;
            --mint: #ecfdf5;
            --gold: #fbbf24;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 50%, #dcfce7 100%);
            min-height: 100vh;
            color: #1f2937;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(5, 150, 105, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* Header Modern */
        .admin-header {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            padding: 0;
            box-shadow: 0 4px 20px rgba(6, 95, 70, 0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 2px solid var(--green);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .header-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .logo-icon-wrapper {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
            position: relative;
            overflow: hidden;
        }

        .logo-icon-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .logo-icon-wrapper i {
            font-size: 26px;
            color: white;
            z-index: 1;
        }

        .header-logo h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--green-dark);
            letter-spacing: -0.5px;
        }

        .admin-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--gold) 0%, #f59e0b 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 10px rgba(251, 191, 36, 0.3);
            margin-left: 10px;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .header-nav a {
            color: #4b5563;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            position: relative;
            padding: 10px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-nav a i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .header-nav a:hover {
            color: var(--green);
            background: rgba(5, 150, 105, 0.08);
        }

        .header-nav a:hover i {
            transform: scale(1.1);
        }

        .header-nav a.active {
            color: white;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            width: 45px;
            height: 45px;
            background: var(--mint);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .notification-icon:hover {
            background: var(--green);
            border-color: var(--green-light);
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .notification-icon i {
            font-size: 20px;
            color: var(--green-dark);
            transition: all 0.3s ease;
        }

        .notification-icon:hover i {
            color: white;
            transform: rotate(15deg) scale(1.1);
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 10px;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            padding: 0 6px;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            background: var(--mint);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .profile-trigger:hover {
            background: white;
            border-color: var(--green);
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: 700;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--green-dark);
            line-height: 1.2;
        }

        .profile-role {
            font-size: 11px;
            color: #6b7280;
            font-weight: 600;
        }

        .profile-arrow {
            color: var(--green);
            font-size: 12px;
            margin-left: 5px;
            transition: transform 0.3s ease;
        }

        .profile-dropdown.active .profile-arrow {
            transform: rotate(180deg);
        }

        .profile-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            padding: 8px;
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            border: 2px solid var(--mint);
        }

        .profile-dropdown.active .profile-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-menu-header {
            padding: 12px 15px;
            border-bottom: 2px solid var(--mint);
            margin-bottom: 8px;
        }

        .profile-menu-header .profile-name {
            font-size: 15px;
            margin-bottom: 2px;
        }

        .profile-menu-header .profile-email {
            font-size: 12px;
            color: #6b7280;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-menu-item:hover {
            background: var(--mint);
            color: var(--green-dark);
        }

        .profile-menu-item i {
            width: 18px;
            font-size: 16px;
            color: var(--green);
        }

        .profile-menu-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 8px 0;
        }

        .profile-menu-item.logout {
            color: #ef4444;
        }

        .profile-menu-item.logout:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .profile-menu-item.logout i {
            color: #ef4444;
        }

        /* Main Container */
        .admin-container {
            max-width: 1600px;
            margin: 30px auto;
            padding: 0 40px;
            min-height: calc(100vh - 250px);
            position: relative;
            z-index: 1;
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

        /* Footer Modern */
        .admin-footer {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);
            color: white;
            padding: 50px 0 0;
            margin-top: 80px;
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
            background: linear-gradient(90deg, var(--green-light), var(--gold), var(--green-light));
            background-size: 200% 100%;
            animation: gradientMove 3s linear infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        .admin-footer::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .footer-content {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 40px 40px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 50px;
            position: relative;
            z-index: 1;
        }

        .footer-section h3 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-section h3 i {
            color: var(--gold);
            font-size: 20px;
        }

        .footer-section p {
            color: #d1fae5;
            line-height: 1.8;
            font-size: 14px;
            margin-bottom: 20px;
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
            transition: all 0.3s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 5px 0;
        }

        .footer-links a:hover {
            color: #fff;
            padding-left: 10px;
        }

        .footer-links i {
            width: 18px;
            color: var(--green-light);
        }

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-icon:hover {
            background: white;
            color: var(--green-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .footer-bottom {
            text-align: center;
            padding: 25px 40px;
            border-top: 1px solid rgba(255,255,255,0.15);
            color: #a7f3d0;
            font-size: 14px;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1600px;
            margin: 0 auto;
        }

        .footer-bottom-left {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .footer-bottom-left i {
            color: #ef4444;
            animation: heartbeat 1.5s infinite;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.2); }
            50% { transform: scale(1); }
        }

        .footer-bottom-right {
            color: #6ee7b7;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .admin-header {
                padding: 15px 20px;
            }

            .header-container {
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
                padding: 0 20px 30px;
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                padding: 20px;
                flex-direction: column;
                gap: 10px;
            }
        }

        @stack('styles')
    </style>
</head>
<body>
    <!-- Header Modern -->
    <header class="admin-header">
        <div class="header-container">
            <div class="header-logo">
                <div class="logo-icon-wrapper">
                    <i class="fas fa-leaf"></i>
                </div>
                <div>
                    <h1>Pupuk & Bibit Subsidi<span class="admin-badge">Admin</span></h1>
                </div>
            </div>
            
            <nav class="header-nav" id="headerNav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard', 'admin.overview') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Overview</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i>
                    <span>Produk</span>
                </a>
            </nav>
            
            <div class="header-icons">
                <a href="{{ route('admin.notifications') }}" class="notification-icon" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">0</span>
                </a>
                
                <!-- Profile Dropdown -->
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-trigger" onclick="toggleProfileMenu()">
                        <div class="profile-avatar">
                            @if(session('admin_avatar'))
                                <img src="{{ asset(session('admin_avatar')) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="fas fa-user-shield"></i>
                            @endif
                        </div>
                        <div class="profile-info">
                            <span class="profile-name">{{ session('admin_name', session('admin_username', 'Admin')) }}</span>
                            <span class="profile-role">Administrator</span>
                        </div>
                        <i class="fas fa-chevron-down profile-arrow"></i>
                    </div>
                    
                    <div class="profile-menu">
                        <div class="profile-menu-header">
                            <div class="profile-name">{{ session('admin_name', session('admin_username', 'Admin')) }}</div>
                            <div class="profile-email">{{ session('admin_email', 'admin@pupuksubsidi.id') }}</div>
                        </div>
                        
                        <a href="{{ route('admin.profil') }}" class="profile-menu-item">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                        
                        <a href="{{ route('admin.profil.edit') }}" class="profile-menu-item">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                        
                        <div class="profile-menu-divider"></div>
                        
                        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="profile-menu-item logout" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
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

    <!-- Footer Modern -->
    <footer class="admin-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-seedling"></i> Pupuk Subsidi Indonesia</h3>
                <p>Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkelanjutan.</p>
                <div class="footer-social">
                    <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3><i class="fas fa-link"></i> Menu Utama</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="{{ route('admin.orders') }}"><i class="fas fa-shopping-cart"></i> Pesanan</a></li>
                    <li><a href="{{ route('products.index') }}"><i class="fas fa-box-open"></i> Produk</a></li>
                    <li><a href="{{ route('admin.notifications') }}"><i class="fas fa-bell"></i> Notifikasi</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3><i class="fas fa-phone-alt"></i> Kontak Kami</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Sitoluama, Laguboti, Toba</li>
                    <li><i class="fas fa-phone"></i> +62 812-3456-7890</li>
                    <li><i class="fas fa-envelope"></i> admin@pupukbibit.com</li>
                    <li><i class="fas fa-clock"></i> Sen-Jum: 08:00 - 17:00</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <span>Made with</span>
                <i class="fas fa-heart"></i>
                <span>by INFORMATION SYSTEMS - Del Institute of Technology</span>
            </div>
            <div class="footer-bottom-right">
                &copy; {{ date('Y') }} All Rights Reserved
            </div>
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
        
        // Profile dropdown toggle
        function toggleProfileMenu() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('active');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const trigger = dropdown.querySelector('.profile-trigger');
            
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
