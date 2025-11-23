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
            background-color: #f0f9f4;
            color: #333;
            min-height: 100vh;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 50px;
            min-height: calc(100vh - 200px);
        }

        /* Back Button */
        .back-button {
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            color: #2e7d32;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #059669;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        /* Card Styles */
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e8f5e9;
        }

        .card-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #2e7d32;
        }

        /* Info Rows */
        .info-row {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            min-width: 120px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        .info-separator {
            margin: 0 10px;
            color: #999;
        }

        .info-value {
            flex: 1;
            color: #333;
            font-size: 14px;
        }

        /* Payment Info Card */
        .payment-info {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .payment-title {
            font-weight: 700;
            color: #065f46;
            margin-bottom: 15px;
            font-size: 15px;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #047857;
            font-size: 13px;
        }

        .payment-bullet {
            width: 6px;
            height: 6px;
            background: #10b981;
            border-radius: 50%;
        }

        .payment-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 15px;
            padding: 12px;
            background: rgba(251, 191, 36, 0.1);
            border-radius: 8px;
        }

        .payment-note-icon {
            color: #f59e0b;
            font-size: 16px;
            margin-top: 2px;
        }

        .payment-note-text {
            font-size: 12px;
            color: #92400e;
            line-height: 1.5;
        }

        /* Order Summary */
        .order-summary-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 80px;
        }

        .product-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e8f5e9;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: #2e7d32;
            margin-bottom: 5px;
            font-size: 15px;
        }

        .product-sku {
            font-size: 12px;
            color: #999;
            margin-bottom: 8px;
        }

        .product-quantity {
            font-size: 13px;
            color: #666;
        }

        .product-price {
            font-weight: 700;
            color: #2e7d32;
            font-size: 16px;
            text-align: right;
        }

        /* Price Summary */
        .price-summary {
            margin-top: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .price-label {
            color: #666;
        }

        .price-value {
            font-weight: 600;
            color: #333;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            margin-top: 15px;
            border-top: 2px solid #e8f5e9;
        }

        .total-label {
            font-size: 16px;
            font-weight: 700;
            color: #2e7d32;
        }

        .total-value {
            font-size: 20px;
            font-weight: 700;
            color: #10b981;
        }

        /* Confirm Button */
        .confirm-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .confirm-button:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .confirm-note {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 15px;
            line-height: 1.5;
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
                font-size: 22px;
            }

            .info-card, .order-summary-card {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-label {
                min-width: auto;
            }

            .info-separator {
                display: none;
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
            <h1 class="page-title">Konfirmasi Pesanan</h1>
            <p class="page-subtitle">Review pesanan anda sebelum konfirmasi</p>
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
                        <span class="info-label">Nama</span>
                        <span class="info-separator">:</span>
                        <span class="info-value">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">HP</span>
                        <span class="info-separator">:</span>
                        <span class="info-value">{{ auth()->user()->no_hp ?? '08123456789' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-separator">:</span>
                        <span class="info-value">{{ auth()->user()->alamat ?? 'Jl. Jalan-jalan, balai desa sukamaju' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Catatan</span>
                        <span class="info-separator">:</span>
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
                            <i class="fas fa-map-marker-alt"></i> Pembayaran Tunai di Lokasi
                        </div>
                        <p style="font-size: 13px; color: #047857; line-height: 1.6;">
                            Setelah pesanan dikonfirmasi, Anda dapat melakukan pembayaran di:
                        </p>
                        <div class="payment-methods">
                            <div class="payment-method">
                                <div class="payment-bullet"></div>
                                <span>Balai Desa setempat</span>
                            </div>
                            <div class="payment-method">
                                <div class="payment-bullet"></div>
                                <span>Dinas Pertanian Kabupaten/Kota</span>
                            </div>
                            <div class="payment-method">
                                <div class="payment-bullet"></div>
                                <span>Kantor Penyuluhan Pertanian (BP3K)</span>
                            </div>
                        </div>
                        <div class="payment-note">
                            <i class="fas fa-exclamation-circle payment-note-icon"></i>
                            <div class="payment-note-text">
                                Bawa <strong>nomor</strong> pesanan dan identitas diri saat pembayaran
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
