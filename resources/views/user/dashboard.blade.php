@extends('layouts.user')

@section('title', 'Beranda')

@push('styles')
<style>
    /* Reset semua spacing untuk dashboard page */
    body {
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
    }

    /* Override content-wrapper margin dari layout */
    .content-wrapper {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    /* Variabel Warna */
    :root {
        --primary-green: #4CAF50;
        --dark-green: #004d00;
        --medium-green: #1a4d1a;
        --light-green: #81c784;
        --secondary-blue: #5C6BC0;
        --yellow-gold: #ffd700;
        --text-color: #333;
        --white: #ffffff;
        --light-gray-bg: #f7f7f7;
        --border-color: #ddd;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    a { text-decoration: none; color: inherit; }
    ul { list-style: none; }
    .text-center { text-align: center; }

    .bg-primary-green { background-color: var(--primary-green); }
    .bg-medium-green { background-color: var(--medium-green); }
    .bg-secondary-blue { background-color: var(--secondary-blue); }
    .text-white { color: var(--white); }

    /* Hero Section */
    .hero-section {
        padding: 0;
        margin: 0;
        background: linear-gradient(135deg, #1a5f3a 0%, #2d7a4f 50%, #1a5f3a 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 50%, rgba(76, 175, 80, 0.1) 0%, transparent 60%),
                    radial-gradient(circle at 80% 50%, rgba(212, 165, 116, 0.1) 0%, transparent 60%);
        pointer-events: none;
    }

    .hero-content {
        display: flex;
        align-items: center;
        gap: 70px;
        color: var(--white);
        width: 100%;
        max-width: 1300px;
        margin: 0 auto;
        padding: 100px 60px 60px;
        position: relative;
        z-index: 1;
    }

    .hero-image {
        width: 52%;
        background-image: url("{{ asset('images/teh.png') }}");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        height: 400px;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3), 
                    0 10px 30px rgba(0,0,0,0.2);
        position: relative;
        overflow: hidden;
        border: 3px solid rgba(255,255,255,0.15);
        display: block;
    }

    .hero-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.15) 0%, transparent 50%);
    }

    .hero-text {
        width: 48%;
        padding-right: 0;
    }

    .welcome-text {
        font-size: 3.8em;
        font-weight: 900;
        color: #ffd700; 
        margin-bottom: 20px;
        line-height: 1.1;
        text-shadow: 3px 3px 8px rgba(0,0,0,0.3);
        letter-spacing: -1.5px;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-text p {
        font-size: 1.25em;
        margin-bottom: 35px;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.98);
        font-weight: 400;
        text-shadow: 1px 2px 4px rgba(0,0,0,0.3);
        animation: fadeInUp 0.8s ease-out 0.2s backwards;
    }

    .cta-button {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        color: white;
        padding: 17px 45px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 700;
        font-size: 1.1em;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(76, 175, 80, 0.4);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.8s ease-out 0.4s backwards;
    }

    .cta-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.4);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .cta-button:hover::before {
        width: 400px;
        height: 400px;
    }
    
    .cta-button:hover {
        background: linear-gradient(135deg, #388e3c 0%, #2d6f30 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(76, 175, 80, 0.5);
    }

    .cta-button:active {
        background: linear-gradient(135deg, #1b5e20 0%, #0d4d2a 100%);
        transform: translateY(-1px) scale(0.98);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.6);
        transition: all 0.1s ease;
    }

    /* Mengapa Memilih */
    .why-choose-us {
        padding: 60px 0;
        text-align: center;
        background-color: #f9fafb;
    }

    .why-choose-us h2 {
        font-size: 2.2em;
        margin-bottom: 15px;
        color: #1a5f3a;
        font-weight: 700;
    }

    .subtitle-text {
        max-width: 850px;
        margin: 0 auto 50px;
        color: #4b5563;
        font-size: 1.15em;
        line-height: 1.8;
    }

    .cards-container {
        display: flex;
        justify-content: center;
        gap: 35px;
        flex-wrap: wrap;
    }

    .card-choice {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 35px 30px;
        max-width: 45%;
        text-align: left;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .card-choice:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-color: #10b981;
    }

    .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2em;
        margin-bottom: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .card-choice:hover .card-icon {
        transform: scale(1.1);
    }
    
    .card-icon.pupuk {
        color: white;
        background: #10b981;
    }
    
    .card-icon.bibit {
        color: white;
        background: #3b82f6;
    }

    .card-choice h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 1.6em;
        color: #1f2937;
        font-weight: 800;
    }
    
    .card-choice p { 
        color: #6b7280;
        line-height: 1.8;
        font-size: 1.05em;
    }

    /* Visi & Misi */
    .vm-section {
        background: #1a4d1a;
        color: white;
        padding: 60px 0;
    }

    .vm-section h2 {
        font-size: 2.5em;
        text-align: center;
        margin-bottom: 40px;
        font-weight: 700;
    }

    .vm-content {
        display: flex;
        gap: 50px;
        padding: 0 50px;
    }

    .vm-vision, .vm-mission {
        width: 50%;
        background: rgba(255, 255, 255, 0.08);
        padding: 35px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
    }

    .vm-vision:hover, .vm-mission:hover {
        background: rgba(255, 255, 255, 0.12);
        transform: translateY(-5px);
    }

    .vm-vision h3, .vm-mission h3 {
        font-size: 2em;
        color: #fbbf24;
        margin-bottom: 20px;
        font-weight: 800;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.2);
    }

    .vm-vision p, .vm-mission ul {
        line-height: 1.9;
        font-size: 1.05em;
    }

    .vm-mission ul {
        padding-left: 25px;
    }
    
    .vm-mission li {
        margin-bottom: 15px;
        list-style: disc;
        position: relative;
        padding-left: 10px;
    }

    .vm-mission li::marker {
        color: #34d399;
        font-size: 1.3em;
    }

    /* Fitur Keunggulan */
    .feature-cards-section {
        padding: 60px 0 40px;
        background: white;
    }

    .feature-grid {
        display: flex;
        justify-content: space-around;
        gap: 25px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .feature-card {
        text-align: center;
        max-width: 200px;
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-8px);
    }
    
    .feature-icon-circle {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2em;
        margin: 0 auto 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon-circle {
        transform: scale(1.1);
    }
    
    .feature-icon-circle.green { 
        background: #e8f5e9;
        color: #4CAF50;
    }
    .feature-icon-circle.purple { 
        background: #ede7f6;
        color: #7e57c2;
    }
    .feature-icon-circle.blue { 
        background: #e3f2fd;
        color: #42a5f5;
    }
    .feature-icon-circle.yellow { 
        background: #fffde7;
        color: #ffd700;
    }

    .feature-card h4 { 
        font-size: 1.2em; 
        margin-bottom: 8px; 
        color: #1f2937;
        font-weight: 700;
    }
    .feature-card p { 
        font-size: 0.95em; 
        color: #6b7280;
        font-weight: 500;
    }

    /* Product Cards Detail */
    .product-cards-detail {
        padding: 0 0 60px;
        background: #f7f9fc;
    }
    
    .product-grid-detail {
        display: flex;
        gap: 40px;
        justify-content: center;
    }

    .product-card-detail {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        max-width: 500px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .product-card-detail:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.15);
    }

    .detail-image {
        height: 250px;
        width: 100%;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .detail-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40%;
        background: linear-gradient(to top, rgba(0,0,0,0.2), transparent);
    }

    .pupuk-detail .detail-image {
        background-image: url('product-pupuk-greenhouse.jpg');
    }

    .bibit-detail .detail-image {
        background-image: url('product-bibit-seedling.jpg');
    }

    .detail-icon-overlay {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 55px;
        height: 55px;
        border-radius: 12px; 
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8em;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .detail-body {
        padding: 40px 35px;
    }

    .detail-body h3 {
        font-size: 1.8em;
        margin-bottom: 18px;
        color: #1f2937;
        font-weight: 800;
    }

    .jenis-pupuk-list, .jenis-bibit-list {
        margin-top: 15px;
        margin-bottom: 20px;
        padding-left: 0;
    }

    .jenis-pupuk-list li, .jenis-bibit-list li {
        position: relative;
        padding-left: 15px;
        font-size: 0.95em;
        margin-bottom: 5px;
    }

    .jenis-pupuk-list li::before { content: "•"; position: absolute; left: 0; color: var(--primary-green); font-weight: bold; }
    .jenis-bibit-list li::before { content: "•"; position: absolute; left: 0; color: var(--secondary-blue); font-weight: bold; }
    
    .info-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .tag {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8em;
        color: var(--white);
        font-weight: 500;
    }
    
    .tag.green { background-color: var(--primary-green); }
    .tag.purple { background-color: var(--secondary-blue); }

    .action-button-detail {
        width: 100%;
        padding: 14px;
        border: none;
        color: white;
        font-weight: 700;
        font-size: 1.1em;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .action-button-detail:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    /* Media Queries */
    /* Responsive - Large Tablet */
    @media (max-width: 1024px) {
        .hero-content {
            gap: 50px;
            padding: 90px 40px 50px;
        }

        .hero-image {
            height: 340px;
            border-radius: 20px;
            background-size: cover;
            background-position: center center;
        }

        .welcome-text {
            font-size: 3em;
        }

        .hero-text p {
            font-size: 1.1em;
            margin-bottom: 28px;
        }

        .cta-button {
            padding: 15px 38px;
            font-size: 1.05em;
        }

        .cards-container {
            gap: 20px;
        }

        .card-choice {
            max-width: 48%;
            padding: 25px;
        }
    }

    /* Responsive - Tablet */
    @media (max-width: 900px) {
        .hero-section {
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .hero-content { 
            flex-direction: column; 
            text-align: center;
            gap: 35px;
            padding: 90px 30px 50px;
        }
        
        .hero-image, .hero-text { 
            width: 100%; 
            padding-right: 0; 
        }
        
        .hero-image { 
            height: 320px;
            border-radius: 18px;
            margin-bottom: 0;
            background-size: cover;
            background-position: center center;
        }

        .welcome-text {
            font-size: 2.5em;
            margin-bottom: 18px;
        }

        .hero-text p {
            font-size: 1.05em;
            margin-bottom: 26px;
        }

        .cta-button {
            padding: 14px 35px;
            font-size: 1em;
        }
        
        .vm-content { 
            flex-direction: column; 
            padding: 0 20px; 
        }
        
        .vm-vision, .vm-mission { 
            width: 100%; 
        }
        
        .cards-container { 
            flex-direction: column; 
            align-items: center; 
        }
        
        .card-choice { 
            max-width: 90%;
            padding: 30px;
        }

        .product-grid-detail { 
            flex-direction: column; 
            align-items: center; 
        }
        
        .product-card-detail { 
            max-width: 90%; 
        }

        .feature-grid { 
            justify-content: center;
            gap: 15px;
        }
        
        .feature-card { 
            min-width: 45%; 
            margin-bottom: 15px; 
        }
    }

    /* Responsive - Mobile */
    @media (max-width: 768px) {
        .hero-section {
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .hero-content {
            padding: 80px 20px 45px;
            gap: 28px;
        }

        .hero-image {
            height: 260px;
            border-radius: 16px;
            background-size: cover;
            background-position: center center;
        }

        .welcome-text {
            font-size: 2em;
            margin-bottom: 14px;
            letter-spacing: -1px;
        }

        .hero-text p {
            font-size: 0.98em;
            margin-bottom: 22px;
            line-height: 1.65;
        }

        .cta-button {
            padding: 12px 30px;
            font-size: 0.95em;
        }

        .why-choose-us,
        .vision-mission,
        .featured-products {
            padding: 40px 0;
        }

        .why-choose-us h2,
        .vision-mission h2,
        .featured-products h2 {
            font-size: 1.6em;
            margin-bottom: 12px;
        }

        .subtitle-text {
            font-size: 0.95em;
            margin-bottom: 30px;
        }

        .card-choice {
            max-width: 100%;
            padding: 25px 20px;
        }

        .card-icon {
            width: 55px;
            height: 55px;
            font-size: 1.6em;
        }

        .feature-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .feature-card {
            min-width: auto;
            padding: 15px;
        }

        .feature-card i {
            font-size: 1.8em;
        }

        .product-card-detail {
            max-width: 100%;
        }
    }

    /* Responsive - Small Mobile */
    @media (max-width: 480px) {
        .hero-section {
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        .hero-content {
            padding: 70px 15px 35px;
            gap: 22px;
        }

        .hero-image {
            height: 220px;
            border-radius: 14px;
            background-size: cover;
            background-position: center center;
        }

        .welcome-text {
            font-size: 1.7em;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .hero-text p {
            font-size: 0.88em;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .cta-button {
            padding: 11px 26px;
            font-size: 0.9em;
        }

        .why-choose-us h2,
        .vision-mission h2,
        .featured-products h2 {
            font-size: 1.4em;
        }

        .feature-grid {
            grid-template-columns: 1fr;
        }

        .feature-card {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="container hero-content">
        <div class="hero-image"></div>
        <div class="hero-text">
            <span class="welcome-text">Selamat Datang!</span>
            <p>Mari bersama kita tingkatkan hasil pertanian dengan akses mudah ke pupuk dan bibit subsidi. Dapatkan informasi, layanan, dan panduan agar pertanian semakin maju dan sejahtera.</p>
            <button class="cta-button" onclick="scrollToWhyChoose()">Lihat Selengkapnya</button>
        </div>
    </div>
</section>

<section class="why-choose-us" id="why-choose-section">
    <div class="container">
        <h2>MENGAPA MEMILIH PUPUK & BIBIT SUBSIDI?</h2>
        <p class="subtitle-text">Program subsidi pemerintah memberikan akses kepada petani untuk mendapatkan pupuk dan bibit berkualitas tinggi dengan harga terjangkau, mendukung peningkatan produktivitas dan kesejahteraan petani Indonesia.</p>

        <div class="cards-container">
            <div class="card-choice">
                <div class="card-icon pupuk"><i class="fas fa-leaf"></i></div>
                <h3>Pupuk Subsidi</h3>
                <p>Pupuk bersubsidi adalah sarana produksi pertanian yang disediakan pemerintah dengan harga lebih murah dari harga eceran tertinggi (HET) untuk membantu petani meningkatkan produktivitas.</p>
            </div>
            <div class="card-choice">
                <div class="card-icon bibit"><i class="fas fa-link"></i></div>
                <h3>Bibit Subsidi</h3>
                <p>Bibit unggul adalah benih tanaman yang telah melalui proses seleksi dan sertifikasi untuk menghasilkan tanaman dengan produktivitas tinggi, tahan hama penyakit, dan adaptif terhadap lingkungan.</p>
            </div>
        </div>
    </div>
</section>

<section class="vm-section">
    <div class="container">
        <h2 class="text-white">VISI & MISI</h2>
        <div class="vm-content">
            <div class="vm-vision">
                <h3>VISI</h3>
                <p>Menjadi platform digital terdepan yang menghubungkan petani Indonesia dengan program subsidi pemerintah, menciptakan kemudahan akses pupuk dan bibit berkualitas untuk meningkatkan kesejahteraan petani dan ketahanan pangan nasional.</p>
            </div>
            <div class="vm-mission">
                <h3>MISI</h3>
                <ul>
                    <li>Menyediakan akses mudah dan transparan terhadap program subsidi pupuk dan bibit.</li>
                    <li>Memastikan distribusi yang merata dan tepat waktu di seluruh nusantara.</li>
                    <li>Meningkatkan produktivitas pertanian melalui teknologi dan inovasi.</li>
                    <li>Mendukung swasembada pangan dan pembangunan pertanian berkelanjutan.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="feature-cards-section">
    <div class="container">
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon-circle green"><i class="fas fa-check-circle"></i></div>
                <h4>Kualitas Terjamin</h4>
                <p>Berstandar SNI</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon-circle purple"><i class="fas fa-award"></i></div>
                <h4>Program Resmi</h4>
                <p>Kementrian RI</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon-circle blue"><i class="fas fa-truck"></i></div>
                <h4>Pengiriman Daerah</h4>
                <p>Se - Indonesia</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon-circle yellow"><i class="fas fa-star"></i></div>
                <h4>Penilaian Baik</h4>
                <p>Rating 4.9/5</p>
            </div>
        </div>
    </div>
</section>

<section class="product-cards-detail">
    <div class="container product-grid-detail">
        <div class="product-card-detail pupuk-detail">
            <div class="detail-image">
                <div class="detail-icon-overlay bg-primary-green"><i class="fas fa-leaf"></i></div>
            </div>
            <div class="detail-body">
                <h3>Pupuk Subsidi</h3>
                <p>Dapatkan pupuk berkualitas tinggi dengan harga terjangkau melalui program subsidi pemerintah. Tersedia berbagai jenis pupuk untuk kebutuhan pertanian Anda.</p>
                <ul class="jenis-pupuk-list">
                    <li>Pupuk Urea - Nitrogen tinggi</li>
                    <li>Pupuk NPK - Nutrisi lengkap</li>
                    <li>Pupuk Organik - Ramah lingkungan</li>
                    <li>Pupuk TSP - Fosfor untuk akar</li>
                </ul>
                <div class="info-tags">
                    <span class="tag green">Harga subsidi hingga 50%</span>
                    <span class="tag green">Kualitas Terjamin SNI</span>
                    <span class="tag green">Distribusi merata</span>
                </div>
                <a href="{{ route('pupuk.bibit') }}" style="display: block; text-decoration: none;">
                    <button class="action-button-detail bg-primary-green">Pesan Pupuk Sekarang</button>
                </a>
            </div>
        </div>

        <div class="product-card-detail bibit-detail">
            <div class="detail-image">
                <div class="detail-icon-overlay bg-secondary-blue"><i class="fas fa-link"></i></div>
            </div>
            <div class="detail-body">
                <h3>Bibit Subsidi</h3>
                <p>Pilihan bibit unggul bersertifikat dengan daya tumbuh tinggi dan hasil panen maksimal. Investasi terbaik untuk masa depan pertanian yang sukses.</p>
                <ul class="jenis-bibit-list">
                    <li>Bibit Padi IR64 - Tahan hama</li>
                    <li>Bibit Jagung Hibrida - Produktif</li>
                    <li>Bibit Cabai - Hasil melimpah</li>
                    <li>Bibit Kedelai - Protein tinggi</li>
                </ul>
                <div class="info-tags">
                    <span class="tag purple">Daya tumbuh hingga 98%</span>
                    <span class="tag purple">Bersertifikat resmi</span>
                    <span class="tag purple">Hasil panen optimal</span>
                </div>
                <a href="{{ route('pupuk.bibit') }}" style="display: block; text-decoration: none;">
                    <button class="action-button-detail bg-secondary-blue">Pesan Bibit Sekarang</button>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // Smooth scroll function untuk tombol "Lihat Selengkapnya"
    function scrollToWhyChoose() {
        const section = document.getElementById('why-choose-section');
        if (section) {
            section.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
</script>
@endsection
