@extends('layouts.admin')

@section('title', 'Admin Dashboard - Overview')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
        --gold: #fbbf24;
        --blue: #3b82f6;
        --purple: #8b5cf6;
        --red: #ef4444;
    }

    .dashboard-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--green-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .page-title i {
        font-size: 28px;
        color: var(--green);
    }

    .welcome-text {
        color: #6b7280;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .welcome-text .admin-name {
        color: var(--green);
        font-weight: 600;
    }

    .welcome-text .date {
        color: #9ca3af;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
        border-color: var(--green);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: transform 0.2s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.05);
    }

    .stat-card:nth-child(1) .stat-icon {
        background: var(--green);
        color: white;
    }

    .stat-card:nth-child(2) .stat-icon {
        background: var(--blue);
        color: white;
    }

    .stat-card:nth-child(3) .stat-icon {
        background: var(--gold);
        color: white;
    }

    .stat-card:nth-child(4) .stat-icon {
        background: var(--purple);
        color: white;
    }

    .stat-body {
        position: relative;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
        line-height: 1;
    }

    .stat-description {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 8px;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
    }

    .stat-trend.up {
        color: var(--green);
    }

    .stat-trend.down {
        color: #ef4444;
    }

    .stat-trend i {
        font-size: 12px;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--green);
        font-size: 20px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 16px;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
        color: #4b5563;
        font-weight: 600;
        font-size: 13px;
    }

    .action-btn:hover {
        border-color: var(--green);
        background: var(--mint);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.1);
        color: var(--green-dark);
    }

    .action-btn i {
        font-size: 28px;
        color: var(--green);
    }

    /* Recent Orders Table */
    .orders-section {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 30px;
    }

    .orders-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .orders-table thead th {
        text-align: left;
        padding: 12px 16px;
        background: #f9fafb;
        color: #374151;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--green);
    }

    .orders-table thead th:first-child {
        border-radius: 8px 0 0 0;
    }

    .orders-table thead th:last-child {
        border-radius: 0 8px 0 0;
    }

    .orders-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #1f2937;
    }

    .orders-table tbody tr {
        transition: all 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: var(--mint);
    }

    .order-id {
        font-weight: 600;
        color: var(--green);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-ready {
        background: #fef3c7;
        color: #92400e;
    }

    .status-pending {
        background: #fce7f3;
        color: #831843;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .empty-state {
        text-align: center;
        padding: 50px 30px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        display: block;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 14px;
        font-weight: 500;
    }

    /* Alert Messages */
    .alert-success {
        padding: 14px 20px;
        background: #d1fae5;
        border: 1px solid var(--green-light);
        border-radius: 8px;
        color: var(--green-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-page {
            padding: 16px;
        }

        .page-title {
            font-size: 24px;
        }

        .page-title i {
            font-size: 24px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }

        .stat-value {
            font-size: 24px;
        }

        .orders-table {
            font-size: 12px;
        }

        .orders-table thead th,
        .orders-table tbody td {
            padding: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-page">
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard Overview
        </h1>
        <p class="welcome-text">
            <span>Selamat datang kembali,</span>
            <span class="admin-name">Admin</span>
            <span class="separator">|</span>
            <i class="far fa-calendar-alt" style="color: var(--green);"></i>
            <span class="date">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </p>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert-success">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Statistics Cards -->
<div class="stats-grid">
    <!-- Card 1: Total Pesanan -->
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">
                <i class="fas fa-shopping-bag"></i>
                Pesanan Masuk
            </div>
            <div class="stat-value">{{ $totalPesanan }}</div>
            <div class="stat-description">Total pesanan yang dikonfirmasi</div>
            <div class="stat-trend {{ $pertumbuhanPesanan >= 0 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $pertumbuhanPesanan >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ $pertumbuhanPesanan >= 0 ? '+' : '' }}{{ $pertumbuhanPesanan }}% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Petani -->
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-user-friends"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">
                <i class="fas fa-users"></i>
                Petani Terdaftar
            </div>
            <div class="stat-value">{{ $totalPetani }}</div>
            <div class="stat-description">Pengguna yang telah mendaftar</div>
            <div class="stat-trend {{ $pertumbuhanPetani >= 0 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $pertumbuhanPetani >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ $pertumbuhanPetani >= 0 ? '+' : '' }}{{ $pertumbuhanPetani }}% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Pendapatan -->
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">
                <i class="fas fa-money-bill-wave"></i>
                Total Pendapatan
            </div>
            <div class="stat-value">Rp {{ number_format($totalPendapatan / 1000000, 1) }}M</div>
            <div class="stat-description">Pendapatan dari semua pesanan</div>
            <div class="stat-trend {{ $pertumbuhanPendapatan >= 0 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $pertumbuhanPendapatan >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ $pertumbuhanPendapatan >= 0 ? '+' : '' }}{{ $pertumbuhanPendapatan }}% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- Card 4: Total Produk -->
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">
                <i class="fas fa-seedling"></i>
                Produk Tersedia
            </div>
            <div class="stat-value">{{ $totalProduk }}</div>
            <div class="stat-description">Pupuk & bibit yang dijual</div>
            <div class="stat-trend {{ $pertumbuhanProduk >= 0 ? 'up' : 'down' }}">
                <i class="fas fa-arrow-{{ $pertumbuhanProduk >= 0 ? 'up' : 'down' }}"></i>
                <span>{{ $pertumbuhanProduk >= 0 ? '+' : '' }}{{ $pertumbuhanProduk }}% dari bulan lalu</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <h2 class="section-title">
        <i class="fas fa-bolt"></i>
        Aksi Cepat
    </h2>
    <div class="actions-grid">
        <a href="{{ route('admin.orders') }}" class="action-btn">
            <i class="fas fa-shopping-cart"></i>
            <span>Lihat Pesanan</span>
        </a>
        <a href="{{ route('admin.products.create') }}" class="action-btn">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Produk</span>
        </a>
        <a href="{{ route('admin.notifications') }}" class="action-btn">
            <i class="fas fa-paper-plane"></i>
            <span>Kirim Notifikasi</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="action-btn">
            <i class="fas fa-boxes"></i>
            <span>Kelola Produk</span>
        </a>
    </div>
</div>

<!-- Recent Orders -->
<div class="orders-section">
    <h2 class="section-title">
        <i class="fas fa-history"></i>
        Pesanan Terbaru
    </h2>
    <table class="orders-table">
        <thead>
            <tr>
                <th>ID PESANAN</th>
                <th>NAMA PETANI</th>
                <th>BALAI DESA</th>
                <th>TANGGAL</th>
                <th>JENIS PRODUK</th>
                <th>STATUS</th>
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
                        <p>Belum ada pesanan terbaru</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
