<!-- resources/views/home.blade.php -->
@extends('layouts.home')
@section('title', 'Selamat Datang')

@section('content')

<!-- ====== HERO SECTION ====== -->
<section class="hero-section">
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title">Selamat Datang!</h1>
            <p class="hero-description">
                Mari bergabung agar kita meningkatkan hasil pertanian dengan akses mudah ke pupuk dan bibit subsidi dari pemerintah Indonesia. Dapatkan informasi, layanan, dan panduan agar pertanian semakin maju dan sejahtera.
            </p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="btn btn-secondary">
                    <i class="fas fa-sign-in-alt"></i>
                    Sudah Punya Akun
                </a>
            </div>
        </div>
        
        <div class="hero-image">
            <div class="image-wrapper">
                <img src="{{ asset('images/petani.jpg') }}" alt="Petani">
                <div class="image-decoration"></div>
            </div>
        </div>
    </div>
</section>

<!-- ====== FITUR SECTION ====== -->
<section style="text-align:center; padding:80px 60px; background-color:#f8fdf8;">
    <h2 style="font-size:2.2rem; font-weight:bold; color:#2d7a3e; margin-bottom:15px;">Pupuk dan Bibit Bersubsidi Pemerintah</h2>
    <p style="color:#555; margin-bottom:50px; font-size:1.05rem; max-width:800px; margin-left:auto; margin-right:auto;">Platform terpercaya untuk mendapatkan pupuk dan bibit bersubsidi dengan mudah dan transparan</p>

    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:35px; max-width:1300px; margin:0 auto;">
        
        <div style="background:white; padding:35px 25px; border-radius:20px; box-shadow:0 5px 20px rgba(0,0,0,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease; border-top:4px solid #ffb74d;">
            <div style="width:70px; height:70px; margin:0 auto 20px; background:#e8c4c4; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <img src="{{ asset('images/logo_box.png') }}" alt="Pemesanan Mudah" style="width:35px; height:35px; object-fit:contain;">
            </div>
            <h3 style="color:#2d7a3e; font-weight:600; margin-bottom:12px; font-size:1.2rem;">Pemesanan Mudah</h3>
            <p style="color:#666; line-height:1.6; font-size:0.95rem;">Pesan pupuk dan bibit subsidi secara online, ambil di Balai Desa terdekat.</p>
        </div>

        <div style="background:white; padding:35px 25px; border-radius:20px; box-shadow:0 5px 20px rgba(0,0,0,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease; border-top:4px solid #64b5f6;">
            <div style="width:70px; height:70px; margin:0 auto 20px; background:#c4dff5; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <img src="{{ asset('images/logo_notif.png') }}" alt="Notifikasi" style="width:35px; height:35px; object-fit:contain;">
            </div>
            <h3 style="color:#2d7a3e; font-weight:600; margin-bottom:12px; font-size:1.2rem;">Notifikasi Langsung</h3>
            <p style="color:#666; line-height:1.6; font-size:0.95rem;">Dapatkan update status pesanan langsung melalui notifikasi real-time.</p>
        </div>

        <div style="background:white; padding:35px 25px; border-radius:20px; box-shadow:0 5px 20px rgba(0,0,0,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease; border-top:4px solid #ba68c8;">
            <div style="width:70px; height:70px; margin:0 auto 20px; background:#dcc8e8; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <img src="{{ asset('images/logo_ambil.png') }}" alt="Ambil" style="width:35px; height:35px; object-fit:contain;">
            </div>
            <h3 style="color:#2d7a3e; font-weight:600; margin-bottom:12px; font-size:1.2rem;">Ambil di Balai Desa</h3>
            <p style="color:#666; line-height:1.6; font-size:0.95rem;">Pilih Balai Desa terdekat untuk mengambil pesanan Anda dengan mudah.</p>
        </div>

        <div style="background:white; padding:35px 25px; border-radius:20px; box-shadow:0 5px 20px rgba(0,0,0,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease; border-top:4px solid #ffb74d;">
            <div style="width:70px; height:70px; margin:0 auto 20px; background:#f5eac8; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <img src="{{ asset('images/logo_harga.png') }}" alt="Harga" style="width:35px; height:35px; object-fit:contain;">
            </div>
            <h3 style="color:#2d7a3e; font-weight:600; margin-bottom:12px; font-size:1.2rem;">Harga Subsidi</h3>
            <p style="color:#666; line-height:1.6; font-size:0.95rem;">Dapatkan pupuk dan bibit dengan harga terjangkau berkat subsidi pemerintah.</p>
        </div>

        <div style="background:white; padding:35px 25px; border-radius:20px; box-shadow:0 5px 20px rgba(0,0,0,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease; border-top:4px solid #81c784;">
            <div style="width:70px; height:70px; margin:0 auto 20px; background:#d0ecd0; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <img src="{{ asset('images/logo_kualitas.png') }}" alt="Kualitas" style="width:35px; height:35px; object-fit:contain;">
            </div>
            <h3 style="color:#2d7a3e; font-weight:600; margin-bottom:12px; font-size:1.2rem;">Kualitas Terjamin</h3>
            <p style="color:#666; line-height:1.6; font-size:0.95rem;">Semua produk sudah tersertifikasi dan terjamin kualitasnya.</p>
        </div>

        <div style="background:white; padding:35px 25px; border-radius:20px; box-shadow:0 5px 20px rgba(0,0,0,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease; border-top:4px solid #a1887f;">
            <div style="width:70px; height:70px; margin:0 auto 20px; background:#dcccc4; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <img src="{{ asset('images/logo_parapetani.png') }}" alt="Petani" style="width:35px; height:35px; object-fit:contain;">
            </div>
            <h3 style="color:#2d7a3e; font-weight:600; margin-bottom:12px; font-size:1.2rem;">Para Petani</h3>
            <p style="color:#666; line-height:1.6; font-size:0.95rem;">Dirancang khusus untuk membantu petani Indonesia meningkatkan hasil panen.</p>
        </div>
    </div>
