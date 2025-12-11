@extends('layouts.admin')

@section('title', 'Detail Pesanan - Admin')

@push('styles')
<style>
    .detail-container {
        max-width: 1400px;
        margin: 30px auto;
        padding: 0 20px;
    }

    /* Back Button */
    .back-button {
        margin-bottom: 20px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        color: #065f46;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #065f46;
        color: white;
        border-color: #065f46;
        transform: translateX(-5px);
    }

    /* Header Section */
    .order-header {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .order-title-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f3f4f6;
    }

    .order-title {
        font-size: 24px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 8px;
    }

    .order-date {
        font-size: 14px;
        color: #6b7280;
    }

    .status-badge {
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-processing {
        background: #e0e7ff;
        color: #5b21b6;
    }

    .status-ready {
        background: #d1fae5;
        color: #065f46;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Grid Layout */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }

    /* Card Styles */
    .detail-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #10b981;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        font-size: 20px;
    }

    /* Info Rows */
    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-item {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 15px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 3px solid #10b981;
    }

    .info-label {
        font-weight: 600;
        color: #065f46;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: #10b981;
        font-size: 14px;
    }

    .info-value {
        color: #374151;
        font-size: 14px;
        font-weight: 500;
        word-break: break-word;
    }

    /* Products Section */
    .products-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .product-item {
        display: grid;
        grid-template-columns: 80px 1fr 120px;
        gap: 20px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 10px;
        margin-bottom: 15px;
        align-items: center;
    }

    .product-item:last-child {
        margin-bottom: 0;
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #10b981;
    }

    .product-info h4 {
        font-size: 16px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 5px;
    }

    .product-meta {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .product-quantity {
        font-size: 13px;
        color: #374151;
        font-weight: 600;
    }

    .product-price {
        text-align: right;
    }

    .product-subtotal {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
    }

    .product-unit-price {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    /* Total Section */
    .total-section {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
        border: 2px solid #10b981;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

    .total-label {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
    }

    .total-value {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
    }

    .grand-total {
        border-top: 2px solid #10b981;
        margin-top: 10px;
        padding-top: 15px;
    }

    .grand-total .total-label {
        font-size: 20px;
        font-weight: 700;
        color: #065f46;
    }

    .grand-total .total-value {
        font-size: 24px;
        font-weight: 700;
        color: #10b981;
    }

    /* Action Buttons */
    .action-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-processing {
        background: #8b5cf6;
        color: white;
    }

    .btn-processing:hover {
        background: #7c3aed;
    }

    .btn-ready {
        background: #10b981;
        color: white;
    }

    .btn-ready:hover {
        background: #059669;
    }

    .btn-complete {
        background: #065f46;
        color: white;
    }

    .btn-complete:hover {
        background: #064e3b;
    }

    .btn-reject {
        background: #ef4444;
        color: white;
    }

    .btn-reject:hover {
        background: #dc2626;
    }

    .btn-print {
        background: white;
        color: #065f46;
        border: 2px solid #065f46;
    }

    .btn-print:hover {
        background: #065f46;
        color: white;
    }

    /* Rejection Section */
    .rejection-section {
        background: #fee2e2;
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #ef4444;
        margin-top: 20px;
    }

    .rejection-title {
        font-size: 16px;
        font-weight: 700;
        color: #991b1b;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rejection-reason {
        font-size: 14px;
        color: #7f1d1d;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .product-item {
            grid-template-columns: 60px 1fr 100px;
            gap: 15px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
    }

    @media (max-width: 768px) {
        .order-title-section {
            flex-direction: column;
            gap: 15px;
        }

        .product-item {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .product-price {
            text-align: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('admin.orders') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar Pesanan</span>
        </a>
    </div>

    <!-- Order Header -->
    <div class="order-header">
        <div class="order-title-section">
            <div>
                <h1 class="order-title">Pesanan {{ $order->order_number }}</h1>
                <p class="order-date">
                    <i class="far fa-calendar"></i>
                    {{ $order->created_at->format('d F Y, H:i') }} WIB
                </p>
            </div>
            <div>
                <span class="status-badge status-{{ strtolower($order->status) }}">
                    {{ $order->status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Customer & Delivery Info -->
    <div class="detail-grid">
        <!-- Customer Information -->
        <div class="detail-card">
            <h3 class="card-title">
                <i class="fas fa-user"></i>
                Informasi Pelanggan
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-user-circle"></i>
                        Nama Lengkap
                    </div>
                    <div class="info-value">{{ $order->user->nama_lengkap ?? $order->user->name ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </div>
                    <div class="info-value">{{ $order->user->email ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-phone"></i>
                        No. Telepon
                    </div>
                    <div class="info-value">{{ $order->user->no_hp ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-id-card"></i>
                        NIK
                    </div>
                    <div class="info-value">{{ $order->user->nik ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="detail-card">
            <h3 class="card-title">
                <i class="fas fa-map-marker-alt"></i>
                Informasi Pengambilan
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-building"></i>
                        Balai Desa
                    </div>
                    <div class="info-value">{{ $order->village_office ?? 'Balai Desa' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-map"></i>
                        Alamat Lengkap
                    </div>
                    <div class="info-value">{{ $order->user->alamat ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-credit-card"></i>
                        Metode Pembayaran
                    </div>
                    <div class="info-value">Tunai di Lokasi</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-check-circle"></i>
                        Status Konfirmasi
                    </div>
                    <div class="info-value">
                        @if($order->confirmed_by_user)
                            <span style="color: #10b981; font-weight: 700;">
                                <i class="fas fa-check"></i> Dikonfirmasi
                            </span>
                        @else
                            <span style="color: #f59e0b; font-weight: 700;">
                                <i class="fas fa-clock"></i> Menunggu
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Ordered -->
    <div class="products-section">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i>
            Produk yang Dipesan
        </h3>
        
        @php
            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
            $subtotal = 0;
        @endphp

        @if(is_array($items) && count($items) > 0)
            @foreach($items as $item)
                @php
                    $itemSubtotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                    $subtotal += $itemSubtotal;
                @endphp
                <div class="product-item">
                    <div class="product-image">
                        @if(($item['type'] ?? '') === 'pupuk')
                            <i class="fas fa-seedling"></i>
                        @else
                            <i class="fas fa-leaf"></i>
                        @endif
                    </div>
                    <div class="product-info">
                        <h4>{{ $item['product_name'] ?? 'Produk' }}</h4>
                        <p class="product-meta">
                            <span style="background: #e0e7ff; color: #5b21b6; padding: 3px 10px; border-radius: 5px; font-weight: 600;">
                                {{ ucfirst($item['type'] ?? 'N/A') }}
                            </span>
                            <span style="margin-left: 10px;">{{ $item['category'] ?? 'N/A' }}</span>
                        </p>
                        <p class="product-quantity">
                            <i class="fas fa-box"></i> Jumlah: {{ $item['quantity'] ?? 0 }} kg
                        </p>
                    </div>
                    <div class="product-price">
                        <div class="product-subtotal">
                            Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                        </div>
                        <div class="product-unit-price">
                            @ Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}/kg
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Total Section -->
            <div class="total-section">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Ongkos Kirim</span>
                    <span class="total-value">Rp 0</span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Total Pembayaran</span>
                    <span class="total-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 40px;">
                <i class="fas fa-inbox" style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
                Tidak ada produk dalam pesanan ini
            </p>
        @endif
    </div>

    <!-- Rejection Reason (if rejected) -->
    @if($order->status === 'Rejected' && $order->rejection_reason)
    <div class="rejection-section">
        <div class="rejection-title">
            <i class="fas fa-exclamation-triangle"></i>
            Alasan Penolakan
        </div>
        <p class="rejection-reason">{{ $order->rejection_reason }}</p>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-section">
        <h3 class="card-title">
            <i class="fas fa-cogs"></i>
            Kelola Pesanan
        </h3>
        <div class="action-buttons">
            @if($order->status === 'Pending')
                <button class="btn btn-processing" onclick="updateStatus('Processing')">
                    <i class="fas fa-spinner"></i>
                    Proses Pesanan
                </button>
                <button class="btn btn-reject" onclick="rejectOrder()">
                    <i class="fas fa-times-circle"></i>
                    Tolak Pesanan
                </button>
            @elseif($order->status === 'Processing')
                <button class="btn btn-ready" onclick="updateStatus('Ready')">
                    <i class="fas fa-check"></i>
                    Siap Diambil
                </button>
                <button class="btn btn-reject" onclick="rejectOrder()">
                    <i class="fas fa-times-circle"></i>
                    Tolak Pesanan
                </button>
            @elseif($order->status === 'Ready')
                <button class="btn btn-complete" onclick="updateStatus('Completed')">
                    <i class="fas fa-check-double"></i>
                    Selesaikan Pesanan
                </button>
            @endif
            
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i>
                Cetak Detail
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateStatus(newStatus) {
        if (!confirm(`Apakah Anda yakin ingin mengubah status pesanan menjadi "${newStatus}"?`)) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/admin/orders/{{ $order->order_number }}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Status pesanan berhasil diupdate!');
                location.reload();
            } else {
                alert('❌ Gagal mengupdate status: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat mengupdate status');
        });
    }

    function rejectOrder() {
        const reason = prompt('Masukkan alasan penolakan:');
        
        if (!reason || reason.trim() === '') {
            alert('❌ Alasan penolakan harus diisi!');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/admin/api/orders/{{ $order->order_number }}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                status: 'Rejected',
                rejection_reason: reason.trim()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Pesanan berhasil ditolak!');
                location.reload();
            } else {
                alert('❌ Gagal menolak pesanan: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat menolak pesanan');
        });
    }
</script>
@endpush
