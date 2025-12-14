<?php $__env->startSection('title', 'Detail Pesanan - Admin'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .detail-container {
        max-width: 1400px;
        margin: 30px auto;
        padding: 0 20px;
    }

    /* Back Button */
    .back-button {
        margin-bottom: 20px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        color: #065f46;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #065f46;
        color: white;
        border-color: #065f46;
        transform: translateX(-5px);
    }

    /* Header Section */
    .order-header {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .order-title-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f3f4f6;
    }

    .order-title {
        font-size: 24px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 8px;
    }

    .order-date {
        font-size: 14px;
        color: #6b7280;
    }

    .status-badge {
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-processing {
        background: #e0e7ff;
        color: #5b21b6;
    }

    .status-ready {
        background: #d1fae5;
        color: #065f46;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Grid Layout */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }

    /* Card Styles */
    .detail-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #10b981;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        font-size: 20px;
    }

    /* Info Rows */
    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-item {
        display: grid;
        grid-template-columns: 140px 1fr;
        gap: 15px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        border-left: 3px solid #10b981;
    }

    .info-label {
        font-weight: 600;
        color: #065f46;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: #10b981;
        font-size: 14px;
    }

    .info-value {
        color: #374151;
        font-size: 14px;
        font-weight: 500;
        word-break: break-word;
    }

    /* Products Section */
    .products-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .product-item {
        display: grid;
        grid-template-columns: 80px 1fr 120px;
        gap: 20px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 10px;
        margin-bottom: 15px;
        align-items: center;
    }

    .product-item:last-child {
        margin-bottom: 0;
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #10b981;
    }

    .product-info h4 {
        font-size: 16px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 5px;
    }

    .product-meta {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .product-quantity {
        font-size: 13px;
        color: #374151;
        font-weight: 600;
    }

    .product-price {
        text-align: right;
    }

    .product-subtotal {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
    }

    .product-unit-price {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    /* Total Section */
    .total-section {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
        border: 2px solid #10b981;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
    }

    .total-label {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
    }

    .total-value {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
    }

    .grand-total {
        border-top: 2px solid #10b981;
        margin-top: 10px;
        padding-top: 15px;
    }

    .grand-total .total-label {
        font-size: 20px;
        font-weight: 700;
        color: #065f46;
    }

    .grand-total .total-value {
        font-size: 24px;
        font-weight: 700;
        color: #10b981;
    }

    /* Action Buttons */
    .action-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-processing {
        background: #8b5cf6;
        color: white;
    }

    .btn-processing:hover {
        background: #7c3aed;
    }

    .btn-ready {
        background: #10b981;
        color: white;
    }

    .btn-ready:hover {
        background: #059669;
    }

    .btn-complete {
        background: #065f46;
        color: white;
    }

    .btn-complete:hover {
        background: #064e3b;
    }

    .btn-reject {
        background: #ef4444;
        color: white;
    }

    .btn-reject:hover {
        background: #dc2626;
    }

    .btn-print {
        background: white;
        color: #065f46;
        border: 2px solid #065f46;
    }

    .btn-print:hover {
        background: #065f46;
        color: white;
    }

    /* Rejection Section */
    .rejection-section {
        background: #fee2e2;
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #ef4444;
        margin-top: 20px;
    }

    .rejection-title {
        font-size: 16px;
        font-weight: 700;
        color: #991b1b;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rejection-reason {
        font-size: 14px;
        color: #7f1d1d;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .product-item {
            grid-template-columns: 60px 1fr 100px;
            gap: 15px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
    }

    @media (max-width: 768px) {
        .order-title-section {
            flex-direction: column;
            gap: 15px;
        }

        .product-item {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .product-price {
            text-align: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="detail-container">
    <!-- Back Button -->
    <div class="back-button">
        <a href="<?php echo e(route('admin.orders')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar Pesanan</span>
        </a>
    </div>

    <!-- Order Header -->
    <div class="order-header">
        <div class="order-title-section">
            <div>
                <h1 class="order-title">Pesanan <?php echo e($order->order_number); ?></h1>
                <p class="order-date">
                    <i class="far fa-calendar"></i>
                    <?php echo e($order->created_at->format('d F Y, H:i')); ?> WIB
                </p>
            </div>
            <div>
                <span class="status-badge status-<?php echo e(strtolower($order->status)); ?>">
                    <?php echo e($order->status); ?>

                </span>
            </div>
        </div>
    </div>

    <!-- Customer & Delivery Info -->
    <div class="detail-grid">
        <!-- Customer Information -->
        <div class="detail-card">
            <h3 class="card-title">
                <i class="fas fa-user"></i>
                Informasi Pelanggan
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-user-circle"></i>
                        Nama Pemesan
                    </div>
                    <div class="info-value"><?php echo e($order->customer_name ?? $order->user->nama_lengkap ?? $order->user->name ?? 'N/A'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </div>
                    <div class="info-value"><?php echo e($order->user->email ?? 'N/A'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-phone"></i>
                        No. HP
                    </div>
                    <div class="info-value"><?php echo e($order->customer_phone ?? $order->user->no_hp ?? 'N/A'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat
                    </div>
                    <div class="info-value"><?php echo e($order->customer_address ?? $order->user->alamat ?? 'Belum diisi'); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-sticky-note"></i>
                        Catatan
                    </div>
                    <div class="info-value"><?php echo e($order->customer_notes ?? 'Tidak ada catatan'); ?></div>
                </div>
            </div>
        </div>


    </div>

    <!-- Pickup Point Information (for Ready status) -->
    <?php if($order->status === 'Ready' || $order->status === 'Completed'): ?>
    <div class="info-card" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 2px solid #10b981;">
        <h3 class="card-title" style="color: #047857;">
            <i class="fas fa-map-marked-alt"></i>
            Informasi Pengambilan Pesanan
        </h3>
        <div id="pickupLoadingSection" style="text-align: center; padding: 20px;">
            <i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #047857;"></i>
            <p style="margin-top: 10px; color: #047857;">Mencari titik pengambilan terdekat...</p>
        </div>
        <div id="pickupInfoSection" style="display: none;">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>
    <?php endif; ?>

    <!-- Products Ordered -->
    <div class="products-section">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i>
            Produk yang Dipesan
        </h3>
        
        <?php
            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
            $calculatedSubtotal = 0;
            
            // Debug: Log items structure (remove in production)
            if (config('app.debug')) {
                \Log::debug('Order Items Structure', [
                    'order_id' => $order->id,
                    'items' => $items,
                    'order_subtotal' => $order->subtotal ?? 'NULL',
                    'order_total' => $order->total_amount ?? 'NULL'
                ]);
            }
        ?>

        <?php if(is_array($items) && count($items) > 0): ?>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Use unit_price if available, otherwise fallback to price
                    $unitPrice = $item['unit_price'] ?? $item['price'] ?? 0;
                    $quantity = $item['quantity'] ?? 0;
                    
                    // Use subtotal from item if available, otherwise calculate
                    $itemSubtotal = $item['subtotal'] ?? ($unitPrice * $quantity);
                    $calculatedSubtotal += $itemSubtotal;
                ?>
                <div class="product-item">
                    <div class="product-image">
                        <?php if(($item['type'] ?? '') === 'pupuk'): ?>
                            <i class="fas fa-seedling"></i>
                        <?php else: ?>
                            <i class="fas fa-leaf"></i>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h4><?php echo e($item['product_name'] ?? 'Produk'); ?></h4>
                        <p class="product-meta">
                            <span style="background: #e0e7ff; color: #5b21b6; padding: 3px 10px; border-radius: 5px; font-weight: 600;">
                                <?php echo e(ucfirst($item['type'] ?? 'N/A')); ?>

                            </span>
                            <span style="margin-left: 10px;"><?php echo e($item['category'] ?? 'N/A'); ?></span>
                        </p>
                        <p class="product-quantity">
                            <i class="fas fa-box"></i> Jumlah: <?php echo e($quantity); ?> kg
                        </p>
                    </div>
                    <div class="product-price">
                        <div class="product-subtotal">
                            Rp <?php echo e(number_format($itemSubtotal, 0, ',', '.')); ?>

                        </div>
                        <div class="product-unit-price">
                            @ Rp <?php echo e(number_format($unitPrice, 0, ',', '.')); ?>/kg
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Total Section -->
            <?php
                // Use order subtotal from DB if calculated is 0, otherwise use calculated
                $finalSubtotal = $calculatedSubtotal > 0 ? $calculatedSubtotal : ($order->subtotal ?? 0);
            ?>
            <div class="total-section">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">Rp <?php echo e(number_format($finalSubtotal, 0, ',', '.')); ?></span>
                </div>
                <div class="total-row">
                    <span class="total-label">Ongkos Kirim</span>
                    <span class="total-value">Rp 0</span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Total Pembayaran</span>
                    <span class="total-value">Rp <?php echo e(number_format($order->total_amount ?? 0, 0, ',', '.')); ?></span>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #6b7280; padding: 40px;">
                <i class="fas fa-inbox" style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
                Tidak ada produk dalam pesanan ini
            </p>
        <?php endif; ?>
    </div>

    <!-- Rejection Reason (if rejected) -->
    <?php if($order->status === 'Rejected' && $order->rejection_reason): ?>
    <div class="rejection-section">
        <div class="rejection-title">
            <i class="fas fa-exclamation-triangle"></i>
            Alasan Penolakan
        </div>
        <p class="rejection-reason"><?php echo e($order->rejection_reason); ?></p>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="action-section">
        <h3 class="card-title">
            <i class="fas fa-cogs"></i>
            Kelola Pesanan
        </h3>
        <div class="action-buttons">
            <?php if($order->status === 'Pending'): ?>
                <button class="btn btn-processing" onclick="updateStatus('Processing')">
                    <i class="fas fa-spinner"></i>
                    Proses Pesanan
                </button>
                <button class="btn btn-reject" onclick="rejectOrder()">
                    <i class="fas fa-times-circle"></i>
                    Tolak Pesanan
                </button>
            <?php elseif($order->status === 'Processing'): ?>
                <button class="btn btn-ready" onclick="updateStatus('Ready')">
                    <i class="fas fa-check"></i>
                    Siap Diambil
                </button>
                <button class="btn btn-reject" onclick="rejectOrder()">
                    <i class="fas fa-times-circle"></i>
                    Tolak Pesanan
                </button>
            <?php elseif($order->status === 'Ready'): ?>
                <button class="btn btn-complete" onclick="updateStatus('Completed')">
                    <i class="fas fa-check-double"></i>
                    Selesaikan Pesanan
                </button>
            <?php endif; ?>
            
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i>
                Cetak Detail
            </button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Load nearest pickup point for Ready orders
    <?php if($order->status === 'Ready' || $order->status === 'Completed'): ?>
    document.addEventListener('DOMContentLoaded', function() {
        loadNearestPickupForAdmin();
    });

    function loadNearestPickupForAdmin() {
        const customerAddress = '<?php echo e($order->customer_address ?? $order->user->alamat ?? ""); ?>';
        const loadingSection = document.getElementById('pickupLoadingSection');
        const infoSection = document.getElementById('pickupInfoSection');
        
        console.log('🔍 Loading pickup points for admin...');
        console.log('📍 Customer Address:', customerAddress);
        
        // Define different coordinates for different areas in Laguboti
        // These are realistic coordinates with proper distances (3-8 km from IT Del)
        const areaCoordinates = {
            'flyover': { lat: 2.5950, lng: 99.0300, name: 'Area Flyover Laguboti' },        // ~6-7 km
            'pasar': { lat: 2.5800, lng: 99.0450, name: 'Area Pasar Laguboti' },           // ~5-6 km
            'pantai': { lat: 2.6400, lng: 99.1200, name: 'Area Pantai' },                   // ~7-8 km
            'desa': { lat: 2.5700, lng: 99.0600, name: 'Area Desa' },                       // ~5 km
            'kota': { lat: 2.5900, lng: 99.0500, name: 'Area Kota Laguboti' },             // ~4-5 km
            'default': { lat: 2.5850, lng: 99.0550, name: 'Area Laguboti Umum' }           // ~4 km
        };
        
        // Determine customer coordinates based on address keywords
        let customerCoords = areaCoordinates.default;
        const addressLower = customerAddress.toLowerCase();
        
        if (addressLower.includes('flyover')) {
            customerCoords = areaCoordinates.flyover;
            console.log('✅ Detected Flyover area');
        } else if (addressLower.includes('pasar')) {
            customerCoords = areaCoordinates.pasar;
            console.log('✅ Detected Pasar area');
        } else if (addressLower.includes('pantai')) {
            customerCoords = areaCoordinates.pantai;
            console.log('✅ Detected Pantai area');
        } else if (addressLower.includes('desa') || addressLower.includes('balai')) {
            customerCoords = areaCoordinates.desa;
            console.log('✅ Detected Desa area');
        } else if (addressLower.includes('kota')) {
            customerCoords = areaCoordinates.kota;
            console.log('✅ Detected Kota area');
        } else {
            console.log('ℹ Using default Laguboti coordinates');
        }
        
        console.log('📍 Customer coordinates:', customerCoords);
        console.log('📍 Area name:', customerCoords.name);
        
        // Now fetch nearest pickup point with determined coordinates
        fetchNearestPickup(customerCoords.lat, customerCoords.lng, customerAddress, loadingSection, infoSection);
    }
    
    function fetchNearestPickup(lat, lng, customerAddress, loadingSection, infoSection) {
        console.log('📍 Fetching nearest pickup with coordinates:', { lat, lng });
        console.log('📍 Customer address:', customerAddress);

        fetch('/api/nearest-pickup', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ lat, lng })
        })
        .then(response => response.json())
        .then(data => {
            console.log('✅ Received data from API:', data);
            
            loadingSection.style.display = 'none';
            infoSection.style.display = 'block';
            
            if (data.nearest_location) {
                const nearest = data.nearest_location;
                const distance = nearest.distance.toFixed(2);
                const mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${lat},${lng}&destination=${nearest.latitude},${nearest.longitude}&travelmode=driving`;                
                console.log('🗺 Google Maps URL:', mapsUrl);
                console.log('📍 Origin (Customer):', { lat, lng });
                console.log('📍 Destination (Pickup):', { lat: nearest.latitude, lng: nearest.longitude });
                console.log('📏 Distance:', distance, 'km');
                
                infoSection.innerHTML = `
                    <div class="info-grid" style="background: white; padding: 20px; border-radius: 10px;">
                        <div class="info-item" style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 2px dashed #e5e7eb;">
                            <span class="info-label" style="font-weight: 600; color: #6366f1;">
                                <i class="fas fa-home"></i> Alamat Customer:
                            </span>
                            <span class="info-value" style="display: block; margin-top: 5px; color: #374151;">
                                ${customerAddress || 'Alamat tidak tersedia'}
                            </span>
                            <span class="info-value" style="display: block; margin-top: 5px; color: #6b7280; font-size: 12px;">
                                📍 Koordinat: ${lat.toFixed(4)}, ${lng.toFixed(4)}
                            </span>
                        </div>
                        <div class="info-item" style="margin-bottom: 15px;">
                            <span class="info-label" style="font-weight: 600; color: #047857;">
                                <i class="fas fa-building"></i> Titik Pengambilan Terdekat:
                            </span>
                            <span class="info-value" style="font-size: 18px; font-weight: 700; color: #047857; display: block; margin-top: 5px;">
                                ${nearest.name}
                            </span>
                        </div>
                        <div class="info-item" style="margin-bottom: 15px;">
                            <span class="info-label" style="font-weight: 600;">
                                <i class="fas fa-map-marker-alt"></i> Alamat Pickup Point:
                            </span>
                            <span class="info-value" style="display: block; margin-top: 5px;">
                                ${nearest.address}
                            </span>
                            <span class="info-value" style="display: block; margin-top: 5px; color: #6b7280; font-size: 12px;">
                                📍 Koordinat: ${nearest.latitude}, ${nearest.longitude}
                            </span>
                        </div>
                        <div class="info-item" style="margin-bottom: 15px;">
                            <span class="info-label" style="font-weight: 600;">
                                <i class="fas fa-route"></i> Jarak dari Customer:
                            </span>
                            <span class="info-value" style="color: #ea580c; font-weight: 700; display: block; margin-top: 5px;">
                                ${distance} km
                            </span>
                        </div>
                        <div class="info-item" style="margin-bottom: 15px;">
                            <span class="info-label" style="font-weight: 600;">
                                <i class="fas fa-credit-card"></i> Metode Pembayaran:
                            </span>
                            <span class="info-value" style="display: block; margin-top: 5px;">
                                Tunai di Lokasi
                            </span>
                        </div>
                        <div style="margin-top: 20px;">
                            <a href="${mapsUrl}" target="_blank" style="display: inline-flex; align-items: center; gap: 10px; padding: 12px 24px; background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);">
                                <i class="fab fa-google"></i> Buka Rute di Google Maps
                            </a>
                        </div>
                    </div>
                `;
            } else {
                infoSection.innerHTML = `
                    <div style="padding: 20px; text-align: center; color: #6b7280;">
                        <i class="fas fa-info-circle"></i> Titik pengambilan belum tersedia
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('❌ Error loading pickup points:', error);
            loadingSection.style.display = 'none';
            infoSection.style.display = 'block';
            infoSection.innerHTML = `
                <div style="padding: 20px; text-align: center; color: #ef4444;">
                    <i class="fas fa-exclamation-triangle"></i> Gagal memuat informasi pengambilan
                    <p style="font-size: 12px; margin-top: 10px;">Error: ${error.message}</p>
                </div>
            `;
        });
    }
    <?php endif; ?>

    function updateStatus(newStatus) {
        if (!confirm(`Apakah Anda yakin ingin mengubah status pesanan menjadi "${newStatus}"?`)) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(/admin/orders/<?php echo e($order->order_number); ?>/status, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Status pesanan berhasil diupdate!');
                location.reload();
            } else {
                alert('❌ Gagal mengupdate status: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat mengupdate status');
        });
    }

    function rejectOrder() {
        const reason = prompt('Masukkan alasan penolakan:');
        
        if (!reason || reason.trim() === '') {
            alert('❌ Alasan penolakan harus diisi!');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(/admin/api/orders/<?php echo e($order->order_number); ?>/status, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                status: 'Rejected',
                rejection_reason: reason.trim()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Pesanan berhasil ditolak!');
                location.reload();
            } else {
                alert('❌ Gagal menolak pesanan: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat menolak pesanan');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/admin/orders/detail.blade.php ENDPATH**/ ?>