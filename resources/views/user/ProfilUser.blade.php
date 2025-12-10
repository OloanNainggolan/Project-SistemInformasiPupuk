@extends('layouts.user')

@section('title', 'Profil Saya')

@push('styles')
<style>
    /* Main Container */
    .profile-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        margin-top: 140px;
        margin-bottom: 3rem;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 1.5rem;
    }

    /* Profile Sidebar Card */
    .profile-sidebar {
        background: white;
        border-radius: 8px;
        padding: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 160px;
        border: 1px solid #e5e7eb;
    }

    .profile-avatar-wrapper {
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .profile-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        margin: 0 auto 0.8rem;
        overflow: hidden;
        background: linear-gradient(135deg, #004d00, #047857);
        box-shadow: 0 2px 8px rgba(16,185,129,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 500;
        flex-shrink: 0;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .profile-name {
        text-align: center;
        margin-bottom: 0.6rem;
    }

    .profile-name h2 {
        font-size: 1rem;
        color: #1b5e20;
        margin-bottom: 0.25rem;
        font-weight: 700;
    }

    .profile-username {
        color: #666;
        font-size: 0.75rem;
        background: #f0f0f0;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
        display: inline-block;
        font-weight: 600;
    }

    .profile-details {
        margin: 0.75rem 0;
        padding: 0.75rem 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-row {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        color: #555;
        font-size: 0.78rem;
        line-height: 1.3;
    }

    .detail-row:last-child {
        margin-bottom: 0;
    }

    .detail-icon {
        width: 20px;
        height: 20px;
        min-width: 20px;
        background: #f8f9fa;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #4caf50;
    }
    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-top: 0.75rem;
    }

    .btn {
        padding: 0.5rem 0.8rem;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.78rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        text-decoration: none;
    }

    .btn-edit-profile {
        background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(76, 175, 80, 0.2);
    }

    .btn-edit-profile:hover {
        background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.35);
    }

    .btn-logout {
        background: white;
        color: #dc3545;
        border: 2px solid #dc3545;
        box-shadow: none;
    }

    .btn-logout:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }

    /* Land Info Card */
    .land-info-card {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 0.75rem;
        margin-top: 0.75rem;
        border: 1px solid #e0e0e0;
    }

    .land-info-card h3 {
        font-size: 0.85rem;
        color: #1b5e20;
        margin-bottom: 0.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .land-detail {
        margin-bottom: 0.5rem;
    }

    .land-label {
        font-size: 0.65rem;
        color: #666;
        margin-bottom: 0.15rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .land-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1b5e20;
    }

    .commodity-list {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .commodity-tag {
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .commodity-padi {
        background: #fff3e0;
        color: #e65100;
        border: 1px solid #ffcc80;
    }

    .commodity-jagung {
        background: #fff9c4;
        color: #f57f17;
        border: 1px solid #fff176;
    }

    /* Main Content Area */
    .profile-main-content {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.8rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        text-align: center;
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

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .stat-card.purple::before { background: linear-gradient(90deg, #7e57c2, #9575cd); }
    .stat-card.blue::before { background: linear-gradient(90deg, #42a5f5, #64b5f6); }
    .stat-card.orange::before { background: linear-gradient(90deg, #ff9800, #ffb74d); }
    .stat-card.green::before { background: linear-gradient(90deg, #4CAF50, #66bb6a); }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
    }

    .stat-card.purple .stat-icon {
        background: linear-gradient(135deg, #7e57c2, #9575cd);
        color: white;
        box-shadow: 0 4px 15px rgba(126, 87, 194, 0.25);
    }

    .stat-card.blue .stat-icon {
        background: linear-gradient(135deg, #42a5f5, #64b5f6);
        color: white;
        box-shadow: 0 4px 15px rgba(66, 165, 245, 0.25);
    }

    .stat-card.orange .stat-icon {
        background: linear-gradient(135deg, #ff9800, #ffb74d);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 152, 0, 0.25);
    }

    .stat-card.green .stat-icon {
        background: linear-gradient(135deg, #4CAF50, #66bb6a);
        color: white;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.25);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1b5e20;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 600;
    }

    /* Orders Section */
    .orders-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title {
        font-size: 1.4rem;
        color: #1b5e20;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .section-title i {
        color: #4caf50;
    }

    /* Orders Table */
    .orders-table-wrapper {
        overflow-x: auto;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead {
        background: #f8f9fa;
    }

    .orders-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.9rem;
        color: #666;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e0e0e0;
    }

    .orders-table td {
        padding: 1.2rem 1rem;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.95rem;
        color: #555;
    }

    .orders-table tbody tr {
        transition: all 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: #f8f9fa;
    }

    .order-product {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-icon-small {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        flex-shrink: 0;
    }

    .product-icon-small.pupuk {
        background: linear-gradient(135deg, #4CAF50, #66bb6a);
    }

    .product-icon-small.bibit {
        background: linear-gradient(135deg, #42a5f5, #64b5f6);
    }

    .product-details h4 {
        font-size: 1rem;
        color: #1b5e20;
        margin-bottom: 0.2rem;
        font-weight: 700;
    }

    .product-details p {
        font-size: 0.85rem;
        color: #666;
    }

    .order-id {
        font-weight: 700;
        color: #4caf50;
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.completed {
        background: #c8e6c9;
        color: #2e7d32;
    }

    .status-badge.ready {
        background: #b3e5fc;
        color: #0277bd;
    }

    .status-badge.processing {
        background: #fff9c4;
        color: #f57f17;
    }

    .status-badge.pending {
        background: #ffecb3;
        color: #ff6f00;
    }

    .status-badge.rejected {
        background: #ffcdd2;
        color: #c62828;
    }

    .order-price {
        font-weight: 700;
        color: #1b5e20;
        font-size: 1.05rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-state p {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 1.5rem;
    }

    .btn-browse {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.9rem 1.8rem;
        background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(76, 175, 80, 0.3);
    }

    .btn-browse:hover {
        background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
    }

    /* Detail Button */
    .btn-detail {
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);
    }

    .btn-detail:hover {
        background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(30px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 700px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.3s ease;
    }

    .modal-header {
        padding: 1.5rem 2rem;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        background: white;
        border-radius: 20px 20px 0 0;
        z-index: 10;
    }

    .modal-header h3 {
        font-size: 1.4rem;
        color: #1b5e20;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        margin: 0;
    }

    .modal-close {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #f5f5f5;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: #666;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: #ffebee;
        color: #d32f2f;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 2rem;
    }

    .detail-section {
        margin-bottom: 1.5rem;
    }

    .detail-section-title {
        font-size: 1rem;
        color: #1b5e20;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .detail-item-modal {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
    }

    .detail-label-modal {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 0.4rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value-modal {
        font-size: 1.1rem;
        color: #1b5e20;
        font-weight: 700;
    }

    .product-info-modal {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);
        padding: 1.5rem;
        border-radius: 16px;
        border: 2px solid #a5d6a7;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .product-image-modal {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #4caf50;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
        flex-shrink: 0;
    }

    .product-info-text h4 {
        font-size: 1.3rem;
        color: #1b5e20;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .product-info-text p {
        font-size: 0.95rem;
        color: #666;
    }

    .price-breakdown {
        background: #fff9c4;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px solid #fff176;
        margin-top: 1rem;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
        font-size: 1rem;
        color: #555;
    }

    .price-row.total {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1b5e20;
        padding-top: 0.8rem;
        border-top: 2px dashed #ffeb3b;
        margin-top: 0.5rem;
    }

    .savings-badge {
        display: inline-block;
        background: #4caf50;
        color: white;
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-sidebar {
            position: static;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            margin-top: 120px;
            padding: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .orders-table {
            font-size: 0.85rem;
        }

        .orders-table th,
        .orders-table td {
            padding: 0.8rem 0.6rem;
        }

        .product-icon-small {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .modal-content {
            width: 95%;
            max-height: 90vh;
        }

        .modal-header {
            padding: 1rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .product-info-modal {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .profile-avatar {
            width: 34px;
            height: 34px;
        }

        .profile-name h2 {
            font-size: 1.3rem;
        }

        .stat-value {
            font-size: 1.6rem;
        }

        .stat-label {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    @if(session('success'))
        <div style="background: linear-gradient(135deg, #d4edda 0%, #c8e6c9 100%); color: #155724; border: 2px solid #81c784; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 3px 12px rgba(76, 175, 80, 0.15);">
            <i class="fas fa-check-circle" style="font-size: 1.3rem;"></i>
            <span style="font-weight: 600; font-size: 0.95rem;">{{ session('success') }}</span>
        </div>
    @endif

    <div class="profile-grid">
        <!-- Sidebar - Profile Card -->
        <aside class="profile-sidebar">
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar">
                    <img src="{{ auth()->user()->foto ? asset('images/profiles/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_lengkap) . '&background=047857&color=fff&size=68' }}" alt="{{ auth()->user()->nama_lengkap }}">
                </div>
            </div>
            
            <div class="profile-name">
                <h2>{{ auth()->user()->nama_lengkap }}</h2>
                <span class="profile-username">@oloan{{ auth()->user()->username ?? 'user' }}</span>
            </div>

            <div class="profile-details">
                <div class="detail-row">
                    <span class="detail-icon"><i class="fas fa-envelope"></i></span>
                    <span>{{ auth()->user()->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-icon"><i class="fas fa-phone"></i></span>
                    <span>{{ auth()->user()->no_telp }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>{{ auth()->user()->alamat }}{{ auth()->user()->kabupaten ? ', ' . auth()->user()->kabupaten : '' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span>Sejak {{ auth()->user()->created_at->format('F Y') }}</span>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('profil.edit') }}" class="btn btn-edit-profile">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-logout" style="width: 100%;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>

            <!-- Land Information -->
            <div class="land-info-card">
                <h3><i class="fas fa-seedling"></i> Informasi Lahan</h3>
                <div class="land-detail">
                    <div class="land-label">Luas Lahan</div>
                    <div class="land-value">3 Ha</div>
                </div>
                <div class="land-detail">
                    <div class="land-label">Komoditas</div>
                    <div class="commodity-list">
                        <span class="commodity-tag commodity-padi">Padi</span>
                        <span class="commodity-tag commodity-jagung">Jagung</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="profile-main-content">
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
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-value">{{ number_format($pupukDiterima, 0) }} Kg</div>
                    <div class="stat-label">Pupuk Diterima</div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="stat-value">{{ number_format($bibitDiterima, 0) }} Kg</div>
                    <div class="stat-label">Bibit Diterima</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-icon">
                        <i class="fas fa-piggy-bank"></i>
                    </div>
                    <div class="stat-value">Rp {{ number_format($totalPenghematan / 1000, 1) }}Jt</div>
                    <div class="stat-label">Penghematan</div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="orders-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-history"></i> Riwayat Pesanan
                    </h3>
                </div>

                @if($orders->count() > 0)
                    <div class="orders-table-wrapper">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kode Order</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="order-product">
                                            @php
                                                $tipeProduk = $order->product ? $order->product->tipe_produk : 'pupuk';
                                                $namaProduk = $order->product ? $order->product->nama_produk : ($order->customer_name ? 'Pesanan ' . $order->customer_name : 'Pesanan #' . $order->order_number);
                                            @endphp
                                            <div class="product-icon-small {{ $tipeProduk }}">
                                                <i class="fas fa-{{ $tipeProduk === 'pupuk' ? 'box' : 'seedling' }}"></i>
                                            </div>
                                            <div class="product-details">
                                                <h4>{{ $namaProduk }}</h4>
                                                <p>{{ ucfirst($tipeProduk) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="order-id">{{ $order->order_number }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>{{ $order->quantity }} Kg</td>
                                    <td>
                                        <span class="order-price">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'Completed' => 'completed',
                                                'Ready for Pickup' => 'ready',
                                                'Processing' => 'processing',
                                                'Pending' => 'pending',
                                                'Rejected' => 'rejected',
                                                default => 'pending'
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ $order->status }}</span>
                                    </td>
                                    <td>
                                        <button class="btn-detail" onclick="showOrderDetail({{ $order->id }})">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Anda belum memiliki riwayat pesanan</p>
                        <a href="{{ route('pupuk.bibit') }}" class="btn-browse">
                            <i class="fas fa-shopping-cart"></i> Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div class="modal-overlay" id="orderDetailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-receipt"></i> Detail Pesanan</h3>
            <button class="modal-close" onclick="closeOrderDetail()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="orderDetailContent">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Data pesanan untuk JavaScript
    const ordersData = @json($orders);

    function showOrderDetail(orderId) {
        const order = ordersData.find(o => o.id === orderId);
        if (!order) {
            alert('Pesanan tidak ditemukan');
            return;
        }

        const product = order.product || {};
        const tipeProduk = product.tipe_produk || 'pupuk';
        const namaProduk = product.nama_produk || (order.customer_name ? 'Pesanan ' + order.customer_name : 'Pesanan #' + order.order_number);
        
        // Status class
        let statusClass = 'pending';
        let statusText = order.status;
        if (order.status === 'Completed') {
            statusClass = 'completed';
            statusText = 'Selesai';
        } else if (order.status === 'Ready for Pickup') {
            statusClass = 'ready';
            statusText = 'Siap Diambil';
        } else if (order.status === 'Processing') {
            statusClass = 'processing';
            statusText = 'Diproses';
        } else if (order.status === 'Rejected') {
            statusClass = 'rejected';
            statusText = 'Ditolak';
        } else if (order.status === 'Pending') {
            statusText = 'Menunggu';
        }

        // Format tanggal
        const orderDate = new Date(order.created_at);
        const formattedDate = orderDate.toLocaleDateString('id-ID', { 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        });

        // Calculate savings
        const savings = order.discount_amount || 0;
        const savingsPercent = order.subtotal > 0 ? ((savings / order.subtotal) * 100).toFixed(0) : 0;

        const content = `
            <div class="product-info-modal">
                <div class="product-image-modal">
                    <i class="fas fa-${tipeProduk === 'pupuk' ? 'box' : 'seedling'}"></i>
                </div>
                <div class="product-info-text">
                    <h4>${namaProduk}</h4>
                    <p>${tipeProduk.charAt(0).toUpperCase() + tipeProduk.slice(1)} • Kode: ${order.order_number}</p>
                    <span class="status-badge ${statusClass}" style="margin-top: 0.5rem;">${statusText}</span>
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-info-circle"></i> Informasi Pesanan
                </div>
                <div class="detail-grid">
                    <div class="detail-item-modal">
                        <div class="detail-label-modal">Tanggal Pesan</div>
                        <div class="detail-value-modal">${formattedDate}</div>
                    </div>
                    <div class="detail-item-modal">
                        <div class="detail-label-modal">Jumlah</div>
                        <div class="detail-value-modal">${order.quantity} Kg</div>
                    </div>
                    <div class="detail-item-modal">
                        <div class="detail-label-modal">Harga Satuan</div>
                        <div class="detail-value-modal">Rp ${Number(order.unit_price || 0).toLocaleString('id-ID')}</div>
                    </div>
                    <div class="detail-item-modal">
                        <div class="detail-label-modal">Status</div>
                        <div class="detail-value-modal">${statusText}</div>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-user"></i> Informasi Penerima
                </div>
                <div class="detail-grid">
                    <div class="detail-item-modal">
                        <div class="detail-label-modal">Nama</div>
                        <div class="detail-value-modal">${order.customer_name || '-'}</div>
                    </div>
                    <div class="detail-item-modal">
                        <div class="detail-label-modal">No. Telepon</div>
                        <div class="detail-value-modal">${order.customer_phone || '-'}</div>
                    </div>
                    <div class="detail-item-modal" style="grid-column: 1 / -1;">
                        <div class="detail-label-modal">Alamat</div>
                        <div class="detail-value-modal">${order.customer_address || '-'}</div>
                    </div>
                    <div class="detail-item-modal" style="grid-column: 1 / -1;">
                        <div class="detail-label-modal">Balai Desa</div>
                        <div class="detail-value-modal">${order.village_office || '-'}</div>
                    </div>
                    ${order.customer_notes ? `
                    <div class="detail-item-modal" style="grid-column: 1 / -1;">
                        <div class="detail-label-modal">Catatan</div>
                        <div class="detail-value-modal">${order.customer_notes}</div>
                    </div>
                    ` : ''}
                </div>
            </div>

            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-calculator"></i> Rincian Harga
                </div>
                <div class="price-breakdown">
                    <div class="price-row">
                        <span>Subtotal (${order.quantity} Kg × Rp ${Number(order.unit_price || 0).toLocaleString('id-ID')})</span>
                        <strong>Rp ${Number(order.subtotal || 0).toLocaleString('id-ID')}</strong>
                    </div>
                    ${savings > 0 ? `
                    <div class="price-row" style="color: #4caf50;">
                        <span>Diskon Subsidi (${savingsPercent}%)</span>
                        <strong>- Rp ${Number(savings).toLocaleString('id-ID')}</strong>
                    </div>
                    ` : ''}
                    <div class="price-row total">
                        <span>Total Pembayaran</span>
                        <span>Rp ${Number(order.total_amount || 0).toLocaleString('id-ID')}
                            ${savings > 0 ? `<span class="savings-badge">Hemat Rp ${Number(savings).toLocaleString('id-ID')}</span>` : ''}
                        </span>
                    </div>
                </div>
            </div>

            ${order.admin_notes ? `
            <div class="detail-section">
                <div class="detail-section-title">
                    <i class="fas fa-comment"></i> Catatan Admin
                </div>
                <div class="detail-item-modal">
                    <div class="detail-value-modal">${order.admin_notes}</div>
                </div>
            </div>
            ` : ''}

            ${order.rejection_reason ? `
            <div class="detail-section">
                <div class="detail-section-title" style="color: #d32f2f;">
                    <i class="fas fa-exclamation-circle"></i> Alasan Penolakan
                </div>
                <div class="detail-item-modal" style="background: #ffebee; border-color: #ffcdd2;">
                    <div class="detail-value-modal" style="color: #d32f2f;">${order.rejection_reason}</div>
                </div>
            </div>
            ` : ''}
        `;

        document.getElementById('orderDetailContent').innerHTML = content;
        document.getElementById('orderDetailModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeOrderDetail() {
        document.getElementById('orderDetailModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('orderDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrderDetail();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeOrderDetail();
        }
    });
</script>
@endpush

@endsection
