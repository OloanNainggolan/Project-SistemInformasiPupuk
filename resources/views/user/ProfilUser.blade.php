@extends('layouts.user')

@section('title', 'Profil Saya')

@push('styles')
<style>
    /* Main Container */
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2.5rem;
        margin-top: 170px;
        margin-bottom: 4rem;
    }

    .dashboard-content {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 3rem;
    }

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 24px;
        padding: 3rem 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        height: fit-content;
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 50%, #4CAF50 100%);
    }

    .profile-card .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        margin: 0 auto 2rem;
        overflow: hidden;
        border: 5px solid #4caf50;
        box-shadow: 0 8px 24px rgba(76, 175, 80, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .profile-card .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-card .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-name h2 {
        font-size: 1.6rem;
        color: #1b5e20;
        margin-bottom: 0.8rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .profile-name p {
        color: #666;
        font-size: 0.95rem;
        background: #f5f5f5;
        padding: 0.5rem 1.4rem;
        border-radius: 25px;
        display: inline-block;
        font-weight: 600;
        border: 1px solid #e0e0e0;
    }

    .profile-info {
        margin: 2.5rem 0;
        padding: 2rem 0;
        border-top: 1px solid #e8e8e8;
        border-bottom: 1px solid #e8e8e8;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
        color: #555;
        font-size: 0.98rem;
        line-height: 1.5;
        padding: 0.4rem 0;
        transition: all 0.2s ease;
    }

    .info-item:hover {
        color: #2e7d32;
    }

    .info-item:hover .info-icon {
        background: #e8f5e9;
        transform: scale(1.08);
    }

        <!-- Recent Orders -->
        <div class="orders-section-modern">
            <div class="section-header">
                <div class="title-wrapper">
                    <h2 class="section-title">
                        <i class="fas fa-history"></i> Riwayat Pesanan
                    </h2>
                    <p class="section-subtitle">Daftar pesanan pupuk dan bibit Anda</p>
                </div>
                <a href="#" class="view-all-link">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>

    .info-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        background: #f8f8f8;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #4caf50;
        transition: all 0.2s ease;
    }

<style>
/* Container */
.profile-container {
    min-height: 100vh;
    background: #f5f7fa;
}

/* Simple Header */
.profile-header-simple {
    position: relative;
    margin-bottom: 30px;
}

.header-background {
    height: 200px;
    background: linear-gradient(135deg, #1a5f3a 0%, #2d7a4f 50%, #00897b 100%);
    position: relative;
}

.profile-content-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
    position: relative;
    top: -80px;
}

.profile-info-card {
    background: white;
    border-radius: 16px;
    padding: 35px 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    gap: 35px;
    align-items: center;
}

/* Avatar */
.avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.avatar-image {
    width: 140px;
    height: 140px;
    border-radius: 16px;
    background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
    border: 4px solid white;
}

.avatar-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-image i {
    font-size: 60px;
    color: #00897b;
}

.verified-badge {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 38px;
    height: 38px;
    background: #4CAF50;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid white;
    box-shadow: 0 3px 10px rgba(76, 175, 80, 0.4);
}

.verified-badge i {
    color: white;
    font-size: 17px;
}

/* Info Section */
.info-section {
    flex: 1;
}

.user-name {
    font-size: 1.8em;
    font-weight: 800;
    color: #1a5f3a;
    margin-bottom: 20px;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #666;
    font-size: 0.95em;
}

.detail-item i {
    color: #00897b;
    font-size: 1.1em;
    width: 18px;
}

/* Action Button */
.action-section {
    flex-shrink: 0;
}

.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 13px 28px;
    background: linear-gradient(135deg, #00897b, #00695c);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95em;
    box-shadow: 0 4px 15px rgba(0, 137, 123, 0.3);
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #00695c, #004d40);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 137, 123, 0.4);
}

/* Main Content */
.main-content-area {
    max-width: 1200px;
    margin: -50px auto 0;
    padding: 0 40px 50px;
}

/* Section Title */
.section-title {
    font-size: 1.8em;
    font-weight: 800;
    color: #1a5f3a;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
}

.section-title i {
    color: #00897b;
}

/* Statistics Cards */
.stats-section {
    margin-bottom: 50px;
}

.stats-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

.stat-card-modern {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    transition: height 0.3s ease;
}

.purple-gradient::before { background: linear-gradient(90deg, #7e57c2, #9575cd); }
.blue-gradient::before { background: linear-gradient(90deg, #42a5f5, #64b5f6); }
.orange-gradient::before { background: linear-gradient(90deg, #ff9800, #ffb74d); }
.green-gradient::before { background: linear-gradient(90deg, #4CAF50, #66bb6a); }

.stat-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
}

.stat-card-modern:hover::before {
    height: 100%;
    opacity: 0.1;
}

.stat-icon {
    width: 65px;
    height: 65px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2em;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}

.purple-gradient .stat-icon {
    background: linear-gradient(135deg, #7e57c2, #9575cd);
    color: white;
    box-shadow: 0 6px 20px rgba(126, 87, 194, 0.3);
}

.blue-gradient .stat-icon {
    background: linear-gradient(135deg, #42a5f5, #64b5f6);
    color: white;
    box-shadow: 0 6px 20px rgba(66, 165, 245, 0.3);
}

.orange-gradient .stat-icon {
    background: linear-gradient(135deg, #ff9800, #ffb74d);
    color: white;
    box-shadow: 0 6px 20px rgba(255, 152, 0, 0.3);
}

.green-gradient .stat-icon {
    background: linear-gradient(135deg, #4CAF50, #66bb6a);
    color: white;
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.3);
}

.stat-number {
    font-size: 2.5em;
    font-weight: 800;
    color: #1a5f3a;
    line-height: 1;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 1em;
    color: #666;
    font-weight: 600;
}

.stat-progress {
    height: 6px;
    background: #f0f0f0;
    border-radius: 10px;
    margin-top: 15px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #00897b, #4CAF50);
    border-radius: 10px;
    transition: width 1s ease;
}

/* Orders Section */
.orders-section-modern {
    background: white;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.section-subtitle {
    color: #666;
    font-size: 0.95em;
    margin-top: 5px;
}

.view-all-link {
    color: #00897b;
    text-decoration: none;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.view-all-link:hover {
    color: #00695c;
    gap: 12px;
}

/* Orders Grid */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
}

.order-card {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 25px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.order-card:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: #00897b;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.order-id-badge {
    padding: 8px 16px;
    background: white;
    color: #00897b;
    border-radius: 20px;
    font-weight: 700;
    font-size: 0.85em;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.order-status {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85em;
    font-weight: 600;
}

.order-status.completed {
    background: #c8e6c9;
    color: #2e7d32;
}

.order-status.ready-for-pickup {
    background: #b3e5fc;
    color: #0277bd;
}

.order-status.processing {
    background: #fff9c4;
    color: #f57f17;
}

.order-status.pending {
    background: #ffecb3;
    color: #ff6f00;
}

.order-status.rejected {
    background: #ffcdd2;
    color: #c62828;
}

.order-status.success {
    background: #c8e6c9;
    color: #2e7d32;
}

.product-info {
    display: flex;
    gap: 15px;
    align-items: flex-start;
    margin-bottom: 20px;
}

.product-icon {
    width: 55px;
    height: 55px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5em;
    color: white;
    flex-shrink: 0;
}

.product-icon.pupuk {
    background: linear-gradient(135deg, #4CAF50, #66bb6a);
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.product-icon.bibit {
    background: linear-gradient(135deg, #42a5f5, #64b5f6);
    box-shadow: 0 4px 15px rgba(66, 165, 245, 0.3);
}

.product-info h4 {
    font-size: 1.1em;
    color: #1a5f3a;
    margin-bottom: 5px;
    font-weight: 700;
}

.product-info p {
    font-size: 0.9em;
    color: #666;
}

.order-details {
    display: flex;
    justify-content: space-between;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9em;
    color: #666;
}

.detail-item i {
    color: #00897b;
}

.detail-item.savings {
    width: 100%;
    justify-content: flex-end;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px dashed #e0e0e0;
}

.savings-text {
    color: #10b981;
    font-weight: 600;
}

/* Empty State */
.empty-orders {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.empty-orders i {
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-orders p {
    font-size: 16px;
    color: #6b7280;
    margin-bottom: 24px;
}

.btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

.btn-browse:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
}

.price {
    font-weight: 700;
    color: #1a5f3a;
    font-size: 1.1em;
}

/* Responsive */
@media (max-width: 768px) {
    .profile-content-wrapper,
    .main-content-area {
        padding: 0 20px;
    }

    .header-background {
        height: 160px;
    }

    .profile-content-wrapper {
        top: -60px;
    }

    .profile-info-card {
        flex-direction: column;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 1.1rem 1.5rem;
        border: none;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        letter-spacing: 0.2px;
    }

    .btn-edit {
        background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(76, 175, 80, 0.2);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(76, 175, 80, 0.35);
    }

    .btn-logout {
        background: linear-gradient(135deg, #f44336 0%, #e53935 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(244, 67, 54, 0.2);
    }

    .btn-logout:hover {
        background: linear-gradient(135deg, #e53935 0%, #d32f2f 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(244, 67, 54, 0.35);
    }

    /* Land Info Section */
    .land-info {
        background: white;
        border-radius: 24px;
        padding: 3rem 2.5rem;
        margin-top: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }

    .land-info::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(135deg, #66BB6A 0%, #4CAF50 50%, #2e7d32 100%);
    }

    .land-info h3 {
        font-size: 1.3rem;
        color: #1b5e20;
        margin-bottom: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        letter-spacing: -0.3px;
    }

    .land-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .land-item {
        background: #fafafa;
        padding: 1.8rem 1.5rem;
        border-radius: 16px;
        border: 1px solid #e8e8e8;
        transition: all 0.3s ease;
    }

    .land-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border-color: #4caf50;
        background: white;
    }

    .land-label {
        font-size: 0.88rem;
        color: #777;
        margin-bottom: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .land-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1b5e20;
    }

    .commodity-tags {
        display: flex;
        gap: 0.9rem;
        margin-top: 1.2rem;
        flex-wrap: wrap;
    }

    .tag {
        padding: 0.65rem 1.4rem;
        border-radius: 25px;
        font-size: 0.92rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: default;
    }

    .tag:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
    }

    .tag-padi {
        background: #fff3e0;
        color: #e65100;
        border: 1.5px solid #ffcc80;
    }

    .tag-jagung {
        background: #fff9c4;
        color: #f57f17;
        border: 1.5px solid #fff176;
    }

    /* Stats Section */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        text-align: center;
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
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .stat-card.purple {
        background: linear-gradient(135deg, #5e35b1, #7e57c2);
        color: white;
    }

    .stat-card.blue {
        background: linear-gradient(135deg, #1e88e5, #42a5f5);
        color: white;
    }

    .avatar-image {
        width: 120px;
        height: 120px;
    }

    .avatar-image i {
        font-size: 50px;
    }

    .user-name {
        font-size: 1.5em;
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.95;
        font-weight: 500;
    }

    /* Orders Table */
    .orders-section {
        background: white;
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
    }

    .orders-section h3 {
        font-size: 1.4rem;
        color: #1b5e20;
        margin-bottom: 2rem;
        font-weight: 700;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .action-section {
        width: 100%;
    }

    .btn-edit {
        width: 100%;
        justify-content: center;
    }

    .stats-grid-modern {
        grid-template-columns: 1fr;
    }

    .orders-grid {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
}

@media (max-width: 480px) {
    .avatar-image {
        width: 100px;
        height: 100px;
    }

    .avatar-image i {
        font-size: 45px;
    }

    .user-name {
        font-size: 1.3em;
    }

    .detail-item {
        font-size: 0.9em;
    }
}
</style>
@endpush

@section('content')
<div class="container">
    @if(session('success'))
        <div style="background: linear-gradient(135deg, #d4edda 0%, #c8e6c9 100%); color: #155724; border: 2px solid #81c784; padding: 1.2rem 1.8rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.15);">
            <i class="fas fa-check-circle" style="font-size: 1.4rem;"></i>
            <span style="font-weight: 600; font-size: 0.98rem;">{{ session('success') }}</span>
        </div>
    @endif

    <div class="dashboard-content">
        <!-- Left Sidebar - Profile Card -->
        <aside>
            <div class="profile-card">
                <div class="profile-avatar">
                    <img src="{{ auth()->user()->foto ? asset('images/profiles/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_lengkap) . '&background=4caf50&color=fff&size=200' }}" alt="Profile">
                </div>
                <div class="profile-name">
                    <h2>{{ auth()->user()->nama_lengkap }}</h2>
                    <p>{{ auth()->user()->username ?? 'User' }}</p>
                </div>
                <div class="profile-info">
                    <div class="info-item">
                        <span class="info-icon"><i class="fas fa-envelope"></i></span>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fas fa-phone"></i></span>
                        <span>{{ auth()->user()->no_telp }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <span>{{ auth()->user()->alamat }}{{ auth()->user()->kabupaten ? ', ' . auth()->user()->kabupaten : '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fas fa-calendar-alt"></i></span>
                        <span>Bergabung Sejak {{ auth()->user()->created_at->format('F Y') }}</span>
                    </div>
                </div>
                <div class="profile-actions">
                    <a href="{{ route('profil.edit') }}" class="btn btn-edit" style="text-decoration: none; text-align: center;"><i class="fas fa-edit"></i> Edit Profil</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-logout" style="width: 100%;"><i class="fas fa-sign-out-alt"></i> Keluar</button>
                    </form>
                </div>
            </div>

            <!-- Land Info -->
            <div class="land-info">
                <h3>Informasi Lahan</h3>
                <div class="land-details">
                    <div class="land-item">
                        <div class="land-label">Luas Lahan</div>
                        <div class="land-value">3 Ha</div>
                    </div>
                </div>
                <div class="land-label" style="margin-top: 1.5rem;">Komoditas</div>
                <div class="commodity-tags">
                    <span class="tag tag-padi">Padi</span>
                    <span class="tag tag-jagung">Jagung</span>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main>
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card purple">
                    <div class="stat-value">24</div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-value">2,8 Ton</div>
                    <div class="stat-label">Pupuk Diterima</div>
                </div>
                <div class="stat-card red">
                    <div class="stat-value">125 Kg</div>
                    <div class="stat-label">Bibit Diterima</div>
                </div>
                <div class="stat-card pink">
                    <div class="stat-value">2.4 Jt</div>
                    <div class="stat-label">Penghematan</div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="orders-section">
                <h3>Riwayat Pesanan</h3>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Pesanan</th>
                                <th>Tanggal Order</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-001</div>
                                    <div class="order-name">Pupuk Urea Bersubsidi</div>
                                </td>
                                <td>24 Januari 2025</td>
                                <td>Rp 85.000</td>
                                <td><span class="status-badge">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-002</div>
                                    <div class="order-name">Pupuk NPK Phonska</div>
                                </td>
                                <td>26 Januari 2025</td>
                                <td>Rp 95.000</td>
                                <td><span class="status-badge">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-003</div>
                                    <div class="order-name">Bibit Padi Unggul IR64</div>
                                </td>
                                <td>15 Maret 2025</td>
                                <td>Rp 35.000</td>
                                <td><span class="status-badge">Berhasil</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="page-arrow">←</button>
                    <button class="page-btn active">01</button>
                    <button class="page-btn">02</button>
                    <button class="page-btn">03</button>
                    <button class="page-arrow">→</button>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
