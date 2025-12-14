

<?php $__env->startSection('title', 'Lokasi Pengambilan - ' . $order->order_number); ?>

<?php $__env->startPush('styles'); ?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f5f1 100%);
        font-family: 'Inter', Arial, sans-serif;
        color: #333;
    }

    .maps-container {
        max-width: 1200px;
        margin: 100px auto 50px;
        padding: 0 20px;
    }

    .back-button {
        margin-bottom: 20px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: white;
        color: #2e7d32;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #2e7d32;
        color: white;
        transform: translateX(-3px);
        box-shadow: 0 5px 18px rgba(46, 125, 50, 0.2);
    }

    .map-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(76, 175, 80, 0.1);
    }

    .map-header {
        background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%);
        padding: 30px;
        color: white;
    }

    .map-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .map-title i {
        font-size: 28px;
    }

    .order-number {
        font-size: 16px;
        opacity: 0.95;
        font-weight: 600;
    }

    .map-content {
        padding: 0;
    }

    .info-section {
        padding: 25px 30px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-bottom: 2px solid #10b981;
    }

    .info-title {
        font-size: 14px;
        font-weight: 600;
        color: #065f46;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.6;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .info-value i {
        color: #10b981;
        margin-top: 3px;
        font-size: 18px;
    }

    #map {
        width: 100%;
        height: 500px;
        position: relative;
        background: #f3f4f6;
    }

    .instructions-section {
        padding: 30px;
        background: white;
    }

    .instructions-title {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .instructions-title i {
        color: #10b981;
        font-size: 22px;
    }

    .instruction-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .instruction-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 10px;
        margin-bottom: 12px;
        border-left: 4px solid #10b981;
    }

    .instruction-item:last-child {
        margin-bottom: 0;
    }

    .instruction-number {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .instruction-text {
        flex: 1;
        font-size: 14px;
        line-height: 1.6;
        color: #374151;
    }

    .action-buttons {
        padding: 25px 30px;
        background: #f9fafb;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-action {
        flex: 1;
        min-width: 200px;
        padding: 14px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-directions {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-directions:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-call {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-call:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .maps-container {
            margin: 90px auto 40px;
            padding: 0 15px;
        }

        .map-header {
            padding: 25px;
        }

        .map-title {
            font-size: 20px;
        }

        #map {
            height: 400px;
        }

        .info-section,
        .instructions-section,
        .action-buttons {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            min-width: auto;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="maps-container">
    <!-- Back Button -->
    <div class="back-button">
        <a href="<?php echo e(route('notifikasi')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Notifikasi</span>
        </a>
    </div>

    <!-- Map Card -->
    <div class="map-card">
        <!-- Header -->
        <div class="map-header">
            <h1 class="map-title">
                <i class="fas fa-map-marked-alt"></i>
                Lokasi Pengambilan Pesanan
            </h1>
            <p class="order-number"><?php echo e($order->order_number); ?></p>
        </div>

        <!-- Pickup Address Info -->
        <div class="info-section">
            <div class="info-title">
                <i class="fas fa-building"></i> Balai Desa
            </div>
            <div class="info-value">
                <i class="fas fa-map-marker-alt"></i>
                <span><?php echo e($pickupAddress); ?></span>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="map-content">
            <div id="map"></div>
        </div>

        <!-- Instructions -->
        <div class="instructions-section">
            <h3 class="instructions-title">
                <i class="fas fa-info-circle"></i>
                Cara Pengambilan Pesanan
            </h3>
            <ul class="instruction-list">
                <li class="instruction-item">
                    <span class="instruction-number">1</span>
                    <span class="instruction-text">
                        <strong>Lihat Lokasi:</strong> Pin merah di peta menunjukkan lokasi Balai Desa untuk pengambilan pesanan Anda.
                    </span>
                </li>
                <li class="instruction-item">
                    <span class="instruction-number">2</span>
                    <span class="instruction-text">
                        <strong>Buka Google Maps:</strong> Klik tombol "Buka di Google Maps" di bawah untuk mendapatkan rute perjalanan dari lokasi Anda.
                    </span>
                </li>
                <li class="instruction-item">
                    <span class="instruction-number">3</span>
                    <span class="instruction-text">
                        <strong>Bawa Identitas:</strong> Jangan lupa membawa KTP dan konfirmasi pesanan saat pengambilan.
                    </span>
                </li>
                <li class="instruction-item">
                    <span class="instruction-number">4</span>
                    <span class="instruction-text">
                        <strong>Jam Operasional:</strong> Balai Desa buka Senin-Jumat, 08:00 - 16:00 WIB.
                    </span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="#" id="btnGoogleMaps" class="btn-action btn-directions" target="_blank">
                <i class="fab fa-google"></i>
                Buka di Google Maps
            </a>
            <a href="tel:+62123456789" class="btn-action btn-call">
                <i class="fas fa-phone-alt"></i>
                Hubungi Balai Desa
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    'use strict';
    
    const config = {
        pickupAddress: <?php echo json_encode($pickupAddress, 15, 512) ?>,
        orderNumber: <?php echo json_encode($order->order_number, 15, 512) ?>,
        googleMapsKey: <?php echo json_encode($googleMapsKey, 15, 512) ?>,
        defaultCenter: { lat: -6.2088, lng: 106.8456 }
    };

    let map;
    let geocoder;
    let pickupMarker;

    // Initialize Google Maps
    function initMap() {
        console.log('🗺️ Initializing Google Maps...');
        
        try {
            // Create map
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: config.defaultCenter,
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true,
                zoomControl: true
            });

            geocoder = new google.maps.Geocoder();
            
            // Geocode address
            geocodePickupAddress();
            
        } catch (error) {
            console.error('❌ Error initializing map:', error);
            showMapError();
        }
    }

    // Geocode pickup address
    function geocodePickupAddress() {
        console.log('📍 Geocoding address:', config.pickupAddress);
        
        geocoder.geocode({ 
            address: config.pickupAddress + ', Indonesia'
        }, function(results, status) {
            if (status === 'OK' && results[0]) {
                const location = results[0].geometry.location;
                console.log('✅ Location found:', location.toString());
                
                // Center map
                map.setCenter(location);
                map.setZoom(15);
                
                // Add marker
                pickupMarker = new google.maps.Marker({
                    map: map,
                    position: location,
                    title: 'Lokasi Pengambilan - Balai Desa',
                    animation: google.maps.Animation.DROP,
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        scaledSize: new google.maps.Size(50, 50)
                    }
                });
                
                // Info window
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="padding: 15px; font-family: Arial;">
                            <h3 style="margin: 0 0 10px 0; color: #065f46; font-size: 16px;">
                                🏛️ Balai Desa
                            </h3>
                            <p style="margin: 0 0 8px 0; font-size: 14px; color: #374151; line-height: 1.5;">
                                ${config.pickupAddress}
                            </p>
                            <p style="margin: 0; font-size: 13px; color: #6b7280;">
                                <strong>Order:</strong> ${config.orderNumber}
                            </p>
                        </div>
                    `
                });
                
                pickupMarker.addListener('click', function() {
                    infoWindow.open(map, pickupMarker);
                });
                
                // Auto open info window
                setTimeout(function() {
                    infoWindow.open(map, pickupMarker);
                }, 500);
                
                // Update Google Maps button
                updateDirectionsButton(location.lat(), location.lng());
                
            } else {
                console.error('❌ Geocoding failed:', status);
                // Use default location
                pickupMarker = new google.maps.Marker({
                    map: map,
                    position: config.defaultCenter,
                    title: config.pickupAddress,
                    animation: google.maps.Animation.DROP
                });
                updateDirectionsButton(config.defaultCenter.lat, config.defaultCenter.lng);
            }
        });
    }

    // Update directions button
    function updateDirectionsButton(lat, lng) {
        const btn = document.getElementById('btnGoogleMaps');
        if (btn) {
            btn.href = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=driving`;
            console.log('✅ Directions button updated');
        }
    }

    // Show error message
    function showMapError() {
        const mapDiv = document.getElementById('map');
        if (mapDiv) {
            mapDiv.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: #fee2e2; color: #991b1b; padding: 40px; text-align: center;">
                    <div>
                        <i class="fas fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 20px;"></i>
                        <h3 style="margin: 0 0 10px 0;">Gagal Memuat Peta</h3>
                        <p style="margin: 0;">Silakan gunakan tombol "Buka di Google Maps" di bawah.</p>
                    </div>
                </div>
            `;
        }
    }

    // Load Google Maps API
    function loadGoogleMaps() {
        if (!config.googleMapsKey) {
            console.error('❌ No Google Maps API key');
            showMapError();
            return;
        }

        // Check if already loaded
        if (window.google && window.google.maps) {
            initMap();
            return;
        }

        window.initMap = initMap;

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${config.googleMapsKey}&callback=initMap`;
        script.async = true;
        script.defer = true;
        script.onerror = function() {
            console.error('❌ Failed to load Google Maps script');
            showMapError();
        };
        
        document.head.appendChild(script);
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadGoogleMaps);
    } else {
        loadGoogleMaps();
    }
})();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'Lokasi Pengambilan - ' . $order->order_number); ?>

