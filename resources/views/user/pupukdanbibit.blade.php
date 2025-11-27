@extends('layouts.user')

@section('title', 'Pupuk & Bibit Subsidi')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    main {
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 30px;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 35px;
        padding: 20px 25px;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
    }

    .section-icon {
        width: 50px;
        height: 50px;
        background: #10b981;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    .section-header h2 {
        font-size: 28px;
        font-weight: 700;
        color: #065f46;
        letter-spacing: -0.5px;
    }

    /* Card Grid - Responsive */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 80px;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }

    /* Product Image Container - Fixed Aspect Ratio */
    .product-image {
        position: relative;
        width: 100%;
        padding-bottom: 75%; /* 4:3 Aspect Ratio */
        overflow: hidden;
        background: #f3f4f6;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.08);
    }

    /* Product Info */
    .product-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-info h3 {
        font-size: 19px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 10px;
        line-height: 1.4;
        min-height: 54px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-info p {
        font-size: 14px;
        line-height: 1.6;
        color: #6b7280;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-category {
        display: inline-block;
        padding: 6px 14px;
        background: #d1fae5;
        color: #065f46;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
    }

    /* Price Section */
    .price-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 12px;
        margin-bottom: 12px;
    }

    .price-item {
        text-align: center;
    }

    .price-label {
        font-size: 11px;
        color: #9ca3af;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .price-value {
        font-size: 17px;
        font-weight: 700;
        color: #065f46;
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
        padding: 14px 20px;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-green {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .btn-green:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
    }

    .btn-blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-blue:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 30px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .empty-state .icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.6;
    }

    .empty-state h3 {
        font-size: 22px;
        color: #374151;
        margin-bottom: 12px;
        font-weight: 600;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 15px;
        line-height: 1.6;
    }

    /* Bibit Section (Blue Theme) */
    #bibit-subsidi .section-header {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    }

    #bibit-subsidi .section-icon {
        background: #3b82f6;
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    }

    #bibit-subsidi .section-header h2 {
        color: #1e40af;
    }

    #bibit-subsidi .product-category {
        background: #dbeafe;
        color: #1e40af;
    }

    #bibit-subsidi .price-value {
        color: #1e40af;
    }

    #bibit-subsidi .price-subsidi {
        color: #2563eb !important;
    }

    #bibit-subsidi .stock-badge {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-color: #bfdbfe;
    }

    #bibit-subsidi .stock-badge span {
        color: #1e40af;
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
