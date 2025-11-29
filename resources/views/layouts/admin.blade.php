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
            background: white;
            border-bottom: 3px solid var(--green);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        /* Logo */
        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .logo-section:hover {
            transform: translateY(-2px);
        }

        .logo-icon {
            font-size: 32px;
            background: linear-gradient(135deg, var(--green), var(--green-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-text h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--green-dark);
            line-height: 1.2;
        }

        .logo-text p {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
        }

        /* Navigation */
        .nav-menu {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            color: #4b5563;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            background: var(--mint);
            color: var(--green-dark);
        }

        .nav-link.active {
            background: var(--green);
            color: white;
        }

        .nav-link i {
            font-size: 16px;
        }

        /* Right Section */
        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Notification Bell */
        .notification-bell {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .notification-bell:hover {
            background: var(--mint);
            border-color: var(--green);
        }

        .notification-bell i {
            font-size: 18px;
            color: #6b7280;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .profile-button:hover {
            background: var(--mint);
            border-color: var(--green);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--green), var(--green-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--green-dark);
            line-height: 1.2;
        }

        .profile-role {
            font-size: 11px;
            color: #6b7280;
        }

        .profile-chevron {
            color: #6b7280;
            font-size: 12px;
            transition: transform 0.2s ease;
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
            min-height: calc(100vh - 250px);
        }

        /* ========== FOOTER ========== */
        .admin-footer {
            background: linear-gradient(135deg, #065f46, #047857);
            color: white;
            padding: 50px 0 0;
            margin-top: 60px;
            position: relative;
        }

        .admin-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--green-light), var(--green), var(--green-light));
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            color: white;
        }

        .footer-section p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(4px);
        }

        .footer-links a i {
            width: 20px;
            margin-right: 8px;
        }

        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .social-link {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .social-link:hover {
            background: white;
            color: var(--green);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 20px 0;
            text-align: center;
        }

        .footer-bottom p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 20px;
            }

            .nav-menu {
                position: fixed;
                top: 70px;
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

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .logo-text h1 {
                font-size: 16px;
            }

            .logo-text p {
                font-size: 10px;
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
                <i class="fas fa-seedling logo-icon"></i>
                <div class="logo-text">
                    <h1>PUPUK & BIBIT SUBSIDI</h1>
                    <p>Admin Panel</p>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="nav-menu" id="navMenu">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>Produk</span>
                </a>
            </nav>

            <!-- Right Section -->
            <div class="header-right">
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Notification Bell -->
                <a href="{{ route('admin.notifications') }}" class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </a>

                <!-- Profile Dropdown -->
                <div class="profile-dropdown" id="profileDropdown">
                    <button class="profile-button" onclick="toggleProfileDropdown()">
                        <div class="profile-avatar">
                            {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                        </div>
                        <div class="profile-info">
                            <span class="profile-name">{{ session('admin_name', 'Administrator') }}</span>
                            <span class="profile-role">Super Admin</span>
                        </div>
                        <i class="fas fa-chevron-down profile-chevron"></i>
                    </button>

                    <div class="dropdown-menu">
                        <div class="dropdown-header">
                            <div class="dropdown-header-name">{{ session('admin_name', 'Administrator') }}</div>
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
                <!-- Company Info -->
                <div class="footer-section">
                    <h3>Pupuk & Bibit Subsidi</h3>
                    <p>Sistem Informasi Pupuk dan Bibit Subsidi membantu petani mendapatkan akses mudah ke produk pertanian berkualitas dengan harga terjangkau.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>Menu Admin</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-angle-right"></i> Dashboard</a></li>
                        <li><a href="{{ route('admin.orders') }}"><i class="fas fa-angle-right"></i> Kelola Pesanan</a></li>
                        <li><a href="{{ route('admin.products.index') }}"><i class="fas fa-angle-right"></i> Kelola Produk</a></li>
                        <li><a href="{{ route('admin.notifications') }}"><i class="fas fa-angle-right"></i> Kirim Notifikasi</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-section">
                    <h3>Kontak</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Jl. Sitoluama, Laguboti</a></li>
                        <li><a href="#"><i class="fas fa-phone"></i> +62 812-3456-7890</a></li>
                        <li><a href="#"><i class="fas fa-envelope"></i> admin@pupuksubsidi.id</a></li>
                        <li><a href="#"><i class="fas fa-clock"></i> Senin - Jumat, 08:00 - 16:00</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Pupuk & Bibit Subsidi. All rights reserved.</p>
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
