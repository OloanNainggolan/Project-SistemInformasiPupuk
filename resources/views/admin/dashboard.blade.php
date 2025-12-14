@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .dashboard-wrapper {
        background: linear-gradient(135deg, #e8f5f1 0%, #d4f1e8 100%);
        min-height: 100vh;
        padding: 0 30px 30px;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 30px;
        box-shadow: 0 8px 24px rgba(0, 137, 123, 0.25);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-content {
        position: relative;
        z-index: 1;
    }

    .welcome-content h1 {
        color: white;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .welcome-content p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-card:active {
        transform: translateY(-2px);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 15px;
        color: white;
    }

    .stat-card:nth-child(1) .stat-icon {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .stat-card:nth-child(4) .stat-icon {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .stat-change {
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-change.positive {
        color: #10b981;
    }

    .stat-change.negative {
        color: #ef4444;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    /* Status Pesanan */
    .status-section {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f1f5f9;
    }

    .section-header i {
        font-size: 20px;
        color: #00897b;
    }

    .section-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        flex: 1;
    }

    .status-badge {
        background: #00897b;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-list {
        list-style: none;
    }

    .status-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-item:last-child {
        border-bottom: none;
    }

    .status-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .status-dot.pending { background: #fbbf24; }
    .status-dot.processing { background: #3b82f6; }
    .status-dot.ready { background: #8b5cf6; }
    .status-dot.completed { background: #10b981; }
    .status-dot.rejected { background: #ef4444; }

    .status-name {
        font-weight: 600;
        color: #1e293b;
    }

    .status-count {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }

    /* Pesanan Terbaru */
    .orders-section {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .view-all-link {
        color: #00897b;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: gap 0.3s ease;
    }

    .view-all-link:hover {
        gap: 10px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    .empty-state h4 {
        font-size: 18px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 14px;
    }

    /* Orders Table */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .orders-table th {
        text-align: left;
        padding: 12px;
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .orders-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #1e293b;
    }

    .orders-table tr:hover {
        background: #f8fafc;
    }

    .order-status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .order-status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .order-status-badge.processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .order-status-badge.ready {
        background: #ede9fe;
        color: #5b21b6;
    }

    .order-status-badge.completed {
        background: #d1fae5;
        color: #065f46;
    }

    .order-status-badge.rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 25px 15px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        color: white;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
    }

    .action-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .action-btn i {
        font-size: 32px;
    }

    .action-btn:nth-child(1) {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .action-btn:nth-child(2) {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .action-btn:nth-child(3) {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .action-btn:nth-child(4) {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9998;
        backdrop-filter: blur(4px);
    }

    .modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-container {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 800px;
        max-height: 85vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
        z-index: 9999;
    }

    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 25px 30px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
    }

    .modal-header h2 {
        font-size: 22px;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .modal-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: white;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 30px;
        max-height: calc(85vh - 100px);
        overflow-y: auto;
    }

    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #00897b;
        border-radius: 4px;
    }

    .loading-spinner {
        text-align: center;
        padding: 40px;
    }

    .loading-spinner i {
        font-size: 48px;
        color: #00897b;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .data-table thead {
        background: #f8fafc;
    }

    .data-table th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #64748b;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .data-table td {
        padding: 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #1e293b;
    }

    .data-table tr:hover {
        background: #f8fafc;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge.pending { background: #fef3c7; color: #92400e; }
    .badge.processing { background: #dbeafe; color: #1e40af; }
    .badge.ready { background: #ede9fe; color: #5b21b6; }
    .badge.completed { background: #d1fae5; color: #065f46; }
    .badge.rejected { background: #fee2e2; color: #991b1b; }

    .empty-modal-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-modal-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    .empty-modal-state h4 {
        font-size: 18px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .empty-modal-state p {
        color: #94a3b8;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <h1>Selamat Datang, Administrator! 👋</h1>
            <p>Berikut adalah ringkasan sistem hari ini - {{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card" data-type="orders" onclick="showDetailModal('orders')">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ $totalPesanan ?? 0 }}</div>
            <div class="stat-change {{ ($pertumbuhanPesanan ?? 0) >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ ($pertumbuhanPesanan ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                {{ ($pertumbuhanPesanan ?? 0) > 0 ? '+' : '' }}{{ $pertumbuhanPesanan ?? 0 }}% dari bulan lalu
            </div>
        </div>

        <div class="stat-card" data-type="revenue" onclick="showDetailModal('revenue')">
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.')}}</div>            
            <div class="stat-change {{ ($pertumbuhanPendapatan ?? 0) >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ ($pertumbuhanPendapatan ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                {{ ($pertumbuhanPendapatan ?? 0) > 0 ? '+' : '' }}{{ $pertumbuhanPendapatan ?? 0 }}% dari bulan lalu
            </div>
        </div>

        <div class="stat-card" data-type="farmers" onclick="showDetailModal('farmers')">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total Petani</div>
            <div class="stat-value">{{ $totalPetani ?? 1 }}</div>
            <div class="stat-change {{ ($pertumbuhanPetani ?? 100) >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ ($pertumbuhanPetani ?? 100) >= 0 ? 'up' : 'down' }}"></i>
                +{{ $pertumbuhanPetani ?? 100 }}% dari bulan lalu
            </div>
        </div>

        <div class="stat-card" data-type="products" onclick="showDetailModal('products')">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-value">{{ $totalProduk ?? 0 }}</div>
            <div class="stat-change {{ ($pertumbuhanProduk ?? 0) >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ ($pertumbuhanProduk ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                {{ ($pertumbuhanProduk ?? 0) > 0 ? '+' : '' }}{{ $pertumbuhanProduk ?? 0 }}% dari bulan lalu
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Status Pesanan -->
        <div class="status-section">
            <div class="section-header">
                <i class="fas fa-chart-pie"></i>
                <h3>Status Pesanan</h3>
                <span class="status-badge">{{ $totalPesanan ?? 0 }} Total</span>
            </div>
            <ul class="status-list">
                <li class="status-item">
                    <div class="status-info">
                        <span class="status-dot pending"></span>
                        <span class="status-name">Pending</span>
                    </div>
                    <span class="status-count">{{ $pendingCount ?? 0 }}</span>
                </li>
                <li class="status-item">
                    <div class="status-info">
                        <span class="status-dot processing"></span>
                        <span class="status-name">Processing</span>
                    </div>
                    <span class="status-count">{{ $processingCount ?? 0 }}</span>
                </li>
                <li class="status-item">
                    <div class="status-info">
                        <span class="status-dot ready"></span>
                        <span class="status-name">Ready</span>
                    </div>
                    <span class="status-count">{{ $readyCount ?? 0 }}</span>
                </li>
                <li class="status-item">
                    <div class="status-info">
                        <span class="status-dot completed"></span>
                        <span class="status-name">Completed</span>
                    </div>
                    <span class="status-count">{{ $completedCount ?? 0 }}</span>
                </li>
                <li class="status-item">
                    <div class="status-info">
                        <span class="status-dot rejected"></span>
                        <span class="status-name">Rejected</span>
                    </div>
                    <span class="status-count">{{ $rejectedCount ?? 0 }}</span>
                </li>
            </ul>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="orders-section">
            <div class="section-header">
                <i class="fas fa-clock"></i>
                <h3>Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders') }}" class="view-all-link">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            @if(isset($recentOrders) && $recentOrders->count() > 0)
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>No Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders->take(5) as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->product->nama_produk ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="order-status-badge {{ strtolower($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h4>Belum ada pesanan</h4>
                    <p>Pesanan akan muncul di sini ketika ada customer yang memesan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Activity Log Section -->
    @include('admin.partials.activity-log')

    <!-- Quick Actions -->
    <div class="quick-actions">
        <div class="section-header">
            <i class="fas fa-tachometer-alt"></i>
            <h3>Aksi Cepat</h3>
        </div>
        <div class="actions-grid">
            <a href="{{ route('admin.products.create') }}" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Produk</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="action-btn">
                <i class="fas fa-list-alt"></i>
                <span>Kelola Pesanan</span>
            </a>
            <a href="{{ route('admin.notifications.inbox') }}" class="action-btn">
                <i class="fas fa-inbox"></i>
                <span>Notifikasi Masuk</span>
            </a>
            <a href="{{ route('admin.notifications.send') }}" class="action-btn">
                <i class="fas fa-paper-plane"></i>
                <span>Kirim Notifikasi</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal-overlay" id="detailModal" onclick="closeModal(event)">
    <div class="modal-container" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2 id="modalTitle">
                <i class="fas fa-chart-line"></i>
                <span>Detail Data</span>
            </h2>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalContent">
            <div class="loading-spinner">
                <i class="fas fa-spinner"></i>
                <p>Memuat data...</p>
            </div>
        </div>
    </div>
</div>

<script>
function showDetailModal(type) {
    const modal = document.getElementById('detailModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    
    // Show modal
    modal.classList.add('active');
    
    // Set loading state
    modalContent.innerHTML = `
        <div class="loading-spinner">
            <i class="fas fa-spinner"></i>
            <p>Memuat data...</p>
        </div>
    `;
    
    // Set title based on type
    const titles = {
        'orders': '<i class="fas fa-shopping-cart"></i> Detail Pesanan',
        'revenue': '<i class="fas fa-wallet"></i> Detail Pendapatan',
        'farmers': '<i class="fas fa-users"></i> Detail Petani',
        'products': '<i class="fas fa-box"></i> Detail Produk'
    };
    modalTitle.innerHTML = titles[type] || 'Detail Data';
    
    // Fetch data
    fetch(`/admin/dashboard/detail/${type}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                modalContent.innerHTML = renderData(type, data.data);
            } else {
                modalContent.innerHTML = `
                    <div class="empty-modal-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <h4>Gagal Memuat Data</h4>
                        <p>${data.message || 'Terjadi kesalahan saat memuat data'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalContent.innerHTML = `
                <div class="empty-modal-state">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h4>Error</h4>
                    <p>Tidak dapat terhubung ke server</p>
                </div>
            `;
        });
}

function renderData(type, data) {
    if (!data || data.length === 0) {
        return `
            <div class="empty-modal-state">
                <i class="fas fa-inbox"></i>
                <h4>Belum Ada Data</h4>
                <p>Data akan muncul di sini ketika tersedia</p>
            </div>
        `;
    }
    
    switch(type) {
        case 'orders':
            return renderOrders(data);
        case 'revenue':
            return renderRevenue(data);
        case 'farmers':
            return renderFarmers(data);
        case 'products':
            return renderProducts(data);
        default:
            return '<p>Tipe data tidak dikenali</p>';
    }
}

function renderOrders(orders) {
    let html = `
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    orders.forEach(order => {
        const statusClass = order.status.toLowerCase();
        html += `
            <tr>
                <td><strong>${order.order_number}</strong></td>
                <td>${order.customer_name}</td>
                <td>Rp ${Number(order.total_amount).toLocaleString('id-ID')}</td>
                <td><span class="badge ${statusClass}">${order.status}</span></td>
                <td>${order.date}</td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
    `;
    
    return html;
}

function renderRevenue(revenues) {
    let total = 0;
    let html = `
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Pendapatan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    revenues.forEach(order => {
        total += parseFloat(order.total_amount);
        html += `
            <tr>
                <td><strong>${order.order_number}</strong></td>
                <td>${order.customer_name}</td>
                <td>Rp ${Number(order.total_amount).toLocaleString('id-ID')}</td>
                <td>${order.date}</td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold; padding-top: 20px;">Total Pendapatan:</td>
                    <td colspan="2" style="font-weight: bold; font-size: 18px; color: #00897b; padding-top: 20px;">
                        Rp ${total.toLocaleString('id-ID')}
                    </td>
                </tr>
            </tfoot>
        </table>
    `;
    
    return html;
}

function renderFarmers(farmers) {
    let html = `
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    farmers.forEach(farmer => {
        html += `
            <tr>
                <td><strong>${farmer.nama_lengkap}</strong></td>
                <td>${farmer.email}</td>
                <td>${farmer.no_telp || '-'}</td>
                <td>${farmer.alamat || '-'}</td>
                <td>${farmer.joined_date}</td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
    `;
    
    return html;
}

function renderProducts(products) {
    let html = `
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Tipe</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga Subsidi</th>
                    <th>Harga Normal</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    products.forEach(product => {
        html += `
            <tr>
                <td><strong>${product.nama_produk}</strong></td>
                <td>${product.tipe_produk}</td>
                <td>${product.kategori}</td>
                <td>${product.stok_produk} ${product.satuan || 'kg'}</td>
                <td>Rp ${Number(product.harga_subsidi).toLocaleString('id-ID')}</td>
                <td>Rp ${Number(product.harga_normal).toLocaleString('id-ID')}</td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
    `;
    
    return html;
}

function closeModal(event) {
    if (!event || event.target.id === 'detailModal') {
        document.getElementById('detailModal').classList.remove('active');
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endsection
