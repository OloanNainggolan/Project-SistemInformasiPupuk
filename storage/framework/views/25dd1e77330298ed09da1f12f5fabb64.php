<?php $__env->startSection('title', 'Lokasi Pengambilan Pesanan'); ?>

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

    .page-container {
        max-width: 1200px;
        margin: 100px auto 40px;
        padding: 0 20px;
    }

    .back-button {
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
        margin-bottom: 25px;
    }

    .back-button:hover {
        background: #2e7d32;
        color: white;
        transform: translateX(-3px);
        box-shadow: 0 5px 18px rgba(46, 125, 50, 0.2);
    }

    .page-header {
        background: white;
        border-radius: 16px;
        padding: 25px 30px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border-left: 5px solid #4CAF50;
    }

    .page-header h1 {
        font-size: 1.8rem;
        color: #2e7d32;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header p {
        color: #666;
        font-size: 0.95rem;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    @media (max-width: 968px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        height: fit-content;
    }

    .info-card h3 {
        font-size: 1.3rem;
        color: #2e7d32;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .order-info {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 20px;
    }

    .order-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid rgba(46, 125, 50, 0.1);
    }

    .order-info-item:last-child {
        border-bottom: none;
    }

    .order-info-label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .order-info-value {
        font-size: 0.95rem;
        color: #2e7d32;
        font-weight: 600;
    }

    .pickup-info {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .pickup-title {
        font-size: 1.1rem;
        color: #e65100;
        font-weight: 700;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pickup-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }

    .pickup-address {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .distance-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: white;
        color: #e65100;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(230, 81, 0, 0.2);
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(76, 175, 80, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #2e7d32;
        border: 2px solid #4CAF50;
    }

    .btn-secondary:hover {
        background: #e8f5e9;
    }

    .map-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        height: 600px;
        position: relative;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    .map-legend {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
    }

    .map-legend-title {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 10px;
        color: #333;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 0.85rem;
    }

    .legend-item:last-child {
        margin-bottom: 0;
    }

    .legend-marker {
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }

    .marker-user {
        background: #2196F3;
        border: 3px solid white;
        box-shadow: 0 2px 6px rgba(33, 150, 243, 0.5);
    }

    .marker-nearest {
        background: #4CAF50;
        border: 3px solid white;
        box-shadow: 0 2px 6px rgba(76, 175, 80, 0.5);
    }

    .marker-other {
        background: #FF9800;
        border: 3px solid white;
        box-shadow: 0 2px 6px rgba(255, 152, 0, 0.5);
    }

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.95rem;
    }

    .alert-info {
        background: #e3f2fd;
        color: #1976d2;
        border-left: 4px solid #2196F3;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 15px;
        z-index: 2000;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #e0e0e0;
        border-top-color: #4CAF50;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .hidden {
        display: none;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-container">
    <a href="<?php echo e(url()->previous()); ?>" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <div class="page-header">
        <h1>
            <i class="fas fa-map-marked-alt"></i>
            Lokasi Pengambilan Pesanan
        </h1>
        <p>Temukan lokasi terdekat untuk mengambil pesanan Anda</p>
    </div>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Klik tombol "Buka di Google Maps" untuk navigasi langsung ke lokasi pengambilan
    </div>

    <div class="content-grid">
        <!-- Info Card -->
        <div class="info-card">
            <h3>
                <i class="fas fa-receipt"></i>
                Detail Pesanan
            </h3>

            <div class="order-info">
                <div class="order-info-item">
                    <span class="order-info-label">No. Pesanan</span>
                    <span class="order-info-value">#<?php echo e($order->order_number); ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Status</span>
                    <span class="order-info-value">
                        <i class="fas fa-check-circle"></i> Siap Diambil
                    </span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Jumlah</span>
                    <span class="order-info-value"><?php echo e($order->quantity); ?> kg</span>
                </div>
            </div>

            <div class="pickup-info">
                <div class="pickup-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Lokasi Terdekat
                </div>
                <div class="pickup-name"><?php echo e($nearestPoint->name); ?></div>
                <div class="pickup-address">
                    <i class="fas fa-location-dot"></i>
                    <?php echo e($nearestPoint->address); ?>

                </div>
                <div class="distance-badge">
                    <i class="fas fa-route"></i>
                    <?php echo e($distance); ?> km dari Anda
                </div>
            </div>

            <div class="action-buttons">
                <a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo e($userLatitude); ?>,<?php echo e($userLongitude); ?>&destination=<?php echo e($nearestPoint->latitude); ?>,<?php echo e($nearestPoint->longitude); ?>&travelmode=driving" 
                   target="_blank" 
                   class="btn btn-primary">
                    <i class="fab fa-google"></i>
                    Buka di Google Maps
                </a>
                <button onclick="getMyLocation()" class="btn btn-secondary">
                    <i class="fas fa-location-crosshairs"></i>
                    Gunakan Lokasi Saya
                </button>
            </div>
        </div>

        <!-- Map Card -->
        <div class="map-container">
            <div id="loading" class="loading-overlay">
                <div class="spinner"></div>
                <p>Memuat peta...</p>
            </div>

            <div class="map-legend">
                <div class="map-legend-title">Keterangan:</div>
                <div class="legend-item">
                    <div class="legend-marker marker-user"></div>
                    <span>Lokasi Anda</span>
                </div>
                <div class="legend-item">
                    <div class="legend-marker marker-nearest"></div>
                    <span>Titik Terdekat</span>
                </div>
                <div class="legend-item">
                    <div class="legend-marker marker-other"></div>
                    <span>Titik Lainnya</span>
                </div>
            </div>

            <div id="map"></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_KEY')); ?>&libraries=places,geometry"></script>
<script>
    let map;
    let userMarker;
    let nearestMarker;
    let otherMarkers = [];
    let directionsRenderer;

    // Data dari server
    const userLocation = { lat: <?php echo e($userLatitude); ?>, lng: <?php echo e($userLongitude); ?> };
    const nearestPoint = {
        lat: <?php echo e($nearestPoint->latitude); ?>,
        lng: <?php echo e($nearestPoint->longitude); ?>,
        name: "<?php echo e($nearestPoint->name); ?>",
        address: "<?php echo e($nearestPoint->address); ?>"
    };

    const allPickupPoints = <?php echo json_encode($allPickupPoints, 15, 512) ?>;

    function initMap() {
        // Initialize map centered between user and nearest point
        const centerLat = (userLocation.lat + nearestPoint.lat) / 2;
        const centerLng = (userLocation.lng + nearestPoint.lng) / 2;

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: { lat: centerLat, lng: centerLng },
            mapTypeControl: true,
            streetViewControl: false,
            fullscreenControl: true,
            styles: [
                {
                    featureType: 'poi',
                    elementType: 'labels',
                    stylers: [{ visibility: 'off' }]
                }
            ]
        });

        // Add user marker (Blue)
        userMarker = new google.maps.Marker({
            position: userLocation,
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 10,
                fillColor: '#2196F3',
                fillOpacity: 1,
                strokeColor: '#ffffff',
                strokeWeight: 3
            },
            title: 'Lokasi Anda',
            animation: google.maps.Animation.DROP
        });

        const userInfoWindow = new google.maps.InfoWindow({
            content: '<div style="padding: 10px;"><strong>Lokasi Anda</strong></div>'
        });

        userMarker.addListener('click', () => {
            userInfoWindow.open(map, userMarker);
        });

        // Add nearest point marker (Green)
        nearestMarker = new google.maps.Marker({
            position: { lat: nearestPoint.lat, lng: nearestPoint.lng },
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 12,
                fillColor: '#4CAF50',
                fillOpacity: 1,
                strokeColor: '#ffffff',
                strokeWeight: 3
            },
            title: nearestPoint.name,
            animation: google.maps.Animation.BOUNCE
        });

        const nearestInfoWindow = new google.maps.InfoWindow({
            content: `
                <div style="padding: 12px; max-width: 250px;">
                    <h4 style="margin: 0 0 8px 0; color: #2e7d32;">
                        <i class="fas fa-map-marker-alt"></i> ${nearestPoint.name}
                    </h4>
                    <p style="margin: 0; font-size: 0.9rem; color: #666;">${nearestPoint.address}</p>
                    <p style="margin: 8px 0 0 0; font-size: 0.85rem; color: #4CAF50; font-weight: 600;">
                        <i class="fas fa-check-circle"></i> Titik Terdekat
                    </p>
                </div>
            `
        });

        nearestMarker.addListener('click', () => {
            nearestInfoWindow.open(map, nearestMarker);
        });

        // Add other pickup points (Orange)
        allPickupPoints.forEach(point => {
            if (point.id !== <?php echo e($nearestPoint->id); ?>) {
                const marker = new google.maps.Marker({
                    position: { lat: point.latitude, lng: point.longitude },
                    map: map,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: '#FF9800',
                        fillOpacity: 0.8,
                        strokeColor: '#ffffff',
                        strokeWeight: 2
                    },
                    title: point.name
                });

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="padding: 10px; max-width: 220px;">
                            <h4 style="margin: 0 0 6px 0; color: #333; font-size: 0.95rem;">${point.name}</h4>
                            <p style="margin: 0; font-size: 0.85rem; color: #666;">${point.address}</p>
                        </div>
                    `
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

                otherMarkers.push(marker);
            }
        });

        // Draw route from user to nearest point
        directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            suppressMarkers: true,
            polylineOptions: {
                strokeColor: '#4CAF50',
                strokeWeight: 5,
                strokeOpacity: 0.7
            }
        });

        const directionsService = new google.maps.DirectionsService();
        directionsService.route({
            origin: userLocation,
            destination: { lat: nearestPoint.lat, lng: nearestPoint.lng },
            travelMode: google.maps.TravelMode.DRIVING
        }, (result, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
            }
        });

        // Hide loading overlay
        document.getElementById('loading').classList.add('hidden');
    }

    // Get user's current location
    function getMyLocation() {
        if (navigator.geolocation) {
            const btn = event.target.closest('.btn-secondary');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari lokasi...';
            btn.disabled = true;

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    // Reload page with new coordinates
                    window.location.href = `<?php echo e(route('maps.show')); ?>?order=<?php echo e($order->order_number); ?>&lat=${lat}&lng=${lng}`;
                },
                (error) => {
                    alert('Tidak dapat mengakses lokasi Anda. Pastikan izin lokasi diaktifkan.');
                    btn.innerHTML = '<i class="fas fa-location-crosshairs"></i> Gunakan Lokasi Saya';
                    btn.disabled = false;
                }
            );
        } else {
            alert('Browser Anda tidak mendukung Geolocation');
        }
    }

    // Initialize map when page loads
    window.onload = initMap;
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ppw\resources\views/user/maps.blade.php ENDPATH**/ ?>