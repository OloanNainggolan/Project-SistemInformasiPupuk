@extends('layouts.user')

@section('title', 'Detail Produk')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-detail {
        max-width: 1280px;
        margin: 0 auto;
        padding: 32px 24px 60px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #065f46;
        text-decoration: none;
        font-weight: 700;
        margin-bottom: 28px;
        padding: 12px 24px;
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .back-link:hover {
        transform: translateX(-8px);
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.15);
        border-color: rgba(16, 185, 129, 0.2);
    }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 460px 1fr;
        gap: 36px;
        margin-bottom: 40px;
    }

    .product-images {
        background: white;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        position: sticky;
        top: 24px;
        height: fit-content;
    }

    .main-image {
        width: 100%;
        height: 600px;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 18px;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(0,0,0,0.04);
        position: relative;
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: all 0.3s ease;
    }

    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid #10b981;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #10b981;
        font-size: 20px;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10;
    }

    .carousel-btn:hover {
        background: #10b981;
        color: white;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .carousel-btn:active {
        transform: translateY(-50%) scale(0.95);
    }

    .carousel-btn.prev {
        left: 15px;
    }

    .carousel-btn.next {
        right: 15px;
    }

    .carousel-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .carousel-btn:disabled:hover {
        background: rgba(255, 255, 255, 0.95);
        color: #10b981;
        transform: translateY(-50%);
    }

    .main-image:hover img {
        transform: scale(1.05);
    }

    .thumbnail-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .thumbnail {
        width: 100%;
        height: 92px;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: #f3f4f6;
    }

    .thumbnail:hover {
        border-color: #10b981;
        transform: scale(1.08);
    }

    .thumbnail.active {
        border-color: #10b981;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info-card {
        background: white;
        border-radius: 24px;
        padding: 36px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
    }

    .product-title {
        font-size: 36px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 20px;
        line-height: 1.2;
        letter-spacing: -0.8px;
    }

    .price-section {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-radius: 18px;
        padding: 24px;
        margin-bottom: 28px;
        border: 2px solid rgba(16, 185, 129, 0.2);
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .price-row:last-child {
        margin-bottom: 0;
        padding-top: 12px;
        border-top: 2px dashed rgba(16, 185, 129, 0.3);
    }

    .price-label {
        color: #065f46;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .price-value {
        font-size: 28px;
        font-weight: 800;
        color: #059669;
        letter-spacing: -0.5px;
    }

    .price-normal {
        text-decoration: line-through;
        color: #9ca3af;
        font-size: 18px;
        font-weight: 600;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 24px;
        font-size: 13px;
        font-weight: 700;
        margin-right: 10px;
        margin-bottom: 10px;
        letter-spacing: 0.3px;
    }

    .badge-subsidi {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .order-section {
        margin-top: 28px;
        padding-top: 28px;
        border-top: 3px solid #f3f4f6;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .quantity-label {
        font-weight: 700;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
    }

    .quantity-buttons {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #f9fafb;
        padding: 10px 16px;
        border-radius: 14px;
        border: 2px solid #e5e7eb;
    }

    .qty-btn {
        width: 38px;
        height: 38px;
        border: none;
        background: white;
        border-radius: 10px;
        cursor: pointer;
        font-size: 18px;
        font-weight: 700;
        color: #10b981;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .qty-btn:hover {
        background: #10b981;
        color: white;
        transform: scale(1.15);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .qty-btn:active {
        transform: scale(0.95);
    }

    .qty-display {
        font-size: 20px;
        font-weight: 800;
        color: #065f46;
        min-width: 60px;
        width: 60px;
        text-align: center;
        border: 2px solid #d1fae5;
        border-radius: 8px;
        padding: 4px 8px;
        background: white;
        transition: all 0.3s ease;
    }

    .qty-display:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .qty-display:disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Hide number input spinner arrows */
    .qty-display::-webkit-outer-spin-button,
    .qty-display::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .qty-display[type=number] {
        -moz-appearance: textfield;
    }

    .stock-info {
        font-size: 13px;
        color: #6b7280;
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .summary-box {
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: inset 0 2px 8px rgba(0,0,0,0.04);
        border: 2px solid #f3f4f6;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        font-size: 15px;
    }

    .summary-label {
        color: #6b7280;
        font-weight: 600;
    }

    .summary-value {
        font-weight: 700;
        color: #1f2937;
    }

    .summary-total {
        border-top: 3px solid #e5e7eb;
        padding-top: 18px;
        margin-top: 18px;
    }

    .summary-total .summary-label {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
    }

    .summary-total .summary-value {
        font-size: 26px;
        font-weight: 800;
        color: #10b981;
        letter-spacing: -0.5px;
    }

    .btn-order {
        width: 100%;
        padding: 18px;
        border: none;
        border-radius: 16px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        font-size: 17px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35);
        position: relative;
        overflow: hidden;
        letter-spacing: 0.3px;
    }

    .btn-order::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-order:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-order:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px rgba(16, 185, 129, 0.4);
    }

    .btn-order:active {
        transform: translateY(-2px);
    }

    .info-notice {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-left: 4px solid #3b82f6;
        padding: 18px 20px;
        border-radius: 12px;
        margin-top: 24px;
        font-size: 14px;
        color: #1e40af;
        line-height: 1.6;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
    }

    .info-notice i {
        font-size: 18px;
        margin-top: 2px;
    }

    .product-info-section {
        background: white;
        border-radius: 24px;
        padding: 36px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        margin-bottom: 32px;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 26px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 3px solid #10b981;
        letter-spacing: -0.5px;
    }

    .section-title i {
        color: #10b981;
        font-size: 24px;
    }

    .description-text {
        color: #4b5563;
        line-height: 1.9;
        font-size: 15px;
        margin-bottom: 24px;
    }

    @media (max-width: 1024px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
        }

        .product-images {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 768px) {
        .container-detail {
            padding: 20px 16px 40px;
        }

        .product-title {
            font-size: 26px;
        }

        .main-image {
            height: 320px;
        }

        .thumbnail-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .product-info-card,
        .product-info-section {
            padding: 24px;
        }

        .quantity-control {
            flex-direction: column;
            align-items: flex-start;
        }

        .stock-info {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-detail">
    <a href="{{ route('pupuk.bibit') }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>

    <div class="product-detail-grid">
        <!-- Product Images -->
        <div class="product-images">
            @php
            $imageList = [];
            if(isset($produk->images) && $produk->images->count() > 0) {
                foreach($produk->images as $image) {
                    $imageList[] = asset($image->image_path);
                }
            } else {
                $fallbackSrc = 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&h=600&fit=crop';
                if(isset($produk)) {
                    if(isset($produk->primaryImage)) {
                        $fallbackSrc = asset($produk->primaryImage->gambar);
                    } elseif(isset($produk->gambar)) {
                        if(filter_var($produk->gambar, FILTER_VALIDATE_URL)) {
                            $fallbackSrc = $produk->gambar;
                        } else {
                            $fallbackSrc = asset($produk->gambar);
                        }
                    }
                }
                $imageList[] = $fallbackSrc;
            }
            $imageSrc = $imageList[0] ?? '';
            @endphp
            
            <!-- Hidden data untuk JavaScript -->
            <div id="imageData" data-images='@json($imageList)' style="display: none;"></div>
            
            <div class="main-image">
                <!-- Tombol Previous -->
                <button class="carousel-btn prev" onclick="prevImage()" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <img id="mainProductImage" src="{{ $imageSrc }}" alt="{{ $produk->nama_produk ?? 'Produk' }}">
                
                <!-- Tombol Next -->
                <button class="carousel-btn next" onclick="nextImage()" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="thumbnail-grid">
                @if(isset($produk->images) && $produk->images->count() > 0)
                    @foreach($produk->images as $index => $image)
                        <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" onclick="goToImage({{ $index }})" data-index="{{ $index }}">
                            <img src="{{ asset($image->image_path) }}" alt="Thumbnail {{ $index + 1 }}">
                        </div>
                    @endforeach
                @else
                    <div class="thumbnail active" onclick="goToImage(0)" data-index="0">
                        <img src="{{ $imageSrc }}" alt="Thumbnail 1">
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info-card">
            <h1 class="product-title">{{ $produk->nama_produk ?? 'Pupuk Urea' }}</h1>
            
            <div>
                <span class="badge badge-subsidi">
                    <i class="fas fa-check-circle"></i>
                    Tersertifikasi & Bersubsidi
                </span>
            </div>

            <div class="price-section">
                <div class="price-row">
                    <span class="price-label">Harga Normal</span>
                    <span class="price-normal">Rp {{ number_format($produk->harga_normal ?? 2800, 0, ',', '.') }}</span>
                </div>
                <div class="price-row">
                    <span class="price-label">Harga Subsidi</span>
                    <span class="price-value">Rp{{ number_format($produk->harga_subsidi ?? 2800, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="order-section">
                <div class="quantity-control">
                    <span class="quantity-label">
                        <i class="fas fa-box"></i>
                        Jumlah Produk yang dipesan:
                    </span>
                    <div class="quantity-buttons">
                        <button class="qty-btn" onclick="decreaseQty()" {{ ($produk->stok_produk ?? 0) == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" class="qty-display" id="qtyDisplay" value="1" min="1" max="{{ $produk->stok_produk ?? 1 }}" oninput="handleManualInput(this.value)" {{ ($produk->stok_produk ?? 0) == 0 ? 'disabled' : '' }}>
                        <button class="qty-btn" onclick="increaseQty()" {{ ($produk->stok_produk ?? 0) == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    @php
                        $stock = $produk->stok_produk ?? 0;
                    @endphp
                    <span class="stock-info" id="stockInfo" style="{{ $stock == 0 ? 'color: #ef4444;' : ($stock < 10 ? 'color: #f59e0b;' : 'color: #10b981;') }}">
                        <i class="fas fa-{{ $stock == 0 ? 'times-circle' : ($stock < 10 ? 'exclamation-triangle' : 'warehouse') }}"></i>
                        @if($stock == 0)
                            Stok Habis
                        @elseif($stock < 10)
                            Tersisa {{ $stock }} unit (Segera habis!)
                        @else
                            Tersedia {{ $stock }} unit
                        @endif
                    </span>
                    <div id="stockWarning" style="display: none; background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-top: 12px; font-size: 13px; font-weight: 600;">
                        <i class="fas fa-exclamation-triangle"></i>
                        Jumlah pesanan melebihi stok tersedia!
                    </div>
                </div>

                <div class="summary-box">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="subtotal">Rp {{ number_format($produk->harga_subsidi ?? 2800, 0, ',', '.') }}</span>
                    </div>
                    @php
                        $discountAmt = $discountAmount ?? 0;
                        $subsidyAmt = $subsidyAmount ?? 0;
                    @endphp
                    @if($discountAmt > 0)
                    <div class="summary-row" style="color: #10b981;">
                        <span class="summary-label">
                            <i class="fas fa-tag"></i> Potongan
                            @if(isset($bestDiscount))
                                <small style="font-size: 11px; opacity: 0.8;">({{ $bestDiscount->code }})</small>
                            @endif
                        </span>
                        <span class="summary-value" id="discountDisplay">- Rp {{ number_format($discountAmt, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($subsidyAmt > 0)
                    <div class="summary-row" style="color: #059669; font-size: 13px;">
                        <span class="summary-label">
                            <i class="fas fa-gift"></i> Subsidi Pemerintah
                        </span>
                        <span class="summary-value">Hemat Rp {{ number_format($subsidyAmt, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="summary-row summary-total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="total">Rp {{ number_format(($produk->harga_subsidi ?? 2800) - $discountAmt, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="{{ route('user.pupukbibit.konfirmasi', $produk->id_produk ?? 1) }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="quantity" id="quantityInput" value="1">
                    <input type="hidden" name="product_id" value="{{ $produk->id_produk ?? 1 }}">
                    
                    @if(($produk->stok_produk ?? 0) > 0)
                        <button type="submit" class="btn-order" id="orderBtn">
                            <i class="fas fa-shopping-cart"></i>
                            Pesan Sekarang
                        </button>
                    @else
                        <button type="button" class="btn-order" disabled style="opacity: 0.5; cursor: not-allowed; background: linear-gradient(135deg, #9ca3af, #6b7280);">
                            <i class="fas fa-times-circle"></i>
                            Stok Habis
                        </button>
                    @endif
                </form>

                <div class="info-notice">
                    <i class="fas fa-info-circle"></i>
                    Anda dapat mengecek harga dan informasi terkait pupuk subsidi ini melalui informasi produk dibawah ini.
                </div>
            </div>
        </div>
    </div>

    <!-- Product Information -->
    <div class="product-info-section">
        <h2 class="section-title">
            <i class="fas fa-clipboard-list"></i>
            Informasi Produk
        </h2>

        <!-- Deskripsi Umum -->
        @if($produk->deskripsi)
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 18px; color: #1f2937; margin-bottom: 12px; font-weight: 700;">
                Deskripsi Produk
            </h3>
            <p style="color: #4b5563; line-height: 1.8; font-size: 15px;">
                {{ $produk->deskripsi }}
            </p>
        </div>
        @endif

        <!-- Manfaat -->
        @if($produk->manfaat)
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 18px; color: #1f2937; margin-bottom: 12px; font-weight: 700;">
                Manfaat & Keunggulan
            </h3>
            <ul style="list-style: none; padding: 0; margin: 0;">
                @foreach(explode("\n", $produk->manfaat) as $manfaatItem)
                    @if(trim($manfaatItem))
                    <li style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px; color: #4b5563; line-height: 1.7; font-size: 15px;">
                        <i class="fas fa-check" style="color: #10b981; margin-top: 4px; flex-shrink: 0;"></i>
                        <span>{{ trim($manfaatItem) }}</span>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Panduan Penggunaan -->
        @if($produk->cara_penggunaan)
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 18px; color: #1f2937; margin-bottom: 16px; font-weight: 700;">
                Panduan Penggunaan
            </h3>
            
            @php
                // Split cara_penggunaan by common section patterns
                $sections = [];
                $lines = explode("\n", $produk->cara_penggunaan);
                $currentSection = null;
                $currentContent = [];
                
                foreach($lines as $line) {
                    $trimmedLine = trim($line);
                    
                    // Check if line is a section header (e.g., "1. Waktu Pemupukan", "2. Pupuk Cair")
                    if(preg_match('/^(\d+)\.\s*(.+)$/', $trimmedLine, $matches)) {
                        // Save previous section
                        if($currentSection) {
                            $sections[] = [
                                'title' => $currentSection,
                                'content' => $currentContent
                            ];
                        }
                        
                        // Start new section
                        $currentSection = $matches[2];
                        $currentContent = [];
                    } else if($trimmedLine && $currentSection) {
                        $currentContent[] = $trimmedLine;
                    }
                }
                
                // Save last section
                if($currentSection) {
                    $sections[] = [
                        'title' => $currentSection,
                        'content' => $currentContent
                    ];
                }
            @endphp
            
            @if(count($sections) > 0)
                @foreach($sections as $index => $section)
                <div style="margin-bottom: 18px;">
                    <h4 style="font-size: 16px; color: #065f46; margin-bottom: 10px; font-weight: 700;">
                        {{ $index + 1 }}. {{ $section['title'] }}
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; padding-left: 20px;">
                        @foreach($section['content'] as $item)
                        <li style="color: #4b5563; line-height: 1.7; font-size: 14px; margin-bottom: 6px; position: relative; padding-left: 20px;">
                            <span style="position: absolute; left: 0; color: #6b7280;">•</span>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            @else
                <p style="color: #4b5563; line-height: 1.8; font-size: 15px; white-space: pre-line;">
                    {{ $produk->cara_penggunaan }}
                </p>
            @endif
        </div>
        @endif

        <!-- Bahan/Komposisi -->
        @if($produk->bahan)
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 18px; color: #1f2937; margin-bottom: 12px; font-weight: 700;">
                Bahan/Komposisi
            </h3>
            <p style="color: #4b5563; line-height: 1.8; font-size: 15px; white-space: pre-line;">
                {{ $produk->bahan }}
            </p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const productId = {{ $produk->id_produk ?? 1 }};
    const productName = '{{ $produk->nama_produk ?? "Produk" }}';
    const basePrice = {{ $produk->harga_subsidi ?? 2800 }};
    const maxStock = {{ $produk->stok_produk ?? 0 }};
    const discountPerUnit = {{ $discountAmount ?? 0 }};
    let quantity = 1;
    
    // Image Carousel Variables
    const imageData = document.getElementById('imageData');
    const images = imageData ? JSON.parse(imageData.dataset.images) : [];
    let currentImageIndex = 0;
    
    // ============================================
    // IMAGE CAROUSEL FUNCTIONS
    // ============================================
    function updateMainImage() {
        if (images.length === 0) return;
        
        const mainImage = document.getElementById('mainProductImage');
        mainImage.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImage.src = images[currentImageIndex];
            mainImage.style.opacity = '1';
        }, 150);
        
        // Update active thumbnail
        updateActiveThumbnail();
        updateCarouselButtons();
    }
    
    function nextImage() {
        if (currentImageIndex < images.length - 1) {
            currentImageIndex++;
            updateMainImage();
        }
    }
    
    function prevImage() {
        if (currentImageIndex > 0) {
            currentImageIndex--;
            updateMainImage();
        }
    }
    
    function goToImage(index) {
        if (index >= 0 && index < images.length) {
            currentImageIndex = index;
            updateMainImage();
        }
    }
    
    function updateActiveThumbnail() {
        document.querySelectorAll('.thumbnail').forEach((thumb, index) => {
            if (index === currentImageIndex) {
                thumb.classList.add('active');
            } else {
                thumb.classList.remove('active');
            }
        });
    }
    
    function updateCarouselButtons() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        if (prevBtn) {
            prevBtn.disabled = currentImageIndex === 0;
        }
        if (nextBtn) {
            nextBtn.disabled = currentImageIndex === images.length - 1;
        }
    }
    
    // Keyboard navigation (Arrow keys)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            prevImage();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        }
    });

    // ============================================
    // QUANTITY FUNCTIONS
    // ============================================
    function increaseQty() {
        if (quantity < maxStock) {
            quantity++;
            updateDisplay();
            hideStockWarning();
        } else {
            showStockWarning();
        }
    }

    function decreaseQty() {
        if (quantity > 1) {
            quantity--;
            updateDisplay();
            hideStockWarning();
        }
    }

    function showStockWarning() {
        const warning = document.getElementById('stockWarning');
        if (warning) {
            warning.style.display = 'block';
            setTimeout(() => {
                warning.style.display = 'none';
            }, 3000);
        }
    }

    function hideStockWarning() {
        const warning = document.getElementById('stockWarning');
        if (warning) {
            warning.style.display = 'none';
        }
    }

    function handleManualInput(value) {
        // Convert to number and validate
        let newQty = parseInt(value);
        
        // Check if valid number
        if (isNaN(newQty) || newQty < 1) {
            newQty = 1;
        }
        
        // Check if exceeds stock
        if (newQty > maxStock) {
            newQty = maxStock;
            showStockWarning();
        } else {
            hideStockWarning();
        }
        
        // Update quantity
        quantity = newQty;
        document.getElementById('qtyDisplay').value = quantity;
        document.getElementById('quantityInput').value = quantity;
        
        // Update prices
        const subtotal = basePrice * quantity;
        const discount = discountPerUnit * quantity;
        const total = subtotal - discount;
        
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        
        const discountEl = document.getElementById('discountDisplay');
        if (discountEl && discount > 0) {
            discountEl.textContent = '- Rp ' + discount.toLocaleString('id-ID');
        }
        
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        // Update button state
        updateButtonState();
    }

    function updateDisplay() {
        document.getElementById('qtyDisplay').value = quantity;
        document.getElementById('quantityInput').value = quantity;
        
        const subtotal = basePrice * quantity;
        const discount = discountPerUnit * quantity;
        const total = subtotal - discount;
        
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        
        const discountEl = document.getElementById('discountDisplay');
        if (discountEl && discount > 0) {
            discountEl.textContent = '- Rp ' + discount.toLocaleString('id-ID');
        }
        
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        // Update button state
        updateButtonState();
    }

    function updateButtonState() {
        const orderBtn = document.getElementById('orderBtn');
        if (orderBtn) {
            if (quantity > maxStock || maxStock == 0) {
                orderBtn.disabled = true;
                orderBtn.style.opacity = '0.5';
                orderBtn.style.cursor = 'not-allowed';
            } else {
                orderBtn.disabled = false;
                orderBtn.style.opacity = '1';
                orderBtn.style.cursor = 'pointer';
            }
        }
    }

    // ============================================
    // VALIDASI SEBELUM SUBMIT
    // ============================================
    document.getElementById('orderForm')?.addEventListener('submit', function(e) {
        // Validasi stok
        if (quantity > maxStock) {
            e.preventDefault();
            alert(`Stok tidak mencukupi!\nMaksimal: ${maxStock} unit`);
            return false;
        }
        
        if (maxStock == 0) {
            e.preventDefault();
            alert('Maaf, stok produk sedang habis.');
            return false;
        }
        
        // Show loading state
        const btn = document.getElementById('orderBtn');
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            btn.disabled = true;
        }
    });

    // ============================================
    // INITIALIZATION
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Set first thumbnail as active
        const firstThumbnail = document.querySelector('.thumbnail');
        if (firstThumbnail) {
            firstThumbnail.classList.add('active');
        }
        
        // Initialize carousel buttons state
        updateCarouselButtons();
        
        // Initial display update
        updateDisplay();
    });
</script>
@endpush
