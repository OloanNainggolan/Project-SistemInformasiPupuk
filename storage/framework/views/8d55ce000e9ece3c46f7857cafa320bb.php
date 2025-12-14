<?php $__env->startSection('title', 'Detail Notifikasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="notification-detail-container">
    <!-- Back Button -->
    <div class="back-navigation">
        <a href="<?php echo e(route('notifikasi')); ?>" class="back-link" onclick="sessionStorage.setItem('notifJustRead', 'true');">
            <i class="fas fa-arrow-left"></i> Kembali ke Notifikasi
        </a>
    </div>

    <!-- Notification Content -->
    <div class="notification-detail-card">
        <!-- Header -->
        <div class="notification-header">
            <div class="sender-info">
                <div class="sender-avatar admin">
                    A
                </div>
                <div class="sender-details">
                    <div class="sender-name">
                        Admin
                        <span class="badge-system">SISTEM</span>
                    </div>
                    <div class="notification-date">
                        <i class="fas fa-clock"></i>
                        <?php echo e($notification->created_at->format('d M Y, H:i')); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Type Badge -->
        <div class="notification-type-badge <?php echo e($notification->type); ?>">
            <?php if($notification->type === 'info'): ?>
                <i class="fas fa-info-circle"></i> Informasi
            <?php elseif($notification->type === 'success'): ?>
                <i class="fas fa-check-circle"></i> Sukses
            <?php elseif($notification->type === 'warning'): ?>
                <i class="fas fa-exclamation-triangle"></i> Peringatan
            <?php elseif($notification->type === 'important'): ?>
                <i class="fas fa-exclamation-circle"></i> Penting
            <?php endif; ?>
        </div>

        <!-- Title -->
        <div class="notification-title">
            <i class="fas fa-bell"></i>
            <?php echo e($notification->title); ?>

        </div>

        <?php
            $message = $notification->message;
            
            // Try to get order from database using related_id
            $relatedOrder = null;
            if ($notification->related_type === 'App\\Models\\Order' && $notification->related_id) {
                $relatedOrder = \App\Models\Order::find($notification->related_id);
            }
            
            // Extract order number - berbagai format (fallback jika tidak ada related_id)
            $orderNumber = null;
            if ($relatedOrder) {
                $orderNumber = $relatedOrder->order_number;
            } elseif (preg_match('/No\.\s*Pesanan:\s*#?([A-Z0-9-]+)/i', $message, $matches)) {
                $orderNumber = $matches[1];
            } elseif (preg_match('/#([A-Z0-9]{3,}-[A-Z0-9]{6,})/i', $message, $matches)) {
                // Format ORD-20251212-780630
                $orderNumber = $matches[1];
            } elseif (preg_match('/ORD-\d{8}-[A-F0-9]{6}/i', $message, $matches)) {
                // Direct match format ORD-YYYYMMDD-XXXXXX
                $orderNumber = $matches[0];
            }
            
            // If we don't have relatedOrder but have orderNumber, try to find it
            if (!$relatedOrder && $orderNumber) {
                $relatedOrder = \App\Models\Order::where('order_number', $orderNumber)->first();
            }
            
            // Extract product name
            $productName = null;
            if (preg_match('/Produk:\s*(.+?)(?:\n|$)/i', $message, $matches)) {
                $productName = trim($matches[1]);
            }
            
            // Extract jumlah
            $jumlah = null;
            if (preg_match('/Jumlah:\s*(\d+)/i', $message, $matches)) {
                $jumlah = $matches[1];
            }
            
            // Extract old and new status
            $oldStatus = null;
            $newStatus = null;
            if (preg_match('/Status\s*Lama:\s*(?:📦|🚚|✅)\s*(.+?)(?:\n|$)/i', $message, $matches)) {
                $oldStatus = trim($matches[1]);
            }
            if (preg_match('/Status\s*Baru:\s*(?:📦|🚚|✅)\s*(.+?)(?:\n|$)/i', $message, $matches)) {
                $newStatus = trim($matches[1]);
            }
            
            // Check for shipping notice
            $isShipped = preg_match('/PESANAN\s+HARI\s+DIKIRIM/i', $message);
            
            // Check if order is Ready - prioritas dari database, fallback ke message text
            $isReady = false;
            if ($relatedOrder && in_array($relatedOrder->status, ['Ready', 'Completed'])) {
                $isReady = true;
            } else {
                $isReady = preg_match('/SIAP\s+DIAMBIL|PESANAN\s+(ANDA\s+)?SUDAH\s+SIAP|Status\s+Baru:.*Siap/i', $message);
            }
            
            // Extract action steps
            $actionSteps = null;
            if (preg_match('/🔔\s*Langkah\s+Pengambilan:(.*?)(?=💡|$)/is', $message, $matches)) {
                $actionSteps = trim($matches[1]);
            }
            
            // Extract tips
            $tip = null;
            if (preg_match('/💡\s*Tip:\s*(.+?)(?:\n|$)/i', $message, $matches)) {
                $tip = trim($matches[1]);
            }
        ?>

        <?php if($orderNumber || $productName || $oldStatus || $newStatus): ?>
        <!-- Order Status Update Section -->
        <div class="order-info-section">
            <div class="section-title">
                <i class="fas fa-box"></i> UPDATE STATUS PESANAN 📦
            </div>
            
            <?php if($orderNumber): ?>
            <div class="info-item">
                <span class="info-label">📋 No. Pesanan:</span>
                <span class="info-value">#<?php echo e($orderNumber); ?></span>
            </div>
            <?php endif; ?>

            <?php if($productName): ?>
            <div class="info-item">
                <span class="info-label">📦 Produk:</span>
                <span class="info-value"><?php echo e($productName); ?></span>
            </div>
            <?php endif; ?>

            <?php if($jumlah): ?>
            <div class="info-item">
                <span class="info-label">🔢 Jumlah:</span>
                <span class="info-value"><?php echo e($jumlah); ?></span>
            </div>
            <?php endif; ?>

            <?php if($oldStatus && $newStatus): ?>
            <div class="status-change-section">
                <div class="status-item lama">
                    <span class="status-icon old">📦</span>
                    <span class="status-label">Status Lama:</span>
                    <span class="status-value"><?php echo e($oldStatus); ?></span>
                </div>
                <div class="status-item baru">
                    <span class="status-icon new">✅</span>
                    <span class="status-label">Status Baru:</span>
                    <span class="status-value highlight"><?php echo e($newStatus); ?></span>
                </div>
            </div>
            <?php endif; ?>

            <?php if($isShipped): ?>
            <div class="highlight-banner shipped">
                📦 PESANAN HARI DIKIRIM!
            </div>
            <?php elseif($isReady): ?>
            <div class="highlight-banner ready">
                PESANAN ANDA SUDAH SIAP.
            </div>
            <?php endif; ?>

            <?php if($actionSteps): ?>
            <div class="action-section">
                <div class="action-title">🔔 Langkah Pengambilan:</div>
                <div class="action-content">
                    <?php echo nl2br(e($actionSteps)); ?>

                </div>
            </div>
            <?php endif; ?>

            <?php if($tip): ?>
            <div class="tip-section">
                <i class="fas fa-lightbulb"></i>
                <strong>Tip:</strong> <?php echo e($tip); ?>

            </div>
            <?php endif; ?>

            
            
            <?php if($isReady && $orderNumber): ?>
            <div class="map-button-section" style="margin-top: 25px; padding: 20px; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-radius: 12px; border: 2px solid #10b981;">
                <div style="text-align: center; margin-bottom: 15px;">
                    <i class="fas fa-map-marked-alt" style="font-size: 48px; color: #10b981;"></i>
                    <h3 style="color: #047857; font-size: 18px; font-weight: 700; margin-top: 10px;">Lihat Lokasi Pengambilan</h3>
                </div>
                <a href="<?php echo e(route('maps.show', ['order' => $orderNumber])); ?>" class="btn-map" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 16px 32px; background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%); color: white; text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4); transition: all 0.3s; margin: 0 auto; max-width: 400px;">
                    <i class="fab fa-google" style="font-size: 20px;"></i>
                    Buka Peta Lokasi Pengambilan
                </a>
                <p class="map-hint" style="text-align: center; margin-top: 15px; color: #047857; font-size: 14px;">
                    <i class="fas fa-info-circle"></i>
                    Sistem akan menunjukkan titik pengambilan terdekat dari lokasi Anda dengan rute Google Maps
                </p>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <!-- Regular Notification Message -->
        <div class="notification-message">
            <?php echo nl2br(e($notification->message)); ?>


            
            <?php
                $hasOrderNumber = preg_match('/ORD-\d{8}-[A-F0-9]{6}/i', $notification->message, $matches);
                $orderNum = $hasOrderNumber ? $matches[0] : null;
                $isSiap = stripos($notification->message, 'siap') !== false || stripos($notification->title, 'siap') !== false;
            ?>
            
            <?php if($isSiap && $orderNum): ?>
            <div class="map-button-section" style="margin-top: 20px;">
                <a href="<?php echo e(route('maps.show', ['order' => $orderNum])); ?>" class="btn-map">
                    <i class="fas fa-map-marked-alt"></i>
                    Lihat Lokasi Pengambilan
                </a>
                <p class="map-hint">
                    <i class="fas fa-info-circle"></i>
                    Klik tombol di atas untuk melihat lokasi pengambilan terdekat dari Anda
                </p>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="notification-actions">
            <a href="<?php echo e(route('notifikasi')); ?>" class="btn-action back" onclick="sessionStorage.setItem('notifJustRead', 'true');">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            
            <form action="<?php echo e(route('user.notifications.destroy', $notification->id)); ?>" method="POST" style="display: inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn-action delete" onclick="return confirm('Yakin ingin menghapus notifikasi ini?')">
                    <i class="fas fa-trash"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.notification-detail-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.back-navigation {
    margin-bottom: 20px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s;
}

