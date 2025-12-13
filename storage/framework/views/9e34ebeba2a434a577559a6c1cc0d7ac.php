<?php $__env->startSection('title', 'Profil Admin - Pupuk & Bibit Subsidi'); ?>

<?php $__env->startPush('styles'); ?>
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
        padding: 30px 20px;
    }

    /* Page Header */
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        padding: 24px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        border-left: 4px solid var(--green);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--green-dark);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .page-title i {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--green), var(--green-light));
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-left: 48px;
    }

    /* Profile Grid */
    .profile-grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 24px;
    }

    /* Profile Card - Left Side */
    .profile-card {
        background: white;
        padding: 0;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #e5e7eb;
        height: fit-content;
        position: sticky;
        top: 90px;
    }

    .profile-cover {
        height: 120px;
        background: linear-gradient(135deg, #004d00 0%, #047857 50%, #10b981 100%);
        position: relative;
    }

    .profile-cover::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="none"/><path d="M10 50 Q 30 30, 50 50 T 90 50" stroke="rgba(255,255,255,0.1)" stroke-width="2" fill="none"/></svg>') repeat;
        opacity: 0.3;
    }

    .profile-main {
        padding: 0 30px 30px;
        text-align: center;
        margin-top: -50px;
        position: relative;
    }

    .profile-avatar-large {
        width: 110px;
        height: 110px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        border-radius: 50%;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 44px;
        color: white;
        box-shadow: 0 4px 16px rgba(5, 150, 105, 0.3);
        border: 5px solid white;
    }

    .profile-name-admin {
        font-size: 24px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 8px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
        line-height: 1.3;
        padding: 0 10px;
    }

    .profile-username {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .profile-email {
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        padding: 0 10px;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--green), var(--green-light));
        color: white;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.35);
    }

    .profile-badge i {
        font-size: 13px;
    }

    .profile-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .stat-box {
        text-align: center;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 11px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 24px;
    }

    .btn {
        padding: 12px 20px;
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
        background: linear-gradient(135deg, var(--green), var(--green-light));
        color: white;
        box-shadow: 0 2px 6px rgba(5, 150, 105, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.4);
    }

    .btn-outline {
        background: white;
        color: var(--green-dark);
        border: 2px solid #e5e7eb;
    }

    .btn-outline:hover {
        background: var(--mint);
        border-color: var(--green);
        color: var(--green-dark);
    }

    /* Info Card - Right Side */
    .info-card {
        background: white;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
        margin-bottom: 24px;
    }

    .info-card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--mint);
    }

    .info-card-title i {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--mint), #d1fae5);
        color: var(--green);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .info-grid {
        display: grid;
        gap: 14px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        padding: 16px;
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .info-item:hover {
        border-color: var(--green-light);
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.1);
        transform: translateX(4px);
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--mint), #d1fae5);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 14px;
    }

    .info-icon i {
        color: var(--green);
        font-size: 16px;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
    }

    /* Activity Card */
    .activity-card {
        background: white;
        padding: 28px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e5e7eb;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px;
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        border-radius: 8px;
        margin-bottom: 12px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-item:hover {
        border-color: var(--green-light);
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.1);
        transform: translateX(4px);
    }

    .activity-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, var(--mint), #d1fae5);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .activity-icon i {
        color: var(--green);
        font-size: 18px;
    }

    .activity-content {
        flex: 1;
        padding-top: 2px;
    }

    .activity-text {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .activity-time {
        font-size: 12px;
        color: #9ca3af;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .activity-time i {
        font-size: 11px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }

        .profile-card {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 768px) {
        .profile-page {
            padding: 20px 15px;
        }

        .page-header {
            padding: 20px;
        }

        .page-title {
            font-size: 22px;
        }

        .page-subtitle {
            margin-left: 48px;
            font-size: 13px;
        }

        .profile-main {
            padding: 0 20px 24px;
        }

        .profile-avatar-large {
            width: 90px;
            height: 90px;
            font-size: 36px;
        }

        .profile-name-admin {
            font-size: 20px;
        }

        .profile-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .stat-box {
            padding: 10px 6px;
        }

        .stat-value {
            font-size: 18px;
        }

        .stat-label {
            font-size: 10px;
        }

        .info-card, .activity-card {
            padding: 20px;
        }

        .info-item, .activity-item {
            padding: 14px;
        }

        .info-icon, .activity-icon {
            width: 38px;
            height: 38px;
        }

        .info-icon i, .activity-icon i {
            font-size: 15px;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="profile-page">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-shield"></i>
            Profil Administrator
        </h1>
        <p class="page-subtitle">Kelola informasi akun administrator Anda dengan mudah</p>
    </div>

    <!-- Profile Grid -->
    <div class="profile-grid">
        <!-- Left: Profile Card -->
        <div class="profile-card">
            <!-- Cover Background -->
            <div class="profile-cover"></div>
            
            <!-- Profile Main Info -->
            <div class="profile-main">
                <div class="profile-avatar-large">
                    <?php if(session('admin_avatar')): ?>
                        <img src="<?php echo e(asset(session('admin_avatar'))); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <i class="fas fa-user-shield"></i>
                    <?php endif; ?>
                </div>
                <h2 class="profile-name-admin"><?php echo e(session('admin_name', 'Administrator Sistem')); ?></h2>
                <p class="profile-username">
                    <i class="fas fa-at" style="font-size: 11px;"></i>
                    <span><?php echo e(session('admin_username', 'admin')); ?></span>
                </p>
                <p class="profile-email">
                    <i class="fas fa-envelope" style="font-size: 10px;"></i>
                    <span><?php echo e(session('admin_email', 'admin@pupuksubsidi.id')); ?></span>
                </p>
                <span class="profile-badge">
                    <i class="fas fa-shield-alt"></i>
                    Super Administrator
                </span>

                <!-- Statistics -->
                <div class="profile-stats">
                    <div class="stat-box">
                        <div class="stat-value"><?php echo e(\App\Models\Order::count()); ?></div>
                        <div class="stat-label">Pesanan</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo e(\App\Models\Product::count()); ?></div>
                        <div class="stat-label">Produk</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-value"><?php echo e(\App\Models\User::count()); ?></div>
                        <div class="stat-label">Petani</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="profile-actions">
                    <a href="<?php echo e(route('admin.profil.edit')); ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                        Edit Profil
                    </a>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Info & Activity -->
        <div>
            <!-- Info Card -->
            <div class="info-card">
                <h3 class="info-card-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Pribadi
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value"><?php echo e(session('admin_name', 'Administrator Sistem')); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?php echo e(session('admin_email', 'admin@pupuksubsidi.id')); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Telepon</div>
                            <div class="info-value"><?php echo e(session('admin_phone', '+62 812-3456-7890')); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Alamat</div>
                            <div class="info-value"><?php echo e(session('admin_address', 'Jl. Sitoluama, Laguboti, Toba Samosir')); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Bergabung Sejak</div>
                            <div class="info-value"><?php echo e(session('admin_login_time') ? \Carbon\Carbon::parse(session('admin_login_time'))->format('d F Y') : '01 Januari 2024'); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Level Akses</div>
                            <div class="info-value">Super Administrator - Full Access</div>
                        </div>
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
                        <div class="activity-time">
                            <i class="far fa-clock"></i>
                            <?php echo e(session('admin_login_time') ? \Carbon\Carbon::parse(session('admin_login_time'))->diffForHumans() : 'Hari ini'); ?>

                        </div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Mengelola produk pupuk dan bibit</div>
                        <div class="activity-time">
                            <i class="far fa-clock"></i>
                            2 jam yang lalu
                        </div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Memproses pesanan petani</div>
                        <div class="activity-time">
                            <i class="far fa-clock"></i>
                            5 jam yang lalu
                        </div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">Mengirim notifikasi ke petani</div>
                        <div class="activity-time">
                            <i class="far fa-clock"></i>
                            Kemarin
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/admin/profil.blade.php ENDPATH**/ ?>