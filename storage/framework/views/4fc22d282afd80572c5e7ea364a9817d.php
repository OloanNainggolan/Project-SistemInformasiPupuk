<?php $__env->startSection('title', 'Manajemen Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="orders-container">
    <!-- Statistics Cards -->

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['total']); ?></div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>
        <div class="stat-card stat-pending">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['pending']); ?></div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="stat-card stat-processing">
            <div class="stat-icon"><i class="fas fa-cog"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['processing']); ?></div>
                <div class="stat-label">Processing</div>
            </div>
        </div>
        <div class="stat-card stat-ready">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['ready']); ?></div>
                <div class="stat-label">Ready</div>
            </div>
        </div>
        <div class="stat-card stat-completed">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['completed']); ?></div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="stat-card stat-rejected">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($stats['rejected']); ?></div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="<?php echo e(route('admin.orders')); ?>" class="filters-form">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari order number, nama, atau telepon..." value="<?php echo e($query); ?>">
            </div>
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="all" <?php echo e($status == 'all' ? 'selected' : ''); ?>>Semua Status</option>
                <option value="Pending" <?php echo e($status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="Processing" <?php echo e($status == 'Processing' ? 'selected' : ''); ?>>Processing</option>
                <option value="Ready" <?php echo e($status == 'Ready' ? 'selected' : ''); ?>>Ready</option>
                <option value="Completed" <?php echo e($status == 'Completed' ? 'selected' : ''); ?>>Completed</option>
                <option value="Rejected" <?php echo e($status == 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
            </select>
            <button type="submit" class="btn-search"><i class="fas fa-search"></i> Cari</button>
        </form>
    </div>

    <!-- Orders List -->
    <?php if($orders->count() > 0): ?>
    <div class="orders-grid">
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="order-card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="order-number">
                    <i class="fas fa-receipt"></i>
                    <span><?php echo e($order->order_number); ?></span>
                </div>
                <span class="order-badge badge-<?php echo e(strtolower($order->status)); ?>">
                    <?php echo e($order->status); ?>

                </span>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Customer Info -->
                <div class="customer-section">
                    <div class="info-row">
                        <i class="fas fa-user"></i>
                        <span class="info-value"><?php echo e($order->customer_name); ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-phone"></i>
                        <span class="info-value"><?php echo e($order->customer_phone); ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="info-value"><?php echo e(Str::limit($order->customer_address, 50)); ?></span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-calendar"></i>
                        <span class="info-value"><?php echo e($order->created_at->format('d M Y, H:i')); ?></span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-section">
                    <div class="section-title">Detail Produk</div>
                    <?php if($order->product): ?>
                    <div class="product-item">
                        <div class="product-info">
                            <div class="product-name"><?php echo e($order->product->nama_produk); ?></div>
                            <div class="product-meta">
                                <span class="product-qty"><?php echo e($order->quantity); ?> <?php echo e($order->product->satuan); ?></span>
                                <span class="product-price">@ Rp <?php echo e(number_format($order->unit_price, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                        <div class="product-subtotal">
                            Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($order->discount_amount > 0): ?>
                    <div class="discount-row">
                        <span>Diskon Subsidi</span>
                        <span class="discount-value">- Rp <?php echo e(number_format($order->discount_amount, 0, ',', '.')); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <div class="total-row">
                        <span>Total Pembayaran</span>
                        <span class="total-value">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                    </div>
                </div>

                <!-- Notes -->
                <?php if($order->customer_notes): ?>
                <div class="notes-section">
                    <div class="section-title">Catatan</div>
                    <p class="notes-text"><?php echo e($order->customer_notes); ?></p>
                </div>
                <?php endif; ?>

                <!-- Status Update -->
                <div class="status-section">
                    <form action="<?php echo e(route('admin.orders.updateStatus', $order->order_number)); ?>" method="POST" class="status-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <label class="status-label">Update Status</label>
                        <div class="status-control">
                            <select name="status" class="status-select" required>
                                <option value="Pending" <?php echo e($order->status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="Processing" <?php echo e($order->status == 'Processing' ? 'selected' : ''); ?>>Processing</option>
                                <option value="Ready" <?php echo e($order->status == 'Ready' ? 'selected' : ''); ?>>Ready</option>
                                <option value="Completed" <?php echo e($order->status == 'Completed' ? 'selected' : ''); ?>>Completed</option>
                                <option value="Rejected" <?php echo e($order->status == 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
                            </select>
                            <button type="submit" class="btn-update">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="<?php echo e(route('admin.orders.show', $order->order_number)); ?>" class="btn-detail">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        <?php echo e($orders->appends(['search' => $query, 'status' => $status])->links()); ?>

    </div>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>Tidak ada pesanan yang ditemukan</p>
    </div>
    <?php endif; ?>
</div>

<style>
/* Container */
.orders-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.stat-card {
    background: white;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.stat-total .stat-icon { background: #e3f2fd; color: #1976d2; }
.stat-pending .stat-icon { background: #fafafa; color: #757575; }
.stat-processing .stat-icon { background: #f3e5f5; color: #7b1fa2; }
.stat-ready .stat-icon { background: #e8f5e9; color: #388e3c; }
.stat-completed .stat-icon { background: #c8e6c9; color: #2e7d32; }
.stat-rejected .stat-icon { background: #ffebee; color: #d32f2f; }

.stat-info {
    flex: 1;
}

.stat-value {
    font-size: 22px;
    font-weight: 700;
    color: #333;
    line-height: 1;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 11px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Filters Section */
.filters-section {
    background: white;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.06);
}

.filters-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 13px;
}

.search-box input {
    width: 100%;
    padding: 9px 12px 9px 35px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 13px;
    transition: all 0.3s;
}

.search-box input:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 3px rgba(76,175,80,0.1);
}

.filter-select {
    padding: 9px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    background: white;
    min-width: 150px;
}

.btn-search {
    padding: 9px 18px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-search:hover {
    background: #45a049;
    transform: translateY(-1px);
}

/* Orders Grid */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 16px;
    margin-bottom: 20px;
}

.order-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: all 0.3s;
}

.order-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

/* Card Header */
.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 12px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #dee2e6;
}

.order-number {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
    color: #2d5016;
    font-size: 13px;
}

.order-number i {
    color: #4CAF50;
    font-size: 12px;
}

.order-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-pending { background: #e0e0e0; color: #666; }
.badge-processing { background: #e1bee7; color: #6a1b9a; }
.badge-ready { background: #c8e6c9; color: #2e7d32; }
.badge-completed { background: #a5d6a7; color: #1b5e20; }
.badge-rejected { background: #ffcdd2; color: #c62828; }

/* Card Body */
.card-body {
    padding: 15px;
}

/* Customer Section */
.customer-section {
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

.info-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
    font-size: 12px;
    color: #555;
}

.info-row:last-child {
    margin-bottom: 0;
}

.info-row i {
    width: 14px;
    color: #4CAF50;
    font-size: 11px;
}

.info-value {
    flex: 1;
}

/* Product Section */
.product-section {
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

.section-title {
    font-size: 11px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.product-item {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 8px;
}

.product-name {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 3px;
}

.product-meta {
    display: flex;
    gap: 8px;
    font-size: 11px;
    color: #666;
}

.product-qty {
    font-weight: 600;
}

.product-subtotal {
    font-size: 13px;
    font-weight: 600;
    color: #2d5016;
}

.discount-row {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #666;
    margin-bottom: 6px;
}

.discount-value {
    color: #d32f2f;
    font-weight: 600;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding-top: 8px;
    border-top: 1px solid #f0f0f0;
    margin-top: 8px;
}

.total-row span:first-child {
    font-size: 12px;
    font-weight: 600;
    color: #666;
}

.total-value {
    font-size: 16px;
    font-weight: 700;
    color: #2d5016;
}

/* Notes Section */
.notes-section {
    margin-bottom: 12px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 6px;
}

.notes-text {
    font-size: 12px;
    color: #555;
    margin: 0;
    line-height: 1.5;
}

/* Status Section */
.status-section {
    margin-top: 12px;
}

.status-label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.status-control {
    display: flex;
    gap: 8px;
}

.status-select {
    flex: 1;
    padding: 8px 10px;
    border: 1.5px solid #ddd;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.status-select:focus {
    outline: none;
    border-color: #4CAF50;
}

.btn-update {
    padding: 8px 14px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-update:hover {
    background: #45a049;
}

/* Empty State */
.empty-state {
    background: white;
    border-radius: 8px;
    padding: 60px 20px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.06);
}

.empty-state i {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 15px;
}

.empty-state p {
    font-size: 14px;
    color: #666;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.btn-detail {
    flex: 1;
    padding: 10px 15px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white !important;
    text-decoration: none !important;
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    cursor: pointer;
}

.btn-detail:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
}

.btn-detail i {
    font-size: 14px;
}

/* Pagination */
.pagination-section {
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .orders-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .filters-form {
        flex-direction: column;
    }
    
    .search-box {
        min-width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit forms with confirmation
    const statusForms = document.querySelectorAll('.status-form');
    
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const select = this.querySelector('.status-select');
            const newStatus = select.value;
            const orderNumber = this.action.split('/').pop();
            
            if (confirm(`Apakah Anda yakin ingin mengubah status pesanan ${orderNumber} menjadi ${newStatus}?`)) {
                this.submit();
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>