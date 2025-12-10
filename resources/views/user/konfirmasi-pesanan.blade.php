@extends('layouts.user')

@section('title', 'Konfirmasi Pesanan - Pupuk & Bibit Subsidi')

@push('styles')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 700;
            color: #065f46;
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: #10b981;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            background: white;
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            background: #f9fafb;
        }

        .form-input:hover {
            border-color: #10b981;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 80px;
        }

        /* Quantity Display (Read-only) */
        .quantity-display {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 12px;
            padding: 12px;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-radius: 10px;
            border: 2px solid #10b981;
        }

        .quantity-label {
            font-weight: 700;
            color: #065f46;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .quantity-label i {
            color: #10b981;
            font-size: 16px;
        }

        .quantity-value-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);
            border: 2px solid #d1fae5;
        }

        .quantity-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        }

        .quantity-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
        }

        .quantity-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 2px rgba(16, 185, 129, 0.3);
        }

        .quantity-btn:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .quantity-display-input {
            width: 60px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 20px;
            font-weight: 800;
            color: #10b981;
            outline: none;
            -moz-appearance: textfield;
        }

        .quantity-display-input::-webkit-outer-spin-button,
        .quantity-display-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .quantity-display-input:focus {
            color: #047857;
        }

        .quantity-unit {
            font-weight: 700;
            color: #059669;
            font-size: 14px;
        }

        /* Price per unit styling */
        .product-quantity {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .price-per-unit-label {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }

        .price-per-unit-value {
            color: #065f46;
            font-size: 16px;
            font-weight: 700;
        }

        /* Original Price Strikethrough */
        .original-price {
            text-decoration: line-through;
            color: #9ca3af !important;
            font-size: 14px;
        }

        /* Discount Rows */
        .discount-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .subsidy-row {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-left: 4px solid #10b981;
        }

        .promo-row {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
        }

        .discount-label {
            color: #065f46;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .discount-label i {
            font-size: 16px;
        }

        .subsidy-row .discount-label i {
            color: #10b981;
        }

        .promo-row .discount-label i {
            color: #f59e0b;
        }

        .promo-code {
            background: white;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 800;
            color: #f59e0b;
            border: 1px solid #fbbf24;
            margin-left: 6px;
        }

        .discount-value {
            font-weight: 800;
            color: #059669;
        }

        /* Savings Highlight */
        .savings-highlight {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        .savings-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .savings-content {
            flex: 1;
        }

        .savings-label {
            font-size: 13px;
            font-weight: 600;
            opacity: 0.9;
            margin-bottom: 4px;
        }

        .savings-amount {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 6px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .savings-percent {
            font-size: 12px;
            font-weight: 600;
            opacity: 0.85;
            background: rgba(255, 255, 255, 0.2);
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* Divider */
        .divider-dashed {
            border-top: 2px dashed #d1d5db;
            margin: 16px 0;
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
                font-size: 20px;
                margin-top: 10px;
            }

            .quantity-display {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .quantity-value-box {
                width: auto;
            }
            
            .quantity-btn {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
            
            .quantity-display-input {
                width: 70px;
                font-size: 18px;
            }

            .savings-highlight {
                flex-direction: column;
                text-align: center;
            }

            .savings-amount {
                font-size: 24px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-input {
                font-size: 16px; /* Prevent zoom on iOS */
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
                    <form id="formInfoPesanan">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-user-circle"></i> Nama Lengkap</label>
                            <input type="text" class="form-input" id="nama" name="nama" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-phone"></i> Nomor HP</label>
                            <input type="tel" class="form-input" id="no_hp" name="no_hp" value="{{ auth()->user()->no_hp ?? '08123456789' }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat Lengkap</label>
                            <textarea class="form-input" id="alamat" name="alamat" rows="3" required>{{ auth()->user()->alamat ?? 'Jl. Jalan-jalan, balai desa sukamaju' }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-comment-dots"></i> Catatan (Opsional)</label>
                            <textarea class="form-input" id="catatan" name="catatan" rows="2" placeholder="Tambahkan catatan untuk pesanan...">{{ $catatan ?? '' }}</textarea>
                        </div>
                    </form>
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
                            $imageSrc = 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=300&h=300&fit=crop';
                            
                            // Cek gambar dari relasi database
                            if (isset($produk->primaryImage) && $produk->primaryImage) {
                                // primaryImage sudah punya image_path lengkap
                                $imageSrc = asset($produk->primaryImage->image_path);
                            } elseif (isset($produk->images) && $produk->images->count() > 0) {
                                // Ambil gambar pertama dari collection
                                $imageSrc = asset($produk->images->first()->image_path);
                            } elseif (isset($produk->gambar) && !empty($produk->gambar)) {
                                // Field gambar lama
                                if (filter_var($produk->gambar, FILTER_VALIDATE_URL)) {
                                    $imageSrc = $produk->gambar;
                                } else {
                                    $imageSrc = asset($produk->gambar);
                                }
                            }
                        @endphp
                        <img src="{{ $imageSrc }}" alt="{{ $produk->nama_produk }}" class="product-image" onerror="this.src='https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=300&h=300&fit=crop'">
                        <div class="product-details" style="flex: 1;">
                            <div class="product-name">{{ $produk->nama_produk }}</div>
                            <div class="product-sku">{{ $produk->kategori ?? 'NPK 16-16-16' }}</div>
                            
                            <div class="quantity-display">
                                <span class="quantity-label"><i class="fas fa-box"></i> Jumlah Pesanan:</span>
                                <div class="quantity-value-box">
                                    <button type="button" class="quantity-btn" id="decreaseBtn" onclick="decreaseQuantity()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantityInput" class="quantity-display-input" value="{{ $quantity ?? 1 }}" min="1" max="{{ $produk->stok }}" onchange="updateQuantity()" oninput="updateQuantity()">
                                    <button type="button" class="quantity-btn" id="increaseBtn" onclick="increaseQuantity()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <span class="quantity-unit">kg</span>
                                </div>
                            </div>
                            <div class="product-quantity" style="margin-top: 12px;">
                                <span class="price-per-unit-label">Harga:</span>
                                <span id="pricePerUnit" class="price-per-unit-value">Rp {{ number_format($produk->harga_subsidi, 0, ',', '.') }}</span>
                                <span class="price-per-unit-label">/ kg</span>
                            </div>
                        </div>
                        <div class="product-price" id="productTotalPrice">
                            Rp. {{ number_format($produk->harga_subsidi * ($quantity ?? 1), 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="price-summary">
                        @php
                            $calculatedSubsidy = ($produk->harga_normal - $produk->harga_subsidi) * ($quantity ?? 1);
                            $totalDiscount = ($discountAmount ?? 0) + $calculatedSubsidy;
                        @endphp
                        
                        <div class="price-row">
                            <span class="price-label"><i class="fas fa-receipt" style="color: #6b7280;"></i> Harga Normal</span>
                            <span class="price-value original-price">Rp {{ number_format($produk->harga_normal * ($quantity ?? 1), 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Subsidi Pemerintah -->
                        @if($calculatedSubsidy > 0)
                        <div class="discount-row subsidy-row">
                            <span class="discount-label">
                                <i class="fas fa-hand-holding-heart"></i> Subsidi Pemerintah
                            </span>
                            <span class="discount-value">- Rp {{ number_format($calculatedSubsidy, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <!-- Potongan Tambahan -->
                        @if(($discountAmount ?? 0) > 0)
                        <div class="discount-row promo-row">
                            <span class="discount-label">
                                <i class="fas fa-tags"></i> Potongan Promo
                                @if(isset($bestDiscount))
                                    <span class="promo-code">{{ $bestDiscount->code }}</span>
                                @endif
                            </span>
                            <span class="discount-value">- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <!-- Total Penghematan -->
                        @if($totalDiscount > 0)
                        <div class="savings-highlight">
                            <div class="savings-icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div class="savings-content">
                                <div class="savings-label">Total Penghematan Anda</div>
                                <div class="savings-amount">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</div>
                                @php
                                    $savingsPercent = ($produk->harga_normal > 0) ? round(($totalDiscount / ($produk->harga_normal * ($quantity ?? 1))) * 100) : 0;
                                @endphp
                                <div class="savings-percent">Hemat {{ $savingsPercent }}% dari harga normal!</div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="divider-dashed"></div>
                        
                        <div class="total-row">
                            <span class="total-label"><i class="fas fa-wallet"></i> Total Bayar</span>
                            <span class="total-value" id="totalValue">Rp {{ number_format($total ?? ($produk->harga_subsidi * ($quantity ?? 1)), 0, ',', '.') }}</span>
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Harga per unit dari backend
        const hargaPerUnit = {{ $produk->harga_subsidi }};
        const hargaNormal = {{ $produk->harga_normal }};
        const productName = '{{ $produk->nama_produk }}';
        const maxStock = {{ $produk->stok }};
        const subsidyAmount = {{ $produk->harga_normal - $produk->harga_subsidi }};
        const discountAmount = {{ $discountAmount ?? 0 }};
        
        // Get product image dari database
        @php
            $popupImageSrc = 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=200&h=200&fit=crop';
            if(isset($produk->primaryImage) && $produk->primaryImage) {
                $popupImageSrc = asset($produk->primaryImage->image_path);
            } elseif(isset($produk->images) && $produk->images->count() > 0) {
                $popupImageSrc = asset($produk->images->first()->image_path);
            } elseif(isset($produk->gambar) && !empty($produk->gambar)) {
                if(filter_var($produk->gambar, FILTER_VALIDATE_URL)) {
                    $popupImageSrc = $produk->gambar;
                } else {
                    $popupImageSrc = asset($produk->gambar);
                }
            }
        @endphp
        const productImage = '{{ $popupImageSrc }}';
        
        // Quantity control functions
        function increaseQuantity() {
            const input = document.getElementById('quantityInput');
            let currentValue = parseInt(input.value) || 1;
            
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                updateQuantity();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: `Stok tersedia hanya ${maxStock} kg!`,
                    confirmButtonColor: '#10b981'
                });
            }
        }
        
        function decreaseQuantity() {
            const input = document.getElementById('quantityInput');
            let currentValue = parseInt(input.value) || 1;
            
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateQuantity();
            }
        }
        
        function updateQuantity() {
            const input = document.getElementById('quantityInput');
            let quantity = parseInt(input.value) || 1;
            
            // Validate input
            if (quantity < 1) {
                quantity = 1;
                input.value = 1;
            } else if (quantity > maxStock) {
                quantity = maxStock;
                input.value = maxStock;
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: `Stok tersedia hanya ${maxStock} kg!`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
            
            // Update button states
            document.getElementById('decreaseBtn').disabled = (quantity <= 1);
            document.getElementById('increaseBtn').disabled = (quantity >= maxStock);
            
            // Update price displays
            const totalPrice = hargaPerUnit * quantity;
            const normalPrice = hargaNormal * quantity;
            const totalSubsidy = subsidyAmount * quantity;
            const totalDiscount = discountAmount + totalSubsidy;
            const finalTotal = normalPrice - totalDiscount;
            
            // Update product total price
            document.getElementById('productTotalPrice').textContent = 
                'Rp. ' + totalPrice.toLocaleString('id-ID');
            
            // Update price summary
            document.querySelectorAll('.price-row .price-value.original-price').forEach(el => {
                el.textContent = 'Rp ' + normalPrice.toLocaleString('id-ID');
            });
            
            // Update subsidy row
            const subsidyRow = document.querySelector('.discount-row.subsidy-row .discount-value');
            if (subsidyRow) {
                subsidyRow.textContent = '- Rp ' + totalSubsidy.toLocaleString('id-ID');
            }
            
            // Update final total
            document.querySelectorAll('.total-row .total-value').forEach(el => {
                el.textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');
            });
        }
        
        // Initialize button states on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateQuantity();
        });
        
        // Konfirmasi pesanan dengan SweetAlert2
        function konfirmasiPesanan() {
            // Ambil data dari form
            const nama = document.getElementById('nama').value.trim();
            const noHp = document.getElementById('no_hp').value.trim();
            const alamat = document.getElementById('alamat').value.trim();
            const catatan = document.getElementById('catatan').value.trim();
            const quantity = parseInt(document.getElementById('quantityInput').value);
            
            // Validasi form
            if (!nama || !noHp || !alamat) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi Nama, No. HP, dan Alamat Pengiriman!',
                    confirmButtonColor: '#10b981'
                });
                return;
            }
            
            if (quantity < 1 || quantity > 100) {
                Swal.fire({
                    icon: 'error',
                    title: 'Jumlah Tidak Valid',
                    text: 'Jumlah pesanan harus antara 1-100 unit!',
                    confirmButtonColor: '#10b981'
                });
                return;
            }
            
            // Hitung total
            const total = hargaPerUnit * quantity;
            
            // Tampilkan konfirmasi dengan SweetAlert2
            Swal.fire({
                title: 'Konfirmasi Pesanan Anda',
                html: `
                    <div style="text-align: center; padding: 20px;">
                        <img src="${productImage}" 
                             style="width: 180px; height: 180px; object-fit: cover; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
                        
                        <h3 style="font-size: 22px; font-weight: 700; color: #1f2937; margin-bottom: 20px;">${productName}</h3>
                        
                        <div style="background: #f9fafb; border-radius: 12px; padding: 16px; margin-bottom: 16px; text-align: left;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #6b7280; font-weight: 600;"><i class="fas fa-user"></i> Nama:</span>
                                <span style="color: #1f2937; font-weight: 700;">${nama}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #6b7280; font-weight: 600;"><i class="fas fa-phone"></i> HP:</span>
                                <span style="color: #1f2937; font-weight: 700;">${noHp}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #6b7280; font-weight: 600;"><i class="fas fa-map-marker-alt"></i> Alamat:</span>
                                <span style="color: #1f2937; font-weight: 700; max-width: 200px; text-align: right;">${alamat}</span>
                            </div>
                            ${catatan ? `
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #6b7280; font-weight: 600;"><i class="fas fa-sticky-note"></i> Catatan:</span>
                                <span style="color: #1f2937; font-weight: 700; max-width: 200px; text-align: right;">${catatan}</span>
                            </div>
                            ` : ''}
                            <hr style="border: 0; border-top: 2px dashed #e5e7eb; margin: 12px 0;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="color: #6b7280; font-weight: 600;"><i class="fas fa-box"></i> Jumlah:</span>
                                <span style="color: #1f2937; font-weight: 700;">${quantity} unit</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #059669; font-weight: 700; font-size: 16px;"><i class="fas fa-money-bill-wave"></i> Total:</span>
                                <span style="color: #10b981; font-weight: 800; font-size: 24px;">Rp ${total.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        
                        <p style="font-size: 15px; color: #374151; margin-top: 16px; font-weight: 600;">
                            <i class="fas fa-question-circle"></i> Apakah data pesanan sudah benar?
                        </p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check-circle"></i> Ya, Konfirmasi Pesanan',
                cancelButtonText: '<i class="fas fa-times-circle"></i> Periksa Lagi',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                reverseButtons: true,
                width: '600px',
                customClass: {
                    popup: 'animated-popup',
                    confirmButton: 'swal-btn-confirm',
                    cancelButton: 'swal-btn-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menyimpan Pesanan',
                        html: '<i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #10b981;"></i><br><br>Mohon tunggu sebentar...',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    
                    // Submit data ke server untuk disimpan ke database
                    fetch('{{ route("user.pupukbibit.store", $produk->id_produk) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: quantity,
                            customer_name: nama,
                            customer_phone: noHp,
                            customer_address: alamat,
                            customer_notes: catatan
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            const nomorPesanan = data.order_number;
                            const total = data.total_amount;
                            
                            // Tampilkan sukses dengan informasi pembayaran
                            Swal.fire({
                                icon: 'success',
                                title: '🎉 Pesanan Berhasil Dikonfirmasi!',
                                html: `
                            <div style="text-align: center; padding: 20px;">
                                <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);">
                                    <h3 style="font-size: 18px; margin-bottom: 8px; font-weight: 700;">Nomor Pesanan</h3>
                                    <p style="font-size: 32px; font-weight: 800; letter-spacing: 2px; margin: 0;">${nomorPesanan}</p>
                                </div>
                                
                                <div style="background: #f9fafb; border-radius: 12px; padding: 20px; margin-bottom: 16px; text-align: left;">
                                    <h4 style="color: #1f2937; font-weight: 700; margin-bottom: 12px; font-size: 16px;">
                                        <i class="fas fa-money-bill-wave" style="color: #10b981;"></i> Total Pembayaran
                                    </h4>
                                    <p style="font-size: 28px; font-weight: 800; color: #10b981; margin: 0 0 16px 0;">
                                        Rp ${total.toLocaleString('id-ID')}
                                    </p>
                                    
                                    <h4 style="color: #1f2937; font-weight: 700; margin-bottom: 12px; font-size: 16px;">
                                        <i class="fas fa-map-marker-alt" style="color: #10b981;"></i> Lokasi Pembayaran
                                    </h4>
                                    <ul style="text-align: left; color: #374151; line-height: 1.8; padding-left: 20px; margin: 0;">
                                        <li><strong>Balai Desa setempat</strong></li>
                                        <li><strong>Dinas Pertanian Kabupaten/Kota</strong></li>
                                        <li><strong>Kantor Penyuluhan Pertanian (BP3K)</strong></li>
                                    </ul>
                                    
                                    <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px; border-radius: 8px; margin-top: 16px;">
                                        <p style="margin: 0; color: #92400e; font-size: 14px; font-weight: 600;">
                                            <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i> 
                                            <strong>Penting:</strong> Bawa nomor pesanan dan identitas diri (KTP/KK)
                                        </p>
                                    </div>
                                    
                                    <div style="background: #fee2e2; border-left: 4px solid #ef4444; padding: 12px; border-radius: 8px; margin-top: 12px;">
                                        <p style="margin: 0; color: #991b1b; font-size: 14px; font-weight: 600;">
                                            <i class="fas fa-clock" style="color: #ef4444;"></i> 
                                            <strong>Batas Waktu:</strong> Maksimal 3 hari setelah konfirmasi
                                        </p>
                                    </div>
                                </div>
                                
                                <p style="font-size: 16px; color: #059669; font-weight: 700; margin-top: 20px;">
                                    <i class="fas fa-heart" style="color: #ef4444;"></i> Terima kasih atas pesanan Anda!
                                </p>
                            </div>
                        `,
                        confirmButtonText: '<i class="fas fa-home"></i> Kembali ke Dashboard',
                        confirmButtonColor: '#10b981',
                        allowOutsideClick: false,
                        width: '650px',
                        customClass: {
                            popup: 'success-popup'
                        }
                    }).then(() => {
                        // Redirect ke dashboard
                        window.location.href = "{{ route('dashboard') }}";
                    });
                        } else {
                            // Error saat menyimpan
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menyimpan Pesanan',
                                text: data.message || 'Terjadi kesalahan saat menyimpan pesanan',
                                confirmButtonColor: '#10b981'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menghubungi server. Silakan coba lagi.',
                            confirmButtonColor: '#10b981'
                        });
                    });
                }
            });
        }
        
        // Initialize - quantity is fixed, no need for updates
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Konfirmasi pesanan page loaded');
        });
    </script>
@endpush
