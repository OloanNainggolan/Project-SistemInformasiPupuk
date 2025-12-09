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
    
    <!-- Global Standards CSS -->
    <link rel="stylesheet" href="{{ asset('css/global-standards.css') }}">
    
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
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f9fafb;
            min-height: 100vh;
            color: #1f2937;
            line-height: 1.6;
        }

        /* ========== HEADER ========== */
        .admin-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafb 100%);
            border-bottom: 3px solid #10b981;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 65px;
        }

        .header-container {
            max-width: 100%;
            margin: 0;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        /* Logo */
        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo-section:hover {
            transform: translateY(-2px);
        }

        .logo {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }

        .logo-section:hover .logo {
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
            transform: scale(1.05);
        }

        .logo i {
            color: white;
            font-size: 22px;
        }

        .logo-text h1 {
            font-size: 16px;
            color: #065f46;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .logo-text p {
            font-size: 11px;
            color: #059669;
            font-weight: 500;
            margin: 0;
            line-height: 1.2;
        }

        /* Navigation */
        .nav-menu {
            display: flex;
            gap: 8px;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
            position: relative;
            height: 44px;
            min-width: 160px;
            justify-content: center;
            border: none;
        }

        .nav-link i {
            font-size: 16px;
            color: white;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .nav-link span {
            font-size: 14px;
            font-weight: 600;
            line-height: 1;
            color: white;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
        }

        .nav-link:hover i {
            transform: scale(1.1);
            color: white;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: white;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.5);
            transform: scale(1.05);
        }

        .nav-link.active i {
            color: white;
        }

        .nav-link.active span {
            color: white;
        }

        /* Right Section */
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* All nav items have consistent styling - no special cases */

        .nav-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 12px;
            min-width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            padding: 0 6px;
            border: 2px solid white;
            animation: pulseBadge 2s infinite;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
            z-index: 10;
        }

        @keyframes pulseBadge {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.15); opacity: 0.9; }
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 16px 4px 4px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 56px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            min-width: 200px;
        }

        .profile-button:hover {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-color: #10b981;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .profile-avatar {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .profile-button:hover .profile-avatar {
            transform: scale(1.1);
            box-shadow: 0 3px 10px rgba(16, 185, 129, 0.4);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 3px;
            flex: 1;
            min-width: 0;
        }

        .profile-name {
            font-size: 14px;
            font-weight: 700;
            color: #065f46;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            display: block;
        }

        .profile-role {
            font-size: 11px;
            color: #10b981;
            line-height: 1.3;
            font-weight: 600;
            white-space: nowrap;
            display: block;
        }

        .profile-chevron {
            color: #9ca3af;
            font-size: 12px;
            transition: transform 0.3s ease;
            flex-shrink: 0;
            margin-left: 4px;
        }

        .profile-dropdown.active .profile-chevron {
            transform: rotate(180deg);
            color: #10b981;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            min-width: 240px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.25s ease;
            border: 1px solid #e5e7eb;
            z-index: 1000;
        }

        .profile-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        .dropdown-header-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 4px;
        }

        .dropdown-header-email {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            text-align: left;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: var(--green-dark);
        }

        .dropdown-item i {
            font-size: 15px;
            width: 20px;
            text-align: center;
            color: #10b981;
        }

        .dropdown-item.logout {
            color: #ef4444;
            border-top: 1px solid #e5e7eb;
        }

        .dropdown-item.logout:hover {
            background: #fee2e2;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            background: var(--green);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
        }

        /* ========== MAIN CONTAINER ========== */
        .admin-main {
            min-height: auto;
            margin-top: 65px;
            padding-bottom: 40px;
        }

        /* ========== FOOTER ========== */
        .admin-footer {
            background: linear-gradient(135deg, #1a5e3a, #2d7a50);
            color: white;
            padding: 40px 0 0;
            margin-top: 60px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 30px;
        }

        .footer-section h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }

        .footer-about {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-brand i {
            font-size: 40px;
            color: white;
        }

        .footer-brand-text h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .footer-brand-text p {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .footer-description {
            font-size: 14px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.85);
            margin-top: 8px;
        }

        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .social-link:hover {
            background: white;
            color: var(--green-dark);
            transform: translateY(-3px);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 8px;
        }

        .footer-links a i {
            font-size: 14px;
            width: 16px;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
        }

        .footer-contact li {
            margin-bottom: 14px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-contact li i {
            font-size: 16px;
            color: white;
            margin-top: 2px;
            min-width: 20px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 24px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer-bottom-content {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
        }

        .footer-bottom-content i {
            font-size: 18px;
            color: white;
        }

        .footer-bottom-content strong {
            color: white;
            font-weight: 600;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 20px;
                height: 65px;
            }

            .admin-header {
                height: 65px;
            }

            .admin-main {
                margin-top: 65px;
            }

            .nav-menu {
                position: fixed;
                top: 65px;
                left: -100%;
                width: 100%;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transition: left 0.3s ease;
                gap: 8px;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-link {
                width: 100%;
                justify-content: flex-start;
            }

            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .profile-info {
                display: none;
            }

            .logo-text h1 {
                font-size: 14px;
            }

            .logo-text p {
                font-size: 10px;
            }

            .logo {
                width: 38px;
                height: 38px;
            }

            .logo i {
                font-size: 18px;
            }

            .footer-container {
                padding: 0 20px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
                gap: 4px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-container">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="logo-section">
                <div class="logo">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="logo-text">
                    <h1>Pupuk & Bibit Subsidi</h1>
                    <p>Sistem Informasi Pemerintah</p>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="nav-menu" id="navMenu">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Overview</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>Produk</span>
                </a>
                <a href="{{ route('admin.notifications.create') }}" class="nav-link {{ request()->routeIs('admin.notifications.create') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirim Notifikasi</span>
                </a>
                <a href="{{ route('admin.messages.inbox') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Pesan Masuk</span>
                    @php
                        $unreadMessages = \App\Models\Message::fromUser()->unread()->count();
                        $newUsersToday = \App\Models\User::whereDate('created_at', today())->count();
                        $totalUnread = $unreadMessages + $newUsersToday;
                    @endphp
                    @if($totalUnread > 0)
                        <span class="nav-badge">{{ $totalUnread }}</span>
                    @endif
                </a>
            </nav>

            <!-- Right Section -->
            <div class="header-right">
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Profile Dropdown -->
                <div class="profile-dropdown" id="profileDropdown">
                    <button class="profile-button" onclick="toggleProfileDropdown()">
                        <div class="profile-avatar">
                            {{ strtoupper(substr(session('admin_name', 'Administrator Sistem'), 0, 1)) }}
                        </div>
                        <div class="profile-info">
                            <span class="profile-name">{{ session('admin_name', 'Administrator Sistem') }}</span>
                            <span class="profile-role">Super Admin</span>
                        </div>
                        <i class="fas fa-chevron-down profile-chevron"></i>
                    </button>

                    <div class="dropdown-menu">
                        <div class="dropdown-header">
                            <div class="dropdown-header-name">{{ session('admin_name', 'Administrator Sistem') }}</div>
                            <div class="dropdown-header-email">{{ session('admin_email', 'admin@pupuksubsidi.id') }}</div>
                        </div>
                        <a href="{{ route('admin.profil') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('admin.profil.edit') }}" class="dropdown-item">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="admin-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-section footer-about">
                    <div class="footer-brand">
                        <i class="fas fa-seedling"></i>
                        <div class="footer-brand-text">
                            <h3>Pupuk Subsidi Indonesia</h3>
                            <p>Program Pemerintah untuk Petani</p>
                        </div>
                    </div>
                    <p class="footer-description">
                        Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkualitas.
                    </p>
                    <div class="follow-us">
                        <p style="font-size: 14px; margin-bottom: 8px; font-weight: 600;">Follow us!</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Menu Links -->
                <div class="footer-section">
                    <h3>Menu Utama</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-angle-right"></i> Overview</a></li>
                        <li><a href="{{ route('admin.orders') }}"><i class="fas fa-angle-right"></i> Pesanan</a></li>
                        <li><a href="{{ route('admin.products.index') }}"><i class="fas fa-angle-right"></i> Produk</a></li>
                        <li><a href="{{ route('admin.notifications.index') }}"><i class="fas fa-angle-right"></i> Notifikasi</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Jl. Sitoluama, Laguboti, Toba</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>+91 91813 23 2309</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>hello@squareup.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <i class="fas fa-landmark"></i>
                    <span><strong>INFORMATION SYSTEMS</strong> Del Institute of Technology</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle Mobile Menu
        function toggleMobileMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }

        // Toggle Profile Dropdown
        function toggleProfileDropdown() {
            document.getElementById('profileDropdown').classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const navMenu = document.getElementById('navMenu');
            
            if (!event.target.closest('#profileDropdown')) {
                profileDropdown.classList.remove('active');
            }
            
            if (!event.target.closest('.mobile-menu-toggle') && !event.target.closest('#navMenu')) {
                navMenu.classList.remove('active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
