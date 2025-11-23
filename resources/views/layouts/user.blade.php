<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pupuk & Bibit Subsidi')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ========== STICKY HEADER ========== */
        .user-header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background-color: #d4a574;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .logo-text h1 {
            font-size: 18px;
            color: #2d5016;
            font-weight: 600;
            margin: 0;
        }

        .logo-text p {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s;
            position: relative;
            padding: 5px 0;
        }

        .nav-menu a:hover {
            color: #4CAF50;
        }

        .nav-menu a.active {
            color: #4CAF50;
            font-weight: 600;
        }

        .nav-menu a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #4CAF50;
            border-radius: 2px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            font-size: 20px;
            color: #333;
            cursor: pointer;
            transition: color 0.3s;
        }

        .notification-icon:hover {
            color: #4CAF50;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #f44336;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .profile-section {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 5px 12px;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        .profile-section:hover {
            background-color: #f5f5f5;
        }

        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 200px;
            margin-top: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .profile-section:hover .profile-dropdown {
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

        .dropdown-item:first-child {
            border-radius: 8px 8px 0 0;
        }

        .dropdown-item:last-child {
            border-bottom: none;
            border-radius: 0 0 8px 8px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item i {
            width: 20px;
            color: #4CAF50;
            font-size: 16px;
        }

        .dropdown-item.logout {
            color: #f44336;
        }

        .dropdown-item.logout i {
            color: #f44336;
        }

        .dropdown-item.logout:hover {
            background-color: #ffebee;
        }

        .profile-avatar {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
        }
        
        .profile-avatar i {
            font-size: 11px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }

        .profile-role {
            font-size: 12px;
            color: #666;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        /* Content Area dengan padding untuk sticky header */
        .content-wrapper {
            flex: 1;
            margin-top: 80px; /* Tinggi header */
            min-height: calc(100vh - 80px);
        }

        /* ========== FOOTER ========== */
        footer {
            background-color: #065f46;
            color: white;
            padding: 40px 50px 20px;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-logo h2 {
            color: #FFF;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .footer-logo p {
            line-height: 1.8;
            color: #d1fae5;
            font-size: 14px;
        }

        .footer-section h3 {
            margin-bottom: 15px;
            color: #FFF;
            font-size: 16px;
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
            color: #FFF;
        }

        .footer-links i {
            margin-right: 8px;
            width: 20px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
            color: #d1fae5;
            font-size: 14px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .header-container {
                padding: 15px 30px;
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }

            footer {
                padding: 30px 30px 20px;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .header-container {
                padding: 15px 20px;
            }

            .nav-menu {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                background-color: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 5px 10px rgba(0,0,0,0.1);
                transition: left 0.3s;
                gap: 15px;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-menu a {
                width: 100%;
                padding: 10px;
                border-bottom: 1px solid #f0f0f0;
            }

            .profile-info {
                display: none;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            footer {
                padding: 25px 20px 15px;
            }

            .content-wrapper {
                margin-top: 80px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sticky Header -->
    <header class="user-header">
        <div class="header-container">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo">
                    🌾
                </div>
                <div class="logo-text">
                    <h1>Pupuk & Bibit Subsidi</h1>
                    <p>Sistem Informasi Pertanian</p>
                </div>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navigation Menu -->
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('pupuk.bibit') }}" class="{{ request()->routeIs('pupuk.bibit') ? 'active' : '' }}">Pupuk & Bibit</a></li>
                <li><a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a></li>
            </ul>

            <!-- Right Section -->
            <div class="header-right">
                <!-- Notification Icon -->
                <a href="{{ route('notifikasi') }}" class="notification-icon" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </a>

                <!-- Profile Section with Dropdown -->
                <div class="profile-section">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">User Petani</span>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="profile-dropdown">
                        <a href="{{ route('profil.user') }}" class="dropdown-item">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('profil.edit') }}" class="dropdown-item">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
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
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <!-- Branding Section -->
            <div class="footer-logo">
                <h2>Pupuk Subsidi Indonesia</h2>
                <p>Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkelanjutan.</p>
            </div>

            <!-- Menu Links -->
            <div class="footer-section">
                <h3>Menu Utama</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="{{ route('pupuk.bibit') }}"><i class="fas fa-seedling"></i> Pupuk & Bibit</a></li>
                    <li><a href="{{ route('profil.user') }}"><i class="fas fa-user"></i> Profil</a></li>
                    <li><a href="{{ route('kontak') }}"><i class="fas fa-envelope"></i> Kontak</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h3>Hubungi Kami</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Sitoluama, Laguboti, Toba</li>
                    <li><i class="fas fa-phone"></i> +62 813 2323 09</li>
                    <li><i class="fas fa-envelope"></i> info@pupuksubsidi.id</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} INFORMATION SYSTEMS - Del Institute of Technology. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (!navMenu.contains(event.target) && !toggle.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });

        // Close mobile menu when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                document.getElementById('navMenu').classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
