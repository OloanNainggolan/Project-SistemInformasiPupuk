<!-- Activity Log Section -->
<div class="orders-section" style="margin-top: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="font-size: 18px; font-weight: 700; color: #1e293b;">
            <i class="fas fa-history" style="color: #00897b; margin-right: 8px;"></i>
            Aktivitas Terbaru
        </h3>
        <button onclick="refreshActivityLog()" style="background: #00897b; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 600; transition: all 0.3s;">
            <i class="fas fa-sync"></i> Refresh
        </button>
    </div>

    <div id="activityLogContainer" style="max-height: 600px; overflow-y: auto;">
        <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="activity-item" style="display: flex; gap: 12px; padding: 15px; border-bottom: 1px solid #f1f5f9; align-items: start; transition: all 0.3s;">
                <div class="activity-icon" style="width: 40px; height: 40px; background: #f0f9ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00897b; font-size: 16px; flex-shrink: 0;">
                    <i class="fas <?php echo e($activity->icon); ?>"></i>
                </div>
                <div class="activity-content" style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; color: #1e293b; font-size: 14px; margin-bottom: 4px;">
                        <?php echo e(ucfirst(str_replace('_', ' ', $activity->action))); ?>

                        <?php if($activity->module): ?>
                            <span style="color: #64748b; font-weight: 400;">- <?php echo e(ucfirst($activity->module)); ?></span>
                        <?php endif; ?>
                    </div>
                    <div style="color: #475569; font-size: 13px; margin-bottom: 6px;">
                        <?php echo e($activity->description); ?>

                    </div>
                    <div style="display: flex; gap: 12px; font-size: 12px;">
                        <span style="color: #94a3b8;">
                            <i class="fas fa-clock" style="margin-right: 4px;"></i>
                            <?php echo e($activity->created_at->diffForHumans()); ?>

                        </span>
                        <?php if($activity->status === 'failed'): ?>
                            <span style="color: #dc2626; background: #fee2e2; padding: 2px 8px; border-radius: 4px;">
                                <i class="fas fa-times-circle"></i> Gagal
                            </span>
                        <?php else: ?>
                            <span style="color: #16a34a; background: #dcfce7; padding: 2px 8px; border-radius: 4px;">
                                <i class="fas fa-check-circle"></i> Berhasil
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if($activity->changes): ?>
                        <div style="background: #f8fafc; padding: 8px 12px; border-radius: 6px; margin-top: 8px; font-size: 12px; color: #475569;">
                            <details style="cursor: pointer;">
                                <summary style="font-weight: 600; color: #00897b;">Detail Perubahan</summary>
                                <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #e2e8f0;">
                                    <?php $__currentLoopData = is_array($activity->changes) ? $activity->changes : json_decode($activity->changes, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div style="margin-bottom: 6px;">
                                            <strong><?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>:</strong>
                                            <?php if(is_array($value)): ?>
                                                <div style="margin-left: 12px;">
                                                    <span style="color: #dc2626;">Sebelum: <?php echo e($value['old'] ?? '-'); ?></span><br>
                                                    <span style="color: #16a34a;">Sesudah: <?php echo e($value['new'] ?? '-'); ?></span>
                                                </div>
                                            <?php else: ?>
                                                <?php echo e($value); ?>

                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </details>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state" style="padding: 40px 20px;">
                <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e0; margin-bottom: 12px;"></i>
                <h4>Belum ada aktivitas</h4>
                <p>Aktivitas admin akan ditampilkan di sini</p>
            </div>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
        <a href="#" style="color: #00897b; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; transition: gap 0.3s ease;">
            Lihat Semua Aktivitas
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<style>
    #activityLogContainer::-webkit-scrollbar {
        width: 6px;
    }

    #activityLogContainer::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    #activityLogContainer::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    #activityLogContainer::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .activity-item:hover {
        background: #f8fafc;
    }
</style>

