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
            gap: 6px;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            color: #374151;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #059669);
            transition: width 0.3s ease;
            border-radius: 10px 10px 0 0;
        }

        .nav-link i {
            font-size: 15px;
            color: #10b981;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #065f46;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover i {
            transform: scale(1.15) rotate(5deg);
            color: #059669;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .nav-link.active i {
            color: white;
        }

        .nav-link.active::before {
            display: none;
        }

        /* Right Section */
        .header-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Notification Bell */
        .notification-bell {
            position: relative;
            color: #374151;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 10px 12px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .notification-bell i {
            color: #10b981;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .notification-bell:hover {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .notification-bell:hover i {
            transform: scale(1.15) rotate(-10deg);
            color: #059669;
        }

        .notification-badge {
            position: absolute;
            top: 3px;
            right: 3px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            padding: 0 4px;
            border: 2px solid white;
            animation: pulseBadge 2s infinite;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
        }

        @keyframes pulseBadge {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 48px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .profile-button:hover {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-color: #10b981;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }

        .profile-button:hover .profile-avatar {
            transform: scale(1.1);
            box-shadow: 0 3px 10px rgba(16, 185, 129, 0.4);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
            min-width: 120px;
        }

        .profile-name {
            font-size: 12px;
            font-weight: 600;
            color: #065f46;
            line-height: 1.2;
        }

        .profile-role {
            font-size: 10px;
            color: #059669;
            line-height: 1.2;
            font-weight: 500;
        }

        .profile-chevron {
            color: #9ca3af;
            font-size: 11px;
            transition: transform 0.3s ease;
        }

        .profile-dropdown.active .profile-chevron {
            transform: rotate(180deg);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            border: 1px solid #e5e7eb;
        }

        .profile-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .dropdown-header-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--green-dark);
        }

        .dropdown-header-email {
            font-size: 12px;
            color: #6b7280;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
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
            background: var(--mint);
            color: var(--green-dark);
        }

        .dropdown-item i {
            font-size: 16px;
            width: 20px;
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
            padding-top: 30px;
            padding-bottom: 40px;
        }

        /* ========== FOOTER ========== */
        .admin-footer {
            background: linear-gradient(135deg, #0d4a2c 0%, #1a6b3f 50%, #2d8f4f 100%);
            color: white;
            padding: 60px 0 0;
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
            height: 3px;
            background: linear-gradient(90deg, #ffd700, #64c864, #ffd700);
        }

        .admin-footer::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 215, 0, 0.3), rgba(100, 200, 100, 0.3), rgba(255, 215, 0, 0.3));
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .footer-columns {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 50px;
            padding-bottom: 50px;
        }

        .footer-col h3 {
            color: #ffd700;
            font-size: 1.5em;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: linear-gradient(90deg, #ffd700, rgba(255, 215, 0, 0));
            border-radius: 1px;
        }

        .footer-col:hover h3 {
            color: #ffed4e;
        }

        .footer-col h3 i {
            font-size: 1.3em;
            transition: transform 0.3s ease;
        }

        .footer-col:hover h3 i {
            transform: scale(1.1) rotate(5deg);
        }

        .footer-col p {
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.8;
            margin-bottom: 0;
            font-size: 1.05em;
            font-weight: 400;
            letter-spacing: 0.2px;
        }

        /* Footer Links */
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.92);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.28s cubic-bezier(.2,.8,.2,1);
            font-size: 1em;
            font-weight: 500;
            letter-spacing: 0.2px;
            padding-left: 0;
        }

        .footer-links a i {
            font-size: 0.9em;
            transition: transform 0.28s ease, color 0.28s ease;
            color: rgba(255, 215, 0, 0.95);
            width: 18px;
            text-align: center;
        }

        .footer-links a:hover {
            color: #ffd700;
            padding-left: 8px;
        }

        .footer-links a:hover i {
            transform: translateX(4px) scale(1.02);
            color: #fff6d6;
        }

        /* Contact Links Styling */
        .contact-links a {
            flex-direction: row;
            align-items: center;
            gap: 12px;
            padding-left: 0;
        }

        .contact-links a i {
            width: auto;
            color: rgba(255, 215, 0, 0.95);
            transition: transform 0.28s ease, color 0.28s ease;
            font-size: 1em;
            flex-shrink: 0;
        }

        .contact-links a span {
            display: block;
            font-size: 0.95em;
        }

        .contact-links a:hover {
            padding-left: 0;
            color: #ffd700;
        }

        .contact-links a:hover i {
            transform: scale(1.15) rotate(5deg);
            color: #fff6d6;
        }

        /* Footer Bottom - full width band */
        .footer-bottom {
            width: 100%;
            background: linear-gradient(90deg, rgba(0,0,0,0.06), rgba(0,0,0,0.02));
            border-top: 1px solid rgba(255, 215, 0, 0.06);
            padding: 28px 40px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
        }

        .footer-bottom-inner {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-bottom p {
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.95em;
            letter-spacing: 0.3px;
            font-weight: 400;
        }

        .footer-bottom strong {
            color: #ffd700;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .footer-bottom:hover strong {
            color: #ffed4e;
        }

        /* Responsive Footer */
        @media (max-width: 768px) {
            .admin-footer {
                padding: 40px 0 0;
            }

            .footer-container {
                padding: 0 20px;
            }

            .footer-columns {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
                padding-bottom: 40px;
            }

            .footer-col h3 {
                justify-content: center;
                margin-bottom: 16px;
            }

            .footer-col h3::after {
                display: none;
            }

            .footer-links a {
                justify-content: center;
                font-size: 0.95em;
            }

            .footer-bottom {
                padding: 25px 0;
            }

            .footer-bottom p {
                font-size: 0.9em;
            }
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
                    <i class="fas fa-leaf"></i>
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
                <a href="{{ route('admin.notifications.inbox') }}" class="nav-link {{ request()->routeIs('admin.notifications.inbox') ? 'active' : '' }}">
                    <i class="fas fa-inbox"></i>
                    <span>Notifikasi Masuk</span>
                    @php $unreadCount = \App\Models\Message::fromUser()->unread()->count(); @endphp
                    @if($unreadCount > 0)
                        <span style="background: #ef4444; color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 700; margin-left: 5px;">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.notifications.send') }}" class="nav-link {{ request()->routeIs('admin.notifications.send') ? 'active' : '' }}">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirim Notifikasi</span>
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
            <div class="footer-columns">
                <!-- Kolom 1 - About -->
                <div class="footer-col">
                    <h3><i class="fas fa-leaf"></i> Tentang Kami</h3>
                    <p>Platform digital terpercaya untuk mengelola subsidi pupuk dan bibit berkualitas bagi petani Indonesia.</p>
                </div>

                <!-- Kolom 2 - Menu Utama Admin -->
                <div class="footer-col">
                    <h3><i class="fas fa-bars"></i> Menu Utama</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-chevron-right"></i> Overview</a></li>
                        <li><a href="{{ route('admin.orders') }}"><i class="fas fa-chevron-right"></i> Pesanan</a></li>
                        <li><a href="{{ route('admin.products.index') }}"><i class="fas fa-chevron-right"></i> Produk</a></li>
                        <li><a href="{{ route('admin.notifications.inbox') }}"><i class="fas fa-chevron-right"></i> Notifikasi Masuk</a></li>
                        <li><a href="{{ route('admin.notifications.send') }}"><i class="fas fa-chevron-right"></i> Kirim Notifikasi</a></li>
                    </ul>
                </div>

                <!-- Kolom 3 - Contact Info -->
                <div class="footer-col">
                    <h3><i class="fas fa-phone-alt"></i> Hubungi Kami</h3>
                    <ul class="footer-links contact-links">
                        <li>
                            <a href="mailto:friskarevalinamanurung@gmail.com">
                                <i class="fas fa-envelope"></i>
                                <span>friskarevalinamanurung@gmail.com</span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+628139629578">
                                <i class="fas fa-phone"></i>
                                <span>+62 813-9629-5784</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <div class="footer-bottom-inner">
                    <p>&copy; {{ date('Y') }} <strong>Pupuk & Bibit Subsidi</strong>. All rights reserved.</p>
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