.back-link:hover {
    background: #eff6ff;
    color: #2563eb;
}

.notification-detail-card {
    background: white;
    border-radius: 12px;
    border-left: 4px solid #3b82f6;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 30px;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.sender-info {
    display: flex;
    gap: 15px;
    align-items: center;
}

.sender-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 20px;
    color: white;
    flex-shrink: 0;
}

.sender-avatar.admin {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.sender-details {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.sender-name {
    font-weight: 600;
    font-size: 16px;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 8px;
}

.badge-system {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 600;
}

.notification-date {
    color: #6b7280;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.notification-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 20px;
}

.notification-type-badge.info {
    background: #dbeafe;
    color: #1e40af;
}

.notification-type-badge.success {
    background: #d1fae5;
    color: #065f46;
}

.notification-type-badge.warning {
    background: #fed7aa;
    color: #92400e;
}

.notification-type-badge.important {
    background: #fee2e2;
    color: #991b1b;
}

.notification-title {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.notification-title i {
    color: #3b82f6;
}

.notification-message {
    color: #4b5563;
    line-height: 1.8;
    font-size: 15px;
    margin-bottom: 25px;
    padding: 20px;
    background: #f9fafb;
    border-radius: 8px;
    border-left: 3px solid #3b82f6;
}

.order-info-section {
    background: linear-gradient(to right, #f0f9ff, #e0f2fe);
    border: 2px solid #3b82f6;
    border-radius: 12px;
    padding: 25px;
    margin: 25px 0;
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-item {
    display: flex;
    padding: 12px 0;
    border-bottom: 1px solid #bfdbfe;
}

.info-item:last-of-type {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #1e40af;
    min-width: 150px;
    flex-shrink: 0;
}

.info-value {
    color: #374151;
    font-weight: 500;
}

.status-change-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px dashed #93c5fd;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    background: white;
}

.status-item.lama {
    border-left: 4px solid #9ca3af;
}

.status-item.baru {
    border-left: 4px solid #10b981;
    background: #ecfdf5;
}

.status-icon {
    font-size: 24px;
}

.status-label {
    font-weight: 600;
    color: #374151;
    min-width: 100px;
}

.status-value {
    color: #1f2937;
}

.status-value.highlight {
    color: #059669;
    font-weight: 700;
}

.highlight-banner {
    padding: 15px;
    border-radius: 8px;
    font-weight: 700;
    text-align: center;
    margin: 15px 0;
    font-size: 16px;
}

.highlight-banner.shipped {
    background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 100%);
    color: #92400e;
}

.highlight-banner.ready {
    background: linear-gradient(135deg, #d1fae5 0%, #10b981 100%);
    color: #065f46;
}

.action-section {
    margin-top: 20px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    border: 2px solid #fbbf24;
}

.action-title {
    font-weight: 700;
    color: #92400e;
    margin-bottom: 12px;
    font-size: 15px;
}

.action-content {
    color: #374151;
    line-height: 1.8;
    padding-left: 15px;
}

.tip-section {
    margin-top: 15px;
    padding: 15px;
    background: #fffbeb;
    border-radius: 8px;
    border-left: 4px solid #fbbf24;
    display: flex;
    align-items: start;
    gap: 10px;
    color: #78350f;
}

.tip-section i {
    color: #f59e0b;
    font-size: 18px;
    margin-top: 2px;
}

/* Map Section */
.map-section {
    background: #f9fafb;
    padding: 25px;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    margin-top: 25px;
}

.address-info {
    background: white;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid #3b82f6;
    margin-bottom: 15px;
}

.address-label {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.address-value {
    font-size: 15px;
    font-weight: 600;
    color: #1f2937;
    line-height: 1.6;
}

.map-notice {
    background: #eff6ff;
    padding: 12px 15px;
    border-radius: 8px;
    border-left: 3px solid #3b82f6;
    margin-top: 15px;
    font-size: 13px;
    color: #1e40af;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.map-notice i {
    flex-shrink: 0;
    margin-top: 2px;
}

.notification-actions {
    display: flex;
    gap: 10px;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.btn-action {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    font-size: 14px;
    text-decoration: none;
}

.btn-action.back {
    background: #6b7280;
    color: white;
}

.btn-action.back:hover {
    background: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

.btn-action.delete {
    background: #ef4444;
    color: white;
}

.btn-action.delete:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

@media (max-width: 768px) {
    .notification-detail-container {
        padding: 15px;
    }
    
    .notification-detail-card {
        padding: 20px;
    }
    
    .sender-avatar {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
    
    .notification-title {
        font-size: 18px;
    }
    
    .info-item {
        flex-direction: column;
        gap: 5px;
    }
    
    .info-label {
        min-width: auto;
    }
    
    .status-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .status-label {
        min-width: auto;
    }
    
    .notification-actions {
        flex-direction: column;
    }
    
    .btn-action {
        width: 100%;
        justify-content: center;
    }
}

/* Map Button Section */
.map-button-section {
    margin-top: 25px;
    padding: 25px;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-radius: 12px;
    border: 2px solid #4ade80;
    text-align: center;
}

.btn-map {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 16px 32px;
    background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%);
    color: white;
    text-decoration: none;
    font-weight: 700;
    font-size: 16px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    margin-bottom: 15px;
}

.btn-map:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(76, 175, 80, 0.5);
    background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
}

.btn-map i {
    font-size: 20px;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.map-hint {
    margin: 0;
    color: #166534;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.map-hint i {
    color: #22c55e;
    font-size: 16px;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/user/notifications/show-notification.blade.php ENDPATH**/ ?>