@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin Panel')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
        --blue: #3b82f6;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        font-size: 32px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-top: 5px;
    }

    .btn-add {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 24px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
    }

    .btn-add i {
        font-size: 16px;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        padding: 20px 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .filter-group {
        flex: 1;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .filter-select {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(5, 150, 105, 0.15);
        border-color: var(--green-light);
    }

    .product-image {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    }

    .product-body {
        padding: 20px;
    }

    .product-type-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .badge-pupuk {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: var(--green-dark);
    }

    .badge-bibit {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .product-name {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .product-category {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 12px;
    }

    .product-prices {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .price-item {
        flex: 1;
    }

    .price-label {
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .price-value {
        font-size: 15px;
        font-weight: 800;
        color: var(--green-dark);
    }

    .price-normal {
        text-decoration: line-through;
        color: #9ca3af;
    }

    .product-stock {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: var(--mint);
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .product-stock i {
        color: var(--green);
        font-size: 14px;
    }

    .stock-text {
        font-size: 13px;
        font-weight: 600;
        color: var(--green-dark);
    }

    .product-actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-edit {
        background: linear-gradient(135deg, var(--blue) 0%, #60a5fa 100%);
        color: white;
        border: none;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    /* Alert */
    .alert-success {
        padding: 16px 24px;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 2px solid var(--green-light);
        border-radius: 12px;
        color: var(--green-dark);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
    }

    .alert-success i {
        font-size: 20px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 30px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    }

    .empty-state i {
        font-size: 80px;
        color: #d1d5db;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h3 {
        font-size: 22px;
        font-weight: 700;
        color: #4b5563;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #9ca3af;
        margin-bottom: 25px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .filter-section {
            flex-direction: column;
        }

        .products-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-boxes"></i>
            Kelola Produk
        </h1>
        <p class="page-subtitle">Manajemen produk pupuk dan bibit subsidi</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-add">
        <i class="fas fa-plus-circle"></i>
        Tambah Produk Baru
    </a>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert-success">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Filter Section -->
<div class="filter-section">
    <div class="filter-group">
        <div class="filter-label">Tipe Produk</div>
        <select class="filter-select" id="filterType">
            <option value="">Semua Tipe</option>
            <option value="pupuk">Pupuk</option>
            <option value="bibit">Bibit</option>
        </select>
    </div>
    <div class="filter-group">
        <div class="filter-label">Kategori</div>
        <select class="filter-select" id="filterCategory">
            <option value="">Semua Kategori</option>
            <option value="Organik">Organik</option>
            <option value="Anorganik">Anorganik</option>
            <option value="Hayati">Hayati</option>
        </select>
    </div>
    <div class="filter-group">
        <div class="filter-label">Urutkan</div>
        <select class="filter-select" id="filterSort">
            <option value="newest">Terbaru</option>
            <option value="name">Nama A-Z</option>
            <option value="price-low">Harga Terendah</option>
            <option value="price-high">Harga Tertinggi</option>
            <option value="stock">Stok Terbanyak</option>
        </select>
    </div>
</div>

<!-- Products Grid -->
<div class="products-grid">
    @forelse($products as $product)
    <div class="product-card" data-type="{{ $product->tipe_produk }}" data-category="{{ $product->kategori }}">
        <img src="{{ $product->primaryImage ? asset($product->primaryImage->image_path) : asset('images/products/default.jpg') }}" 
             alt="{{ $product->nama_produk }}" 
             class="product-image">
        
        <div class="product-body">
            <span class="product-type-badge badge-{{ $product->tipe_produk }}">
                {{ ucfirst($product->tipe_produk) }}
            </span>
            
            <h3 class="product-name">{{ $product->nama_produk }}</h3>
            <p class="product-category">Kategori: {{ $product->kategori }}</p>
            
            <div class="product-prices">
                <div class="price-item">
                    <div class="price-label">Subsidi</div>
                    <div class="price-value">Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}</div>
                </div>
                <div class="price-item">
                    <div class="price-label">Normal</div>
                    <div class="price-value price-normal">Rp {{ number_format($product->harga_normal, 0, ',', '.') }}</div>
                </div>
            </div>
            
            <div class="product-stock">
                <i class="fas fa-box"></i>
                <span class="stock-text">Stok: {{ $product->stok }} unit</span>
            </div>
            
            <div class="product-actions">
                <a href="{{ route('admin.products.edit', $product->id_produk) }}" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form action="{{ route('admin.products.destroy', $product->id_produk) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete" style="width: 100%;">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state" style="grid-column: 1 / -1;">
        <i class="fas fa-box-open" style="font-size: 80px; color: #d1d5db; margin-bottom: 24px;"></i>
        <h3 style="font-size: 24px; font-weight: 800; color: #374151; margin-bottom: 12px;">Belum Ada Produk</h3>
        <p style="font-size: 16px; color: #6b7280; margin-bottom: 28px;">Mulai tambahkan produk pupuk atau bibit subsidi untuk ditampilkan kepada petani</p>
        <a href="{{ route('admin.products.create') }}" class="btn-add" style="display: inline-flex; padding: 16px 32px; font-size: 16px; font-weight: 700;">
            <i class="fas fa-plus-circle"></i>
            Tambah Produk Pertama
        </a>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
    // Filter functionality
    const filterType = document.getElementById('filterType');
    const filterCategory = document.getElementById('filterCategory');
    const filterSort = document.getElementById('filterSort');
    const productCards = document.querySelectorAll('.product-card');

    function filterProducts() {
        const typeValue = filterType.value.toLowerCase();
        const categoryValue = filterCategory.value;

        productCards.forEach(card => {
            const cardType = card.getAttribute('data-type');
            const cardCategory = card.getAttribute('data-category');
            
            const typeMatch = !typeValue || cardType === typeValue;
            const categoryMatch = !categoryValue || cardCategory === categoryValue;
            
            if (typeMatch && categoryMatch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    filterType.addEventListener('change', filterProducts);
    filterCategory.addEventListener('change', filterProducts);

    // Sort functionality
    filterSort.addEventListener('change', function() {
        const grid = document.querySelector('.products-grid');
        const cards = Array.from(productCards);
        
        cards.sort((a, b) => {
            const sortValue = this.value;
            
            if (sortValue === 'name') {
                const nameA = a.querySelector('.product-name').textContent;
                const nameB = b.querySelector('.product-name').textContent;
                return nameA.localeCompare(nameB);
            } else if (sortValue === 'price-low' || sortValue === 'price-high') {
                const priceA = parseInt(a.querySelector('.price-value').textContent.replace(/[^0-9]/g, ''));
                const priceB = parseInt(b.querySelector('.price-value').textContent.replace(/[^0-9]/g, ''));
                return sortValue === 'price-low' ? priceA - priceB : priceB - priceA;
            } else if (sortValue === 'stock') {
                const stockA = parseInt(a.querySelector('.stock-text').textContent.replace(/[^0-9]/g, ''));
                const stockB = parseInt(b.querySelector('.stock-text').textContent.replace(/[^0-9]/g, ''));
                return stockB - stockA;
            }
            
            return 0;
        });
        
        cards.forEach(card => grid.appendChild(card));
    });
</script>
@endpush
