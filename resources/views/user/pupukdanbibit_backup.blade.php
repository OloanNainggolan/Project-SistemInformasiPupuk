@extends('layouts.user')

@section('title', 'Pupuk & Bibit Subsidi')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box: #333;
    }

    main {
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 50px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        padding: 15px;
        background-color: #d1fae5;
        border-radius: 10px;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background-color: #10b981;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .section-header h2 {
        font-size: 24px;
        color: #065f46;
    }

    /* Card Grid */
    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }

    .product-card {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .product-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-info {
        padding: 20px;
    }

    .product-info h3 {
        font-size: 20px;
        color: #065f46;
        margin-bottom: 15px;
    }

    .product-info p {
        font-size: 13px;
        line-height: 1.6;
        color: #555;
        margin-bottom: 15px;
        text-align: justify;
    }

    .product-info ul {
        list-style: none;
        margin-bottom: 20px;
    }

    .product-info ul li {
        font-size: 13px;
        color: #333;
        padding: 5px 0;
        padding-left: 20px;
        position: relative;
    }

    .product-info ul li:before {
        content: "•";
        color: #10b981;
        font-weight: bold;
        position: absolute;
        left: 0;
    }

    .price-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-top: 15px;
        border-top: 1px solid #e5e7eb;
    }

    .price-item {
        flex: 1;
    }

    .price-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 3px;
    }

    .price-value {
        font-size: 16px;
        font-weight: 600;
        color: #065f46;
    }

    .btn-detail {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-green {
        background-color: #065f46;
        color: white;
    }

    .btn-green:hover {
        background-color: #047857;
        transform: scale(1.02);
    }

    .btn-blue {
        background-color: #1e40af;
        color: white;
    }

    .btn-blue:hover {
        background-color: #1e3a8a;
        transform: scale(1.02);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .footer-content {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        main {
            padding: 0 20px;
        }

        .card-grid {
            grid-template-columns: 1fr;
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
                            <p>{{ Str::limit($product->deskripsi, 180) }}</p>
                            
                            @if($product->kategori)
                                <div style="margin-bottom: 10px;">
                                    <span style="display: inline-block; padding: 4px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        {{ $product->kategori }}
                                    </span>
                                </div>
                            @endif

                            <div class="price-section">
                                <div class="price-item">
                                    <div class="price-label">Harga Normal</div>
                                    <div class="price-value">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                                </div>
                                <div class="price-item">
                                    <div class="price-label">Harga Subsidi</div>
                                    <div class="price-value" style="color: #059669;">Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div style="margin-bottom: 15px; padding: 8px; background: #f0fdf4; border-radius: 6px; text-align: center;">
                                <span style="font-size: 12px; color: #065f46;">
                                    <strong>Stok:</strong> {{ number_format($product->stok_produk) }} unit
                                </span>
                            </div>

                            <button class="btn-detail btn-green" onclick="window.location.href='/user/pupuk-bibit/{{ $product->id_produk }}/detail'">
                                Lihat Detail & Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: #f9fafb; border-radius: 12px;">
                <div style="font-size: 48px; margin-bottom: 15px;">🌿</div>
                <h3 style="color: #6b7280; margin-bottom: 10px;">Belum Ada Pupuk Tersedia</h3>
                <p style="color: #9ca3af; font-size: 14px;">Produk pupuk subsidi akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>

    <!-- Bibit Subsidi Section -->
    <section id="bibit-subsidi">
        <div class="section-header" style="background-color: #dbeafe;">
            <div class="section-icon" style="background-color: #1e40af;">🌱</div>
            <h2 style="color: #1e3a8a;">Bibit Subsidi</h2>
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
                            <p>{{ Str::limit($product->deskripsi, 180) }}</p>
                            
                            @if($product->kategori)
                                <div style="margin-bottom: 10px;">
                                    <span style="display: inline-block; padding: 4px 12px; background: #dbeafe; color: #1e40af; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                        {{ $product->kategori }}
                                    </span>
                                </div>
                            @endif

                            <div class="price-section">
                                <div class="price-item">
                                    <div class="price-label">Harga Normal</div>
                                    <div class="price-value" style="color: #1e3a8a;">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                                </div>
                                <div class="price-item">
                                    <div class="price-label">Harga Subsidi</div>
                                    <div class="price-value" style="color: #1e40af;">Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div style="margin-bottom: 15px; padding: 8px; background: #eff6ff; border-radius: 6px; text-align: center;">
                                <span style="font-size: 12px; color: #1e40af;">
                                    <strong>Stok:</strong> {{ number_format($product->stok_produk) }} unit
                                </span>
                            </div>

                            <button class="btn-detail btn-blue" onclick="window.location.href='/user/pupuk-bibit/{{ $product->id_produk }}/detail'">
                                Lihat Detail & Pesan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; background: #f9fafb; border-radius: 12px;">
                <div style="font-size: 48px; margin-bottom: 15px;">🌱</div>
                <h3 style="color: #6b7280; margin-bottom: 10px;">Belum Ada Bibit Tersedia</h3>
                <p style="color: #9ca3af; font-size: 14px;">Produk bibit subsidi akan segera ditambahkan oleh admin.</p>
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
