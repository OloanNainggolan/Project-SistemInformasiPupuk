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
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0;
            border-bottom: 3px solid #004d00;
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
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .logo-section:hover {
            transform: translateY(-2px);
        }

        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #004d00, #047857);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 15px #004d00;
        }

        .logo i {
            color: white;
            font-size: 24px;
        }

        .logo-text h1 {
            font-size: 17px;
            color: #004d00;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.3px;
        }

        .logo-text p {
            font-size: 12px;
            color: #004d00;
            font-weight: 500;
            margin: 0;
        }

        .nav-menu {
            display: flex;
            gap: 8px;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: #374151;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
            padding: 10px 16px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .nav-menu a i {
            font-size: 16px;
            color: #10b981;
            transition: all 0.3s ease;
        }

        .nav-menu a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(135deg, #004d00, #047857);
            transition: width 0.3s ease;
            border-radius: 10px 10px 0 0;
        }

        .nav-menu a:hover::before {
            width: 100%;
        }

        .nav-menu a:hover {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            color: #065f46;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16,185,129,0.2);
        }

        .nav-menu a:hover i {
            transform: scale(1.2);
            color: #047857;
        }

        .nav-menu a.active {
            background: linear-gradient(135deg, #004d00, #047857);
            color: white;
            box-shadow: 0 4px 15px rgba(16,185,129,0.3);
        }

        .nav-menu a.active i {
            color: white;
        }

        .nav-menu a.active::before {
            display: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notification-icon {
            position: relative;
            font-size: 18px;
            color: #374151;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 10px 12px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: inline-flex;
            align-items: center;
        }

        .notification-icon i {
            color: #004d00;
        }

        .notification-icon:hover {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16,185,129,0.2);
        }

        .notification-icon:hover i {
            transform: scale(1.2);
            color: #047857;
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
            font-size: 10px;
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

        .profile-section {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .profile-section:hover {
            background: linear-gradient(135deg, #dcfce7, #d1fae5);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16,185,129,0.2);
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
            color: #004d00;
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

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #004d00, #047857);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(16,185,129,0.3);
            border: 2px solid white;
            flex-shrink: 0;
        }
        
        .profile-avatar i {
            font-size: 15px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-size: 14px;
            font-weight: 600;
            color: #065f46;
            white-space: nowrap;
            line-height: 1;
        }

        .profile-role {
            font-size: 11px;
            color: #047857;
            font-weight: 500;
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
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
            color: white;
            padding: 60px 50px 0;
            margin-top: auto;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #004d00, #047857, #065f46, #047857, #004d00);
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
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 50px;
        margin-bottom: 40px;
    }        .footer-logo {
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

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer-social a:hover {
            background: #004d00;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 77, 0, 0.4);
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
            background: linear-gradient(90deg, #004d00, #047857);
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
            color: #004d00;
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
            color: #004d00;
            font-size: 18px;
            margin-top: 2px;
            min-width: 20px;
        }

        .footer-bottom {
            text-align: center;
            padding: 25px 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #d1fae5;
            font-size: 14px;
            background: rgba(0, 0, 0, 0.2);
            margin: 0 -50px;
            padding-left: 50px;
            padding-right: 50px;
        }

        .footer-bottom p {
            margin: 0;
        }

        .footer-bottom a {
            color: #004d00;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .footer-bottom a:hover {
            color: #047857;
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

            .footer-logo {
                grid-column: 1 / -1;
            }

            footer {
                padding: 50px 30px 0;
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
                gap: 30px;
            }

            .footer-logo {
                grid-column: auto;
            }

            footer {
                padding: 40px 20px 0;
            }

            .footer-bottom {
                font-size: 12px;
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
            <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                <div class="logo-section">
                    <div class="logo">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Pupuk & Bibit Subsidi</h1>
                        <p>Sistem Informasi Pemerintah</p>
                    </div>
                </div>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navigation Menu -->
            <ul class="nav-menu" id="navMenu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pupuk.bibit') }}" class="{{ request()->routeIs('pupuk.bibit') ? 'active' : '' }}">
                        <i class="fas fa-leaf"></i>
                        <span>Pupuk & Bibit</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Kontak</span>
                    </a>
                </li>
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
                        @if(auth()->user()->foto)
                            <img src="{{ asset(auth()->user()->foto) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div class="profile-info">
                        <span class="profile-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'User' }}</span>
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
                <div class="footer-logo-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h2>Pupuk Subsidi Indonesia</h2>
                <p>Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkelanjutan.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Menu Links -->
            <div class="footer-section">
                <h3>Menu Utama</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i>Beranda</a></li>
                    <li><a href="{{ route('pupuk.bibit') }}"><i class="fas fa-seedling"></i>Pupuk & Bibit</a></li>
                    <li><a href="{{ route('profil.user') }}"><i class="fas fa-user"></i>Profil</a></li>
                    <li><a href="{{ route('kontak') }}"><i class="fas fa-envelope"></i>Kontak</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h3>Hubungi Kami</h3>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Jl. Sitoluama, Laguboti, Toba</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>+62 813 2323 09</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span>info@pupuksubsidi.id</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} INFORMATION SYSTEMS - <a href="https://www.del.ac.id" target="_blank">Del Institute of Technology</a>. All Rights Reserved.</p>
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
