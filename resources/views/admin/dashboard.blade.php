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
        padding: 30px;
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
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
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
        <div class="stat-card">
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

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
            <div class="stat-change {{ ($pertumbuhanPendapatan ?? 0) >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-arrow-{{ ($pertumbuhanPendapatan ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                {{ ($pertumbuhanPendapatan ?? 0) > 0 ? '+' : '' }}{{ $pertumbuhanPendapatan ?? 0 }}% dari bulan lalu
            </div>
        </div>

        <div class="stat-card">
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

        <div class="stat-card">
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
                <a href="{{ route('admin.pesanmasuk') }}" class="view-all-link">
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

    <!-- Quick Actions -->
    <div class="quick-actions">
        <div class="section-header">
            <i class="fas fa-bolt"></i>
            <h3>Aksi Cepat</h3>
        </div>
        <div class="actions-grid">
            <a href="{{ route('admin.products.create') }}" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Produk</span>
            </a>
            <a href="{{ route('admin.pesanmasuk') }}" class="action-btn">
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
@endsection
