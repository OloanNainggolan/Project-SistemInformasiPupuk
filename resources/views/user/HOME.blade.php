<!-- resources/views/home.blade.php -->
@extends('layouts.home')
@section('title', 'Selamat Datang')

@section('content')

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
<section style="text-align:center; padding:70px 60px 70px; background:linear-gradient(135deg, #e8f5e9, #c8e6c9); margin-bottom:-60px;">
    <h3 style="font-size:2rem; font-weight:bold; color:#2d7a3e; margin-bottom:20px;">Siap Meningkatkan Hasil Panen?</h3>
    <p style="color:#555; margin-bottom:35px; font-size:1.05rem; max-width:700px; margin-left:auto; margin-right:auto;">Bergabunglah dengan ribuan petani Indonesia yang sudah merasakan manfaatnya</p>
    <a href="{{ route('register') }}" style="padding:16px 45px; background:#2d7a3e; color:white; text-decoration:none; border-radius:12px; font-weight:600; font-size:1.05rem; display:inline-block; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(45,122,62,0.3);">Mulai Sekarang</a>
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
        background-image: url('{{ asset('images/Petani.jpg') }}');
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
        box-shadow: 0 12px 35px rgba(251, 191, 36, 0.6);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-5px) scale(1.08);
        box-shadow: 0 18px 50px rgba(251, 191, 36, 0.8);
    }
    
    .btn-primary:active {
        transform: translateY(-2px) scale(1.02);
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
        transform: translateY(-2px) scale(1.02);
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
        .hero-title {
            font-size: 3.8rem;
        }
        
        .hero-description {
            font-size: 1.25rem;
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
        
        .hero-buttons {
            flex-direction: column;
            width: 100%;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@endsection
