@extends('layouts.user')

@section('title', 'Beranda')

@push('styles')
<style>
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
        padding: 40px 0;
        background-color: var(--dark-green);
    }

    .hero-content {
        display: flex;
        align-items: center;
        gap: 40px;
        color: var(--white);
    }

    .hero-image {
        width: 50%;
        background-image: url("{{ asset('images/teh.png') }}");
        background-size: cover;
        background-position: center;
        height: 300px;
        border-radius: 10px;
        box-shadow: 0 8px 15px rgba(0,0,0,0.4);
    }

    .hero-text {
        width: 50%;
        padding-right: 20px;
    }

    .welcome-text {
        font-size: 2.5em;
        font-weight: bold;
        color: var(--yellow-gold); 
        margin-bottom: 10px;
    }

    .hero-text p {
        font-size: 1.1em;
        margin-bottom: 25px;
    }

    .cta-button {
        background-color: var(--primary-green);
        color: var(--white);
        padding: 10px 25px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    /* Mengapa Memilih */
    .why-choose-us {
        padding: 50px 0;
        text-align: center;
        background-color: var(--white);
    }

    .why-choose-us h2 {
        font-size: 2em;
        margin-bottom: 15px;
    }

    .subtitle-text {
        max-width: 800px;
        margin: 0 auto 40px;
        color: #666;
        font-size: 1.05em;
    }

    .cards-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .card-choice {
        background-color: var(--white);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 30px;
        max-width: 45%;
        text-align: left;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        position: relative;
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2em;
        margin-bottom: 15px;
        position: relative;
        top: 0;
        left: 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .card-icon.pupuk {
        color: var(--primary-green);
        background-color: rgba(76, 175, 80, 0.1); 
    }
    
    .card-icon.bibit {
        color: var(--secondary-blue);
        background-color: rgba(92, 107, 192, 0.1);
    }

    .card-choice h3 {
        margin-top: 0;
        margin-bottom: 12px;
        font-size: 1.4em;
    }
    
    .card-choice p { color: #555; }

    /* Visi & Misi */
    .vm-section {
        background-color: var(--medium-green);
        color: var(--white);
        padding: 50px 0;
    }

    .vm-section h2 {
        font-size: 2.5em;
        text-align: center;
        margin-bottom: 30px;
    }

    .vm-content {
        display: flex;
        gap: 50px;
        padding: 0 50px;
    }

    .vm-vision, .vm-mission {
        width: 50%;
    }

    .vm-vision h3, .vm-mission h3 {
        font-size: 1.8em;
        color: var(--light-green);
        margin-bottom: 15px;
    }

    .vm-mission ul {
        padding-left: 20px;
    }
    
    .vm-mission li {
        margin-bottom: 10px;
        list-style: disc;
    }

    /* Fitur Keunggulan */
    .feature-cards-section {
        padding: 50px 0 30px;
        background-color: var(--light-gray-bg);
    }

    .feature-grid {
        display: flex;
        justify-content: space-around;
        gap: 20px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .feature-card {
        text-align: center;
        max-width: 200px;
    }
    
    .feature-icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2em;
        margin-bottom: 10px;
    }
    
    .feature-icon-circle.green { background-color: #e8f5e9; color: var(--primary-green); }
    .feature-icon-circle.purple { background-color: #ede7f6; color: #7e57c2; }
    .feature-icon-circle.blue { background-color: #e3f2fd; color: #42a5f5; }
    .feature-icon-circle.yellow { background-color: #fffde7; color: var(--yellow-gold); }

    .feature-card h4 { font-size: 1.1em; margin-bottom: 5px; color: #444; }
    .feature-card p { font-size: 0.9em; color: #777; }

    /* Product Cards Detail */
    .product-cards-detail {
        padding: 0 0 50px;
        background-color: var(--light-gray-bg);
    }
    
    .product-grid-detail {
        display: flex;
        gap: 40px;
        justify-content: center;
    }

    .product-card-detail {
        background-color: var(--white);
        border-radius: 15px;
        overflow: hidden;
        max-width: 500px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    .detail-image {
        height: 250px;
        width: 100%;
        background-size: cover;
        background-position: center;
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
        width: 50px;
        height: 50px;
        border-radius: 10px; 
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.8em;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .detail-body {
        padding: 30px;
    }

    .detail-body h3 {
        font-size: 1.6em;
        margin-bottom: 15px;
        color: var(--text-color);
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
        padding: 12px;
        border: none;
        color: var(--white);
        font-weight: bold;
        font-size: 1.1em;
        border-radius: 8px;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    /* Media Queries */
    @media (max-width: 900px) {
        .hero-content { flex-direction: column; text-align: center; }
        .hero-image, .hero-text { width: 100%; padding-right: 0; }
        .hero-image { height: 250px; margin-bottom: 20px; }
        
        .vm-content { flex-direction: column; padding: 0 20px; }
        .vm-vision, .vm-mission { width: 100%; }
        
        .cards-container, .product-grid-detail { flex-direction: column; align-items: center; }
        .card-choice, .product-card-detail { max-width: 95%; }
        .card-choice { padding-top: 45px; }
        .card-icon { top: 15px; }

        .feature-grid { justify-content: space-around; }
        .feature-card { min-width: 40%; margin-bottom: 20px; }
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
            <button class="cta-button">Lihat Selengkapnya</button>
        </div>
    </div>
</section>

<section class="why-choose-us">
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
@endsection
