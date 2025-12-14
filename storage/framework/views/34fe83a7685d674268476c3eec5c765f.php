<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - Pupuk & Bibit Subsidi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/global-standards.css')); ?>">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .btn { 
            background: #004d00; color: white; padding: 12px 24px; 
            border: none; border-radius: 6px; cursor: pointer; font-weight: bold;
            text-decoration: none; display: inline-block;
        }
        .btn:hover { background: #004d00; }

        /* Modern Footer Styles */
        .home-footer {
            background: linear-gradient(135deg, #004d00 0%, #004d00 100%);
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
            background: linear-gradient(90deg, #004d00);
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
            background: linear-gradient(135deg, #004d00);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px #004d00;
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
            background: #004d00;
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
            background: linear-gradient(90deg, #004d00);
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
            color : #004d00;
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
            color: #004d00;
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
            color: #004d00;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .home-footer-bottom a:hover {
            color: #004d00;
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

        /* ========== ENHANCED FOOTER STYLES (User Footer) ========== */
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
</head>
<body>
    <!-- HEADER: Simple header without navigation -->
    <?php echo $__env->make('partials.header-home', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Modern Footer for Home Page -->
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
                    <h3><i class="fas fa-link"></i> Menu Utama</h3>
                    <ul class="footer-links">
                        <li><a href="/"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                        <li><a href="/login"><i class="fas fa-chevron-right"></i> Login</a></li>
                        <li><a href="/register"><i class="fas fa-chevron-right"></i> Daftar</a></li>
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
                    <p>&copy; <?php echo e(date('Y')); ?> <strong>Pupuk & Bibit Subsidi</strong>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\laragon\www\ppw\resources\views/layouts/home.blade.php ENDPATH**/ ?>