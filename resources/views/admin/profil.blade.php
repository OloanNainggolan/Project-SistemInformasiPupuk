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
        max-width: 900px;
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

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    /* Profile Grid */
    .profile-grid {
        display: grid;
        gap: 24px;
    }

    /* Profile Card */
    .profile-card {
        background: white;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .profile-avatar-large {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .profile-name {
        font-size: 24px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 6px;
    }

    .profile-username {
        font-size: 14px;
        color: #9ca3af;
        margin-bottom: 12px;
    }

    .profile-badge {
        display: inline-block;
        background: var(--green);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        justify-content: center;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--green);
        color: white;
    }

    .btn-primary:hover {
        background: var(--green-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(5, 150, 105, 0.2);
    }

    .btn-outline {
        background: white;
        color: var(--green);
        border: 2px solid var(--green);
    }

    .btn-outline:hover {
        background: var(--mint);
        border-color: var(--green-dark);
        color: var(--green-dark);
    }

    /* Info Card */
    .info-card {
        background: white;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .info-card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--mint);
    }

    .info-card-title i {
        color: var(--green);
        font-size: 20px;
    }

    .info-grid {
        display: grid;
        gap: 16px;
    }

    .info-item {
        display: grid;
        grid-template-columns: 160px 1fr;
        gap: 16px;
        padding: 14px;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 3px solid var(--green);
    }

    .info-label {
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: var(--green);
        width: 18px;
        font-size: 14px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        display: flex;
        align-items: center;
    }

    /* Activity Card */
    .activity-card {
        background: white;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-top: 24px;
        border: 1px solid #e5e7eb;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 10px;
        border-left: 3px solid var(--green-light);
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: var(--mint);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .activity-icon i {
        color: var(--green);
        font-size: 16px;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .activity-time {
        font-size: 12px;
        color: #9ca3af;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-page {
            padding: 16px;
        }

        .page-title {
            font-size: 24px;
        }

        .page-title i {
            font-size: 24px;
        }

        .profile-card {
            padding: 24px;
        }

        .profile-avatar-large {
            width: 100px;
            height: 100px;
            font-size: 40px;
        }

        .profile-name {
            font-size: 20px;
        }

        .profile-actions {
            flex-direction: column;
        }

        .info-card, .activity-card {
            padding: 20px;
        }

        .info-item {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .info-label {
            font-size: 12px;
        }

        .info-value {
            font-size: 13px;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-page">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-circle"></i>
            Profil Administrator
        </h1>
        <p class="page-subtitle">Kelola informasi akun administrator</p>
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
            <p class="profile-username">@{{ session('admin_username', 'admin') }}</p>
            <span class="profile-badge">Super Administrator</span>

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
