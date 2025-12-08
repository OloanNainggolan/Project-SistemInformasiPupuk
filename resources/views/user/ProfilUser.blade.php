@extends('layouts.user')

@section('title', 'Profil Saya')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Main Container */
    .profile-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f5 100%);
        padding: 40px 20px;
        margin-top: 100px;
    }

    .profile-wrapper {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Success Alert */
    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c8e6c9 100%);
        color: #155724;
        border: 2px solid #81c784;
        padding: 16px 24px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.15);
        animation: slideDown 0.4s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success i {
        font-size: 1.4rem;
    }

    .alert-success span {
        font-weight: 600;
        font-size: 0.98rem;
    }

    /* Layout Grid */
    .profile-layout {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 30px;
    }

    /* Profile Card - Left Sidebar */
    .profile-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        height: fit-content;
        position: sticky;
        top: 120px;
    }

    .profile-header-section {
        text-align: center;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 30px;
        margin-bottom: 30px;
    }

    .profile-avatar-wrapper {
        width: 140px;
        height: 140px;
        margin: 0 auto 20px;
        position: relative;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid #10b981;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
        transition: all 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 32px rgba(16, 185, 129, 0.35);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name-section h2 {
        font-size: 1.75rem;
        color: #1f2937;
        margin-bottom: 8px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .profile-name-section .username-badge {
        display: inline-block;
        background: #ecfdf5;
        color: #059669;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        border: 1px solid #a7f3d0;
    }

    /* Profile Info List */
    .profile-info-list {
        margin-bottom: 30px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        color: #4b5563;
        font-size: 0.95rem;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    .info-item:hover {
        color: #10b981;
        padding-left: 8px;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: #f0fdf4;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 1rem;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .info-item:hover .info-icon {
        background: #10b981;
        color: white;
        transform: scale(1.1);
    }

    .info-text {
        flex: 1;
        line-height: 1.5;
        word-break: break-word;
    }

    /* Action Buttons */
    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 30px;
    }

    .btn {
        width: 100%;
        padding: 14px 20px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-edit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-logout {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-logout:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    /* Land Info Section */
    .land-info-card {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-radius: 16px;
        padding: 24px;
        border: 2px solid #a7f3d0;
    }

    .land-info-card h3 {
        font-size: 1.1rem;
        color: #065f46;
        margin-bottom: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .land-details {
        margin-bottom: 16px;
    }

    .land-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

    .land-label {
        color: #047857;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .land-value {
        color: #065f46;
        font-weight: 800;
        font-size: 1.2rem;
    }

    .commodity-tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 12px;
    }

    .tag {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .tag-padi {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fbbf24;
    }

    .tag-jagung {
        background: #fed7aa;
        color: #7c2d12;
        border: 1px solid #fb923c;
    }

    /* Main Content Area */
    .main-content {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 28px 24px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card.purple::before {
        background: linear-gradient(90deg, #8b5cf6, #a78bfa);
    }

    .stat-card.blue::before {
        background: linear-gradient(90deg, #3b82f6, #60a5fa);
    }

    .stat-card.orange::before {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .stat-card.green::before {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 16px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-card.purple .stat-icon {
        background: linear-gradient(135deg, #8b5cf6, #a78bfa);
        color: white;
    }

    .stat-card.blue .stat-icon {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        color: white;
    }

    .stat-card.orange .stat-icon {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: white;
    }

    .stat-card.green .stat-icon {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 8px;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }

    /* Orders Section */
    .orders-section {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f3f4f6;
    }

    .section-title {
        font-size: 1.5rem;
        color: #1f2937;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title i {
        color: #10b981;
        font-size: 1.3rem;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f9fafb;
    }

    th {
        padding: 16px;
        text-align: left;
        font-weight: 700;
        color: #374151;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    td {
        padding: 18px 16px;
        color: #4b5563;
        font-size: 0.95rem;
    }

    .order-id {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .order-name {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.status-ready {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-badge.status-processing {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.status-pending {
        background: #fed7aa;
        color: #7c2d12;
    }

    .status-badge.status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-detail:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .empty-orders {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-orders i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-orders h4 {
        font-size: 1.5rem;
        color: #374151;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .empty-orders p {
        color: #6b7280;
        margin-bottom: 24px;
        font-size: 1rem;
    }

    .btn-browse-products {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-browse-products:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #f3f4f6;
    }

    .page-btn,
    .page-arrow {
        width: 40px;
        height: 40px;
        border: 2px solid #e5e7eb;
        background: white;
        border-radius: 10px;
        font-weight: 700;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-btn:hover,
    .page-arrow:hover {
        border-color: #10b981;
        color: #10b981;
        background: #ecfdf5;
    }

    .page-btn.active {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .profile-layout {
            grid-template-columns: 1fr;
        }

        .profile-card {
            position: static;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            margin-top: 80px;
            padding: 20px 15px;
        }

        .profile-layout {
            gap: 20px;
        }

        .profile-card {
            padding: 30px 20px;
        }

        .profile-avatar-wrapper {
            width: 120px;
            height: 120px;
        }

        .profile-name-section h2 {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .orders-section {
            padding: 24px 20px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .table-container {
            overflow-x: scroll;
        }

        table {
            min-width: 600px;
        }
    }

    @media (max-width: 480px) {
        .profile-name-section h2 {
            font-size: 1.3rem;
        }

        .stat-value {
            font-size: 1.7rem;
        }

        .section-title {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-wrapper">
        <!-- Success Alert -->
        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="profile-layout">
            <!-- Left Sidebar - Profile Card -->
            <aside>
                <div class="profile-card">
                    <!-- Profile Header -->
                    <div class="profile-header-section">
                        <div class="profile-avatar-wrapper">
                            <div class="profile-avatar">
                                <img src="{{ auth()->user()->foto ? asset('images/profiles/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_lengkap) . '&background=10b981&color=fff&size=200&font-size=0.4' }}" 
                                     alt="{{ auth()->user()->nama_lengkap }}">
                            </div>
                        </div>
                        <div class="profile-name-section">
                            <h2>{{ auth()->user()->nama_lengkap }}</h2>
                            <span class="username-badge">
                                <i class="fas fa-user"></i> {{ auth()->user()->username ?? 'User' }}
                            </span>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="profile-info-list">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-text">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-text">{{ auth()->user()->no_telp ?? 'Belum diisi' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-text">
                                {{ auth()->user()->alamat ?? 'Belum diisi' }}{{ auth()->user()->kabupaten ? ', ' . auth()->user()->kabupaten : '' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="info-text">Bergabung {{ auth()->user()->created_at->format('F Y') }}</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="profile-actions">
                        <a href="{{ route('profil.edit') }}" class="btn btn-edit">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </button>
                        </form>
                    </div>

                    <!-- Land Information -->
                    <div class="land-info-card">
                        <h3>
                            <i class="fas fa-seedling"></i> Informasi Lahan
                        </h3>
                        <div class="land-details">
                            <div class="land-item">
                                <span class="land-label">Luas Lahan</span>
                                <span class="land-value">2.4 Ha</span>
                            </div>
                        </div>
                        <div class="land-label">Komoditas</div>
                        <div class="commodity-tags">
                            <span class="tag tag-padi">
                                <i class="fas fa-leaf"></i> Padi
                            </span>
                            <span class="tag tag-jagung">
                                <i class="fas fa-seedling"></i> Jagung
                            </span>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="main-content">
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card purple">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-value">{{ $totalPesanan }}</div>
                        <div class="stat-label">Total Pesanan</div>
                    </div>
                    <div class="stat-card blue">
                        <div class="stat-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="stat-value">{{ number_format($pupukDiterima / 1000, 1) }} Ton</div>
                        <div class="stat-label">Pupuk Diterima</div>
                    </div>
                    <div class="stat-card orange">
                        <div class="stat-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="stat-value">{{ $bibitDiterima }} Kg</div>
                        <div class="stat-label">Bibit Diterima</div>
                    </div>
                    <div class="stat-card green">
                        <div class="stat-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="stat-value">{{ number_format($totalPenghematan / 1000000, 1) }} Jt</div>
                        <div class="stat-label">Penghematan</div>
                    </div>
                </div>

                <!-- Orders History -->
                <div class="orders-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-history"></i> Riwayat Pesanan
                        </h3>
                    </div>

                    <div class="table-container">
                        @if($orders->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Pesanan</th>
                                    <th>Tanggal Order</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="order-id">{{ $order->order_number }}</div>
                                        <div class="order-name">{{ $order->product ? $order->product->nama_produk : 'Produk tidak tersedia' }}</div>
                                    </td>
                                    <td>{{ $order->created_at->format('d F Y') }}</td>
                                    <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                    <td>
                                        @if($order->status == 'Completed')
                                            <span class="status-badge status-completed">Selesai</span>
                                        @elseif($order->status == 'Ready for Pickup')
                                            <span class="status-badge status-ready">Siap Diambil</span>
                                        @elseif($order->status == 'Processing')
                                            <span class="status-badge status-processing">Diproses</span>
                                        @elseif($order->status == 'Pending')
                                            <span class="status-badge status-pending">Menunggu</span>
                                        @elseif($order->status == 'Rejected')
                                            <span class="status-badge status-rejected">Ditolak</span>
                                        @else
                                            <span class="status-badge">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn-detail" onclick="showOrderDetail({{ $order->id }}); return false;">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="empty-orders">
                            <i class="fas fa-inbox"></i>
                            <h4>Belum Ada Pesanan</h4>
                            <p>Anda belum memiliki riwayat pesanan</p>
                            <a href="{{ route('user.pupukbibit') }}" class="btn-browse-products">
                                <i class="fas fa-shopping-cart"></i> Mulai Belanja
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                    <div class="pagination">
                        @if($orders->onFirstPage())
                            <button class="page-arrow" disabled>←</button>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="page-arrow">←</a>
                        @endif

                        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if($page == $orders->currentPage())
                                <button class="page-btn active">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</button>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            @endif
                        @endforeach

                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="page-arrow">→</a>
                        @else
                            <button class="page-arrow" disabled>→</button>
                        @endif
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div id="orderDetailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 20px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto; padding: 32px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px solid #f3f4f6;">
            <h3 style="font-size: 1.5rem; color: #1f2937; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-file-invoice" style="color: #10b981;"></i> Detail Pesanan
            </h3>
            <button onclick="closeOrderDetail()" style="width: 36px; height: 36px; border-radius: 8px; border: none; background: #f3f4f6; color: #6b7280; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: all 0.3s ease;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="orderDetailContent" style="color: #4b5563;">
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #10b981;"></i>
                <p style="margin-top: 16px; color: #6b7280;">Memuat data...</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showOrderDetail(orderId) {
    const modal = document.getElementById('orderDetailModal');
    const content = document.getElementById('orderDetailContent');
    
    // Show modal
    modal.style.display = 'flex';
    
    // Fetch order details
    fetch(`/user/orders/${orderId}/detail`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const order = data.order;
                let statusBadgeClass = 'status-completed';
                let statusText = order.status;
                
                if (order.status === 'Completed') {
                    statusBadgeClass = 'status-completed';
                    statusText = 'Selesai';
                } else if (order.status === 'Ready for Pickup') {
                    statusBadgeClass = 'status-ready';
                    statusText = 'Siap Diambil';
                } else if (order.status === 'Processing') {
                    statusBadgeClass = 'status-processing';
                    statusText = 'Diproses';
                } else if (order.status === 'Pending') {
                    statusBadgeClass = 'status-pending';
                    statusText = 'Menunggu';
                } else if (order.status === 'Rejected') {
                    statusBadgeClass = 'status-rejected';
                    statusText = 'Ditolak';
                }
                
                content.innerHTML = `
                    <div style="background: #f9fafb; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <div>
                                <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 4px;">Nomor Pesanan</div>
                                <div style="font-size: 1.1rem; font-weight: 700; color: #1f2937;">${order.order_number}</div>
                            </div>
                            <span class="status-badge ${statusBadgeClass}">${statusText}</span>
                        </div>
                        <div style="font-size: 0.9rem; color: #6b7280;">
                            <i class="fas fa-calendar-alt" style="color: #10b981; margin-right: 6px;"></i>
                            ${order.created_at}
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-box" style="color: #10b981;"></i> Informasi Produk
                        </h4>
                        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 16px;">
                            <div style="font-weight: 700; color: #1f2937; margin-bottom: 8px; font-size: 1.05rem;">${order.product_name}</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; font-size: 0.9rem;">
                                <div>
                                    <span style="color: #6b7280;">Jumlah:</span>
                                    <span style="font-weight: 700; color: #1f2937;"> ${order.quantity || 0} Kg</span>
                                </div>
                                <div>
                                    <span style="color: #6b7280;">Harga Satuan:</span>
                                    <span style="font-weight: 700; color: #1f2937;"> Rp ${order.unit_price_formatted || '0'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-user" style="color: #10b981;"></i> Informasi Penerima
                        </h4>
                        <div style="background: white; border: 2px solid #e5e7eb; border-radius: 12px; padding: 16px; font-size: 0.9rem;">
                            <div style="margin-bottom: 10px;">
                                <i class="fas fa-user-circle" style="color: #10b981; margin-right: 8px;"></i>
                                <strong>${order.customer_name || '-'}</strong>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <i class="fas fa-phone" style="color: #10b981; margin-right: 8px;"></i>
                                ${order.customer_phone || '-'}
                            </div>
                            <div style="margin-bottom: 10px;">
                                <i class="fas fa-map-marker-alt" style="color: #10b981; margin-right: 8px;"></i>
                                ${order.customer_address || '-'}
                            </div>
                            <div>
                                <i class="fas fa-building" style="color: #10b981; margin-right: 8px;"></i>
                                ${order.village_office || '-'}
                            </div>
                        </div>
                    </div>
                    
                    ${order.customer_notes ? `
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-comment" style="color: #10b981;"></i> Catatan
                        </h4>
                        <div style="background: #fef3c7; border: 2px solid #fbbf24; border-radius: 12px; padding: 16px; font-size: 0.9rem; color: #92400e;">
                            ${order.customer_notes}
                        </div>
                    </div>
                    ` : ''}
                    
                    <div style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 2px solid #a7f3d0; border-radius: 12px; padding: 20px; margin-top: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="color: #047857; font-weight: 600;">Subtotal</span>
                            <span style="color: #065f46; font-weight: 700;">Rp ${order.subtotal_formatted}</span>
                        </div>
                        ${order.discount_amount > 0 ? `
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="color: #047857; font-weight: 600;">Diskon</span>
                            <span style="color: #059669; font-weight: 700;">- Rp ${order.discount_formatted}</span>
                        </div>
                        ` : ''}
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 2px solid #a7f3d0;">
                            <span style="color: #065f46; font-weight: 800; font-size: 1.1rem;">Total</span>
                            <span style="color: #065f46; font-weight: 800; font-size: 1.3rem;">Rp ${order.total_formatted}</span>
                        </div>
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #ef4444; margin-bottom: 16px;"></i>
                        <h4 style="color: #1f2937; margin-bottom: 8px;">Gagal Memuat Data</h4>
                        <p style="color: #6b7280;">${data.message || 'Terjadi kesalahan'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            content.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #f59e0b; margin-bottom: 16px;"></i>
                    <h4 style="color: #1f2937; margin-bottom: 8px;">Terjadi Kesalahan</h4>
                    <p style="color: #6b7280;">Tidak dapat memuat detail pesanan</p>
                </div>
            `;
        });
}

function closeOrderDetail() {
    document.getElementById('orderDetailModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('orderDetailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrderDetail();
    }
});
</script>
@endpush

@endsection
