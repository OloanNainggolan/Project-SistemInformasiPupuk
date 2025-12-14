@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="orders-container">
    <!-- Statistics Cards -->

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="stat-card stat-processing">
            <div class="stat-icon"><i class="fas fa-cog"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['processing'] }}</div>
                <div class="stat-label">Processing</div>
            </div>
        </div>
        <div class="stat-card stat-ready">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['ready'] }}</div>
                <div class="stat-label">Ready</div>
            </div>
        </div>
        <div class="stat-card stat-completed">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['completed'] }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="stat-card stat-rejected">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['rejected'] }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.orders') }}" class="filters-form">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari order number, nama, atau telepon..." value="{{ $query }}">
            </div>
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Processing" {{ $status == 'Processing' ? 'selected' : '' }}>Processing</option>
                <option value="Ready" {{ $status == 'Ready' ? 'selected' : '' }}>Ready</option>
                <option value="Completed" {{ $status == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn-search"><i class="fas fa-search"></i> Cari</button>
        </form>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
    <div class="orders-grid">
        @foreach($orders as $order)
        <div class="order-card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="order-number">
                    <i class="fas fa-receipt"></i>
                    <span>{{ $order->order_number }}</span>
                </div>
                <span class="order-badge badge-{{ strtolower($order->status) }}">
                    {{ $order->status }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Customer Info -->
                <div class="customer-section">
                    <div class="info-row">
                        <i class="fas fa-user"></i>
                        <span class="info-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-phone"></i>
                        <span class="info-value">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="info-value">{{ Str::limit($order->customer_address, 50) }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-calendar"></i>
                        <span class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-section">
                    <div class="section-title">Detail Produk</div>
                    @if($order->product)
                    <div class="product-item">
                        <div class="product-info">
                            <div class="product-name">{{ $order->product->nama_produk }}</div>
                            <div class="product-meta">
                                <span class="product-qty">{{ $order->quantity }} {{ $order->product->satuan }}</span>
                                <span class="product-price">@ Rp {{ number_format($order->unit_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="product-subtotal">
                            Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endif
                    
                    @if($order->discount_amount > 0)
                    <div class="discount-row">
                        <span>Diskon Subsidi</span>
                        <span class="discount-value">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    
                    <div class="total-row">
                        <span>Total Pembayaran</span>
                        <span class="total-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Notes -->
                @if($order->customer_notes)
                <div class="notes-section">
                    <div class="section-title">Catatan</div>
                    <p class="notes-text">{{ $order->customer_notes }}</p>
                </div>
                @endif

                <!-- Status Update -->
                <div class="status-section">
                    <form action="{{ route('admin.orders.updateStatus', $order->order_number) }}" method="POST" class="status-form">
                        @csrf
                        @method('PATCH')
                        <label class="status-label">Update Status</label>
                        <div class="status-control">
                            <select name="status" class="status-select" required>
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Ready" {{ $order->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Rejected" {{ $order->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn-update">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.orders.show', $order->order_number) }}" class="btn-detail">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        {{ $orders->appends(['search' => $query, 'status' => $status])->links() }}
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>Tidak ada pesanan yang ditemukan</p>
    </div>
    @endif
</div>

<style>
/* Container */
.orders-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px 20px;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
    border-color: #4CAF50;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.stat-total .stat-icon { background: linear-gradient(135deg, #e3f2fd, #bbdefb); color: #1565c0; }
.stat-pending .stat-icon { background: linear-gradient(135deg, #fafafa, #e0e0e0); color: #616161; }
.stat-processing .stat-icon { background: linear-gradient(135deg, #f3e5f5, #e1bee7); color: #6a1b9a; }
.stat-ready .stat-icon { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); color: #2e7d32; }
.stat-completed .stat-icon { background: linear-gradient(135deg, #c8e6c9, #a5d6a7); color: #1b5e20; }
.stat-rejected .stat-icon { background: linear-gradient(135deg, #ffebee, #ffcdd2); color: #c62828; }

.stat-info {
    flex: 1;
}

.stat-value {
    font-size: 28px;
    font-weight: 800;
    color: #2d5016;
    line-height: 1;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
}

.stat-label {
    font-size: 12px;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

/* Filters Section */
.filters-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 2px solid #e5e7eb;
}

.filters-form {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    align-items: center;
}

.search-box {
    flex: 1;
    min-width: 280px;
    position: relative;
}

.search-box i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #4CAF50;
    font-size: 14px;
}

.search-box input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.search-box input:focus {
    outline: none;
    border-color: #4CAF50;
    background: white;
    box-shadow: 0 0 0 4px rgba(76,175,80,0.1);
}

.search-box input::placeholder {
    color: #9ca3af;
}

.filter-select {
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    background: #f9fafb;
    min-width: 160px;
    transition: all 0.3s ease;
}

.filter-select:hover {
    border-color: #4CAF50;
    background: white;
}

.filter-select:focus {
    outline: none;
    border-color: #4CAF50;
    background: white;
    box-shadow: 0 0 0 4px rgba(76,175,80,0.1);
}

.btn-search {
    padding: 12px 24px;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(76,175,80,0.3);
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-search:hover {
    background: linear-gradient(135deg, #45a049, #3d8b40);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(76,175,80,0.4);
}

.btn-search i {
    font-size: 14px;
}

/* Orders Grid */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 24px;
    margin-bottom: 30px;
}

.order-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.order-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transform: translateY(-4px);
    border-color: #4CAF50;
}

/* Card Header */
.card-header {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #e5e7eb;
}

.order-number {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 800;
    color: #065f46;
    font-size: 14px;
    letter-spacing: 0.3px;
}

.order-number i {
    color: #10b981;
    font-size: 16px;
}

.order-badge {
    padding: 6px 14px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 2px solid;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge-pending { background: #f3f4f6; color: #6b7280; border-color: #d1d5db; }
.badge-processing { background: #f3e5f5; color: #6a1b9a; border-color: #ce93d8; }
.badge-ready { background: #d1fae5; color: #065f46; border-color: #10b981; }
.badge-completed { background: #a5d6a7; color: #1b5e20; border-color: #66bb6a; }
.badge-rejected { background: #ffcdd2; color: #b71c1c; border-color: #ef5350; }

/* Card Body */
.card-body {
    padding: 20px;
}

/* Customer Section */
.customer-section {
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f3f4f6;
}

.info-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 13px;
    color: #374151;
    font-weight: 500;
}

.info-row:last-child {
    margin-bottom: 0;
}

.info-row i {
    width: 18px;
    color: #10b981;
    font-size: 13px;
    text-align: center;
}

.info-value {
    flex: 1;
}

/* Product Section */
.product-section {
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f3f4f6;
}

.section-title {
    font-size: 12px;
    font-weight: 700;
    color: #4b5563;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.section-title::before {
    content: '';
    width: 3px;
    height: 14px;
    background: #10b981;
    border-radius: 2px;
}

.product-item {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 10px;
    padding: 12px;
    background: #f9fafb;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.product-name {
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
    line-height: 1.3;
}

.product-meta {
    display: flex;
    gap: 12px;
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

.product-qty {
    font-weight: 700;
    color: #4b5563;
}

.product-price {
    color: #059669;
}

.product-subtotal {
    font-size: 15px;
    font-weight: 800;
    color: #065f46;
    white-space: nowrap;
}

.discount-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 8px;
    padding: 8px 12px;
    background: #fef2f2;
    border-radius: 6px;
}

.discount-value {
    color: #dc2626;
    font-weight: 700;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 14px 12px;
    border-top: 2px solid #e5e7eb;
    margin-top: 10px;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-radius: 8px;
}

.total-row span:first-child {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.total-value {
    font-size: 18px;
    font-weight: 800;
    color: #065f46;
    letter-spacing: -0.3px;
}

/* Notes Section */
.notes-section {
    margin-bottom: 16px;
    padding: 14px;
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border-radius: 8px;
    border: 2px solid #fbbf24;
}

.notes-section .section-title {
    margin-bottom: 8px;
}

.notes-text {
    font-size: 13px;
    color: #78350f;
    margin: 0;
    line-height: 1.6;
    font-weight: 500;
}

/* Status Section */
.status-section {
    margin-top: 16px;
    padding: 16px;
    background: #f9fafb;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
}

.status-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.status-control {
    display: flex;
    gap: 10px;
}

.status-select {
    flex: 1;
    padding: 11px 14px;
    border: 2px solid #d1d5db;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    background: white;
    transition: all 0.3s ease;
}

.status-select:hover {
    border-color: #10b981;
}

.status-select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16,185,129,0.1);
}

.btn-update {
    padding: 11px 18px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 6px rgba(16,185,129,0.3);
}

.btn-update:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(16,185,129,0.4);
}

.btn-update i {
    font-size: 13px;
}

/* Empty State */
.empty-state {
    background: white;
    border-radius: 12px;
    padding: 80px 20px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 2px solid #e5e7eb;
}

.empty-state i {
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state p {
    font-size: 16px;
    color: #6b7280;
    font-weight: 600;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    margin-top: 18px;
    display: flex;
    gap: 12px;
}

.btn-detail {
    flex: 1;
    padding: 14px 20px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white !important;
    text-decoration: none !important;
    border-radius: 10px;
    text-align: center;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    letter-spacing: 0.3px;
}

.btn-detail:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(37, 99, 235, 0.4);
}

.btn-detail i {
    font-size: 15px;
}

/* Pagination */
.pagination-section {
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 1024px) {
    .orders-grid {
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .orders-container {
        padding: 20px 15px;
    }

    .orders-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .stat-card {
        padding: 16px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        font-size: 20px;
    }

    .stat-value {
        font-size: 24px;
    }
    
    .filters-form {
        flex-direction: column;
    }
    
    .search-box {
        min-width: 100%;
    }

    .filter-select {
        width: 100%;
    }

    .btn-search {
        width: 100%;
        justify-content: center;
    }

    .card-header {
        padding: 14px 16px;
    }

    .card-body {
        padding: 16px;
    }

    .product-item {
        flex-direction: column;
        gap: 8px;
    }

    .product-subtotal {
        text-align: left;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .order-number {
        font-size: 13px;
    }

    .order-badge {
        font-size: 10px;
        padding: 5px 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit forms with confirmation
    const statusForms = document.querySelectorAll('.status-form');
    
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const select = this.querySelector('.status-select');
            const newStatus = select.value;
            const orderNumber = this.action.split('/').pop();
            
            if (confirm(`Apakah Anda yakin ingin mengubah status pesanan ${orderNumber} menjadi ${newStatus}?`)) {
                this.submit();
            }
        });
    });
});
</script>
@endsection
