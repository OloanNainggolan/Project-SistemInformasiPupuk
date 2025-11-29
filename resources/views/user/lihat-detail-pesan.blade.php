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
        background: #f8fafc;
        font-family: 'Inter', 'Segoe UI', sans-serif;
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
        height: 420px;
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 18px;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(0,0,0,0.04);
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
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
        min-width: 50px;
        text-align: center;
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
            <div class="main-image">
                @php
                $imageSrc = 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=400&fit=crop';
                
                if(isset($produk)) {
                    if(isset($produk->primaryImage)) {
                        $imageSrc = asset($produk->primaryImage->gambar);
                    } elseif(isset($produk->gambar)) {
                        if(filter_var($produk->gambar, FILTER_VALIDATE_URL)) {
                            $imageSrc = $produk->gambar;
                        } else {
                            $imageSrc = asset($produk->gambar);
                        }
                    }
                }
                @endphp
                <img id="mainProductImage" src="{{ $imageSrc }}" alt="{{ $produk->nama_produk ?? 'Pupuk Urea' }}">
            </div>
            <div class="thumbnail-grid">
                <div class="thumbnail" onclick="changeImage('{{ $imageSrc }}', this)">
                    <img src="{{ $imageSrc }}" alt="Thumbnail 1">
                </div>
                <div class="thumbnail" onclick="changeImage('https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=400&fit=crop', this)">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=150&h=150&fit=crop" alt="Thumbnail 2">
                </div>
                <div class="thumbnail" onclick="changeImage('https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=400&fit=crop', this)">
                    <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=150&h=150&fit=crop" alt="Thumbnail 3">
                </div>
                <div class="thumbnail" onclick="changeImage('{{ $imageSrc }}', this)">
                    <img src="{{ $imageSrc }}" alt="Thumbnail 4">
                </div>
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
                        <button class="qty-btn" onclick="decreaseQty()"><i class="fas fa-minus"></i></button>
                        <span class="qty-display" id="qtyDisplay">1</span>
                        <button class="qty-btn" onclick="increaseQty()"><i class="fas fa-plus"></i></button>
                    </div>
                    <span class="stock-info">
                        <i class="fas fa-warehouse"></i>
                        Tersedia {{ $produk->stok_produk ?? 85 }} unit
                    </span>
                </div>

                <div class="summary-box">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="subtotal">Rp. {{ number_format($produk->harga_subsidi ?? 2800, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Ongkos Kirim</span>
                        <span class="summary-value">Rp. 0</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value" id="total">Rp {{ number_format($produk->harga_subsidi ?? 2800, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="{{ route('user.pupukbibit.konfirmasi', $produk->id_produk ?? 1) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" id="quantityInput" value="1">
                    <input type="hidden" name="catatan" id="catatanInput" value="">
                    <button type="submit" class="btn-order">
                        <i class="fas fa-shopping-cart"></i>
                        Pesan Sekarang
                    </button>
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
        <div style="margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border-radius: 12px; border-left: 4px solid #6b7280;">
            <h3 style="font-size: 18px; color: #374151; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-align-left" style="color: #6b7280;"></i>
                Deskripsi Produk
            </h3>
            <p style="color: #4b5563; line-height: 1.8; font-size: 15px;">
                {{ $produk->deskripsi }}
            </p>
        </div>
        @endif

        <!-- Manfaat -->
        @if($produk->manfaat)
        <div style="margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 12px; border-left: 4px solid #10b981;">
            <h3 style="font-size: 18px; color: #065f46; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-leaf" style="color: #10b981;"></i>
                Manfaat & Keunggulan
            </h3>
            <p style="color: #047857; line-height: 1.8; font-size: 15px; white-space: pre-line;">
                {{ $produk->manfaat }}
            </p>
        </div>
        @endif

        <!-- Bahan/Komposisi -->
        @if($produk->bahan)
        <div style="margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px; border-left: 4px solid #3b82f6;">
            <h3 style="font-size: 18px; color: #1e40af; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-flask" style="color: #3b82f6;"></i>
                Bahan/Komposisi
            </h3>
            <p style="color: #1e40af; line-height: 1.8; font-size: 15px; white-space: pre-line;">
                {{ $produk->bahan }}
            </p>
        </div>
        @endif

        <!-- Cara Penggunaan -->
        @if($produk->cara_penggunaan)
        <div style="margin-bottom: 30px; padding: 20px; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px; border-left: 4px solid #f59e0b;">
            <h3 style="font-size: 18px; color: #92400e; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-tasks" style="color: #f59e0b;"></i>
                Cara Penggunaan
            </h3>
            <p style="color: #92400e; line-height: 1.8; font-size: 15px; white-space: pre-line;">
                {{ $produk->cara_penggunaan }}
            </p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    const basePrice = {{ $produk->harga_subsidi ?? 2800 }};
    let quantity = 1;

    function changeImage(src, element) {
        const mainImage = document.getElementById('mainProductImage');
        mainImage.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 150);

        // Update active thumbnail
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        if (element) {
            element.classList.add('active');
        }
    }

    function increaseQty() {
        const maxStock = {{ $produk->stok_produk ?? 85 }};
        if (quantity < maxStock) {
            quantity++;
            updateDisplay();
        }
    }

    function decreaseQty() {
        if (quantity > 1) {
            quantity--;
            updateDisplay();
        }
    }

    function updateDisplay() {
        document.getElementById('qtyDisplay').textContent = quantity;
        document.getElementById('quantityInput').value = quantity;
        
        const subtotal = basePrice * quantity;
        const total = subtotal; // + ongkir (0)
        
        document.getElementById('subtotal').textContent = 'Rp. ' + subtotal.toLocaleString('id-ID');
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Set first thumbnail as active on load
    document.addEventListener('DOMContentLoaded', function() {
        const firstThumbnail = document.querySelector('.thumbnail');
        if (firstThumbnail) {
            firstThumbnail.classList.add('active');
        }
    });
</script>
@endpush