</section>

<!-- ====== CTA SECTION ====== -->
<section style="text-align:center; padding:70px 60px 50px; background:linear-gradient(135deg, #e8f5e9, #c8e6c9); margin-bottom:0;">
    <h3 style="font-size:2rem; font-weight:bold; color:#2d7a3e; margin-bottom:20px;">Siap Meningkatkan Hasil Panen?</h3>
    <p style="color:#555; margin-bottom:35px; font-size:1.05rem; max-width:700px; margin-left:auto; margin-right:auto;">Bergabunglah dengan ribuan petani Indonesia yang sudah merasakan manfaatnya</p>
    <a href="{{ route('register') }}" style="padding:16px 45px; background:#2d7a3e; color:white; text-decoration:none; border-radius:12px; font-weight:600; font-size:1.05rem; display:inline-block; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(45,122,62,0.3);">Mulai Sekarang</a>
</section>

<style>
    /* Hero Section Styles */
    .hero-section {
        background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
        color: white;
        padding: 100px 60px;
        min-height: 600px;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 30s linear infinite;
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
        justify-content: space-between;
        gap: 60px;
        position: relative;
        z-index: 1;
    }
    
    .hero-text {
        flex: 1;
        max-width: 600px;
        animation: fadeInUp 1s ease;
    }
    
    .hero-title {
        font-size: 3.8rem;
        font-weight: 800;
        margin-bottom: 25px;
        line-height: 1.1;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        letter-spacing: -1px;
    }
    
    .hero-description {
        font-size: 1.2rem;
        line-height: 1.8;
        margin-bottom: 40px;
        opacity: 0.95;
        font-weight: 400;
    }
    
    .hero-buttons {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 36px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 16px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        letter-spacing: 0.5px;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    
    .btn:hover::before {
        width: 300px;
        height: 300px;
    }
    
    .btn i {
        font-size: 18px;
        transition: transform 0.3s ease;
    }
    
    .btn:hover i {
        transform: translateX(5px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #000;
        box-shadow: 0 10px 30px rgba(251, 191, 36, 0.5);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 40px rgba(251, 191, 36, 0.7);
    }
    
    .btn-primary:active {
        transform: translateY(-2px) scale(1.02);
    }
    
    .btn-secondary {
        background: transparent;
        color: white;
        border: 3px solid white;
        box-shadow: 0 10px 30px rgba(255,255,255,0.2);
    }
    
    .btn-secondary:hover {
        background: white;
        color: #065f46;
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 40px rgba(255,255,255,0.4);
    }
    
    .btn-secondary:active {
        transform: translateY(-2px) scale(1.02);
    }
    
    .hero-image {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        animation: fadeInRight 1.2s ease;
    }
    
    .image-wrapper {
        position: relative;
        width: 450px;
        height: 450px;
    }
    
    .image-wrapper img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 10px solid rgba(255,255,255,0.3);
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        position: relative;
        z-index: 2;
        animation: pulse 3s ease-in-out infinite;
    }
    
    .image-decoration {
        position: absolute;
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        border-radius: 50%;
        border: 3px dashed rgba(255,255,255,0.5);
        animation: rotate 20s linear infinite;
    }

    /* Feature Cards Hover - Only for feature cards, not hero section */
    section:not(.hero-section) > div > div[style*="background:white"] {
        cursor: pointer;
    }
    
    section:not(.hero-section) > div > div[style*="background:white"]:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 35px rgba(0,0,0,0.15) !important;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
        }
        
        .hero-text {
            max-width: 100%;
        }
        
        .hero-buttons {
            justify-content: center;
        }
        
        .image-wrapper {
            width: 380px;
            height: 380px;
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 60px 30px;
            min-height: auto;
        }
        
        .hero-title {
            font-size: 2.8rem;
        }
        
        .hero-description {
            font-size: 1.05rem;
        }
        
        .image-wrapper {
            width: 320px;
            height: 320px;
        }
        
        .btn {
            padding: 14px 28px;
            font-size: 15px;
        }
    }
    
    @media (max-width: 480px) {
        .hero-title {
            font-size: 2.2rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .image-wrapper {
            width: 280px;
            height: 280px;
        }
    }
</style>

@endsection