<?php $__env->startPush('styles'); ?>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f5f1 100%);
        font-family: 'Inter', Arial, sans-serif;
        color: #333;
    }

    .maps-container {
        max-width: 1200px;
        margin: 100px auto 50px;
        padding: 0 20px;
    }

    .back-button {
        margin-bottom: 20px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: white;
        color: #2e7d32;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #2e7d32;
        color: white;
        transform: translateX(-3px);
        box-shadow: 0 5px 18px rgba(46, 125, 50, 0.2);
    }

    .map-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(76, 175, 80, 0.1);
    }

    .map-header {
        background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%);
        padding: 30px;
        color: white;
    }

    .map-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .map-title i {
        font-size: 28px;
    }

    .order-number {
        font-size: 16px;
        opacity: 0.95;
        font-weight: 600;
    }

    .map-content {
        padding: 0;
    }

    .info-section {
        padding: 25px 30px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border-bottom: 2px solid #10b981;
    }

    .info-title {
        font-size: 14px;
        font-weight: 600;
        color: #065f46;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.6;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .info-value i {
        color: #10b981;
        margin-top: 3px;
        font-size: 18px;
    }

    #map {
        width: 100%;
        height: 500px;
        position: relative;
    }

    .map-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 1000;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .map-loading i {
        font-size: 48px;
        color: #10b981;
        margin-bottom: 15px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .map-loading p {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    .instructions-section {
        padding: 30px;
        background: white;
    }

    .instructions-title {
        font-size: 18px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .instructions-title i {
        color: #10b981;
        font-size: 22px;
    }

    .instruction-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .instruction-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px;
        background: #f9fafb;
        border-radius: 10px;
        margin-bottom: 12px;
        border-left: 4px solid #10b981;
    }

    .instruction-item:last-child {
        margin-bottom: 0;
    }

    .instruction-number {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .instruction-text {
        flex: 1;
        font-size: 14px;
        line-height: 1.6;
        color: #374151;
    }

    .action-buttons {
        padding: 25px 30px;
        background: #f9fafb;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-action {
        flex: 1;
        min-width: 200px;
        padding: 14px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-directions {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-directions:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-call {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-call:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .maps-container {
            margin: 90px auto 40px;
            padding: 0 15px;
        }

        .map-header {
            padding: 25px;
        }

        .map-title {
            font-size: 20px;
        }

        #map {
            height: 400px;
        }

        .info-section,
        .instructions-section,
        .action-buttons {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            min-width: auto;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="maps-container">
    <!-- Back Button -->
    <div class="back-button">
        <a href="<?php echo e(route('notifikasi')); ?>" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Notifikasi</span>
        </a>
    </div>

    <!-- Map Card -->
    <div class="map-card">
        <!-- Header -->
        <div class="map-header">
            <h1 class="map-title">
                <i class="fas fa-map-marked-alt"></i>
                Lokasi Pengambilan Pesanan
            </h1>
            <p class="order-number"><?php echo e($order->order_number); ?></p>
        </div>

        <!-- Pickup Address Info -->
        <div class="info-section">
            <div class="info-title">
                <i class="fas fa-building"></i> Balai Desa
            </div>
            <div class="info-value">
                <i class="fas fa-map-marker-alt"></i>
                <span><?php echo e($pickupAddress); ?></span>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="map-content">
            <div id="map">
                <div id="mapLoading" class="map-loading">
                    <i class="fas fa-spinner"></i>
                    <p>Memuat peta lokasi pengambilan...</p>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="instructions-section">
            <h3 class="instructions-title">
                <i class="fas fa-info-circle"></i>
                Cara Pengambilan Pesanan
            </h3>
            <ul class="instruction-list">
                <li class="instruction-item">
                    <span class="instruction-number">1</span>
                    <span class="instruction-text">
                        <strong>Lihat Lokasi:</strong> Pin merah di peta menunjukkan lokasi Balai Desa untuk pengambilan pesanan Anda.
                    </span>
                </li>
                <li class="instruction-item">
                    <span class="instruction-number">2</span>
                    <span class="instruction-text">
                        <strong>Buka Google Maps:</strong> Klik tombol "Buka di Google Maps" di bawah untuk mendapatkan rute perjalanan dari lokasi Anda.
                    </span>
                </li>
                <li class="instruction-item">
                    <span class="instruction-number">3</span>
                    <span class="instruction-text">
                        <strong>Bawa Identitas:</strong> Jangan lupa membawa KTP dan konfirmasi pesanan saat pengambilan.
                    </span>
                </li>
                <li class="instruction-item">
                    <span class="instruction-number">4</span>
                    <span class="instruction-text">
                        <strong>Jam Operasional:</strong> Balai Desa buka Senin-Jumat, 08:00 - 16:00 WIB.
                    </span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="#" id="btnGoogleMaps" class="btn-action btn-directions" target="_blank">
                <i class="fab fa-google"></i>
                Buka di Google Maps
            </a>
            <a href="tel:+62123456789" class="btn-action btn-call">
                <i class="fas fa-phone-alt"></i>
                Hubungi Balai Desa
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<!-- Leaflet CSS (fallback) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Leaflet JS (fallback) -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
    // Configuration
    const pickupAddress = <?php echo json_encode($pickupAddress, 15, 512) ?>;
    const orderNumber = <?php echo json_encode($order->order_number, 15, 512) ?>;
    const googleMapsKey = <?php echo json_encode($googleMapsKey, 15, 512) ?>;

    let map;
    let pickupMarker;
    let userMarker;
    let useLeaflet = false; // Flag untuk fallback ke Leaflet

    // Initialize Google Maps
    function initMap() {
        console.log('🗺️ Initializing Google Maps...');
        
        // Hide loading indicator
        const loadingEl = document.getElementById('mapLoading');
        if (loadingEl) {
            loadingEl.style.display = 'none';
        }

        // Check if Google Maps loaded successfully
        if (typeof google === 'undefined' || !google.maps) {
            console.warn('⚠️ Google Maps failed to load, using Leaflet fallback');
            useLeaflet = true;
            initLeafletMap();
            return;
        }

        // Default location (Indonesia - Jakarta)
        const defaultLocation = { lat: -6.2088, lng: 106.8456 };

        // Initialize map
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: defaultLocation,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true,
            zoomControl: true
        });

        // Initialize directions service
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            suppressMarkers: true
        });

        // Geocode pickup address
        geocodeAddressGoogle(directionsService, directionsRenderer);

        // Get user's current location
        getUserLocationGoogle(directionsService, directionsRenderer);
    }

    // Leaflet fallback initialization
    function initLeafletMap() {
        console.log('🗺️ Initializing Leaflet (OpenStreetMap)...');
        
        const defaultLocation = [-6.2088, 106.8456];
        
        // Initialize Leaflet map
        map = L.map('map').setView(defaultLocation, 13);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(map);
        
        // Custom red marker icon
        const redIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
        
        // Geocode with Nominatim
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(pickupAddress + ', Indonesia')}&limit=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    
                    map.setView([lat, lon], 15);
                    
                    pickupMarker = L.marker([lat, lon], {icon: redIcon})
                        .addTo(map)
                        .bindPopup(`
                            <div style="padding: 10px;">
                                <h3 style="margin: 0 0 8px 0; color: #065f46; font-size: 16px;">
                                    <i class="fas fa-building"></i> Balai Desa
                                </h3>
                                <p style="margin: 0 0 8px 0; font-size: 13px;">${pickupAddress}</p>
                                <p style="margin: 0; font-size: 12px; color: #6b7280;">
                                    <strong>Order:</strong> ${orderNumber}
                                </p>
                            </div>
                        `)
                        .openPopup();
                    
                    // Update Google Maps link
                    updateGoogleMapsLink(lat, lon);
                    
                    console.log('✅ Pickup location marked (Leaflet)');
                } else {
                    console.warn('⚠️ No coordinates found');
                    L.marker(defaultLocation, {icon: redIcon})
                        .addTo(map)
                        .bindPopup(`<b>Lokasi</b><br>${pickupAddress}`)
                        .openPopup();
                }
            })
            .catch(error => {
                console.error('❌ Geocoding error:', error);
            });
        
        // Get user location for Leaflet
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = [position.coords.latitude, position.coords.longitude];
                    
                    const blueIcon = L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });
                    
                    userMarker = L.marker(userLocation, {icon: blueIcon})
                        .addTo(map)
                        .bindPopup('<b>Lokasi Anda</b>')
                        .openPopup();
                    
                    console.log('✅ User location marked (Leaflet)');
                },
                (error) => {
                    console.warn('⚠️ Could not get user location:', error.message);
                }
            );
        }
    }

    // Geocode address with Google
    function geocodeAddressGoogle(directionsService, directionsRenderer) {
        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 
            address: pickupAddress + ', Indonesia' 
        }, (results, status) => {
            if (status === 'OK') {
                const location = results[0].geometry.location;
                
                // Center map on pickup location
                map.setCenter(location);
                map.setZoom(15);

                // Add pickup marker (red)
                pickupMarker = new google.maps.Marker({
                    map: map,
                    position: location,
                    title: 'Lokasi Pengambilan',
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        scaledSize: new google.maps.Size(40, 40)
                    },
                    animation: google.maps.Animation.DROP
                });

                // Info window for pickup location
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="padding: 10px; max-width: 250px;">
                            <h3 style="margin: 0 0 8px 0; color: #065f46; font-size: 16px;">
                                <i class="fas fa-building"></i> Balai Desa
                            </h3>
                            <p style="margin: 0 0 8px 0; font-size: 13px; color: #374151;">
                                ${pickupAddress}
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #6b7280;">
                                <strong>Order:</strong> ${orderNumber}
                            </p>
                        </div>
                    `
                });

                pickupMarker.addListener('click', () => {
                    infoWindow.open(map, pickupMarker);
                });

                // Open info window by default
                infoWindow.open(map, pickupMarker);

                // Update Google Maps button
                updateGoogleMapsLink(location.lat(), location.lng());

                console.log('✅ Pickup location marked successfully');
            } else {
                console.error('❌ Geocoding failed:', status);
                alert('Gagal menemukan lokasi pengambilan. Mohon coba lagi.');
            }
        });
    }

    // Geocode address with Google
    function geocodeAddressGoogle(directionsService, directionsRenderer) {
        const geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 
            address: pickupAddress + ', Indonesia' 
        }, (results, status) => {
            if (status === 'OK') {
                const location = results[0].geometry.location;
                
                // Center map on pickup location
                map.setCenter(location);
                map.setZoom(15);

                // Add pickup marker (red)
                pickupMarker = new google.maps.Marker({
                    map: map,
                    position: location,
                    title: 'Lokasi Pengambilan',
                    icon: {
                        url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                        scaledSize: new google.maps.Size(40, 40)
                    },
                    animation: google.maps.Animation.DROP
                });

                // Info window for pickup location
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="padding: 10px; max-width: 250px;">
                            <h3 style="margin: 0 0 8px 0; color: #065f46; font-size: 16px;">
                                <i class="fas fa-building"></i> Balai Desa
                            </h3>
                            <p style="margin: 0 0 8px 0; font-size: 13px; color: #374151;">
                                ${pickupAddress}
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #6b7280;">
                                <strong>Order:</strong> ${orderNumber}
                            </p>
                        </div>
                    `
                });

                pickupMarker.addListener('click', () => {
                    infoWindow.open(map, pickupMarker);
                });

                // Open info window by default
                infoWindow.open(map, pickupMarker);

                // Update Google Maps button
                updateGoogleMapsLink(location.lat(), location.lng());

                console.log('✅ Pickup location marked successfully');
            } else {
                console.error('❌ Geocoding failed:', status);
                alert('Gagal menemukan lokasi pengambilan. Mohon coba lagi.');
            }
        });
    }

    // Get user's current location for Google Maps
    function getUserLocationGoogle(directionsService, directionsRenderer) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Add user marker (blue)
                    userMarker = new google.maps.Marker({
                        map: map,
                        position: userLocation,
                        title: 'Lokasi Anda',
                        icon: {
                            url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                            scaledSize: new google.maps.Size(40, 40)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    const userInfoWindow = new google.maps.InfoWindow({
                        content: `
                            <div style="padding: 10px;">
                                <h3 style="margin: 0 0 5px 0; color: #1e40af; font-size: 14px;">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi Anda
                                </h3>
                            </div>
                        `
                    });

                    userMarker.addListener('click', () => {
                        userInfoWindow.open(map, userMarker);
                    });

    // Get user's current location for Google Maps
    function getUserLocationGoogle(directionsService, directionsRenderer) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Add user marker (blue)
                    userMarker = new google.maps.Marker({
                        map: map,
                        position: userLocation,
                        title: 'Lokasi Anda',
                        icon: {
                            url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                            scaledSize: new google.maps.Size(40, 40)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    const userInfoWindow = new google.maps.InfoWindow({
                        content: `
                            <div style="padding: 10px;">
                                <h3 style="margin: 0 0 5px 0; color: #1e40af; font-size: 14px;">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi Anda
                                </h3>
                            </div>
                        `
                    });

                    userMarker.addListener('click', () => {
                        userInfoWindow.open(map, userMarker);
                    });

                    console.log('✅ User location marked successfully');

                    // Calculate route if pickup marker exists
                    if (pickupMarker) {
                        calculateRoute(userLocation, pickupMarker.getPosition(), directionsService, directionsRenderer);
                    }
                },
                (error) => {
                    console.warn('⚠️ Could not get user location:', error.message);
                }
            );
        }
    }

    // Calculate route between two points
    function calculateRoute(origin, destination, directionsService, directionsRenderer) {
        const request = {
            origin: origin,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        };

        directionsService.route(request, (result, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
                console.log('✅ Route calculated successfully');
            } else {
                console.warn('⚠️ Could not calculate route:', status);
            }
        });
    }

    // Update Google Maps link
    function updateGoogleMapsLink(lat, lng) {
        const btnGoogleMaps = document.getElementById('btnGoogleMaps');
        if (btnGoogleMaps) {
            // Link to Google Maps with directions
            btnGoogleMaps.href = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
        }
    }

    // Load Google Maps script with error handling
    function loadGoogleMaps() {
        if (!googleMapsKey || googleMapsKey === '') {
            console.warn('⚠️ No Google Maps API key, using Leaflet fallback');
            useLeaflet = true;
            initLeafletMap();
            return;
        }

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${googleMapsKey}&callback=initMap&libraries=places`;
        script.async = true;
        script.defer = true;
        
        // Error handling for script loading
        script.onerror = function() {
            console.error('❌ Failed to load Google Maps, using Leaflet fallback');
            useLeaflet = true;
            initLeafletMap();
        };
        
        document.head.appendChild(script);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        // Hide loading indicator after a delay if maps don't load
        setTimeout(() => {
            const loadingEl = document.getElementById('mapLoading');
            if (loadingEl && loadingEl.style.display !== 'none') {
                loadingEl.style.display = 'none';
                if (!useLeaflet && typeof google === 'undefined') {
                    console.warn('⚠️ Google Maps timeout, using Leaflet fallback');
                    useLeaflet = true;
                    initLeafletMap();
                }
            }
        }, 5000);
        
        loadGoogleMaps();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/user/maps/show.blade.php ENDPATH**/ ?>