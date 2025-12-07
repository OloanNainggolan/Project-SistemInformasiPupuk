<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            top: 3px;
            right: 3px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 12px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { 
                transform: scale(1); 
                box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
            }
            50% { 
                transform: scale(1.15); 
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.6);
            }
        }

        .profile-section {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 5px 12px;
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
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #004d00, #047857);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(16,185,129,0.3);
            flex-shrink: 0;
            overflow: hidden;
        }
        
        .profile-avatar i {
            font-size: 16px;
        }
        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 600;
            color: #065f46;
            white-space: nowrap;
            line-height: 1.2;
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

        /* ========== MODERN FOOTER ========== */
        .user-footer {
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
            color: #1a5e3a;
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
        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }

            .footer-about {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 15px 25px;
            }

            .user-header {
                padding: 0;
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

            .nav-menu a {
                width: 100%;
                justify-content: flex-start;
            }

            .mobile-menu-toggle {
                display: flex !important;
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
                width: 44px;
                height: 44px;
            }

            .logo i {
                font-size: 20px;
            }

            .footer-container {
                padding: 0 25px;
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
                    @php
                        $unreadMessages = \App\Models\Message::where('user_id', Auth::id())
                            ->fromAdmin()
                            ->unread()
                            ->count();
                    @endphp
                    @if($unreadMessages > 0)
                        <span class="notification-badge">{{ $unreadMessages > 9 ? '9+' : $unreadMessages }}</span>
                    @endif
                </a>

                <!-- Profile Section with Dropdown -->
                <div class="profile-section">
                    <div class="profile-avatar">
                        @if(auth()->user()->foto)
                            <img src="{{ asset(auth()->user()->foto) }}" alt="Profile">
                        @else
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
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

    <!-- Modern Footer -->
    <footer class="user-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-section footer-about">
                    <div class="footer-brand">
                        <i class="fas fa-seedling"></i>
                        <div class="footer-brand-text">
                            <h3>Pupuk & Bibit Subsidi</h3>
                            <p>Program Pemerintah untuk Petani</p>
                        </div>
                    </div>
                    <p class="footer-description">
                        Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkualitas.
                    </p>
                    <div class="follow-us">
                        <p style="font-size: 14px; margin-bottom: 8px; font-weight: 600;">Ikuti Kami!</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Menu Links -->
                <div class="footer-section">
                    <h3>Menu Utama</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fas fa-angle-right"></i> Beranda</a></li>
                        <li><a href="{{ route('pupuk.bibit') }}"><i class="fas fa-angle-right"></i> Pupuk & Bibit</a></li>
                        <li><a href="{{ route('profil.user') }}"><i class="fas fa-angle-right"></i> Profil Saya</a></li>
                        <li><a href="{{ route('notifikasi') }}"><i class="fas fa-angle-right"></i> Notifikasi</a></li>
                        <li><a href="{{ route('kontak') }}"><i class="fas fa-angle-right"></i> Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="footer-section">
                    <h3>Hubungi Kami</h3>
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

        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Newsletter Form
        document.querySelector('.newsletter-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const email = e.target.querySelector('input[type="email"]').value;
            alert('Terima kasih! Email ' + email + ' telah terdaftar untuk newsletter.');
            e.target.reset();
        });

        // Animate footer elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.footer-column, .footer-newsletter').forEach(el => {
            observer.observe(el);
        });

        // Add fadeInUp animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>

    @stack('scripts')
</body>
</html>
