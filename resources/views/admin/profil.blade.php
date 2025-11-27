@extends('layouts.admin')

@section('title', 'Profil Admin - Pupuk & Bibit Subsidi')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
        --gold: #fbbf24;
    }

    .profile-page {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--green-dark);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .page-title i {
        color: var(--green);
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    /* Profile Grid */
    .profile-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    /* Profile Card */
    .profile-card {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        text-align: center;
        border: 1px solid rgba(5, 150, 105, 0.1);
    }

    .profile-avatar-large {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 65px;
        color: white;
        box-shadow: 0 8px 30px rgba(5, 150, 105, 0.3);
        position: relative;
    }

    .profile-avatar-large::after {
        content: '';
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, var(--gold) 0%, #f59e0b 100%);
        border-radius: 50%;
        border: 4px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-name {
        font-size: 24px;
        font-weight: 800;
        color: var(--green-dark);
        margin-bottom: 5px;
    }

    .profile-username {
        font-size: 15px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .profile-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--gold) 0%, #f59e0b 100%);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
    }

    .profile-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin: 25px 0;
    }

    .stat-item {
        background: var(--mint);
        padding: 15px;
        border-radius: 12px;
        border: 2px solid rgba(5, 150, 105, 0.1);
    }

    .stat-value {
        font-size: 24px;
        font-weight: 800;
        color: var(--green-dark);
        display: block;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        margin-top: 5px;
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 25px;
    }

    .btn {
        padding: 14px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
    }

    .btn-outline {
        background: white;
        color: var(--green-dark);
        border: 2px solid var(--green);
    }

    .btn-outline:hover {
        background: var(--mint);
        border-color: var(--green-dark);
    }

    /* Info Card */
    .info-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(5, 150, 105, 0.1);
    }

    .info-card-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--mint);
    }

    .info-card-title i {
        color: var(--green);
        font-size: 22px;
    }

    .info-grid {
        display: grid;
        gap: 20px;
    }

    .info-item {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 15px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 10px;
        border-left: 4px solid var(--green);
    }

    .info-label {
        font-size: 13px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: var(--green);
        width: 20px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
    }

    /* Activity Card */
    .activity-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-top: 30px;
        border: 1px solid rgba(5, 150, 105, 0.1);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 10px;
        margin-bottom: 12px;
        border-left: 4px solid var(--green);
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 3px;
    }

    .activity-time {
        font-size: 12px;
        color: #6b7280;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .info-item {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .page-title {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-page">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-shield"></i>
            Profil Administrator
        </h1>
        <p class="page-subtitle">Kelola informasi profil dan aktivitas admin</p>
    </div>

    <!-- Profile Grid -->
    <div class="profile-grid">
        <!-- Left: Profile Card -->
        <div class="profile-card">
            <div class="profile-avatar-large">
                @if(session('admin_avatar'))
                    <img src="{{ asset(session('admin_avatar')) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    <i class="fas fa-user-shield"></i>
                @endif
            </div>
            <h2 class="profile-name">{{ session('admin_name', 'Administrator') }}</h2>
            <span class="profile-badge">Super Administrator</span>

            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-value">{{ $totalPesanan ?? 0 }}</span>
                    <span class="stat-label">Pesanan</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $totalProduk ?? 0 }}</span>
                    <span class="stat-label">Produk</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">{{ $totalPetani ?? 0 }}</span>
                    <span class="stat-label">Petani</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">100%</span>
                    <span class="stat-label">Akses</span>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('admin.profil.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Profil
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Right: Info Card -->
        <div>
            <div class="info-card">
                <h3 class="info-card-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Pribadi
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-user"></i>
                            Nama Lengkap
                        </div>
                        <div class="info-value">{{ session('admin_name', 'Administrator Sistem') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </div>
                        <div class="info-value">{{ session('admin_email', 'admin@pupuksubsidi.id') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            Telepon
                        </div>
                        <div class="info-value">{{ session('admin_phone', '+62 812-3456-7890') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat
                        </div>
                        <div class="info-value">{{ session('admin_address', 'Jl. Sitoluama, Laguboti, Toba Samosir') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calendar-alt"></i>
                            Bergabung Sejak
                        </div>
                        <div class="info-value">{{ session('admin_login_time') ? \Carbon\Carbon::parse(session('admin_login_time'))->format('d F Y') : '01 Januari 2024' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-shield-alt"></i>
                            Role
                        </div>
                        <div class="info-value">Super Administrator</div>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="activity-card">
                <h3 class="info-card-title">
                    <i class="fas fa-history"></i>
                    Aktivitas Terakhir
                </h3>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Login ke sistem admin</div>
                        <div class="activity-time">{{ session('admin_login_time') ? \Carbon\Carbon::parse(session('admin_login_time'))->diffForHumans() : 'Hari ini' }}</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Mengelola produk pupuk dan bibit</div>
                        <div class="activity-time">2 jam yang lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Memproses pesanan petani</div>
                        <div class="activity-time">5 jam yang lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Mengirim notifikasi ke petani</div>
                        <div class="activity-time">Kemarin</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
