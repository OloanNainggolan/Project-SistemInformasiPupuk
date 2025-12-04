@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    :root {
        --color-primary: #065f46;
        --color-primary-light: #d4edda;
        --color-text-dark: #1f2937;
        --color-text-grey: #6b7280;
        --color-bg-light: #f0f4f0;
        --color-border: #e5e7eb;
        --color-success: #10b981;
        --color-danger: #ef4444;
        --color-warning: #fbbf24;
        --color-processing: #8b5cf6;
    }

    .dashboard-wrapper {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
        margin: 30px auto;
        max-width: 1400px;
        padding: 0 20px;
    }

    /* Sidebar Profile */
    .profile-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-title-green {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        padding: 15px 20px;
        border-radius: 12px;
        font-size: 20px;
        font-weight: 700;
        color: var(--color-primary);
        text-align: center;
    }

    .profile-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
    }

    .profile-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 32px;
        color: white;
        font-weight: 700;
    }

    .profile-username {
        font-size: 16px;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 4px;
    }

    .profile-handle {
        font-size: 12px;
        color: var(--color-text-grey);
        margin-bottom: 16px;
    }

    .profile-info {
        text-align: left;
        margin: 16px 0;
        font-size: 11px;
        line-height: 1.5;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .profile-info p {
        margin: 0;
        padding: 10px 12px;
        color: #4b5563;
        display: grid;
        grid-template-columns: 18px 1fr;
        align-items: start;
        gap: 10px;
        word-break: break-word;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 3px solid var(--color-primary);
    }

    .profile-info i {
        color: var(--color-primary);
        flex-shrink: 0;
        margin-top: 1px;
        font-size: 13px;
        text-align: center;
    }
    
    .profile-info p span {
        line-height: 1.5;
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 16px;
    }

    .btn {
        padding: 10px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 13px;
    }

    .btn-edit {
        background: var(--color-primary);
        color: white;
    }

    .btn-edit:hover {
        background: #044e37;
    }

    .btn-logout {
        background: var(--color-danger);
        color: white;
        width: 100%;
    }

    .btn-logout:hover {
        background: #dc2626;
    }

    /* Main Dashboard Area */
    .dashboard-main {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Stats Row */
    .stats-container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid var(--color-border);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-left {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--color-text-grey);
        font-weight: 600;
        text-transform: uppercase;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--color-text-dark);
    }

    .stat-change {
        font-size: 12px;
        color: var(--color-success);
        font-weight: 600;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        border-radius: 8px;
        background: #f3f4f6;
    }

    /* Orders Table */
    .orders-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .orders-section h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-text-dark);
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--color-primary);
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead th {
        text-align: left;
        padding: 12px;
        background: #f9fafb;
        color: var(--color-text-grey);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 2px solid var(--color-border);
    }

    .orders-table tbody td {
        padding: 15px 12px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: var(--color-text-dark);
    }

    .orders-table tbody tr:hover {
        background: #f9fafb;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-processing {
        background: #e0e7ff;
        color: #5b21b6;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .dashboard-wrapper {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .orders-table {
            font-size: 12px;
        }

        .orders-table thead th,
        .orders-table tbody td {
            padding: 10px 8px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <!-- Left Sidebar: Profile -->
    <aside class="profile-sidebar">
        <div class="page-title-green">
            Admin Dashboard
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
            </div>
            <div class="profile-username">{{ session('admin_name', 'Administrator Sistem') }}</div>
            <div class="profile-handle">@{{ session('admin_username', 'admin') }}</div>

            <div class="profile-info">
                <p>
                    <i class="fas fa-envelope"></i>
                    <span>{{ session('admin_email', 'Nupi.Sianturi@gmail.com') }}</span>
                </p>
                <p>
                    <i class="fas fa-phone"></i>
                    <span>{{ session('admin_phone', '+62 812-3456-7890') }}</span>
                </p>
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ session('admin_address', 'Desa Situlama, Kec. Silaiang, Kab. Sidama, Jawa Barat') }}</span>
                </p>
                <p>
                    <i class="fas fa-calendar"></i>
                    <span>Bergabung Sejak Januari 2020</span>
                </p>
            </div>

            <div class="profile-actions">
                <a href="{{ route('admin.profil.edit') }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" style="width: 100%;">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Right: Main Dashboard Area -->
    <main class="dashboard-main">
        <!-- Alert Messages -->
        @if(session('success'))
        <div style="padding: 12px 20px; background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 8px; color: #065f46; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="stats-container">
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
                        <i class="fas fa-handshake" style="color: #059669;"></i>
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
                        <i class="fas fa-users" style="color: #059669;"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-left">
                        <div class="stat-label">Total Pendapatan</div>
                        <div class="stat-value">Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i> +8%
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-chart-line" style="color: #059669;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table - Pesanan dalam Proses -->
        <div class="orders-section">
            <h2><i class="fas fa-clock"></i> Pesanan dalam Pemrosesan</h2>
            <p style="font-size: 13px; color: #6b7280; margin-top: -10px; margin-bottom: 15px;">
                Pesanan yang memerlukan tindakan. Untuk melihat riwayat pesanan selesai, buka menu <a href="{{ route('admin.orders') }}" style="color: #10b981; font-weight: 600;">Pesanan</a>.
            </p>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Balai Desa</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.orders.show', $order->order_number) }}'">
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->nama_lengkap ?? $order->user->name ?? 'N/A' }}</td>
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
                        <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                            <i class="fas fa-check-circle" style="font-size: 48px; margin-bottom: 10px; display: block; color: #10b981;"></i>
                            <strong>Semua pesanan sudah diproses!</strong><br>
                            <small>Lihat riwayat pesanan di menu Pesanan</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
