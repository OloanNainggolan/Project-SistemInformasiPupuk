@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="detail-order-container">
    <!-- Header -->
    <div class="detail-header">
        <div class="header-content">
            <div class="header-left">
                <div class="order-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <h4 class="order-title">{{ $order->order_number }}</h4>
                    <p class="order-subtitle">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>
            <a href="{{ route('admin.orders') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="detail-content">
        <!-- Left Column -->
        <div class="detail-left">
            <!-- Order Status Card -->
            <div class="info-card status-card">
                <div class="card-header-custom">
                    <i class="fas fa-info-circle"></i>
                    <span>Status Pesanan</span>
                </div>
                <div class="card-body-custom">
                    <div class="status-grid">
                        <div class="status-item">
                            <div class="status-label">Status</div>
                            @php
                                $statusConfig = match($order->status) {
                                    'Completed' => ['class' => 'success', 'icon' => 'check-double'],
                                    'Ready for Pickup' => ['class' => 'info', 'icon' => 'box'],
                                    'Processing' => ['class' => 'warning', 'icon' => 'cog'],
                                    'Pending' => ['class' => 'secondary', 'icon' => 'clock'],
                                    'Rejected' => ['class' => 'danger', 'icon' => 'times-circle'],
                                    default => ['class' => 'secondary', 'icon' => 'question']
                                };
                            @endphp
                            <div class="status-badge badge-{{ $statusConfig['class'] }}">
                                <i class="fas fa-{{ $statusConfig['icon'] }}"></i>
                                <span>{{ $order->status }}</span>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-label">Konfirmasi User</div>
                            @if($order->confirmed_by_user)
                                <div class="status-badge badge-success">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Dikonfirmasi</span>
                                </div>
                            @else
                                <div class="status-badge badge-warning">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span>Menunggu</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="info-card">
                <div class="card-header-custom">
                    <i class="fas fa-box"></i>
                    <span>Informasi Produk</span>
                </div>
                <div class="card-body-custom">
                    @if($order->product)
                    <div class="product-detail">
                        <div class="product-image-container">
                            @if($order->product->primaryImage)
                                <img src="{{ asset('images/products/' . $order->product->primaryImage->image_path) }}" 
                                     alt="{{ $order->product->nama_produk }}" 
                                     class="product-image">
                            @else
                                <div class="product-no-image">
                                    <i class="fas fa-image"></i>
                                    <span>Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h5 class="product-name">{{ $order->product->nama_produk }}</h5>
                            <div class="product-badges">
                                <span class="product-badge badge-type">
                                    <i class="fas fa-tag"></i>
                                    {{ ucfirst($order->product->tipe_produk) }}
                                </span>
                                <span class="product-badge badge-category">
                                    <i class="fas fa-layer-group"></i>
                                    {{ $order->product->kategori }}
                                </span>
                            </div>
                            <div class="product-specs">
                                <div class="spec-item">
                                    <div class="spec-label">Jumlah</div>
                                    <div class="spec-value">{{ $order->quantity }} Kg</div>
                                </div>
                                <div class="spec-item">
                                    <div class="spec-label">Harga Satuan</div>
                                    <div class="spec-value">Rp {{ number_format($order->unit_price, 0, ',', '.') }}</div>
                                </div>
                                <div class="spec-item highlight">
                                    <div class="spec-label">Subtotal</div>
                                    <div class="spec-value">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert-custom alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Produk tidak ditemukan atau telah dihapus</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information -->
            <div class="info-card">
                <div class="card-header-custom">
                    <i class="fas fa-user"></i>
                    <span>Informasi Penerima</span>
                </div>
                <div class="card-body-custom">
                    @if($order->customer_name || $order->customer_phone || $order->customer_address)
                    <div class="customer-grid">
                        <div class="customer-item">
                            <div class="customer-icon">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="customer-info">
                                <div class="customer-label">Nama Penerima</div>
                                <div class="customer-value">{{ $order->customer_name ?: ($order->user ? $order->user->nama_lengkap : 'Data tidak tersedia') }}</div>
                            </div>
                        </div>
                        <div class="customer-item">
                            <div class="customer-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="customer-info">
                                <div class="customer-label">No. Telepon</div>
                                <div class="customer-value">{{ $order->customer_phone ?: ($order->user ? $order->user->no_telp : 'Data tidak tersedia') }}</div>
                            </div>
                        </div>
                        <div class="customer-item">
                            <div class="customer-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="customer-info">
                                <div class="customer-label">Alamat</div>
                                <div class="customer-value">{{ $order->customer_address ?: ($order->user ? $order->user->alamat : 'Data tidak tersedia') }}</div>
                            </div>
                        </div>
                        <div class="customer-item">
                            <div class="customer-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="customer-info">
                                <div class="customer-label">Balai Desa</div>
                                <div class="customer-value">{{ $order->village_office ?: 'Data tidak tersedia' }}</div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert-custom alert-warning">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Data customer tidak lengkap</strong>
                            <p class="mb-0 mt-1" style="font-size: 12px;">Pesanan ini dibuat sebelum sistem pencatatan customer diimplementasikan. Informasi user dapat dilihat di bagian "Informasi User".</p>
                        </div>
                    </div>
                    @endif
                        @if($order->customer_notes)
                        <div class="customer-item full-width">
                            <div class="customer-notes">
                                <div class="notes-header">
                                    <i class="fas fa-comment-dots"></i>
                                    <span>Catatan Customer</span>
                                </div>
                                <div class="notes-content">{{ $order->customer_notes }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="detail-right">
            <!-- Price Summary -->
            <div class="info-card price-card">
                <div class="card-header-custom">
                    <i class="fas fa-calculator"></i>
                    <span>Rincian Harga</span>
                </div>
                <div class="card-body-custom">
                    <div class="price-breakdown">
                        <div class="price-row">
                            <span class="price-label">Subtotal</span>
                            <span class="price-value">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="price-row discount-row">
                            <span class="price-label">
                                <i class="fas fa-tag"></i>
                                Diskon Subsidi
                            </span>
                            <span class="price-value discount">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="price-divider"></div>
                        <div class="price-row total-row">
                            <span class="price-label">Total Pembayaran</span>
                            <span class="price-value total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div class="savings-badge">
                            <i class="fas fa-piggy-bank"></i>
                            <span>Hemat Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Info -->
            @if($order->user)
            <div class="info-card user-card">
                <div class="card-header-custom">
                    <i class="fas fa-user-circle"></i>
                    <span>Informasi User</span>
                </div>
                <div class="card-body-custom">
                    <div class="user-profile">
                        <div class="user-avatar">
                            <span>{{ strtoupper(substr($order->user->nama_lengkap, 0, 1)) }}</span>
                        </div>
                        <div class="user-main-info">
                            <div class="user-name">{{ $order->user->nama_lengkap }}</div>
                            <div class="user-email">{{ $order->user->email }}</div>
                        </div>
                    </div>
                    <div class="user-details">
                        <div class="user-detail-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $order->user->no_telp }}</span>
                        </div>
                        <div class="user-detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $order->user->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Admin Notes -->
            @if($order->admin_notes || $order->rejection_reason)
            <div class="info-card notes-card">
                <div class="card-header-custom">
                    <i class="fas fa-sticky-note"></i>
                    <span>Catatan Admin</span>
                </div>
                <div class="card-body-custom">
                    @if($order->admin_notes)
                    <div class="admin-note">
                        <div class="note-label">
                            <i class="fas fa-clipboard"></i>
                            <span>Catatan</span>
                        </div>
                        <div class="note-content">{{ $order->admin_notes }}</div>
                    </div>
                    @endif
                    @if($order->rejection_reason)
                    <div class="admin-note rejection">
                        <div class="note-label">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Alasan Penolakan</span>
                        </div>
                        <div class="note-content">{{ $order->rejection_reason }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
/* Container */
.detail-order-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
    background: #f5f7fa;
    min-height: 100vh;
}

/* Header */
.detail-header {
    background: white;
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.order-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #4CAF50, #2e7d32);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.order-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.2;
}

.order-subtitle {
    font-size: 13px;
    color: #666;
    margin: 4px 0 0 0;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    color: #555;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-back:hover {
    background: #f5f5f5;
    border-color: #4CAF50;
    color: #4CAF50;
    text-decoration: none;
}

/* Content Layout */
.detail-content {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
}

/* Info Card */
.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-bottom: 24px;
    overflow: hidden;
    transition: all 0.3s;
}