<script>
    // Real-time activity log refresh setiap 30 detik
    let activityRefreshInterval = setInterval(refreshActivityLog, 30000);

    function refreshActivityLog() {
        fetch('<?php echo e(route("admin.activities")); ?>')
            .then(response => response.json())
            .then(data => {
                if (data.activities && data.activities.length > 0) {
                    updateActivityLog(data.activities);
                }
            })
            .catch(error => console.error('Error fetching activities:', error));
    }

    function updateActivityLog(activities) {
        const container = document.getElementById('activityLogContainer');
        
        if (!activities || activities.length === 0) {
            container.innerHTML = `
                <div class="empty-state" style="padding: 40px 20px;">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #cbd5e0; margin-bottom: 12px;"></i>
                    <h4>Belum ada aktivitas</h4>
                    <p>Aktivitas admin akan ditampilkan di sini</p>
                </div>
            `;
            return;
        }

        let html = '';
        activities.forEach(activity => {
            const timestamp = new Date(activity.created_at);
            const diffText = getTimeDifference(timestamp);
            const statusBadge = activity.status === 'failed' 
                ? '<span style="color: #dc2626; background: #fee2e2; padding: 2px 8px; border-radius: 4px;"><i class="fas fa-times-circle"></i> Gagal</span>'
                : '<span style="color: #16a34a; background: #dcfce7; padding: 2px 8px; border-radius: 4px;"><i class="fas fa-check-circle"></i> Berhasil</span>';

            html += `
                <div class="activity-item" style="display: flex; gap: 12px; padding: 15px; border-bottom: 1px solid #f1f5f9; align-items: start; transition: all 0.3s;">
                    <div class="activity-icon" style="width: 40px; height: 40px; background: #f0f9ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #00897b; font-size: 16px; flex-shrink: 0;">
                        <i class="fas ${getActivityIcon(activity.action)}"></i>
                    </div>
                    <div class="activity-content" style="flex: 1; min-width: 0;">
                        <div style="font-weight: 600; color: #1e293b; font-size: 14px; margin-bottom: 4px;">
                            ${activity.action.replace(/_/g, ' ').charAt(0).toUpperCase() + activity.action.replace(/_/g, ' ').slice(1)}
                            ${activity.module ? '<span style="color: #64748b; font-weight: 400;">- ' + activity.module.charAt(0).toUpperCase() + activity.module.slice(1) + '</span>' : ''}
                        </div>
                        <div style="color: #475569; font-size: 13px; margin-bottom: 6px;">
                            ${activity.description}
                        </div>
                        <div style="display: flex; gap: 12px; font-size: 12px;">
                            <span style="color: #94a3b8;">
                                <i class="fas fa-clock" style="margin-right: 4px;"></i>
                                ${diffText}
                            </span>
                            ${statusBadge}
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        
        // Re-attach hover effects
        container.querySelectorAll('.activity-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.background = '#f8fafc';
            });
            item.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
            });
        });
    }

    function getActivityIcon(action) {
        const icons = {
            'login': 'fa-sign-in-alt',
            'logout': 'fa-sign-out-alt',
            'update_profile': 'fa-user-edit',
            'update_password': 'fa-lock',
            'create_product': 'fa-plus-circle',
            'update_product': 'fa-edit',
            'delete_product': 'fa-trash',
            'update_order_status': 'fa-list-check',
            'delete_order': 'fa-trash-alt',
            'view_order': 'fa-eye',
            'send_notification': 'fa-bell',
            'update_settings': 'fa-cog',
            'default': 'fa-info-circle'
        };
        return icons[action] || icons['default'];
    }

    function getTimeDifference(date) {
        const now = new Date();
        const diff = Math.floor((now - date) / 1000); // dalam detik

        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
        if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
        if (diff < 604800) return Math.floor(diff / 86400) + ' hari lalu';
        
        return date.toLocaleDateString('id-ID');
    }

    // Stop refresh ketika halaman ditutup
    window.addEventListener('beforeunload', () => {
        clearInterval(activityRefreshInterval);
    });
</script>
<?php /**PATH C:\laragon\www\ppw\resources\views/admin/partials/activity-log.blade.php ENDPATH**/ ?>