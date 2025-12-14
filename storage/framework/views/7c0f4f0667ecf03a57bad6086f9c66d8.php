<?php $__env->startSection('title', 'Notifikasi Masuk - Admin'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .inbox-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fffe 100%);
        border-radius: 20px;
        padding: 35px;
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(0, 137, 123, 0.08);
        border: 1px solid rgba(0, 137, 123, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left h1 {
        font-size: 32px;
        font-weight: 800;
        color: #065f46;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-left h1 i {
        color: #00897b;
        background: rgba(0, 137, 123, 0.1);
        padding: 12px;
        border-radius: 12px;
    }

    .header-left p {
        color: #64748b;
        font-size: 15px;
    }

    .header-stats {
        display: flex;
        gap: 15px;
    }

    .stat-badge {
        padding: 10px 20px;
        background: #f1f5f9;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        color: #475569;
    }

    .stat-badge.unread {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .btn-mark-all {
        padding: 10px 20px;
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-mark-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 137, 123, 0.3);
    }

    .filter-tabs {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #00897b;
        box-shadow: 0 0 0 3px rgba(0, 137, 123, 0.1);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%2364748b' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 40px;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        color: #475569;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
    }

    .messages-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .message-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        display: flex;
        gap: 15px;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .message-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .message-card.unread {
        border-color: #00897b;
        background: rgba(0, 137, 123, 0.02);
    }

    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
    }

    .avatar.order {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .avatar.contact {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .avatar.new_user {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .message-content {
        flex: 1;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 8px;
    }

    .sender-name {
        font-weight: 700;
        font-size: 16px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .unread-dot {
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
    }

    .message-time {
        font-size: 13px;
        color: #94a3b8;
    }

    .message-type {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .type-message {
        background: #dbeafe;
        color: #1e40af;
    }

    .type-contact {
        background: #e0e7ff;
        color: #4338ca;
    }

    .type-order {
        background: #fef3c7;
        color: #92400e;
    }

    .type-new_user {
        background: #ede9fe;
        color: #6b21a8;
    }

    .message-text {
        color: #475569;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .order-number {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: #f1f5f9;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        color: #475569;
    }

    .empty-state {
        background: white;
        border-radius: 16px;
        padding: 60px 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 14px;
    }

    .pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="inbox-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1><i class="fas fa-inbox"></i> Notifikasi Masuk</h1>
            <p>Semua notifikasi: Pesan, Kontak, Pesanan, dan User Baru</p>
        </div>
        <div class="header-stats">
            <div class="stat-badge"><?php echo e($totalCount); ?> Total</div>
            <div class="stat-badge unread"><?php echo e($unreadCount); ?> Belum Dibaca</div>
            <?php if($unreadCount > 0): ?>
                <form action="<?php echo e(route('admin.notifications.markAllRead')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-mark-all">
                        <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-tabs">
        <form method="GET" action="<?php echo e(route('admin.notifications.inbox')); ?>" id="filterForm">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 15px; align-items: end;">
                <!-- Sort By -->
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                        <i class="fas fa-sort"></i> Urutkan
                    </label>
                    <select name="sort" class="form-control form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="latest" <?php echo e($sortBy == 'latest' ? 'selected' : ''); ?>>Terbaru</option>
                        <option value="oldest" <?php echo e($sortBy == 'oldest' ? 'selected' : ''); ?>>Terlama</option>
                        <option value="name_asc" <?php echo e($sortBy == 'name_asc' ? 'selected' : ''); ?>>Nama A-Z</option>
                        <option value="name_desc" <?php echo e($sortBy == 'name_desc' ? 'selected' : ''); ?>>Nama Z-A</option>
                    </select>
                </div>
                
                <!-- Date From -->
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                        <i class="fas fa-calendar"></i> Dari Tanggal
                    </label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo e($dateFrom); ?>" 
                           onchange="document.getElementById('filterForm').submit()">
                </div>
                
                <!-- Date To -->
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">
                        <i class="fas fa-calendar"></i> Sampai Tanggal
                    </label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo e($dateTo); ?>" 
                           onchange="document.getElementById('filterForm').submit()">
                </div>
                
                <!-- Reset Button -->
                <div>
                    <a href="<?php echo e(route('admin.notifications.inbox')); ?>" class="btn-reset">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Messages List -->
    <?php if($notifications->count() > 0): ?>
        <div class="messages-list">
            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="message-card <?php echo e($notif['status'] == 'unread' ? 'unread' : ''); ?>" 
                     data-notif-id="<?php echo e($notif['id']); ?>"
                     data-notif-type="<?php echo e($notif['type']); ?>"
                     onclick="openNotification('<?php echo e($notif['id']); ?>', '<?php echo e($notif['type']); ?>', '<?php echo e($notif['link']); ?>')">
                    
                    <!-- Avatar -->
                    <div class="avatar <?php echo e($notif['type']); ?>">
                        <?php if($notif['type'] == 'message'): ?>
                            <?php echo e(strtoupper(substr($notif['sender_name'], 0, 1))); ?>

                        <?php elseif($notif['type'] == 'contact'): ?>
                            <i class="fas fa-address-book"></i>
                        <?php elseif($notif['type'] == 'order'): ?>
                            <i class="fas fa-shopping-cart"></i>
                        <?php else: ?>
                            <i class="fas fa-user-plus"></i>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="message-content">
                        <div class="message-header">
                            <div class="sender-name notification-sender">
                                <?php if($notif['status'] == 'unread'): ?>
                                    <span class="unread-dot"></span>
                                <?php endif; ?>
                                <?php echo e($notif['sender_name']); ?>

                            </div>
                            <span class="message-time"><?php echo e($notif['time']); ?></span>
                        </div>

                        <span class="message-type type-<?php echo e($notif['type']); ?>">
                            <?php if($notif['type'] == 'message'): ?>
                                <i class="fas fa-envelope"></i> Pesan
                            <?php elseif($notif['type'] == 'contact'): ?>
                                <i class="fas fa-address-book"></i> Kontak
                            <?php elseif($notif['type'] == 'order'): ?>
                                <i class="fas fa-shopping-cart"></i> Pesanan
                            <?php else: ?>
                                <i class="fas fa-user-plus"></i> User Baru
                            <?php endif; ?>
                        </span>

                        <div class="message-text notification-message">
                            <?php echo e(Str::limit($notif['content'], 150)); ?>

                        </div>

                        <?php if($notif['type'] == 'order' && !empty($notif['order_number'])): ?>
                            <div class="order-number">
                                <i class="fas fa-hashtag"></i>
                                <?php echo e($notif['order_number']); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php echo e($notifications->links()); ?>

        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Tidak Ada Pesan</h3>
            <p>Belum ada pesan atau notifikasi dari pengguna</p>
        </div>
    <?php endif; ?>
</div>

<script>
    // Open notification
    function openNotification(id, type, link) {
        // Mark as read - handle both numeric IDs and composite IDs (contact_1, order_1, user_1)
        const numericId = id.toString().replace(/^(contact_|order_|user_)/, '');
        
        if (type === 'message') {
            fetch(`/admin/notifications/${numericId}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
        } else if (type === 'contact') {
            fetch(`/admin/notifications/contact/${numericId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            });
        }

        // Redirect to link (skip for new_user type without proper link)
        if (link && link !== '#') {
            window.location.href = link;
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/admin/notifications/inbox.blade.php ENDPATH**/ ?>