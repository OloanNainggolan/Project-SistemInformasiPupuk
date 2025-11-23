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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-detail {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #065f46;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        padding: 8px 16px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }

    .back-link:hover {
        transform: translateX(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 400px 1fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    .product-images {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .main-image {
        width: 100%;
        height: 350px;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 15px;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .thumbnail {
        width: 100%;
        height: 80px;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail:hover {
        border-color: #10b981;
        transform: scale(1.05);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .product-title {
        font-size: 32px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 15px;
    }

    .price-section {
        background: linear-gradient(135deg, #dcfce7 0%, #d1fae5 100%);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .price-label {
        color: #065f46;
        font-weight: 600;
        font-size: 14px;
    }

    .price-value {
        font-size: 24px;
        font-weight: 700;
        color: #047857;
    }

    .price-normal {
        text-decoration: line-through;
        color: #6b7280;
        font-size: 16px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-right: 8px;
        margin-bottom: 8px;
    }

    .badge-subsidi {
        background: #10b981;
        color: white;
    }

    .order-section {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 2px solid #f3f4f6;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .quantity-label {
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .quantity-buttons {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f3f4f6;
        padding: 8px 12px;
        border-radius: 10px;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        font-weight: 600;
        color: #047857;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .qty-btn:hover {
        background: #10b981;
        color: white;
        transform: scale(1.1);
    }

    .qty-display {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
        min-width: 40px;
        text-align: center;
    }

    .stock-info {
        font-size: 13px;
        color: #6b7280;
        margin-left: auto;
    }

    .summary-box {
        background: #f9fafb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 15px;
    }

    .summary-label {
        color: #6b7280;
    }

    .summary-value {
        font-weight: 600;
        color: #1f2937;
    }

    .summary-total {
        border-top: 2px solid #e5e7eb;
        padding-top: 15px;
        margin-top: 15px;
    }

    .summary-total .summary-label {
        font-size: 16px;
        font-weight: 600;
        color: #065f46;
    }

    .summary-total .summary-value {
        font-size: 22px;
        font-weight: 700;
        color: #047857;
    }

    .btn-order {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
    }

    .info-notice {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        font-size: 14px;
        color: #1e40af;
    }

    .product-info-section {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 30px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 22px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 3px solid #10b981;
    }

    .description-text {
        color: #4b5563;
        line-height: 1.8;
        font-size: 15px;
        margin-bottom: 20px;
    }

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .benefit-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px;
        background: #f0fdf4;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .benefit-item:hover {
        background: #dcfce7;
        transform: translateX(5px);
    }

    .benefit-icon {
        color: #10b981;
        font-size: 18px;
        margin-top: 2px;
    }

    .benefit-text {
        color: #374151;
        font-size: 14px;
        line-height: 1.6;
    }

    .usage-section {
        margin-top: 25px;
    }

    .usage-title {
        font-size: 18px;
        font-weight: 600;
        color: #065f46;
        margin-bottom: 15px;
    }

    .usage-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .usage-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .usage-card:hover {
        border-color: #10b981;
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
    }

    .usage-number {
        width: 40px;
        height: 40px;
        background: #10b981;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        margin: 0 auto 15px;
    }

    .usage-card h4 {
        font-size: 16px;
        color: #065f46;
        margin-bottom: 8px;
    }

    .usage-card p {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
    }

    .farmer-notes {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .notes-textarea {
        width: 100%;
        min-height: 150px;
        padding: 15px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        transition: all 0.3s ease;
    }

    .notes-textarea:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .notes-hint {
        font-size: 13px;
        color: #6b7280;
        margin-top: 8px;
    }

    .btn-send-notes {
        margin-top: 15px;
        padding: 12px 30px;
        border: none;
        border-radius: 10px;
        background: #10b981;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-send-notes:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    @media (max-width: 1024px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
        }

        .benefits-grid {
            grid-template-columns: 1fr;
        }

        .usage-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .container-detail {
            padding: 15px;
        }

        .product-title {
            font-size: 24px;
        }

        .thumbnail-grid {
            grid-template-columns: repeat(3, 1fr);
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
                <div class="thumbnail">
                    <img src="{{ $imageSrc }}" alt="Thumbnail 1" onclick="changeImage(this.src)">
                </div>
                <div class="thumbnail">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=150&h=150&fit=crop" alt="Thumbnail 2" onclick="changeImage(this.src)">
                </div>
                <div class="thumbnail">
                    <img src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=150&h=150&fit=crop" alt="Thumbnail 3" onclick="changeImage(this.src)">
                </div>
                <div class="thumbnail">
                    <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=150&h=150&fit=crop" alt="Thumbnail 4" onclick="changeImage(this.src)">
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
                    <span class="stock-info">Tersedia {{ $produk->stok_produk ?? 85 }}</span>
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

        <h3 style="font-size: 18px; color: #065f46; margin-bottom: 15px;">Deskripsi Produk</h3>
        <p class="description-text">
            {{ $produk->deskripsi ?? 'Pupuk NPK Phonska adalah pupuk majemuk lengkap yang mengandung unsur hara Nitrogen (N), Fosfat (P), dan Kalium (K). Faktor (P), dan Kalium (K) dalam komposisi seimbang 15-15-15. Diracik khusus untuk meningkatkan produktivitas tanaman padi, jagung, dan palawija dengan hasil maksimal.' }}
        </p>

        <h3 style="font-size: 18px; color: #065f46; margin-bottom: 15px;">Manfaat & Keunggulan</h3>
        <div class="benefits-grid">
            <div class="benefit-item">
                <i class="fas fa-check-circle benefit-icon"></i>
                <span class="benefit-text">Meningkatkan hasil panen hingga 30%</span>
            </div>
            <div class="benefit-item">
                <i class="fas fa-check-circle benefit-icon"></i>
                <span class="benefit-text">Mempercepat fase & daun tanaman</span>
            </div>
            <div class="benefit-item">
                <i class="fas fa-check-circle benefit-icon"></i>
                <span class="benefit-text">Mempercepat pertumbuhan vegetatif</span>
            </div>
            <div class="benefit-item">
                <i class="fas fa-check-circle benefit-icon"></i>
                <span class="benefit-text">Memperkukut batang & akar tanaman</span>
            </div>
        </div>

        <div class="usage-section">
            <h3 class="usage-title">Panduan Penggunaan</h3>
            <div class="usage-grid">
                <div class="usage-card">
                    <div class="usage-number">1</div>
                    <h4>Waktu Penggunaan</h4>
                    <p>Gunakan NPK saat: Tanam awal tulir, dan pindah tanam</p>
                </div>
                <div class="usage-card">
                    <div class="usage-number">2</div>
                    <h4>Pupuk Cair</h4>
                    <p>Campur 1 tutup botol NPK cair dengan 1 liter air</p>
                </div>
                <div class="usage-card">
                    <div class="usage-number">3</div>
                    <h4>Pupuk Padat</h4>
                    <p>Gunakan secukupnya, 'dengan taburan tepat sasaran sesuai</p>
                </div>
            </div>
            <div class="usage-grid" style="margin-top: 20px;">
                <div class="usage-card">
                    <h4 style="margin-bottom: 10px;">Cara Pakai:</h4>
                    <ul style="text-align: left; font-size: 13px; color: #6b7280; line-height: 1.8;">
                        <li>Taburkan di permukaan tanaman (sebagai = 10 cm dari tanaman)</li>
                        <li>Tutup biji di permuting tanaman (sebaikir = 10 cm dari tanaman)</li>
                        <li>Siram dengan air secukupnya</li>
                    </ul>
                </div>
                <div class="usage-card">
                    <h4 style="margin-bottom: 10px;">Dosis Aplikasi:</h4>
                    <ul style="text-align: left; font-size: 13px; color: #6b7280; line-height: 1.8;">
                        <li>Gunakan secara merata pada pangsan</li>
                        <li>Letakkan ampir tansi, untuk benih</li>
                        <li>Untuk pengecam cap = 2 minggu</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Farmer Notes -->
    <div class="farmer-notes">
        <h2 class="section-title">
            <i class="fas fa-comment-alt"></i>
            Ulasan Petani
        </h2>
        <p style="color: #6b7280; margin-bottom: 15px; font-size: 14px;">
            Tulis Ulasan Anda
        </p>
        <textarea class="notes-textarea" id="notesTextarea" placeholder="Tulis ulasan atau catatan khusus Anda di sini..."></textarea>
        <p class="notes-hint">Catatan ini akan membantu kami memberikan pelayanan terbaik untuk Anda</p>
        <button class="btn-send-notes" onclick="saveNotes()">
            <i class="fas fa-paper-plane"></i>
            Kirim Ulasan
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const basePrice = {{ $produk->harga_subsidi ?? 2800 }};
    let quantity = 1;

    function changeImage(src) {
        document.getElementById('mainProductImage').src = src;
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

    function saveNotes() {
        const notes = document.getElementById('notesTextarea').value;
        document.getElementById('catatanInput').value = notes;
        alert('Ulasan Anda telah disimpan!');
    }
</script>
@endpush
