<!-- resources/views/home.blade.php -->

<?php $__env->startSection('title', 'Selamat Datang'); ?>

<?php $__env->startSection('content'); ?>

<!-- ====== HERO SECTION ====== -->
<section class="hero-section">
    <!-- Background Image Layer with Blur -->
    <div class="hero-background"></div>
    <!-- Green Overlay Layer -->
    <div class="hero-overlay"></div>
    
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Selamat Datang!</h1>
            <p class="hero-description">
                Mari bergabung agar kita meningkatkan hasil pertanian dengan akses mudah ke pupuk dan bibit subsidi dari pemerintah Indonesia. Dapatkan informasi, layanan, dan panduan agar pertanian semakin maju dan sejahtera.
            </p>
            <div class="hero-buttons">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary">
                    <i class="fas fa-sign-in-alt"></i>
                    Sudah Punya Akun
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ====== FITUR SECTION ====== -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2>Pupuk dan Bibit Bersubsidi Pemerintah</h2>
            <p>Platform terpercaya untuk mendapatkan pupuk dan bibit bersubsidi dengan mudah dan transparan</p>
        </div>

        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon" style="background:#ffe6e6;">
                    <img src="<?php echo e(asset('images/logo_box.png')); ?>" alt="Pemesanan Mudah">
                </div>
                <h3>Pemesanan Mudah</h3>
                <p>Pesan pupuk dan bibit subsidi secara online, ambil di Balai Desa terdekat.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon" style="background:#e3f2fd;">
                    <img src="<?php echo e(asset('images/logo_notif.png')); ?>" alt="Notifikasi">
                </div>
                <h3>Notifikasi Langsung</h3>
                <p>Dapatkan update status pesanan langsung melalui notifikasi real-time.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon" style="background:#f3e5f5;">
                    <img src="<?php echo e(asset('images/logo_ambil.png')); ?>" alt="Ambil">
                </div>
                <h3>Ambil di Balai Desa</h3>
                <p>Pilih Balai Desa terdekat untuk mengambil pesanan Anda dengan mudah.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon" style="background:#fff8e1;">
                    <img src="<?php echo e(asset('images/logo_harga.png')); ?>" alt="Harga">
                </div>
                <h3>Harga Subsidi</h3>
                <p>Dapatkan pupuk dan bibit dengan harga terjangkau berkat subsidi pemerintah.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon" style="background:#e8f5e9;">
                    <img src="<?php echo e(asset('images/logo_kualitas.png')); ?>" alt="Kualitas">
                </div>
                <h3>Kualitas Terjamin</h3>
                <p>Semua produk sudah tersertifikasi dan terjamin kualitasnya.</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon" style="background:#efebe9;">
                    <img src="<?php echo e(asset('images/logo_parapetani.png')); ?>" alt="Petani">
                </div>
                <h3>Para Petani</h3>
                <p>Dirancang khusus untuk membantu petani Indonesia meningkatkan hasil panen.</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA SECTION ====== -->
<section style="text-align:center; padding:70px 60px 70px; background:linear-gradient(135deg, #e8f5e9, #c8e6c9); margin-bottom:-60px;">
    <h3 style="font-size:2rem; font-weight:bold; color:#2d7a3e; margin-bottom:20px;">Siap Meningkatkan Hasil Panen?</h3>
    <p style="color:#555; margin-bottom:35px; font-size:1.05rem; max-width:700px; margin-left:auto; margin-right:auto;">Bergabunglah dengan ribuan petani Indonesia yang sudah merasakan manfaatnya</p>
    <a href="<?php echo e(route('register')); ?>" style="padding:16px 45px; background:#2d7a3e; color:white; text-decoration:none; border-radius:12px; font-weight:600; font-size:1.05rem; display:inline-block; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(45,122,62,0.3);">Mulai Sekarang</a>
</section>

