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
        background: #f8fafc;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    main {
        max-width: 1440px;
        margin: 0 auto;
        padding: 40px 30px 80px;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 32px;
        padding: 24px 28px;
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 10px 25px rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.1);
        position: relative;
        overflow: hidden;
    }

    .section-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
    }

    .section-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);
        flex-shrink: 0;
    }

    .section-header h2 {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.8px;
    }


    /* Card Grid - Responsive */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 28px;
        margin-bottom: 60px;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.04);
        position: relative;
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover::before {
        opacity: 1;
    }

    .product-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12), 0 8px 16px rgba(16, 185, 129, 0.15);
        border-color: rgba(16, 185, 129, 0.2);
    }

    /* Product Image Container - Fixed Aspect Ratio */
    .product-image {
        position: relative;
        width: 100%;
        padding-bottom: 70%; /* 10:7 Aspect Ratio */
        overflow: hidden;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .product-card:hover .product-image img {
        transform: scale(1.15);
    }

    /* Product Info */
    .product-info {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-info h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 12px;
        line-height: 1.4;
        min-height: 56px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        letter-spacing: -0.3px;
    }

    .product-info p {
        font-size: 14px;
        line-height: 1.7;
        color: #6b7280;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-category {
        display: inline-block;
        padding: 7px 16px;
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        color: #065f46;
        border-radius: 24px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    /* Price Section */
    .price-section {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 18px;
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        border-radius: 14px;
        margin-bottom: 14px;
        border: 2px solid rgba(16, 185, 129, 0.15);
    }

    .price-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .price-value {
        font-size: 16px;
        font-weight: 700;
        color: #374151;
    }

    .price-subsidi {
        color: #10b981 !important;
        font-size: 22px !important;
        font-weight: 800 !important;
        letter-spacing: -0.5px;
    }

    .price-normal {
        color: #9ca3af !important;
        text-decoration: line-through;
        font-size: 14px !important;
        font-weight: 500 !important;
    }

    /* Stock Badge */
    .stock-badge {
        padding: 12px 16px;
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border-radius: 12px;
        text-align: center;
        margin-bottom: 16px;
        border: 2px dashed rgba(16, 185, 129, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .stock-badge i {
        color: #10b981;
        font-size: 14px;
    }

    .stock-badge span {
        font-size: 13px;
        color: #374151;
        font-weight: 700;
    }

    /* Button */
    .btn-detail {
        width: 100%;
        padding: 15px 24px;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }

    .btn-detail::before {
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

    .btn-detail:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-green:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(16, 185, 129, 0.4);
    }

    .btn-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-blue:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(59, 130, 246, 0.4);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 100px 40px;
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border-radius: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 2px dashed rgba(156, 163, 175, 0.3);
    }

    .empty-state .icon {
        font-size: 80px;
        margin-bottom: 24px;
        opacity: 0.5;
        filter: grayscale(0.3);
    }

    .empty-state h3 {
        font-size: 24px;
        color: #374151;
        margin-bottom: 12px;
        font-weight: 700;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 15px;
        line-height: 1.7;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Bibit Section (Blue Theme) */
    #bibit-subsidi .section-header {
        background: linear-gradient(135deg, #ffffff 0%, #eff6ff 100%);
        border: 1px solid rgba(59, 130, 246, 0.1);
    }

    #bibit-subsidi .section-header::before {
        background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
    }

    #bibit-subsidi .section-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25);
    }

    #bibit-subsidi .section-header h2 {
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    #bibit-subsidi .product-category {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: #1e40af;
        border-color: rgba(59, 130, 246, 0.2);
    }

    #bibit-subsidi .price-section {
        background: linear-gradient(135deg, #eff6ff 0%, #e0f2fe 100%);
        border-color: rgba(59, 130, 246, 0.15);
    }

    #bibit-subsidi .price-subsidi {
        color: #3b82f6 !important;
    }

    #bibit-subsidi .stock-badge {
        border-color: rgba(59, 130, 246, 0.3);
    }

    #bibit-subsidi .stock-badge i {
        color: #3b82f6;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .card-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        main {
            padding: 0 20px;
            margin: 20px auto;
        }

        .section-header {
            padding: 16px 20px;
            margin-bottom: 25px;
        }

        .section-icon {
            width: 42px;
            height: 42px;
            font-size: 20px;
        }

        .section-header h2 {
            font-size: 22px;
        }

        .card-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 50px;
        }

        .product-image {
            padding-bottom: 65%; /* Slightly shorter on mobile */
        }

        .product-info h3 {
            font-size: 17px;
            min-height: auto;
        }

        .empty-state {
            padding: 60px 20px;
        }
    }

    @media (max-width: 480px) {
        .price-section {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .price-item {
            padding: 8px 0;
        }
    }
</style>
@endpush

@section('content')
<main>
    @php
        $pupukProducts = $products->where('tipe_produk', 'pupuk');
        $bibitProducts = $products->where('tipe_produk', 'bibit');
    @endphp

    <!-- Pupuk Subsidi Section -->
    <section id="pupuk-subsidi">
        <div class="section-header">
            <div class="section-icon">🌿</div>
            <h2>Pupuk Subsidi</h2>
        </div>

        @if($pupukProducts->count() > 0)
            <div class="card-grid">
                @foreach($pupukProducts as $product)
                    <div class="product-card" data-product-id="{{ $product->id_produk }}">
                        <div class="product-image">
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
                            
                            @if($product->kategori)
                                <span class="product-category">
                                    {{ $product->kategori }}
                                </span>
                            @endif

                            @if($product->manfaat)
                                <p>{{ Str::limit($product->manfaat, 100) }}</p>
                            @endif

                            <div class="price-section">
                                <div class="price-item">
                                    <div class="price-label">Harga Normal</div>
                                    <div class="price-value price-normal">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                                </div>
                                <div class="price-item">
                                    <div class="price-label">Harga Subsidi</div>
                                    <div class="price-value price-subsidi">Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div class="stock-badge">
                                <span><i class="fas fa-box"></i> Stok: {{ number_format($product->stok_produk) }} unit</span>
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
                <div class="icon">🌿</div>
                <h3>Belum Ada Pupuk Tersedia</h3>
                <p>Produk pupuk subsidi akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>

    <!-- Bibit Subsidi Section -->
    <section id="bibit-subsidi">
        <div class="section-header">
            <div class="section-icon">🌱</div>
            <h2>Bibit Subsidi</h2>
        </div>

        @if($bibitProducts->count() > 0)
            <div class="card-grid">
                @foreach($bibitProducts as $product)
                    <div class="product-card" data-product-id="{{ $product->id_produk }}">
                        <div class="product-image">
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
                            
                            @if($product->kategori)
                                <span class="product-category">
                                    {{ $product->kategori }}
                                </span>
                            @endif

                            @if($product->manfaat)
                                <p>{{ Str::limit($product->manfaat, 100) }}</p>
                            @endif

                            <div class="price-section">
                                <div class="price-item">
                                    <div class="price-label">Harga Normal</div>
                                    <div class="price-value price-normal">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                                </div>
                                <div class="price-item">
                                    <div class="price-label">Harga Subsidi</div>
                                    <div class="price-value price-subsidi">Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div class="stock-badge">
                                <span><i class="fas fa-box"></i> Stok: {{ number_format($product->stok_produk) }} unit</span>
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
                <div class="icon">🌱</div>
                <h3>Belum Ada Bibit Tersedia</h3>
                <p>Produk bibit subsidi akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>
</main>
@endsection

@push('scripts')
<script>
    // Smooth scroll effect for all anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const section = document.getElementById(targetId);
            if (section) {
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Card animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        observer.observe(card);
    });
</script>
@endpush