.info-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.card-header-custom {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 16px 20px;
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 700;
    color: #2d5016;
}

.card-header-custom i {
    color: #4CAF50;
    font-size: 16px;
}

.card-body-custom {
    padding: 20px;
}

/* Status Card */
.status-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.status-item {
    background: #f8f9fa;
    padding: 16px;
    border-radius: 8px;
}

.status-label {
    font-size: 11px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
}

.status-badge i {
    font-size: 12px;
}

.badge-success {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-info {
    background: #e3f2fd;
    color: #1976d2;
}

.badge-warning {
    background: #fff3e0;
    color: #f57c00;
}

.badge-secondary {
    background: #f5f5f5;
    color: #666;
}

.badge-danger {
    background: #ffebee;
    color: #c62828;
}

/* Product Detail */
.product-detail {
    display: flex;
    gap: 20px;
}

.product-image-container {
    flex-shrink: 0;
    width: 140px;
}

.product-image {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #e0e0e0;
}

.product-no-image {
    width: 100%;
    height: 140px;
    background: #f5f5f5;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #999;
    border: 2px dashed #ddd;
}

.product-no-image i {
    font-size: 32px;
}

.product-no-image span {
    font-size: 12px;
}

.product-info {
    flex: 1;
}

.product-name {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 12px 0;
    line-height: 1.3;
}

.product-badges {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
}

.product-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.badge-type {
    background: #e3f2fd;
    color: #1976d2;
}

.badge-category {
    background: #f3e5f5;
    color: #7b1fa2;
}

.product-specs {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.spec-item {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
}

.spec-item.highlight {
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
}

.spec-label {
    font-size: 11px;
    font-weight: 600;
    color: #666;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.spec-value {
    font-size: 14px;
    font-weight: 700;
    color: #1a1a1a;
}

.spec-item.highlight .spec-value {
    color: #2e7d32;
}

/* Customer Grid */
.customer-grid {
    display: grid;
    gap: 16px;
}

.customer-item {
    display: flex;
    gap: 14px;
    align-items: start;
}

.customer-item.full-width {
    grid-column: 1 / -1;
}

.customer-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1976d2;
    font-size: 16px;
    flex-shrink: 0;
}

.customer-info {
    flex: 1;
}

.customer-label {
    font-size: 11px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.customer-value {
    font-size: 14px;
    color: #1a1a1a;
    font-weight: 500;
    line-height: 1.5;
}

.customer-notes {
    background: #fff8e1;
    border: 1px solid #ffe082;
    border-radius: 8px;
    padding: 14px;
}

.notes-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 700;
    color: #f57c00;
    margin-bottom: 8px;
}

.notes-content {
    font-size: 13px;
    color: #555;
    line-height: 1.6;
}

/* Price Card */
.price-breakdown {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}

.price-label {
    font-size: 13px;
    color: #555;
    font-weight: 500;
}

.price-value {
    font-size: 14px;
    font-weight: 700;
    color: #1a1a1a;
}

.discount-row .price-label {
    color: #2e7d32;
    display: flex;
    align-items: center;
    gap: 6px;
}

.discount-row .price-value.discount {
    color: #2e7d32;
}

.price-divider {
    height: 1px;
    background: linear-gradient(to right, transparent, #e0e0e0, transparent);
    margin: 8px 0;
}

.total-row {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 14px 16px !important;
    border-radius: 8px;
    margin-top: 4px;
}

.total-row .price-label {
    font-size: 14px;
    font-weight: 700;
    color: #1a1a1a;
}

.total-row .price-value.total {
    font-size: 20px;
    color: #2e7d32;
}

.savings-badge {
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    padding: 12px 16px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #2e7d32;
    font-weight: 700;
    font-size: 13px;
    margin-top: 4px;
}

.savings-badge i {
    font-size: 16px;
}

/* User Card */
.user-profile {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 16px;
}

.user-avatar {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #004d00, #047857);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    font-weight: 700;
}

.user-main-info {
    flex: 1;
}

.user-name {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 4px;
}

.user-email {
    font-size: 12px;
    color: #666;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.user-detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #555;
}

.user-detail-item i {
    width: 16px;
    color: #4CAF50;
    font-size: 13px;
}

/* Admin Notes Card */
.admin-note {
    background: #e3f2fd;
    border-left: 4px solid #1976d2;
    border-radius: 8px;
    padding: 14px;
    margin-bottom: 12px;
}

.admin-note:last-child {
    margin-bottom: 0;
}

.admin-note.rejection {
    background: #ffebee;
    border-left-color: #c62828;
}

.note-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 700;
    color: #1976d2;
    margin-bottom: 8px;
}

.admin-note.rejection .note-label {
    color: #c62828;
}

.note-content {
    font-size: 13px;
    color: #555;
    line-height: 1.6;
}

/* Alert Custom */
.alert-custom {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px;
    border-radius: 8px;
    font-size: 13px;
}

.alert-warning {
    background: #fff8e1;
    border: 1px solid #ffe082;
    color: #f57c00;
}

/* Responsive */
@media (max-width: 1024px) {
    .detail-content {
        grid-template-columns: 1fr;
    }
    
    .product-detail {
        flex-direction: column;
    }
    
    .product-image-container {
        width: 100%;
    }
    
    .product-specs {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .detail-order-container {
        padding: 16px;
    }
    
    .header-content {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
        width: 100%;
    }
    
    .status-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
@endsection
