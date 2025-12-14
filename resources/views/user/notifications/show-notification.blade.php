@extends('layouts.user')

@section('title', 'Detail Notifikasi')

@section('content')
<div class="notification-detail-container">
    <!-- Back Button -->
    <div class="back-navigation">
        <a href="{{ route('notifikasi') }}" class="back-link" onclick="sessionStorage.setItem('notifJustRead', 'true');">
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
                        {{ $notification->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Type Badge -->
        <div class="notification-type-badge {{ $notification->type }}">
            @if($notification->type === 'info')
                <i class="fas fa-info-circle"></i> Informasi
            @elseif($notification->type === 'success')
                <i class="fas fa-check-circle"></i> Sukses
            @elseif($notification->type === 'warning')
                <i class="fas fa-exclamation-triangle"></i> Peringatan
            @elseif($notification->type === 'important')
                <i class="fas fa-exclamation-circle"></i> Penting
            @endif
        </div>

        <!-- Title -->
        <div class="notification-title">
            <i class="fas fa-bell"></i>
            {{ $notification->title }}
        </div>

        @php
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
        @endphp

        @if($orderNumber || $productName || $oldStatus || $newStatus)
        <!-- Order Status Update Section -->
        <div class="order-info-section">
            <div class="section-title">
                <i class="fas fa-box"></i> UPDATE STATUS PESANAN 📦
            </div>
            
            @if($orderNumber)
            <div class="info-item">
                <span class="info-label">📋 No. Pesanan:</span>
                <span class="info-value">#{{ $orderNumber }}</span>
            </div>
            @endif

            @if($productName)
            <div class="info-item">
                <span class="info-label">📦 Produk:</span>
                <span class="info-value">{{ $productName }}</span>
            </div>
            @endif

            @if($jumlah)
            <div class="info-item">
                <span class="info-label">🔢 Jumlah:</span>
                <span class="info-value">{{ $jumlah }}</span>
            </div>
            @endif

            @if($oldStatus && $newStatus)
            <div class="status-change-section">
                <div class="status-item lama">
                    <span class="status-icon old">📦</span>
                    <span class="status-label">Status Lama:</span>
                    <span class="status-value">{{ $oldStatus }}</span>
                </div>
                <div class="status-item baru">
                    <span class="status-icon new">✅</span>
                    <span class="status-label">Status Baru:</span>
                    <span class="status-value highlight">{{ $newStatus }}</span>
                </div>
            </div>
            @endif

            @if($isShipped)
            <div class="highlight-banner shipped">
                📦 PESANAN HARI DIKIRIM!
            </div>
            @elseif($isReady)
            <div class="highlight-banner ready">
                PESANAN ANDA SUDAH SIAP.
            </div>
            @endif

            @if($actionSteps)
            <div class="action-section">
                <div class="action-title">🔔 Langkah Pengambilan:</div>
                <div class="action-content">
                    {!! nl2br(e($actionSteps)) !!}
                </div>
            </div>
            @endif

            @if($tip)
            <div class="tip-section">
                <i class="fas fa-lightbulb"></i>
                <strong>Tip:</strong> {{ $tip }}
            </div>
            @endif

            {{-- Map Section - Tampilkan di dalam order info --}}
            @php
                // Get address from order or user
                $mapAddress = null;
                $addressSource = 'none';
                
                if ($notification->order) {
                    if (!empty($notification->order->customer_address)) {
                        $mapAddress = $notification->order->customer_address;
                        $addressSource = 'order.customer_address';
                    } elseif ($notification->order->user && !empty($notification->order->user->alamat)) {
                        $mapAddress = $notification->order->user->alamat;
                        $addressSource = 'order.user.alamat';
                    }
                }
            @endphp

            @if($mapAddress)
            <div class="map-section" style="margin-top: 20px;">
                <div class="section-title" style="font-size: 15px; font-weight: 700; color: #1e40af; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #93c5fd;">
                    <i class="fas fa-map-marked-alt"></i> PETA LOKASI PENGAMBILAN
                </div>
                
                <div class="address-info">
                    <div class="address-label">
                        <i class="fas fa-building"></i> Balai Desa
                    </div>
                    <div class="address-value">
                        {{ $mapAddress }}
                    </div>
                </div>
                
                <div id="orderMap" style="height: 350px; border-radius: 12px; margin-top: 15px; border: 2px solid #e5e7eb; position: relative; background: #f3f4f6;">
                    <div id="mapLoading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 1000;">
                        <div style="font-size: 40px; margin-bottom: 10px;">🗺️</div>
                        <div style="font-size: 14px; color: #6b7280;">Memuat peta lokasi pengambilan...</div>
                    </div>
                </div>
                
                <div class="map-notice">
                    <i class="fas fa-info-circle"></i>
                    <span>Pin merah menunjukkan lokasi Balai Desa untuk pengambilan pesanan. Klik marker untuk info detail.</span>
                </div>
            </div>
            @endif

        </div>
        @else
        <!-- Regular Notification Message -->
        <div class="notification-message">
            {!! nl2br(e($notification->message)) !!}

            {{-- Tombol Maps juga untuk regular message jika ada kata "siap" dan order number --}}
            @php
                $hasOrderNumber = preg_match('/ORD-\d{8}-[A-F0-9]{6}/i', $notification->message, $matches);
                $orderNum = $hasOrderNumber ? $matches[0] : null;
                $isSiap = stripos($notification->message, 'siap') !== false || stripos($notification->title, 'siap') !== false;
            @endphp
            
            @if($isSiap && $orderNum)
            <div class="map-button-section" style="margin-top: 20px;">
                <a href="{{ route('maps.show', ['order' => $orderNum]) }}" class="btn-map">
                    <i class="fas fa-map-marked-alt"></i>
                    Lihat Lokasi Pengambilan
                </a>
                <p class="map-hint">
                    <i class="fas fa-info-circle"></i>
                    Klik tombol di atas untuk melihat lokasi pengambilan terdekat dari Anda
                </p>
            </div>
            @endif
        </div>
        @endif

        <!-- Debug Section (di luar order info) -->
        @php
            // Debug: Log notification data
            \Log::info('Notification Data for Map', [
                'notification_id' => $notification->id,
                'has_order' => isset($notification->order),
                'order_loaded' => $notification->order ? 'YES' : 'NO',
                'related_id' => $notification->related_id ?? 'null',
                'related_type' => $notification->related_type ?? 'null',
                'user_alamat' => auth()->user()->alamat ?? 'null'
            ]);
            
            // Get address from multiple sources with fallback
            $mapAddress = null;
            $addressSource = 'none';
            
            if ($notification->order) {
                \Log::info('Order loaded, checking addresses', [
                    'customer_address' => $notification->order->customer_address ?? 'null',
                    'order_user_exists' => isset($notification->order->user) ? 'yes' : 'no',
                ]);
                
                if (!empty($notification->order->customer_address)) {
                    $mapAddress = $notification->order->customer_address;
                    $addressSource = 'order.customer_address';
                } elseif ($notification->order->user && !empty($notification->order->user->alamat)) {
                    $mapAddress = $notification->order->user->alamat;
                    $addressSource = 'order.user.alamat';
                } elseif (!empty(auth()->user()->alamat)) {
                    $mapAddress = auth()->user()->alamat;
                    $addressSource = 'auth.user.alamat';
                }
            } elseif (!empty(auth()->user()->alamat)) {
                $mapAddress = auth()->user()->alamat;
                $addressSource = 'auth.user.alamat (no order)';
            }
            
            \Log::info('Map Address Result', [
                'address' => $mapAddress ?? 'null',
                'source' => $addressSource
            ]);
        @endphp

        <!-- Action Buttons -->
        <div class="notification-actions">
            <a href="{{ route('notifikasi') }}" class="btn-action back" onclick="sessionStorage.setItem('notifJustRead', 'true');">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            
            <form action="{{ route('user.notifications.destroy', $notification->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
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
</style>
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

@if($mapAddress)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🗺️ Initializing map for notification...');
        console.log('📍 Address:', @json($mapAddress));
        console.log('🔍 Leaflet loaded:', typeof L !== 'undefined');
        
        if (typeof L === 'undefined') {
            console.error('❌ Leaflet library not loaded!');
            return;
        }
        
        const mapElement = document.getElementById('orderMap');
        if (!mapElement) {
            console.error('❌ Map element #orderMap not found!');
            console.log('Available elements:', document.querySelectorAll('[id*="map"]'));
            return;
        }
        console.log('✅ Map element found:', mapElement);
        
        // Geocode alamat menggunakan Nominatim (OpenStreetMap)
        const address = @json($mapAddress);
        
        // Koordinat default (Indonesia - Jakarta)
        let defaultLat = -6.2088;
        let defaultLng = 106.8456;
        
        // Initialize map dengan koordinat default
        console.log('📍 Creating map...');
        const map = L.map('orderMap').setView([defaultLat, defaultLng], 13);
        
        // Hide loading indicator setelah map initialized
        const loadingEl = document.getElementById('mapLoading');
        if (loadingEl) {
            loadingEl.style.display = 'none';
        }
        
        // Tambahkan tile layer dari OpenStreetMap
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
        
        // Coba geocode alamat
        console.log('🔍 Geocoding address:', address);
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address + ', Indonesia')}&limit=1`)
            .then(response => {
                console.log('📡 Geocoding response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('📊 Geocoding data:', data);
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    console.log('✅ Coordinates found:', { lat, lon });
                    
                    // Update map center
                    map.setView([lat, lon], 15);
                    
                    // Tambahkan marker dengan icon merah
                    L.marker([lat, lon], {icon: redIcon})
                        .addTo(map)
                        .bindPopup(`<b>📍 Lokasi Pengambilan</b><br>${address}`)
                        .openPopup();
                } else {
                    console.warn('⚠️ No coordinates found, using default location');
                    // Jika geocoding gagal, tampilkan marker di lokasi default
                    L.marker([defaultLat, defaultLng], {icon: redIcon})
                        .addTo(map)
                        .bindPopup(`<b>📍 Lokasi</b><br>${address}<br><small>(Koordinat tidak ditemukan, menampilkan lokasi default)</small>`)
                        .openPopup();
                }
            })
            .catch(error => {
                console.error('❌ Geocoding error:', error);
                // Jika error, tampilkan marker di lokasi default
                L.marker([defaultLat, defaultLng], {icon: redIcon})
                    .addTo(map)
                    .bindPopup(`<b>📍 Lokasi</b><br>${address}<br><small>(Error geocoding, menampilkan lokasi default)</small>`)
                    .openPopup();
            });
        
        console.log('✅ Map initialization completed');
    });
</script>
@endif
@endpush
