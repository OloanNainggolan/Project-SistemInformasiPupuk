@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="profile-container">
    <!-- Simple Profile Header -->
    <div class="profile-header-simple">
        <div class="header-background"></div>
        <div class="profile-content-wrapper">
            <div class="profile-info-card">
                <div class="avatar-wrapper">
                    <div class="avatar-image">
                        @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
                            <img src="{{ asset(Auth::user()->foto) }}" alt="Foto Profil">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <div class="verified-badge">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                
                <div class="info-section">
                    <h1 class="user-name">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</h1>
                    
                    <div class="user-details">
                        <div class="detail-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ Auth::user()->no_telp ?? 'Belum diisi' }}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Bergabung {{ Auth::user()->created_at->locale('id')->translatedFormat('F Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="action-section">
                    <a href="{{ route('profil.edit') }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content-area">
        <!-- Statistics Overview -->
        <div class="stats-section">
            <h2 class="section-title">
                <i class="fas fa-chart-line"></i> Statistik Anda
            </h2>
            <div class="stats-grid-modern">
                <div class="stat-card-modern purple-gradient">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">24</div>
                        <div class="stat-label">Total Pesanan</div>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 85%"></div>
                    </div>
                </div>

                <div class="stat-card-modern blue-gradient">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">2,8 Ton</div>
                        <div class="stat-label">Pupuk Diterima</div>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                </div>

                <div class="stat-card-modern orange-gradient">
                    <div class="stat-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">125 Kg</div>
                        <div class="stat-label">Bibit Diterima</div>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 60%"></div>
                    </div>
                </div>

                <div class="stat-card-modern green-gradient">
                    <div class="stat-icon">
                        <i class="fas fa-piggy-bank"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">2.4 Jt</div>
                        <div class="stat-label">Total Penghematan</div>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: 90%"></div>
                    </div>
                </div>
            </div>
        </div>

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

            <div class="orders-grid">
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id-badge">ORD-2025-001</div>
                        <div class="order-status success">
                            <i class="fas fa-check-circle"></i> Success
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="product-info">
                            <div class="product-icon pupuk">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <h4>Pupuk Urea Bersubsidi</h4>
                                <p>50 Kg • Subsidi Pemerintah</p>
                            </div>
                        </div>
                        <div class="order-details">
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>24 Januari 2025</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="price">Rp 85.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id-badge">ORD-2025-002</div>
                        <div class="order-status success">
                            <i class="fas fa-check-circle"></i> Success
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="product-info">
                            <div class="product-icon pupuk">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <h4>Pupuk NPK Phonska</h4>
                                <p>50 Kg • Subsidi Pemerintah</p>
                            </div>
                        </div>
                        <div class="order-details">
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>26 Januari 2025</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="price">Rp 95.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id-badge">ORD-2025-003</div>
                        <div class="order-status success">
                            <i class="fas fa-check-circle"></i> Success
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="product-info">
                            <div class="product-icon bibit">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <div>
                                <h4>Bibit Padi Unggul IR64</h4>
                                <p>10 Kg • Kualitas Premium</p>
                            </div>
                        </div>
                        <div class="order-details">
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>15 Maret 2025</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="price">Rp 35.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        text-align: center;
        padding: 30px 25px;
        gap: 25px;
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

    .user-details {
        align-items: center;
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
@endsection
