@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    :root {
        --color-primary: #065f46;
        --color-primary-light: #d1fae5;
        --color-text-dark: #1f2937;
        --color-text-grey: #6b7280;
        --color-bg-light: #f0f4f0;
        --color-border: #e5e7eb;
        --color-success: #10b981;
        --color-danger: #ef4444;
        --color-warning: #f59e0b;
        --color-processing: #8b5cf6;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #10b981;
    }

    .page-subtitle {
        font-size: 15px;
        color: #6b7280;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 30px;
    }

    /* Main Content Area */
    .dashboard-main {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
    }

    .stat-left {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--color-text-grey);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--color-text-dark);
        line-height: 1;
    }

    .stat-change {
        font-size: 13px;
        color: var(--color-success);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        background: #d1fae5;
        padding: 4px 10px;
        border-radius: 20px;
        margin-top: 5px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        border-radius: 14px;
        background: linear-gradient(135deg, #dcfce7, #d1fae5);
    }

    .stat-icon i {
        color: #059669;
    }

    /* Orders Section */
    .orders-section {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #10b981;
        font-size: 20px;
    }

    .view-all-btn {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .view-all-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Orders Table */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead th {
        text-align: left;
        padding: 14px 12px;
        background: linear-gradient(135deg, #f8faf8, #f0f4f0);
        color: var(--color-text-grey);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .orders-table tbody td {
        padding: 16px 12px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: var(--color-text-dark);
    }

    .orders-table tbody tr {
        transition: all 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: linear-gradient(135deg, #f8faf8, #f0f4f0);
    }

    .order-id {
        font-weight: 700;
        color: #065f46;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-completed {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .status-processing {
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        color: #5b21b6;
    }

    .status-rejected {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .status-ready {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    /* Profile Sidebar */
    .profile-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .profile-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 45px;
        color: white;
        position: relative;
        z-index: 1;
        border: 5px solid white;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .profile-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background: #f59e0b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
    }

    .profile-badge i {
        font-size: 10px;
        color: white;
    }

    .profile-name {
        font-size: 20px;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 4px;
        position: relative;
        z-index: 1;
    }

    .profile-role {
        font-size: 13px;
        color: #10b981;
        font-weight: 600;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        background: #d1fae5;
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .profile-info {
        text-align: left;
        margin: 20px 0;
        font-size: 13px;
        line-height: 1.8;
        position: relative;
        z-index: 1;
    }

    .profile-info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .profile-info-item:last-child {
        border-bottom: none;
    }

    .profile-info-item i {
        color: #10b981;
        width: 20px;
        margin-top: 2px;
    }

    .profile-info-item span {
        color: #4b5563;
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }

    .btn {
        padding: 14px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        width: 100%;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    /* Quick Actions Card */
    .quick-actions {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .quick-actions h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quick-actions h3 i {
        color: #10b981;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #f8faf8;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--color-text-dark);
    }

    .quick-action-btn:hover {
        background: linear-gradient(135deg, #dcfce7, #d1fae5);
        transform: translateX(5px);
    }

    .quick-action-btn i {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .quick-action-btn span {
        font-weight: 600;
        font-size: 14px;
    }

    /* Alert Messages */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7;
        color: #065f46;
    }

    .alert i {
        font-size: 20px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 60px;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .empty-state p {
        font-size: 16px;
        color: #6b7280;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            order: -1;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 24px;
        }

        .orders-table {
            font-size: 12px;
        }

        .orders-table thead th,
        .orders-table tbody td {
            padding: 12px 8px;
        }

        .section-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard Admin
    </h1>
    <p class="page-subtitle">Selamat datang kembali! Kelola sistem distribusi pupuk dan bibit subsidi.</p>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<div class="dashboard-grid">
    <!-- Main Dashboard Area -->
    <div class="dashboard-main">
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-left">
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value">{{ $totalPesanan }}</div>
                    <div class="stat-change">
                        <i class="fas fa-arrow-up"></i> +35%
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-left">
                    <div class="stat-label">Total Petani</div>
                    <div class="stat-value">{{ $totalPetani }}</div>
                    <div class="stat-change">
                        <i class="fas fa-arrow-up"></i> +10%
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-left">
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-value" style="font-size: 24px;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="stat-change">
                        <i class="fas fa-arrow-up"></i> +8%
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="orders-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list-alt"></i>
                    Pesanan Terbaru
                </h2>
                <a href="{{ route('admin.orders') }}" class="view-all-btn">
                    <i class="fas fa-external-link-alt"></i>
                    Lihat Semua
                </a>
            </div>

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Petani</th>
                        <th>Balai Desa</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><span class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->village_office }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            @php
                                $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
                                $types = [];
                                if (is_array($items)) {
                                    foreach ($items as $item) {
                                        if (isset($item['type'])) {
                                            $types[] = ucfirst($item['type']);
                                        }
                                    }
                                }
                                echo implode(', ', array_unique($types)) ?: 'N/A';
                            @endphp
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada pesanan yang masuk</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Profile Sidebar -->
    <aside class="profile-sidebar">
        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-avatar">
                <i class="fas fa-user-shield"></i>
                <div class="profile-badge">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            <div class="profile-name">Administrator</div>
            <div class="profile-role">Super Admin</div>

            <div class="profile-info">
                <div class="profile-info-item">
                    <i class="fas fa-envelope"></i>
                    <span>admin@pupukbibit.com</span>
                </div>
                <div class="profile-info-item">
                    <i class="fas fa-phone"></i>
                    <span>+62 812-3456-7890</span>
                </div>
                <div class="profile-info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Sitoluama, Laguboti, Toba</span>
                </div>
                <div class="profile-info-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Bergabung sejak Januari 2020</span>
                </div>
            </div>

            <div class="profile-actions">
                <form action="{{ route('admin.logout') }}" method="POST" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3>
                <i class="fas fa-bolt"></i>
                Aksi Cepat
            </h3>
            <a href="{{ route('admin.orders') }}" class="quick-action-btn">
                <i class="fas fa-shopping-cart"></i>
                <span>Kelola Pesanan</span>
            </a>
            <a href="{{ route('products.index') }}" class="quick-action-btn">
                <i class="fas fa-box"></i>
                <span>Kelola Produk</span>
            </a>
            <a href="{{ route('products.create') }}" class="quick-action-btn">
                <i class="fas fa-plus"></i>
                <span>Tambah Produk Baru</span>
            </a>
            <a href="{{ route('admin.notifications') }}" class="quick-action-btn">
                <i class="fas fa-bell"></i>
                <span>Kirim Notifikasi</span>
            </a>
        </div>
    </aside>
</div>
@endsection
