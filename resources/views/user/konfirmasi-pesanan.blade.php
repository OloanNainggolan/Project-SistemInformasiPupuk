@extends('layouts.user')

@section('title', 'Konfirmasi Pesanan - Pupuk & Bibit Subsidi')

@push('styles')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #333;
            min-height: 100vh;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 50px;
            min-height: calc(100vh - 200px);
            animation: fadeIn 0.5s ease;
        }

        /* Back Button */
        .back-button {
            margin-bottom: 30px;
            animation: slideInUp 0.6s ease;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #065f46;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            transform: translateX(-5px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            animation: slideInUp 0.7s ease;
        }

        .page-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 36px;
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.3);
            animation: pulse 2s ease infinite;
        }

        .page-title {
            font-size: 32px;
            color: #065f46;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #065f46, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 16px;
            color: #059669;
            font-weight: 500;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 35px;
        }

        /* Card Styles */
        .info-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            animation: slideInUp 0.8s ease;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #10b981;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #065f46;
        }

        /* Info Rows */
        .info-row {
            display: grid;
            grid-template-columns: 140px auto;
            gap: 15px;
            margin-bottom: 18px;
            padding: 15px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .info-row:hover {
            background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%);
            transform: translateX(5px);
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 700;
            color: #065f46;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label i {
            color: #10b981;
        }

        .info-value {
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.6;
        }

        /* Payment Info Card */
        .payment-info {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 0;
            border: 2px solid #10b981;
            position: relative;
            overflow: hidden;
        }

        .payment-info::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 3s infinite;
        }

        .payment-title {
            font-weight: 700;
            color: #065f46;
            margin-bottom: 15px;
            font-size: 17px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-title i {
            color: #10b981;
            font-size: 20px;
        }

        .payment-description {
            font-size: 14px;
            color: #047857;
            line-height: 1.7;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .payment-methods {
            display: grid;
            gap: 12px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #065f46;
            font-size: 14px;
            font-weight: 600;
            padding: 12px;
            background: white;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            transform: translateX(10px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .payment-bullet {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .payment-note {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 20px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            border-left: 4px solid #f59e0b;
        }

        .payment-note-icon {
            color: #f59e0b;
            font-size: 20px;
            margin-top: 2px;
        }

        .payment-note-text {
            font-size: 13px;
            color: #92400e;
            line-height: 1.6;
            font-weight: 500;
        }

        /* Order Summary */
        .order-summary-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 80px;
            animation: slideInUp 0.9s ease;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .order-summary-card:hover {
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .product-item {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .product-item:hover {
            background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%);
            transform: scale(1.02);
        }

        .product-image {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid #10b981;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: 700;
            color: #065f46;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .product-sku {
            font-size: 13px;
            color: #10b981;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .product-quantity {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .product-price {
            font-weight: 700;
            color: #065f46;
            font-size: 18px;
            text-align: right;
        }

        /* Price Summary */
        .price-summary {
            margin-top: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 15px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 15px;
            padding: 10px 0;
        }

        .price-label {
            color: #6b7280;
            font-weight: 500;
        }

        .price-value {
            font-weight: 700;
            color: #374151;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            margin-top: 15px;
            background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%);
            border-radius: 12px;
            border: 2px solid #10b981;
        }

        .total-label {
            font-size: 18px;
            font-weight: 700;
            color: #065f46;
        }

        .total-value {
            font-size: 24px;
            font-weight: 700;
            color: #10b981;
        }

        /* Confirm Button */
        .confirm-button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .confirm-button:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5);
        }

        .confirm-button:active {
            transform: translateY(0);
        }

        .confirm-note {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 15px;
            line-height: 1.6;
            font-weight: 500;
        }

        /* Success Badge */
        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 15px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-top: 10px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .order-summary-card {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px;
            }

            .page-title {
                font-size: 24px;
            }

            .page-icon {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }

            .info-card, .order-summary-card {
                padding: 20px;
            }

            .info-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .product-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .product-price {
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-container">
        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ route('user.pupukbibit.detail', $produk->id_produk) }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h1 class="page-title">Konfirmasi Pesanan</h1>
            <p class="page-subtitle">Review pesanan Anda sebelum konfirmasi</p>
            <span class="badge-verified">
                <i class="fas fa-shield-alt"></i>
                Transaksi Aman & Terpercaya
            </span>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Left Column -->
            <div>
                <!-- Informasi Pesanan -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <h2 class="card-title">Informasi Pesanan</h2>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user-circle"></i> Nama</span>
                        <span class="info-value">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-phone"></i> HP</span>
                        <span class="info-value">{{ auth()->user()->no_hp ?? '08123456789' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-map-marker-alt"></i> Alamat</span>
                        <span class="info-value">{{ auth()->user()->alamat ?? 'Jl. Jalan-jalan, balai desa sukamaju' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-comment-dots"></i> Catatan</span>
                        <span class="info-value">{{ $catatan ?? 'bagus yaa...' }}</span>
                    </div>
                </div>

                <!-- Informasi Pembayaran -->
                <div class="info-card" style="margin-top: 20px;">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h2 class="card-title">Informasi Pembayaran</h2>
                    </div>
                    <div class="payment-info">
                        <div class="payment-title">
                            <i class="fas fa-map-marker-alt"></i>
                            Pembayaran Tunai di Lokasi
                        </div>
                        <p class="payment-description">
                            Setelah pesanan dikonfirmasi, Anda dapat melakukan pembayaran di:
                        </p>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <div class="payment-bullet">1</div>
                                <span>Balai Desa setempat</span>
                            </div>
                            <div class="payment-method">
                                <div class="payment-bullet">2</div>
                                <span>Dinas Pertanian Kabupaten/Kota</span>
                            </div>
                            <div class="payment-method">
                                <div class="payment-bullet">3</div>
                                <span>Kantor Penyuluhan Pertanian (BP3K)</span>
                            </div>
                        </div>
                        <div class="payment-note">
                            <i class="fas fa-exclamation-circle payment-note-icon"></i>
                            <div class="payment-note-text">
                                Bawa <strong>nomor pesanan</strong> dan <strong>identitas diri</strong> saat pembayaran. Pembayaran dapat dilakukan maksimal 3 hari setelah konfirmasi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div>
                <div class="order-summary-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h2 class="card-title">Informasi Pesanan</h2>
                    </div>

                    <!-- Product Item -->
                    <div class="product-item">
                        @php
                            // Cek apakah produk punya primaryImage (dari database) atau gambar (data statis)
                            if (isset($produk->primaryImage) && $produk->primaryImage) {
                                $imageSrc = asset('images/products/' . $produk->primaryImage->image_path);
                            } elseif (isset($produk->gambar) && !filter_var($produk->gambar, FILTER_VALIDATE_URL)) {
                                $imageSrc = asset('images/products/' . $produk->gambar);
                            } else {
                                $imageSrc = $produk->gambar ?? asset('images/placeholder-product.jpg');
                            }
                        @endphp
                        <img src="{{ $imageSrc }}" alt="{{ $produk->nama_produk }}" class="product-image">
                        <div class="product-details">
                            <div class="product-name">Ringkasan pesanan</div>
                            <div class="product-sku">NPK 16-16-16</div>
                            <div class="product-quantity">{{ $quantity ?? 1 }} kg x Rp. {{ number_format($produk->harga_subsidi, 0, ',', '.') }}</div>
                        </div>
                        <div class="product-price">
                            Rp. {{ number_format($produk->harga_subsidi * ($quantity ?? 1), 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="price-summary">
                        <div class="price-row">
                            <span class="price-label">Subtotal</span>
                            <span class="price-value">Rp. {{ number_format($produk->harga_subsidi * ($quantity ?? 1), 0, ',', '.') }}</span>
                        </div>
                        <div class="price-row">
                            <span class="price-label">Ongkos Kirim</span>
                            <span class="price-value">Rp. 0</span>
                        </div>
                        <div class="total-row">
                            <span class="total-label">Total</span>
                            <span class="total-value">Rp {{ number_format($produk->harga_subsidi * ($quantity ?? 1), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <button class="confirm-button" onclick="konfirmasiPesanan()">
                        <i class="fas fa-check-circle"></i>
                        Konfirmasi Pesanan
                    </button>

                    <p class="confirm-note">
                        Dengan mengkonfirmasi pesanan, Anda menyetujui syarat dan ketentuan yang berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function konfirmasiPesanan() {
            if (confirm('Apakah Anda yakin ingin mengkonfirmasi pesanan ini?')) {
                alert('Pesanan Anda telah dikonfirmasi!\n\nNomor Pesanan: #' + Math.random().toString(36).substr(2, 9).toUpperCase() + '\n\nSilakan lakukan pembayaran di lokasi yang telah ditentukan.\n\nTerima kasih!');
                // Redirect ke halaman dashboard atau riwayat pesanan
                window.location.href = "{{ route('dashboard') }}";
            }
        }
    </script>
@endpush