<style>
    /* Hero Section Styles */
    .hero-section {
        color: white;
        padding: 100px 60px;
        min-height: 600px;
        position: relative;
        overflow: hidden;
    }
    
    /* Background Image Layer with Blur Effect */
    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('<?php echo e(asset('images/Petani.jpg')); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(2px);
        transform: scale(1.05);
        z-index: 0;
    }
    
    /* Green Overlay Layer */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(6, 95, 70, 0.45) 0%, rgba(5, 150, 105, 0.40) 50%, rgba(16, 185, 129, 0.35) 100%);
        z-index: 1;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
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
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .hero-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }
    
    .hero-text {
        max-width: 850px;
        text-align: center;
        animation: fadeInUp 1s ease;
    }
    
    .hero-title {
        font-size: 4.5rem;
        font-weight: 800;
        margin-bottom: 30px;
        line-height: 1.1;
        text-shadow: 3px 4px 15px rgba(0,0,0,0.7);
        letter-spacing: -1px;
    }
    
    .hero-description {
        font-size: 1.35rem;
        line-height: 1.9;
        margin-bottom: 45px;
        font-weight: 400;
        text-shadow: 2px 3px 12px rgba(0,0,0,0.7);
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .hero-buttons {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 36px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
    }
    
    .btn i {
        font-size: 16px;
    }
    
    .btn-primary {
        background: #fbbf24;
        color: #000;
        box-shadow: 0 12px 35px rgba(251, 191, 36, 0.6);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-5px) scale(1.08);
        box-shadow: 0 18px 50px rgba(251, 191, 36, 0.8);
    }
    
    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(251, 191, 36, 0.3);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 3px solid white;
        box-shadow: 0 12px 35px rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
    }
    
    .btn-secondary:hover {
        background: white;
        color: #065f46;
        transform: translateY(-5px) scale(1.08);
        box-shadow: 0 18px 50px rgba(255,255,255,0.5);
    }
    
    .btn-secondary:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(255,255,255,0.2);
    }
    


    /* Features Section */
    .features-section {
        background: #f8fdf8;
        padding: 90px 60px;
    }
    
    .container {
        max-width: 1300px;
        margin: 0 auto;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #065f46;
        margin-bottom: 18px;
        letter-spacing: -0.5px;
    }
    
    .section-header p {
        font-size: 1.15rem;
        color: #6b7280;
        max-width: 850px;
        margin: 0 auto;
        line-height: 1.8;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 35px;
    }
    
    .feature-card {
        background: white;
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-top: 4px solid transparent;
        cursor: pointer;
        text-align: center;
    }
    
    .feature-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        border-top-color: #059669;
    }
    
    .feature-card:nth-child(1) { border-top-color: #ffb74d; }
    .feature-card:nth-child(2) { border-top-color: #64b5f6; }
    .feature-card:nth-child(3) { border-top-color: #ba68c8; }
    .feature-card:nth-child(4) { border-top-color: #ffb74d; }
    .feature-card:nth-child(5) { border-top-color: #81c784; }
    .feature-card:nth-child(6) { border-top-color: #a1887f; }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }
    
    .feature-card:hover .feature-icon {
        transform: scale(1.15) rotate(5deg);
    }
    
    .feature-icon img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    
    .feature-card h3 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 14px;
        line-height: 1.3;
    }
    
    .feature-card p {
        font-size: 1rem;
        color: #6b7280;
        line-height: 1.7;
        margin: 0;
    }
    
    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        padding: 90px 60px;
        margin: 0;
    }
    
    .cta-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .cta-content h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #065f46;
        margin-bottom: 22px;
        letter-spacing: -0.5px;
    }
    
    .cta-content p {
        font-size: 1.2rem;
        color: #374151;
        margin-bottom: 40px;
        line-height: 1.8;
    }
    
    .cta-btn {
        display: inline-block;
        padding: 18px 50px;
        background: #065f46;
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(6, 95, 70, 0.25);
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }
    
    .cta-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: left 0.5s ease;
    }
    
    .cta-btn:hover {
        background: #047857;
        box-shadow: 0 6px 20px rgba(6, 95, 70, 0.35);
        transform: translateY(-2px);
    }
    
    .cta-btn:hover::before {
        left: 100%;
    }
    
    .cta-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(6, 95, 70, 0.3);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .hero-title {
            font-size: 3.8rem;
        }
        
        .hero-description {
            font-size: 1.25rem;
        }
        
        .features-section, .cta-section {
            padding: 70px 40px;
        }
        
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 28px;
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 70px 30px;
            min-height: 550px;
        }
        
        .hero-title {
            font-size: 3rem;
        }
        
        .hero-description {
            font-size: 1.15rem;
        }
        
        .btn {
            padding: 14px 28px;
            font-size: 15px;
        }
        
        .section-header h2 {
            font-size: 2rem;
        }
        
        .section-header p {
            font-size: 1rem;
        }
        
        .features-section, .cta-section {
            padding: 60px 30px;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }
        
        .cta-content h3 {
            font-size: 2rem;
        }
        
        .cta-content p {
            font-size: 1.05rem;
        }
    }
    
    @media (max-width: 480px) {
        .hero-section {
            padding: 60px 20px;
            min-height: 500px;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-description {
            font-size: 1.05rem;
        }
        
        .hero-description {
            font-size: 0.95rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            width: 100%;
            gap: 15px;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
            padding: 16px 24px;
        }
    }
</style>

<script>
    // Check if account was deleted (via query parameter)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('deleted') === '1') {
        // Show success notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 10000;
            font-size: 16px;
            font-weight: 600;
            animation: slideIn 0.5s ease-out;
        `;
        notification.innerHTML = `
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i>
            Akun Anda berhasil dihapus. Terima kasih telah menggunakan layanan kami.
        `;
        document.body.appendChild(notification);
        
        // Add animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(400px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.5s ease-out';
            setTimeout(() => notification.remove(), 500);
        }, 5000);
        
        // Clean URL
        window.history.replaceState({}, document.title, '/');
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/user/HOME.blade.php ENDPATH**/ ?>