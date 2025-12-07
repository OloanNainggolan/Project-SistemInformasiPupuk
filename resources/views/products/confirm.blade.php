<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan | Pupuk & Bibit Subsidi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Variabel Warna (disesuaikan dengan desain screenshot: hijau dominan, putih, abu-abu muda) */
        :root {
            --primary-green: #4CAF50; /* Hijau utama untuk tombol dan highlight */
            --dark-green: #004d00;    /* Hijau sangat gelap untuk navbar */
            --medium-green: #1a4d1a;  /* Hijau gelap untuk footer */
            --light-green: #81c784;   /* Hijau terang untuk background elemen */
            --secondary-blue: #5C6BC0; /* Biru untuk elemen bibit */
            --yellow-gold: #ffd700;   /* Kuning keemasan */
            --text-color: #333;       
            --white: #ffffff;
            --light-gray-bg: #f0f8f0; /* Abu-abu hijau muda untuk background utama */
            --border-color: #ddd;     
            --success-green: #28a745; /* Hijau sukses untuk tombol konfirmasi */
            --info-blue: #e3f2fd;    /* Biru muda untuk ikon pembayaran */
        }

        /* Reset Dasar & Global */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--white);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        .text-center { text-align: center; }

        /* Utilitas Warna */
        .bg-primary-green { background-color: var(--primary-green); }
        .bg-medium-green { background-color: var(--medium-green); }
        .bg-light-green { background-color: var(--light-gray-bg); }
        .bg-info-blue { background-color: var(--info-blue); }
        .text-white { color: var(--white); }

        /* --- 1. Navbar (disesuaikan dengan screenshot: logo kiri, menu tengah, ikon bell kanan) --- */
        .navbar {
            background-color: var(--dark-green);
            color: var(--white);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-weight: bold; 
            font-size: 1.2em; 
        }
        .logo img { 
            width: 30px; 
            height: 30px; 
            border-radius: 5px; 
        }
        .logo .subtitle { 
            font-size: 0.8em; 
            opacity: 0.7; 
            margin-left: 5px; 
        }

        nav a {
            margin-left: 15px;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
            color: var(--white);
        }
        
        nav a:hover, nav a.active {
            background-color: var(--primary-green);
        }

        .nav-icons i { 
            font-size: 1.2em; 
            cursor: pointer; 
        }

        /* --- Konfirmasi Pesanan Section (disesuaikan dengan screenshot: dua kolom utama, background hijau muda) --- */
        .confirmation-section {
            padding: 50px 0;
            background-color: var(--light-gray-bg);
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .confirmation-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .back-button {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: var(--text-color);
            padding: 5px;
        }

        .info-section {
            flex: 1;
        }

        .info-section h2 {
            font-size: 1.8em;
            color: var(--text-color);
            margin-bottom: 10px;
        }

        .info-section p {
            color: #666;
            margin-bottom: 20px;
        }

        .info-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        .info-card h3 {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: var(--primary-green);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card p {
            margin-bottom: 10px;
            font-size: 1em;
        }

        .payment-info {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid var(--border-color);
            position: relative;
        }

        .payment-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--info-blue);
            border-radius: 2px 0 0 2px;
        }

        .payment-info ul {
            margin-top: 15px;
            padding-left: 0;
            list-style: none;
        }

        .payment-info ul li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            font-size: 0.95em;
            position: relative;
            padding-left: 10px;
        }

        .payment-info ul li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 4px;
            width: 6px;
            height: 6px;
            background-color: var(--info-blue);
            border-radius: 50%;
        }

        .summary-section {
            flex: 0 0 280px;
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid var(--border-color);
            margin-left: 20px;
        }

        .summary-section img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .summary-title {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: var(--primary-green);
            text-align: center;
            background-color: var(--light-gray-bg);
            padding: 10px;
            border-radius: 5px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95em;
        }

        .summary-item .price {
            font-weight: bold;
        }

        .summary-total {
            font-weight: bold;
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
            margin-top: 10px;
            color: var(--success-green);
        }

        .confirm-button {
            background-color: var(--success-green);
            color: var(--white);
            padding: 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.1em;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .confirm-button:hover {
            background-color: var(--primary-green);
        }

        .terms-text {
            font-size: 0.85em;
            color: #666;
            margin-top: 10px;
            text-align: center;
            line-height: 1.4;
        }

        /* --- 7. Footer (disesuaikan dengan screenshot: grid 3 kolom, social links, contact) --- */
        .footer {
            background-color: var(--medium-green); 
            color: #f0f0f0;
            padding: 40px 0 0;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-brand .logo { 
            margin-bottom: 15px; 
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-brand .logo img { 
            height: 40px; 
            width: 40px; 
        }
        .footer-brand h4 { 
            font-size: 1.3em; 
            margin: 0 0 10px 0; 
        }
        .footer-brand p { 
            font-size: 0.9em; 
            opacity: 0.8; 
            margin-bottom: 15px; 
        }

        .follow-us { 
            font-weight: bold; 
            margin-bottom: 5px !important; 
        }

        .social-links {
            display: flex;
            gap: 10px;
        }
        .social-links a { 
            font-size: 1.2em; 
            transition: color 0.3s; 
            color: #f0f0f0;
        }
        .social-links a:hover { 
            color: var(--primary-green); 
        }

        .footer-links h4, .footer-contact h4 {
            margin-bottom: 15px;
            font-size: 1.1em;
            color: var(--light-green);
        }

        .footer-links ul li, .footer-contact ul li { 
            margin-bottom: 8px; 
            font-size: 0.9em; 
        }

        .footer-contact i { 
            margin-right: 8px; 
            color: var(--primary-green); 
        }

        .footer-contact .location {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .footer-bottom {
            text-align: center;
            padding: 15px 0;
        }

        .footer-bottom img { 
            height: 30px; 
            margin-bottom: 5px; 
        }
        .footer-bottom p { 
            font-size: 0.75em; 
            opacity: 0.7; 
        }

        /* --- Media Queries (Responsif: stack vertikal di mobile) --- */
        @media (max-width: 900px) {
            .nav-content nav { display: none; }
            .confirmation-container { 
                flex-direction: column; 
                gap: 20px; 
                padding: 20px; 
            }
            .summary-section { 
                flex: none; 
                margin-left: 0; 
            }
            .footer-grid { 
                grid-template-columns: 1fr; 
                text-align: center; 
            }
            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="container nav-content">
            <div class="logo">
                <img src="logo.png" alt="Logo Pupuk & Bibit Subsidi">
                <span>Pupuk & Bibit Subsidi</span>
                <span class="subtitle">Sistem Informasi Pemerintahan</span>
            </div>
            <nav>
                <a href="#"><i class="fas fa-home"></i> Beranda</a>
                <a class="active" href="#"><i class="fas fa-box"></i> Pupuk & Bibit</a>
                <a href="#"><i class="fas fa-user"></i> Profil</a>
                <a href="#"><i class="fas fa-envelope"></i> Kontak</a>
            </nav>
            <div class="nav-icons">
                <i class="fas fa-bell"></i>
            </div>
        </div>
    </header>

    <section class="confirmation-section">
        <div class="container">
            <div class="confirmation-header">
                <button class="back-button" onclick="history.back()">
                    ← Kembali
                </button>
                <div></div> <!-- Spacer -->
            </div>
            <div class="confirmation-container" style="display: flex; gap: 40px; background-color: var(--white); border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); padding: 40px; max-width: 900px; width: 100%;">
                <div class="info-section">
                    <h2>Konfirmasi Pesanan</h2>
                    <p>Review pesanan anda sebelum konfirmasi</p>

                    <!-- Info Pesanan -->
                    <div class="info-card">
                        <h3><i class="fas fa-user"></i> Informasi Pesanan</h3>
                        <p><strong>Nama :</strong> Olan Nainggolan</p>
                        <p><strong>HP :</strong> 0812346789</p>
                        <p><strong>Alamat :</strong> Jl. Jalan, balai desa sukamju</p>
                        <p><strong>Catatan :</strong> bagus ya...</p>
                    </div>

                    <!-- Info Pembayaran -->
                    <div class="payment-info">
                        <h3><i class="fas fa-credit-card"></i> Informasi Pembayaran</h3>
                        <ul>
                            <li>Pilih bayar tunai lokal dan dapat...</li>
                            <li>Metode pembayaran tunai:</li>
                            <li>Dana pertaniah kapube kota (BPS)</li>
                            <li>Rama permasalatan identitas</li>
                            <li>dan sa pembayaran dan identitas</li>
                        </ul>
                    </div>
                </div>

                <div class="summary-section">
                    <img src="pupuk.png" alt="Pupuk NPK 16-16-16">
                    <div class="summary-title">Ringkasan pesanan</div>
                    <div class="summary-item">
                        <span>NPK 16-16-16</span>
                        <span class="price">Rp. 2.800</span>
                    </div>
                    <div class="summary-item">
                        <span>1 kg x Rp 2.800</span>
                        <span class="price">Rp. 2.800</span>
                    </div>
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span class="price">Rp. 2.800</span>
                    </div>
                    <div class="summary-item">
                        <span>Ongkos Kirim</span>
                        <span class="price">Rp. 0</span>
                    </div>
                    <div class="summary-item summary-total">
                        <span>Total</span>
                        <span class="price">Rp. 2.800</span>
                    </div>
                    <button class="confirm-button">
                        <i class="fas fa-check"></i> Konfirmasi Pesanan
                    </button>
                    <div class="terms-text">
                        Dengan mengkonfirmasi pesanan, anda menyatakan setuju syarat dan ketentuan yang berlaku.
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <div class="logo">
                    <img src="logo.png" alt="Logo Pupuk & Bibit Subsidi">
                    <div>
                        <h4>Pupuk Subsidi Indonesia</h4>
                        <p>Program Pemerintahan untuk Petani</p>
                    </div>
                </div>
                <p>Platform resmi pemerintahan untuk distribusi pupuk dan bibit bersubsidi kepada petani Indonesia. Mendukung ketahanan pangan nasional melalui program subsidi berkualitas.</p>
                <p class="follow-us">Follow us!</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <div class="footer-links">
                <h4>Menu Utama</h4>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Pupuk & Bibit</a></li>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contact Us</h4>
                <ul>
                    <li class="location"><i class="fas fa-map-marker-alt"></i> Jl. Sitoalama, Laguboti, Toba</li>
                    <li><i class="fas fa-phone"></i> +91 91813 23 309</li>
                    <li><i class="fas fa-envelope"></i> hello@squareup.com</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <img src="lambang himsi.png" alt="Information Systems Logo">
            <p>INFORMATION SYSTEMS<br>Del Institute of Technology</p>
        </div>
    </footer>

    <script>
        // Form submission handler (opsional, sesuaikan dengan backend)
        document.querySelector('.confirm-button').addEventListener('click', function() {
            // Logic konfirmasi pesanan di sini, misalnya submit form
            alert('Pesanan dikonfirmasi!'); // Placeholder
        });
    </script>

</body>
</html>