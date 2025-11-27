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

    /* Page Title */
    .page-header {
        margin-bottom: 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-title i {
        font-size: 36px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .welcome-text {
        color: #6b7280;
        font-size: 15px;
        margin-top: 5px;
    }

    /* Stats Grid - Modern Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(5, 150, 105, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(5, 150, 105, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(5, 150, 105, 0.15);
        border-color: var(--green);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        position: relative;
        z-index: 1;
    }

    .stat-card:nth-child(1) .stat-icon {
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
    }

    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, var(--blue) 0%, #60a5fa 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, var(--gold) 0%, #fcd34d 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.3);
    }

    .stat-card:nth-child(4) .stat-icon {
        background: linear-gradient(135deg, var(--purple) 0%, #a78bfa 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
    }

    .stat-body {
        position: relative;
        z-index: 1;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 34px;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 12px;
        line-height: 1;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .stat-trend.up {
        color: var(--green);
    }

    .stat-trend i {
        font-size: 14px;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 35px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title i {
        color: var(--green);
        font-size: 22px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 20px;
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        color: #4b5563;
        font-weight: 600;
        font-size: 14px;
    }

    .action-btn:hover {
        border-color: var(--green);
        background: linear-gradient(135deg, var(--mint) 0%, white 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.15);
        color: var(--green-dark);
    }

    .action-btn i {
        font-size: 32px;
        color: var(--green);
    }

    /* Recent Orders Table */
    .orders-section {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 35px;
    }

    .orders-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .orders-table thead th {
        text-align: left;
        padding: 15px;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--green);
    }

    .orders-table thead th:first-child {
        border-radius: 10px 0 0 0;
    }

    .orders-table thead th:last-child {
        border-radius: 0 10px 0 0;
    }

    .orders-table tbody td {
        padding: 18px 15px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #1f2937;
    }

    .orders-table tbody tr {
        transition: all 0.3s ease;
    }

    .orders-table tbody tr:hover {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        transform: scale(1.01);
    }

    .order-id {
        font-weight: 700;
        color: var(--green);
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-completed {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-processing {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .status-ready {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-pending {
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
        color: #831843;
    }

    .status-rejected {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .empty-state {
        text-align: center;
        padding: 60px 30px;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        display: block;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 16px;
        font-weight: 600;
    }

    /* Alert Messages */
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
        font-size: 22px;
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
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
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
            padding: 12px 10px;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-chart-pie"></i>
            Dashboard Overview
        </h1>
        <p class="welcome-text">Selamat datang kembali, Admin! Berikut ringkasan sistem hari ini.</p>
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
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ $totalPesanan }}</div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+12% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">Total Petani</div>
            <div class="stat-value">{{ $totalPetani }}</div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+8% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">Pendapatan</div>
            <div class="stat-value">{{ number_format($totalPendapatan / 1000000, 1) }}M</div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+15% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-box-open"></i>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-label">Total Produk</div>
            <div class="stat-value">{{ $totalProduk }}</div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+5% dari bulan lalu</span>
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
        <a href="{{ route('products.create') }}" class="action-btn">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Produk</span>
        </a>
        <a href="{{ route('admin.notifications') }}" class="action-btn">
            <i class="fas fa-paper-plane"></i>
            <span>Kirim Notifikasi</span>
        </a>
        <a href="{{ route('products.index') }}" class="action-btn">
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
