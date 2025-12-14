<?php $__env->startSection('title', 'Detail Pesanan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .detail-container {
        max-width: 1200px;
        margin: 140px auto 3rem;
        padding: 0 2rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #047857;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-decoration: none;
        transition: all 0.3s;
    }

    .back-button:hover {
        color: #065f46;
        gap: 12px;
    }

    .detail-header {
        background: linear-gradient(135deg, #047857 0%, #065f46 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px 12px 0 0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .detail-header h1 {
        margin: 0 0 0.5rem 0;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .order-number {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .detail-content {
        background: white;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .detail-section {
        padding: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-section:last-child {
        border-bottom: none;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.25rem;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 1.5rem;
    }

    .section-title i {
        color: #10b981;
        font-size: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem;
        color: #1f2937;
        font-weight: 500;
    }

    .product-card {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        background: #f9fafb;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .product-image {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }

    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 0.5rem;
    }

    .product-type {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: #10b981;
        color: white;
        border-radius: 4px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .product-details {
        display: flex;
        gap: 2rem;
        margin-top: 0.5rem;
    }

    .product-detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .product-detail-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 600;
    }

    .product-detail-value {
        font-size: 1rem;
        color: #1f2937;
        font-weight: 600;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        width: fit-content;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-badge.processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-badge.ready {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.completed {
        background: #dcfce7;
        color: #14532d;
    }

    .status-badge.cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .summary-box {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #10b981;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #d1fae5;
    }

    .summary-row:last-child {
        border-bottom: none;
        padding-top: 1rem;
        font-size: 1.25rem;
        font-weight: 700;
        color: #065f46;
    }

    .summary-label {
        color: #374151;
        font-weight: 500;
    }

    .summary-value {
        color: #1f2937;
        font-weight: 600;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 9px;
        top: 10px;
        bottom: 10px;
        width: 2px;
        background: #d1fae5;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: -2rem;
        width: 20px;
        height: 20px;
        background: #10b981;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #d1fae5;
    }

    .timeline-content {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 8px;
        border-left: 3px solid #10b981;
    }

    .timeline-title {
        font-weight: 700;
        color: #065f46;
        margin-bottom: 0.25rem;
    }

    .timeline-date {
        font-size: 0.875rem;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .detail-container {
            margin-top: 100px;
            padding: 0 1rem;
        }

        .detail-header {
            padding: 1.5rem;
        }

        .detail-header h1 {
            font-size: 1.5rem;
        }

        .detail-section {
            padding: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .product-card {
            flex-direction: column;
        }

        .product-image {
            width: 100%;
            height: 200px;
        }

        .product-details {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="detail-container">
    <a href="<?php echo e(route('profil.user')); ?>" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Profil
    </a>

    <div class="detail-header">
        <h1><i class="fas fa-receipt"></i> Detail Pesanan</h1>
        <p class="order-number">Order Number: <strong><?php echo e($order->order_number); ?></strong></p>
    </div>

    <div class="detail-content">
        <!-- Status Section -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-info-circle"></i>
                Status Pesanan
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Status Saat Ini</span>
                    <?php
                        $statusClass = match($order->status) {
                            'Menunggu Konfirmasi' => 'pending',
                            'Sedang Diproses' => 'processing',
                            'Siap Diambil' => 'ready',
                            'Selesai' => 'completed',
                            'Dibatalkan' => 'cancelled',
                            default => 'pending'
                        };
                    ?>
                    <span class="status-badge <?php echo e($statusClass); ?>">
                        <i class="fas fa-circle" style="font-size: 8px;"></i>
                        <?php echo e($order->status); ?>

                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Pesanan</span>
                    <span class="info-value"><?php echo e($order->created_at->format('d F Y, H:i')); ?> WIB</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Terakhir Diperbarui</span>
                    <span class="info-value"><?php echo e($order->updated_at->format('d F Y, H:i')); ?> WIB</span>
                </div>
            </div>
        </div>

        <!-- Product Section -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-box"></i>
                Informasi Produk
            </h2>
            <div class="product-card">
                <?php
                    $productImage = asset('images/pupuk.jpg'); // Default
                    
                    if($order->product) {
                        if($order->product->primaryImage) {
                            $productImage = asset($order->product->primaryImage->image_path);
                        } elseif($order->product->images && $order->product->images->count() > 0) {
                            $productImage = asset($order->product->images->first()->image_path);
                        } elseif($order->product->gambar) {
                            if(filter_var($order->product->gambar, FILTER_VALIDATE_URL)) {
                                $productImage = $order->product->gambar;
                            } elseif(file_exists(public_path('images/products/' . $order->product->gambar))) {
                                $productImage = asset('images/products/' . $order->product->gambar);
                            } elseif(file_exists(public_path('images/' . $order->product->gambar))) {
                                $productImage = asset('images/' . $order->product->gambar);
                            } elseif(file_exists(public_path($order->product->gambar))) {
                                $productImage = asset($order->product->gambar);
                            } else {
                                // Product type specific fallback
                                if(isset($order->product->tipe_produk) && $order->product->tipe_produk === 'bibit') {
                                    $productImage = asset('images/bibit.jpg');
                                } elseif(strpos(strtolower($order->product->nama_produk ?? ''), 'bibit') !== false) {
                                    $productImage = asset('images/bibit.jpg');
                                }
                            }
                        }
                    }
                ?>
                
                <img src="<?php echo e($productImage); ?>" 
                     alt="<?php echo e($order->product->nama_produk ?? 'Produk'); ?>" 
                     class="product-image"
                     onerror="this.src='<?php echo e(asset('images/pupuk.jpg')); ?>'">
                
                <div class="product-info">
                    <div>
                        <h3 class="product-name"><?php echo e($order->product->nama_produk ?? 'Produk tidak tersedia'); ?></h3>
                        <span class="product-type"><?php echo e($order->product->tipe_produk ?? '-'); ?></span>
                        <p style="color: #6b7280; margin: 0.5rem 0;">
                            <?php echo e($order->product->deskripsi ?? '-'); ?>

                        </p>
                    </div>
                    <div class="product-details">
                        <div class="product-detail-item">
                            <span class="product-detail-label">Jumlah</span>
                            <span class="product-detail-value"><?php echo e($order->quantity); ?> Kg</span>
                        </div>
                        <div class="product-detail-item">
                            <span class="product-detail-label">Harga Satuan</span>
                            <span class="product-detail-value">Rp <?php echo e(number_format($order->product->harga_subsidi ?? 0, 0, ',', '.')); ?></span>
                        </div>
                        <div class="product-detail-item">
                            <span class="product-detail-label">Subtotal</span>
                            <span class="product-detail-value">Rp <?php echo e(number_format($order->total_amount ?? 0, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-user"></i>
                Informasi Penerima
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value"><?php echo e($order->customer_name ?? $order->user->nama_lengkap ?? $order->user->name ?? '-'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nomor Telepon</span>
                    <span class="info-value"><?php echo e($order->customer_phone ?? $order->user->no_telp ?? '-'); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat Lengkap</span>
                    <span class="info-value"><?php echo e($order->customer_address ?? $order->user->alamat ?? '-'); ?></span>
                </div>
                <?php if($order->customer_notes): ?>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">Catatan Pesanan</span>
                    <span class="info-value" style="white-space: pre-wrap;"><?php echo e($order->customer_notes); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-money-bill-wave"></i>
                Ringkasan Pembayaran
            </h2>
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">Subtotal Produk</span>
                    <span class="summary-value">Rp <?php echo e(number_format($order->total_amount ?? 0, 0, ',', '.')); ?></span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Diskon Subsidi</span>
                    <span class="summary-value" style="color: #10b981;">
                        <?php if($order->product): ?>
                            - Rp <?php echo e(number_format(($order->product->harga_normal - $order->product->harga_subsidi) * $order->quantity, 0, ',', '.')); ?>

                        <?php else: ?>
                            Rp 0
                        <?php endif; ?>
                    </span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">TOTAL PEMBAYARAN</span>
                    <span class="summary-value">Rp <?php echo e(number_format($order->total_amount ?? 0, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <?php if($order->status !== 'Menunggu Konfirmasi'): ?>
        <div class="detail-section">
            <h2 class="section-title">
                <i class="fas fa-history"></i>
                Riwayat Pesanan
            </h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Dibuat</div>
                        <div class="timeline-date"><?php echo e($order->created_at->format('d F Y, H:i')); ?> WIB</div>
                    </div>
                </div>
                
                <?php if($order->status !== 'Menunggu Konfirmasi'): ?>
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Dikonfirmasi</div>
                        <div class="timeline-date"><?php echo e($order->updated_at->format('d F Y, H:i')); ?> WIB</div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(in_array($order->status, ['Sedang Diproses', 'Siap Diambil', 'Selesai'])): ?>
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Diproses</div>
                        <div class="timeline-date"><?php echo e($order->updated_at->format('d F Y, H:i')); ?> WIB</div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(in_array($order->status, ['Siap Diambil', 'Selesai'])): ?>
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Siap Diambil</div>
                        <div class="timeline-date"><?php echo e($order->updated_at->format('d F Y, H:i')); ?> WIB</div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($order->status === 'Selesai'): ?>
                <div class="timeline-item">
                    <div class="timeline-icon"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">Pesanan Selesai</div>
                        <div class="timeline-date"><?php echo e($order->updated_at->format('d F Y, H:i')); ?> WIB</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw10\Project-SistemInformasiPupuk\resources\views/user/order-detail.blade.php ENDPATH**/ ?>