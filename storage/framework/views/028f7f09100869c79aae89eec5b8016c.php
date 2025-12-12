<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Pupuk & Bibit Subsidi'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/global-standards.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/user-theme.css')); ?>">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            width: 100%;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            font-size: inherit;
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

        .dropdown-item.delete-account {
            color: #dc3545;
        }

        .dropdown-item.delete-account i {
            color: #dc3545;
        }

        .dropdown-item.delete-account:hover {
            background-color: #fee2e2;
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

        /* ========== FOOTER ========== */
        footer {
            background-color: #2d5f2e;
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-top: 60px;
        }

        footer div {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        footer > div > div {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 30px;
        }

        footer > div > div > div {
            flex: 1;
            min-width: 250px;
            text-align: left;
        }

        footer > div > div > div h3 {
            color: #ffd700;
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        footer > div > div > div p {
            line-height: 1.6;
            font-size: 0.95em;
            color: rgba(255,255,255,0.9);
        }

        footer > div > div > div ul {
            list-style: none;
            padding: 0;
            line-height: 2;
        }

        footer > div > div > div ul li a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: color 0.3s;
        }

        footer > div > div > div ul li a:hover {
            color: #ffd700 !important;
        }

        footer > div > div:last-child {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        footer > div > div:last-child a {
            color: white;
            margin: 0 12px;
            font-size: 1.5em;
            transition: color 0.3s;
        }

        footer > div > div:last-child a:hover {
            color: #ffd700;
        }

        footer > div > div:last-child i {
            margin-right: 8px;
        }

        footer > div > div:last-child p {
            margin: 0;
            font-size: 0.9em;
            color: rgba(255,255,255,0.8);
        }

        @media (max-width: 768px) {
            footer > div > div:first-child {
                flex-direction: column;
            }
            
            footer > div > div:first-child > div {
                text-align: center !important;
            }
        }

        .enhanced-footer {
            background: linear-gradient(135deg, #0d4a2c 0%, #1a6b3f 50%, #2d8f4f 100%);
            color: white;
            padding: 60px 0 0;
            margin-top: 60px;
            position: relative;
            overflow: hidden;
        }

        .enhanced-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ffd700, #64c864, #ffd700);
        }

        .enhanced-footer::after {
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

        /* Responsive */
        @media (max-width: 768px) {
            .enhanced-footer {
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
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Sticky Header -->
    <header class="user-header">
        <div class="header-container">
            <!-- Logo Section -->
            <a href="<?php echo e(route('dashboard')); ?>" style="text-decoration: none;">
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
                    <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('pupuk.bibit')); ?>" class="<?php echo e(request()->routeIs('pupuk.bibit') ? 'active' : ''); ?>">
                        <i class="fas fa-leaf"></i>
                        <span>Pupuk & Bibit</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('kontak')); ?>" class="<?php echo e(request()->routeIs('kontak') ? 'active' : ''); ?>">
                        <i class="fas fa-envelope"></i>
                        <span>Kontak</span>
                    </a>
                </li>
            </ul>

            <!-- Right Section -->
            <div class="header-right">
                <!-- Notification Icon -->
                <a href="<?php echo e(route('notifikasi')); ?>" class="notification-icon" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <?php
                        // Count unread messages from admin (conversations)
                        $unreadMessages = \App\Models\Message::where('user_id', Auth::id())
                            ->whereNull('reply_to')
                            ->where('subject', 'NOT LIKE', '%Update Status Pesanan%')
                            ->where('subject', 'NOT LIKE', '%Status Pesanan Diperbarui%')
                            ->fromAdmin()
                            ->unread()
                            ->count();
                        
                        // Count unread notifications from notifications table
                        $unreadNotifications = \App\Models\Notification::where('user_id', Auth::id())
                            ->unread()
                            ->count();
                        
                        // Count unread system messages (order status updates)
                        $unreadSystemMessages = \App\Models\Message::where('user_id', Auth::id())
                            ->whereNull('reply_to')
                            ->where(function($q) {
                                $q->where('subject', 'LIKE', '%Update Status Pesanan%')
                                  ->orWhere('subject', 'LIKE', '%Status Pesanan Diperbarui%');
                            })
                            ->where('status', 'unread')
                            ->count();
                        
                        $totalUnread = $unreadMessages + $unreadSystemMessages;
                    ?>
                    <?php if($totalUnread > 0): ?>
                        <span class="notification-badge"><?php echo e($totalUnread > 9 ? '9+' : $totalUnread); ?></span>
                    <?php endif; ?>
                </a>

                <!-- Profile Section with Dropdown -->
                <div class="profile-section">
                    <div class="profile-avatar">
                      <?php if(Auth::user()->foto): ?>
                            <img src="<?php echo e(asset(Auth::user()->foto)); ?>" alt="Profile">
                      <?php else: ?>
                          <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?>

                      <?php endif; ?>
                    </div>
                    <div class="profile-info">
                        <span class="profile-name"><?php echo e(auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'User'); ?></span>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="profile-dropdown">
                        <a href="<?php echo e(route('profil.user')); ?>" class="dropdown-item">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                        <a href="<?php echo e(route('profil.edit')); ?>" class="dropdown-item">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </a>
                        <button type="button" class="dropdown-item delete-account" onclick="confirmDeleteAccount()">
                            <i class="fas fa-trash-alt"></i>
                            <span>Hapus Akun</span>
                        </button>
                        <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: 0;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="dropdown-item logout">
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
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Enhanced Footer -->
    <footer class="enhanced-footer">
        <div class="footer-container">
            <div class="footer-columns">
                <!-- Kolom 1 - About -->
                <div class="footer-col">
                    <h3><i class="fas fa-seedling"></i> Tentang Kami</h3>
                    <p>Platform digital terpercaya untuk subsidi pupuk dan bibit berkualitas bagi petani Indonesia.</p>
                </div>

                <!-- Kolom 2 - Quick Links -->
                <div class="footer-col">
                    <h3><i class="fas fa-link"></i> Menu Cepat</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo e(route('home')); ?>"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                        <li><a href="<?php echo e(route('pupuk.bibit')); ?>"><i class="fas fa-chevron-right"></i> Pupuk & Bibit</a></li>
                        <li><a href="<?php echo e(route('kontak')); ?>"><i class="fas fa-chevron-right"></i> Kontak</a></li>
                    </ul>
                </div>


            </div>

            <!-- Copyright -->
            <div class="footer-bottom">
                <div class="footer-bottom-inner">
                    <p>&copy; <?php echo e(date('Y')); ?> <strong>Pupuk & Bibit Subsidi</strong>. All rights reserved.</p>
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

    <!-- Delete Account Modal & Script -->
    <div id="deleteAccountModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 15px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
            <div style="text-align: center; margin-bottom: 20px;">
                <i class="fas fa-exclamation-triangle" style="font-size: 60px; color: #dc3545;"></i>
                <h2 style="margin: 15px 0 10px; color: #333;">Hapus Akun</h2>
                <p style="color: #666; line-height: 1.6;">
                    Apakah Anda yakin ingin menghapus akun Anda?<br>
                    <strong style="color: #dc3545;">Tindakan ini tidak dapat dibatalkan!</strong><br>
                    Semua data Anda akan dihapus secara permanen.
                </p>
            </div>
            
            <form action="<?php echo e(route('account.delete')); ?>" method="POST" id="deleteAccountForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        Ketik "<strong>HAPUS AKUN SAYA</strong>" untuk konfirmasi:
                    </label>
                    <input type="text" id="confirmText" class="form-control" style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 14px;" placeholder="HAPUS AKUN SAYA" required>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" onclick="closeDeleteModal()" style="padding: 12px 30px; border: 2px solid #ddd; background: white; color: #666; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" id="confirmDeleteBtn" disabled style="padding: 12px 30px; border: none; background: #dc3545; color: white; border-radius: 8px; cursor: not-allowed; font-weight: 600; transition: all 0.3s; opacity: 0.5;">
                        <i class="fas fa-trash-alt"></i> Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function confirmDeleteAccount() {
            document.getElementById('deleteAccountModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteAccountModal').style.display = 'none';
            document.getElementById('confirmText').value = '';
            document.getElementById('confirmDeleteBtn').disabled = true;
            document.getElementById('confirmDeleteBtn').style.opacity = '0.5';
            document.getElementById('confirmDeleteBtn').style.cursor = 'not-allowed';
        }

        document.getElementById('confirmText').addEventListener('input', function(e) {
            const btn = document.getElementById('confirmDeleteBtn');
            if (e.target.value === 'HAPUS AKUN SAYA') {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            } else {
                btn.disabled = true;
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
            }
        });

        // Close modal when clicking outside
        document.getElementById('deleteAccountModal').addEventListener('click', function(e) {
            if (e.target.id === 'deleteAccountModal') {
                closeDeleteModal();
            }
        });
    </script>

    <!-- Google Maps Script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_KEY')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\Project-SistemInformasiPupuk\resources\views/layouts/user.blade.php ENDPATH**/ ?>