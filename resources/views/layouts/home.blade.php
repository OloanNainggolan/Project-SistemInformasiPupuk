<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Pupuk & Bibit Subsidi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .btn { 
            background: #2e8b57; color: white; padding: 12px 24px; 
            border: none; border-radius: 6px; cursor: pointer; font-weight: bold;
            text-decoration: none; display: inline-block;
        }
        .btn:hover { background: #1a5d1a; }

        /* Modern Footer Styles */
        .home-footer {
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
            color: white;
            padding: 50px 20px 0;
            margin-top: 0;
            position: relative;
            overflow: hidden;
        }

        .home-footer::before {
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

        .home-footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .home-footer-logo {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .home-footer-logo-icon {
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

        .home-footer-logo-icon i {
            font-size: 30px;
            color: white;
        }

        .home-footer-logo h2 {
            color: #FFF;
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .home-footer-logo p {
            line-height: 1.8;
            color: #d1fae5;
            font-size: 14px;
            margin-top: 10px;
        }

        .home-footer-social {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .home-footer-social a {
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

        .home-footer-social a:hover {
            background: #10b981;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }

        .home-footer-section h3 {
            margin-bottom: 20px;
            color: #FFF;
            font-size: 18px;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        .home-footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #34d399);
            border-radius: 2px;
        }

        .home-footer-links {
            list-style: none;
        }

        .home-footer-links li {
            margin-bottom: 14px;
        }

        .home-footer-links a {
            color: #d1fae5;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .home-footer-links a:hover {
            color: #FFF;
            transform: translateX(5px);
        }

        .home-footer-links i {
            width: 20px;
            color: #10b981;
            font-size: 16px;
        }

        .home-footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            color: #d1fae5;
            font-size: 14px;
            line-height: 1.6;
        }

        .home-footer-contact-item i {
            color: #10b981;
            font-size: 18px;
            margin-top: 2px;
            min-width: 20px;
        }

        .home-footer-bottom {
            text-align: center;
            padding: 25px 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #d1fae5;
            font-size: 14px;
            background: rgba(0, 0, 0, 0.2);
        }

        .home-footer-bottom p {
            margin: 5px 0;
        }

        .home-footer-bottom a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .home-footer-bottom a:hover {
            color: #34d399;
        }

        @media (max-width: 1024px) {
            .home-footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }

            .home-footer-logo {
                grid-column: 1 / -1;
            }

            .home-footer {
                padding: 40px 30px 0;
            }
        }

        @media (max-width: 768px) {
            .home-footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .home-footer-logo {
                grid-column: auto;
            }

            .home-footer {
                padding: 40px 20px 0;
            }

            .home-footer-bottom {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER: Simple header without navigation -->
    @include('partials.header-home')

    @yield('content')

    <!-- Modern Footer for Home Page -->
    <footer class="home-footer">
        <div class="home-footer-content">
            <!-- Branding Section -->
            <div class="home-footer-logo">
                <div class="home-footer-logo-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h2>Pupuk Subsidi Indonesia</h2>
                <p>Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional.</p>
                <div class="home-footer-social">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="home-footer-section">
                <h3>Menu</h3>
                <ul class="home-footer-links">
                    <li><a href="/"><i class="fas fa-home"></i>Beranda</a></li>
                    <li><a href="/login"><i class="fas fa-sign-in-alt"></i>Login</a></li>
                    <li><a href="/register"><i class="fas fa-user-plus"></i>Daftar</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="home-footer-section">
                <h3>Hubungi Kami</h3>
                <div class="home-footer-contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Jl. Sitoluama, Laguboti, Toba</span>
                </div>
                <div class="home-footer-contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>+62 813 2323 09</span>
                </div>
                <div class="home-footer-contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span>info@pupuksubsidi.id</span>
                </div>
            </div>
        </div>

        <div class="home-footer-bottom">
            <p>&copy; {{ date('Y') }} Pupuk & Bibit Subsidi - Sistem Informasi Pemerintah. Semua hak cipta dilindungi.</p>
            <p>INFORMATION SYSTEMS - <a href="https://www.del.ac.id" target="_blank">Del Institute of Technology</a></p>
        </div>
    </footer>
</body>
</html>
