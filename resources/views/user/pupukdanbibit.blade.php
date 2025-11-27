@extends('layouts.user')

@section('title', 'Pupuk & Bibit Subsidi')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f7f9fc;
    }

    /* Hero Banner Section - Enhanced Version */
    .hero-banner {
        background: linear-gradient(135deg, #1a5f3a 0%, #2d7a4f 50%, #1a5f3a 100%);
        padding: 80px 50px;
        margin-bottom: 0;
        position: relative;
        overflow: hidden;
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
        text-align: center;
    }

    .hero-title {
        font-size: 3em;
        font-weight: 700;
        color: white;
        margin-bottom: 18px;
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        animation: fadeInUp 0.8s ease-out;
        letter-spacing: -0.5px;
    }

    .hero-subtitle {
        font-size: 1.2em;
        color: rgba(255, 255, 255, 0.95);
        line-height: 1.6;
        max-width: 750px;
        margin: 0 auto;
        animation: fadeInUp 1s ease-out;
        font-weight: 400;
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

    /* Main Content */
    main {
        max-width: 1400px;
        margin: 0 auto;
        padding: 50px 50px 70px;
        background: #f7f9fc;
    }

    /* Section Styles */
    .product-section {
        margin-bottom: 55px;
    }

    .product-section:last-child {
        margin-bottom: 0;
    }

    .section-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .section-header h2 {
        font-size: 32px;
        font-weight: 700;
        color: #1a5f3a;
        letter-spacing: -0.5px;
        margin-bottom: 12px;
    }

    .section-divider {
        width: 70px;
        height: 4px;
        background: linear-gradient(90deg, #2d7a4f, #1a5f3a);
        border-radius: 2px;
        margin: 0 auto;
    }

    /* Card Grid Layout */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        position: relative;
        opacity: 0;
        transform: translateY(20px);
    }

    .product-card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        border-color: #2d7a4f;
    }

    .product-image {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
        background: linear-gradient(135deg, #f0fdf4, #d1fae5);
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.08);
    }

    .subsidy-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        z-index: 1;
    }

    .product-info {
        padding: 24px;
    }

    .product-info h3 {
        font-size: 19px;
        color: #1a5f3a;
        margin-bottom: 12px;
        font-weight: 700;
        line-height: 1.4;
    }

    .product-info p {
        font-size: 14px;
        line-height: 1.7;
        color: #6b7280;
        margin-bottom: 16px;
    }

    .category-badge {
        display: inline-block;
        padding: 6px 12px;
        background: #f0fdf4;
        color: #1a5f3a;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 16px;
        border: 1px solid #d1fae5;
    }

    /* Price Section */
    .price-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding: 18px 20px;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 12px;
        border: 2px solid #d1fae5;
        gap: 20px;
    }

    .price-item {
        text-align: center;
    }

    .price-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        line-height: 1.2;
    }

    .price-value {
        font-size: 19px;
        font-weight: 700;
        color: #374151;
        line-height: 1.3;
    }

    .price-value.subsidy-price {
        color: #1a5f3a;
        font-size: 20px;
    }

    .stock-info {
        margin-bottom: 18px;
        padding: 12px;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 10px;
        text-align: center;
        border: 1px solid #d1fae5;
    }

    .stock-info span {
        font-size: 13px;
        color: #1a5f3a;
        font-weight: 600;
    }

    .price-subsidi {
        color: #059669 !important;
        font-size: 19px !important;
    }

    .price-normal {
        color: #9ca3af !important;
        text-decoration: line-through;
        font-size: 15px !important;
    }

    /* Stock Badge */
    .stock-badge {
        padding: 10px 15px;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 10px;
        text-align: center;
        margin-bottom: 15px;
        border: 1px solid #a7f3d0;
    }

    .stock-badge span {
        font-size: 13px;
        color: #065f46;
        font-weight: 600;
    }

    /* Button */
    .btn-detail {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-green {
        background: linear-gradient(135deg, #2d7a4f, #1a5f3a);
        color: white;
        box-shadow: 0 4px 15px rgba(45, 122, 79, 0.3);
    }

    .btn-green:hover {
        background: linear-gradient(135deg, #1a5f3a, #0d4d2a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 122, 79, 0.4);
    }

    .btn-blue {
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
        color: white;
        box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
    }

    .btn-blue:hover {
        background: linear-gradient(135deg, #1e3a8a, #1e3a8a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 70px 30px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 2px dashed #e5e7eb;
    }

    .empty-state-icon {
        font-size: 56px;
        margin-bottom: 18px;
        opacity: 0.4;
    }

    .empty-state h3 {
        color: #374151;
        margin-bottom: 10px;
        font-size: 20px;
        font-weight: 700;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 14px;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .card-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }

    @media (max-width: 900px) {
        .hero-banner {
            padding: 60px 30px;
        }

        .hero-title {
            font-size: 2.3em;
        }

        .hero-subtitle {
            font-size: 1.05em;
        }

        main {
            padding: 40px 30px 50px;
        }

        .section-header h2 {
            font-size: 26px;
        }

        .section-divider {
            width: 50px;
        }
    }

    @media (max-width: 768px) {
        .hero-banner {
            padding: 50px 25px;
        }

        .hero-title {
            font-size: 2em;
        }

        .hero-subtitle {
            font-size: 1em;
        }

        main {
            padding: 35px 25px 45px;
        }

        .card-grid {
            grid-template-columns: 1fr;
            gap: 22px;
        }

        .section-header h2 {
            font-size: 24px;
        }

        .product-image {
            height: 220px;
        }
    }

    @media (max-width: 480px) {
        .hero-banner {
            padding: 40px 20px;
        }

        .hero-title {
            font-size: 1.7em;
        }

        .hero-subtitle {
            font-size: 0.95em;
        }

        main {
            padding: 30px 20px 40px;
        }

        .section-header h2 {
            font-size: 22px;
        }

        .section-divider {
            width: 40px;
            height: 3px;
        }

        .card-grid {
            gap: 20px;
        }

        .product-info {
            padding: 20px;
        }

        .product-info h3 {
            font-size: 17px;
        }

        .price-section {
            flex-direction: column;
            gap: 14px;
            padding: 16px;
        }

        .price-item {
            text-align: center;
        }

        .price-label {
            font-size: 11px;
            margin-bottom: 6px;
        }

        .price-value {
            font-size: 18px;
        }

        .price-value.subsidy-price {
            font-size: 19px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Banner -->
<div class="hero-banner">
    <div class="hero-content">
        <h1 class="hero-title">Pupuk & Bibit Subsidi</h1>
        <p class="hero-subtitle">
            Dapatkan pupuk dan bibit berkualitas tinggi dengan harga subsidi dari pemerintah. 
            Tingkatkan hasil panen Anda dengan produk terpercaya dan terjangkau.
        </p>
    </div>
</div>

<main>
    @php
        $pupukProducts = $products->where('tipe_produk', 'pupuk');
        $bibitProducts = $products->where('tipe_produk', 'bibit');
    @endphp

    <!-- Pupuk Subsidi Section -->
    <section id="pupuk-subsidi" class="product-section">
        <div class="section-header">
            <div>
                <h2>Pupuk Subsidi</h2>
                <div class="section-divider"></div>
            </div>
        </div>

        @if($pupukProducts->count() > 0)
            <div class="card-grid">
                @foreach($pupukProducts as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <div class="subsidy-badge">SUBSIDI</div>
                            @if($product->primaryImage)
                                <img src="{{ asset($product->primaryImage->image_path) }}" alt="{{ $product->nama_produk }}">
                            @elseif($product->gambar)
                                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama_produk }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=400&h=300&fit=crop" alt="{{ $product->nama_produk }}">
                            @endif
                        </div>
                        <div class="product-info">
                            <h3>{{ $product->nama_produk }}</h3>
                            <p>{{ Str::limit($product->deskripsi, 120) }}</p>
                            
                            @if($product->kategori)
                                <div class="category-badge">
                                    {{ $product->kategori }}
                                </div>
                            @endif

                            <div class="price-section">
                                <div class="price-item">
                                    <div class="price-label">Harga Normal</div>
                                    <div class="price-value price-normal">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                                </div>
                                <div class="price-item">
                                    <div class="price-label">Harga Subsidi</div>
                                    <div class="price-value subsidy-price">Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div class="stock-info">
                                <span>Stok: {{ number_format($product->stok_produk) }} unit</span>
                            </div>

                            <button class="btn-detail btn-green" onclick="window.location.href='/user/pupuk-bibit/{{ $product->id_produk }}/detail'">
                                <i class="fas fa-eye"></i> Lihat Detail & Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">—</div>
                <h3>Belum Ada Pupuk Tersedia</h3>
                <p>Produk pupuk subsidi akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>

    <!-- Bibit Subsidi Section -->
    <section id="bibit-subsidi" class="product-section">
        <div class="section-header">
            <div>
                <h2>Bibit Subsidi</h2>
                <div class="section-divider"></div>
            </div>
        </div>

        @if($bibitProducts->count() > 0)
            <div class="card-grid">
                @foreach($bibitProducts as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <div class="subsidy-badge">SUBSIDI</div>
                            @if($product->primaryImage)
                                <img src="{{ asset($product->primaryImage->image_path) }}" alt="{{ $product->nama_produk }}">
                            @elseif($product->gambar)
                                <img src="{{ asset($product->gambar) }}" alt="{{ $product->nama_produk }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400&h=300&fit=crop" alt="{{ $product->nama_produk }}">
                            @endif
                        </div>
                        <div class="product-info">
                            <h3>{{ $product->nama_produk }}</h3>
                            <p>{{ Str::limit($product->deskripsi, 120) }}</p>
                            
                            @if($product->kategori)
                                <div class="category-badge">
                                    {{ $product->kategori }}
                                </div>
                            @endif

                            <div class="price-section">
                                <div class="price-item">
                                    <div class="price-label">Harga Normal</div>
                                    <div class="price-value">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                                </div>
                                <div class="price-item">
                                    <div class="price-label">Harga Subsidi</div>
                                    <div class="price-value subsidy-price">Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div class="stock-info">
                                <span>Stok: {{ number_format($product->stok_produk) }} unit</span>
                            </div>

                            <button class="btn-detail btn-blue" onclick="window.location.href='/user/pupuk-bibit/{{ $product->id_produk }}/detail'">
                                <i class="fas fa-eye"></i> Lihat Detail & Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">—</div>
                <h3>Belum Ada Bibit Tersedia</h3>
                <p>Produk bibit subsidi akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>
</main>
@endsection

@push('scripts')
<script>
    // Smooth scroll animation for cards on load
    window.addEventListener('load', function() {
        const cards = document.querySelectorAll('.product-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush
