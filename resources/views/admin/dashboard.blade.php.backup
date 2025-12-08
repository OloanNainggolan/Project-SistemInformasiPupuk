@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    :root {
        --color-primary: #065f46;
        --color-primary-light: #d4edda;
        --color-text-dark: #1f2937;
        --color-text-grey: #6b7280;
        --color-bg-light: #f9fafb;
        --color-border: #e5e7eb;
        --color-success: #10b981;
        --color-danger: #ef4444;
        --color-warning: #fbbf24;
        --color-processing: #8b5cf6;
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 8px;
    }

    .page-subtitle {
        font-size: 14px;
        color: var(--color-text-grey);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid var(--color-primary);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-card.success { border-left-color: var(--color-success); }
    .stat-card.warning { border-left-color: var(--color-warning); }
    .stat-card.danger { border-left-color: var(--color-danger); }
    .stat-card.processing { border-left-color: var(--color-processing); }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-icon.success { background: linear-gradient(135deg, var(--color-success), #059669); }
    .stat-icon.warning { background: linear-gradient(135deg, var(--color-warning), #f59e0b); }
    .stat-icon.danger { background: linear-gradient(135deg, var(--color-danger), #dc2626); }
    .stat-icon.processing { background: linear-gradient(135deg, var(--color-processing), #7c3aed); }

    .stat-label {
        font-size: 13px;
        color: var(--color-text-grey);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 8px;
    }

    .stat-change {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 6px;
    }

    .stat-change.up {
        background: #d1fae5;
        color: #065f46;
    }

    .stat-change.down {
        background: #fee2e2;
        color: #991b1b;
    }

    .stat-change i {
        font-size: 12px;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    /* Recent Orders Table */
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--color-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-text-dark);
    }

    .card-body {
        padding: 0;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead {
        background: var(--color-bg-light);
    }

    .orders-table th {
        padding: 12px 24px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--color-text-grey);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .orders-table td {
        padding: 16px 24px;
        border-top: 1px solid var(--color-border);
        font-size: 14px;
        color: var(--color-text-dark);
    }

    .orders-table tbody tr:hover {
        background: var(--color-bg-light);
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.processing {
        background: #e0e7ff;
        color: #3730a3;
    }

    .status-badge.ready {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-badge.completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Status Summary */
    .status-summary {
        padding: 24px;
    }

    .status-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        margin-bottom: 12px;
        background: var(--color-bg-light);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .status-item:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .status-color.pending { background: var(--color-warning); }
    .status-color.processing { background: var(--color-processing); }
    .status-color.ready { background: #3b82f6; }
    .status-color.completed { background: var(--color-success); }
    .status-color.rejected { background: var(--color-danger); }

    .status-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--color-text-dark);
    }

    .status-count {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-text-dark);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .orders-table {
            font-size: 12px;
        }

        .orders-table th,
        .orders-table td {
            padding: 10px 12px;
        }

        .stat-value {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-tachometer-alt"></i> Dashboard Overview
        </h1>
        <p class="page-subtitle">Selamat datang kembali! Berikut adalah ringkasan sistem Anda.</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div style="padding: 14px 20px; background: #d1fae5; border-left: 4px solid #10b981; border-radius: 8px; color: #065f46; display: flex; align-items: center; gap: 12px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <i class="fas fa-check-circle" style="font-size: 20px;"></i>
        <span style="font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Main Statistics Grid -->
    <div class="stats-grid">
        <!-- Total Pesanan Card -->
        <div class="stat-card success">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value">{{ number_format($totalPesanan) }}</div>
                    @if($pertumbuhanPesanan != 0)
                        <span class="stat-change {{ $pertumbuhanPesanan > 0 ? 'up' : 'down' }}">
                            <i class="fas fa-arrow-{{ $pertumbuhanPesanan > 0 ? 'up' : 'down' }}"></i>
                            {{ abs($pertumbuhanPesanan) }}% bulan ini
                        </span>
                    @endif
                </div>
                <div class="stat-icon success">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan Card -->
        <div class="stat-card warning">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    @if($pertumbuhanPendapatan != 0)
                        <span class="stat-change {{ $pertumbuhanPendapatan > 0 ? 'up' : 'down' }}">
                            <i class="fas fa-arrow-{{ $pertumbuhanPendapatan > 0 ? 'up' : 'down' }}"></i>
                            {{ abs($pertumbuhanPendapatan) }}% bulan ini
                        </span>
                    @endif
                </div>
                <div class="stat-icon warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <!-- Total Petani Card -->
        <div class="stat-card processing">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Petani</div>
                    <div class="stat-value">{{ number_format($totalPetani) }}</div>
                    @if($pertumbuhanPetani != 0)
                        <span class="stat-change {{ $pertumbuhanPetani > 0 ? 'up' : 'down' }}">
                            <i class="fas fa-arrow-{{ $pertumbuhanPetani > 0 ? 'up' : 'down' }}"></i>
                            {{ abs($pertumbuhanPetani) }}% bulan ini
                        </span>
                    @endif
                </div>
                <div class="stat-icon processing">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Total Produk Card -->
        <div class="stat-card danger">
            <div class="stat-header">
                <div>
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-value">{{ number_format($totalProduk) }}</div>
                    @if($pertumbuhanProduk != 0)
                        <span class="stat-change {{ $pertumbuhanProduk > 0 ? 'up' : 'down' }}">
                            <i class="fas fa-arrow-{{ $pertumbuhanProduk > 0 ? 'up' : 'down' }}"></i>
                            {{ abs($pertumbuhanProduk) }}% bulan ini
                        </span>
                    @endif
                </div>
                <div class="stat-icon danger">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid: Recent Orders & Status Summary -->
    <div class="content-grid">
        <!-- Recent Orders Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock"></i> Pesanan Terbaru
                </h3>
                <a href="{{ route('admin.orders') }}" style="color: var(--color-primary); font-size: 14px; font-weight: 600; text-decoration: none;">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Petani</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #9ca3af;">
                                <i class="fas fa-inbox" style="font-size: 48px; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                                <strong>Belum ada pesanan</strong>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Summary -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Status Pesanan
                </h3>
            </div>
            <div class="status-summary">
                <div class="status-item">
                    <div class="status-info">
                        <span class="status-color pending"></span>
                        <span class="status-name">Pending</span>
                    </div>
                    <span class="status-count">{{ $pendingCount }}</span>
                </div>

                <div class="status-item">
                    <div class="status-info">
                        <span class="status-color processing"></span>
                        <span class="status-name">Processing</span>
                    </div>
                    <span class="status-count">{{ $processingCount }}</span>
                </div>

                <div class="status-item">
                    <div class="status-info">
                        <span class="status-color ready"></span>
                        <span class="status-name">Ready</span>
                    </div>
                    <span class="status-count">{{ $readyCount }}</span>
                </div>

                <div class="status-item">
                    <div class="status-info">
                        <span class="status-color completed"></span>
                        <span class="status-name">Completed</span>
                    </div>
                    <span class="status-count">{{ $completedCount }}</span>
                </div>

                <div class="status-item">
                    <div class="status-info">
                        <span class="status-color rejected"></span>
                        <span class="status-name">Rejected</span>
                    </div>
                    <span class="status-count">{{ $rejectedCount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
