<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .main-footer {
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        color: white;
        padding: 60px 0 0;
        margin-top: 50px;
        position: relative;
        overflow: hidden;
    }

    .main-footer::before {
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
    
    .footer-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 50px;
    }
    
    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 50px;
        margin-bottom: 40px;
    }
    
    .footer-logo-section {
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
    
    .footer-logo-text h4 {
        font-size: 22px;
        margin: 0;
        color: #FFF;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    
    .footer-logo-text p {
        font-size: 13px;
        margin: 5px 0 0 0;
        color: #d1fae5;
    }
    
    .footer-description {
        font-size: 14px;
        line-height: 1.8;
        color: #d1fae5;
        margin: 15px 0 20px 0;
    }
    
    .footer-social-title {
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 15px;
        color: white;
    }
    
    .footer-social-links {
        display: flex;
        gap: 12px;
        margin-top: 15px;
    }
    
    .footer-social-links a {
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
        font-size: 16px;
    }
    
    .footer-social-links a:hover {
        background: #10b981;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
    }
    
    .footer-section h3 {
        font-size: 18px;
        margin-bottom: 20px;
        color: #FFF;
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
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 2px;
    }
    
    .footer-menu-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-menu-list li {
        margin-bottom: 14px;
    }
    
    .footer-menu-list a {
        font-size: 14px;
        color: #d1fae5;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    
    .footer-menu-list a:hover {
        color: white;
        transform: translateX(5px);
    }

    .footer-menu-list i {
        width: 20px;
        color: #10b981;
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
    
    .footer-contact-icon {
        color: #10b981;
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
    }
    
    .footer-institute-badge {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .footer-institute-badge:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }
    
    .footer-badge-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }

    .footer-badge-icon i {
        color: white;
        font-size: 18px;
    }
    
    .footer-badge-text h5 {
        font-size: 14px;
        margin: 0 0 2px 0;
        color: white;
        font-weight: 600;
    }
    
    .footer-badge-text p {
        font-size: 12px;
        color: #d1fae5;
        margin: 0;
    }

    .footer-badge-text a {
        color: #10b981;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .footer-badge-text a:hover {
        color: #34d399;
    }
    
    @media (max-width: 1024px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }

        .footer-logo-section {
            grid-column: 1 / -1;
        }

        .main-footer {
            padding: 50px 0 0;
        }

        .footer-container {
            padding: 0 30px;
        }
    }
    
    @media (max-width: 768px) {
        .footer-container {
            padding: 0 20px;
        }
        
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-logo-section {
            grid-column: auto;
        }
        
        .footer-bottom {
            padding: 25px 20px;
            font-size: 12px;
        }

        .main-footer {
            padding: 40px 0 0;
        }
    }
</style>

<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-section">
                <div class="footer-logo-section">
                    <div class="footer-logo-icon">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <div class="footer-logo-text">
                        <h4>Pupuk Subsidi Indonesia</h4>
                        <p>Program Pemerintah untuk Petani</p>
                    </div>
                </div>
                <p class="footer-description">Platform resmi pemerintah untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkualitas.</p>
                <p class="footer-social-title">Ikuti Kami!</p>
                <div class="footer-social-links">
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Menu Utama</h3>
                <ul class="footer-menu-list">
                    @auth
                        <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-home"></i>Beranda</a></li>
                    @else
                        <li><a href="{{ route('home') }}"><i class="fa-solid fa-home"></i>Beranda</a></li>
                    @endauth
                    <li><a href="{{ route('pupuk.bibit') }}"><i class="fa-solid fa-leaf"></i>Pupuk & Bibit</a></li>
                    @auth
                        <li><a href="{{ route('profil.user') }}"><i class="fa-solid fa-user"></i>Profil</a></li>
                    @else
                        <li><a href="{{ route('login') }}"><i class="fa-solid fa-sign-in-alt"></i>Masuk</a></li>
                    @endauth
                    <li><a href="{{ route('kontak') }}"><i class="fa-solid fa-envelope"></i>Kontak</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Informasi</h3>
                <ul class="footer-menu-list">
                    <li><a href="#"><i class="fa-solid fa-circle-info"></i>Tentang Kami</a></li>
                    <li><a href="#"><i class="fa-solid fa-file-shield"></i>Kebijakan Privasi</a></li>
                    <li><a href="#"><i class="fa-solid fa-file-contract"></i>Syarat & Ketentuan</a></li>
                    <li><a href="#"><i class="fa-solid fa-circle-question"></i>FAQ</a></li>
                </ul>
            </div>

            <div class="footer-section" id="kontak">
                <h3>Hubungi Kami</h3>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-location-dot footer-contact-icon"></i>
                    <span>Jl. Sitoluama, Laguboti, Toba</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-phone footer-contact-icon"></i>
                    <span>+62 813 2323 09</span>
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-envelope footer-contact-icon"></i>
                    <span>info@pupuksubsidi.id</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="footer-institute-badge">
            <div class="footer-badge-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="footer-badge-text">
                <h5>INFORMATION SYSTEMS</h5>
                <p><a href="https://www.del.ac.id" target="_blank">Del Institute of Technology</a></p>
            </div>
        </div>
    </div>
</footer>