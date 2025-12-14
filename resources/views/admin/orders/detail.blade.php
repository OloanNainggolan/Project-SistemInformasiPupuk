@extends('layouts.admin')

@section('title', 'Detail Pesanan - Admin')

@push('styles')
<style>
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 40px;
    }

    /* Back Button */
    .back-button {
        margin-bottom: 24px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        color: #065f46;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .btn-back:hover {
        background: #065f46;
        color: white;
        border-color: #065f46;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(5, 95, 70, 0.2);
    }

    .btn-back i {
        font-size: 16px;
    }

    /* Header Section */
    .order-header {
        background: white;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        border: 2px solid #f3f4f6;
    }

    .order-title-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 3px solid #f3f4f6;
    }

    .order-title {
        font-size: 26px;
        font-weight: 800;
        color: #065f46;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .order-title i {
        color: #10b981;
        font-size: 28px;
    }

    .order-date {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .order-date i {
        color: #9ca3af;
    }

    .status-badge {
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
        border-color: #fbbf24;
    }

    .status-processing {
        background: #e0e7ff;
        color: #5b21b6;
        border-color: #8b5cf6;
    }

    .status-ready {
        background: #d1fae5;
        color: #065f46;
        border-color: #10b981;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
        border-color: #10b981;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
        border-color: #ef4444;
    }

    /* Grid Layout */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    /* Management Grid - for Action and Customer Info */
    .management-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    @media (max-width: 968px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .management-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }
    }

    /* Card Styles */
    .detail-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
        height: fit-content;
    }

    .detail-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        border-color: #10b981;
    }

    .card-title {
        font-size: 20px;
        font-weight: 800;
        color: #065f46;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 3px solid transparent;
        background: linear-gradient(to right, #10b981 0%, #10b981 40%, transparent 40%);
        background-repeat: no-repeat;
        background-position: bottom;
        background-size: 100% 3px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-title i {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    /* Info Rows */
    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .info-item {
        display: grid;
        grid-template-columns: 160px 1fr;
        gap: 16px;
        padding: 16px 20px;
        background: #f9fafb;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
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

    /* Map Section Admin */
    .map-section-admin {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .address-box {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #d1fae5 100%);
        padding: 24px;
        border-radius: 12px;
        border: 3px solid #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
    }

    .address-row {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .address-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .address-icon i {
        color: #10b981;
        font-size: 24px;
    }

    .address-details {
        flex: 1;
    }

    .address-label-text {
        font-size: 13px;
        font-weight: 600;
        color: #065f46;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .address-value-text {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.6;
    }

    .map-info-box {
        background: #f0f9ff;
        padding: 15px 20px;
        border-radius: 10px;
        border-left: 4px solid #0ea5e9;
        margin-top: 20px;
        font-size: 14px;
        color: #0c4a6e;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-weight: 500;
    }

    .map-info-box i {
        color: #0ea5e9;
        flex-shrink: 0;
        margin-top: 2px;
        font-size: 16px;
    }

    /* Products Section */
    .products-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 2px solid #e5e7eb;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .products-section:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        border-color: #10b981;
    }

    .product-item {
        display: grid;
        grid-template-columns: 90px 1fr 140px;
        gap: 24px;
        padding: 24px;
        background: #f9fafb;
        border-radius: 12px;
        margin-bottom: 18px;
        align-items: center;
        border: 2px solid #e5e7eb;
    }

    .product-item:last-child {
        margin-bottom: 0;
    }

    .product-image {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: #10b981;
        overflow: hidden;
        border: 2px solid #e5e7eb;
    }

    .product-info h4 {
        font-size: 17px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .product-meta {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-quantity {
        font-size: 14px;
        color: #374151;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .product-price {
        text-align: right;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
    }

    .product-subtotal {
        font-size: 20px;
        font-weight: 800;
        color: #065f46;
        letter-spacing: 0.5px;
    }

    .product-unit-price {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Total Section */
    .total-section {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #d1fae5 100%);
        padding: 24px 28px;
        border-radius: 12px;
        margin-top: 24px;
        border: 3px solid #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
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
        border-top: 3px solid #10b981;
        margin-top: 12px;
        padding-top: 18px;
    }

    .grand-total .total-label {
        font-size: 22px;
        font-weight: 800;
        color: #065f46;
        letter-spacing: 0.5px;
    }

    .grand-total .total-value {
        font-size: 28px;
        font-weight: 800;
        color: #10b981;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }

    /* Action Buttons */
    .action-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: 2px solid #e5e7eb;
        height: fit-content;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 14px;
        width: 100%;
    }

    .btn {
        padding: 16px 24px;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        letter-spacing: 0.3px;
        text-align: center;
        width: 100%;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-processing {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        box-shadow: 0 4px 8px rgba(139, 92, 246, 0.3);
    }

    .btn-processing:hover {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        box-shadow: 0 6px 12px rgba(139, 92, 246, 0.4);
    }

    .btn-ready {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-ready:hover {
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 6px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-complete {
        background: linear-gradient(135deg, #065f46, #064e3b);
        color: white;
        box-shadow: 0 4px 8px rgba(6, 95, 70, 0.3);
    }

    .btn-complete:hover {
        background: linear-gradient(135deg, #064e3b, #022c22);
        box-shadow: 0 6px 12px rgba(6, 95, 70, 0.4);
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
    }

    .btn-reject:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        box-shadow: 0 6px 12px rgba(239, 68, 68, 0.4);
    }

    .btn-print {
        background: white;
        color: #065f46;
        border: 3px solid #065f46;
        box-shadow: 0 2px 6px rgba(6, 95, 70, 0.1);
    }

    .btn-print:hover {
        background: linear-gradient(135deg, #065f46, #047857);
        color: white;
        border-color: #065f46;
        box-shadow: 0 6px 12px rgba(6, 95, 70, 0.3);
    }

    /* Map Section Admin */
    .map-section-admin {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 25px;
    }

    .address-box {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        padding: 20px;
        border-radius: 10px;
        border: 2px solid #10b981;
        margin-bottom: 20px;
    }

    .address-row {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .address-icon {
        width: 45px;
        height: 45px;
        background: #10b981;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }

    .address-details {
        flex: 1;
    }

    .address-label-text {
        font-size: 13px;
        font-weight: 600;
        color: #065f46;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .address-value-text {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.6;
    }

    .map-info-box {
        background: #dbeafe;
        padding: 12px 18px;
        border-radius: 8px;
        border-left: 3px solid #3b82f6;
        margin-top: 15px;
        font-size: 13px;
        color: #1e40af;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .map-info-box i {
        flex-shrink: 0;
        margin-top: 2px;
        font-size: 16px;
    }

    /* Rejection Section */
    .rejection-section {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        padding: 24px;
        border-radius: 12px;
        border: 3px solid #ef4444;
        margin-top: 24px;
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.2);
    }

    .rejection-title {
        font-size: 18px;
        font-weight: 800;
        color: #991b1b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rejection-title i {
        width: 32px;
        height: 32px;
        background: #ef4444;
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .rejection-reason {
        font-size: 15px;
        color: #7f1d1d;
        line-height: 1.7;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .detail-container {
            padding: 25px 30px;
        }

        .management-grid {
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .product-item {
            grid-template-columns: 80px 1fr 130px;
            gap: 20px;
        }

        .product-image {
            width: 80px;
            height: 80px;
        }
    }

    @media (max-width: 968px) {
        .detail-container {
            padding: 20px;
        }

        .detail-card, .products-section, .map-section-admin, .action-section {
            padding: 20px;
        }

        .product-item {
            grid-template-columns: 70px 1fr 110px;
            gap: 16px;
            padding: 18px;
        }

        .product-image {
            width: 70px;
            height: 70px;
        }

        .info-item {
            grid-template-columns: 140px 1fr;
            gap: 12px;
        }
    }

    @media (max-width: 768px) {
        .order-header {
            padding: 24px;
        }

        .order-title {
            font-size: 22px;
        }

        .product-item {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 12px;
        }

        .product-image {
            margin: 0 auto;
            width: 80px;
            height: 80px;
        }

        .product-price {
            text-align: center;
        }

        .action-buttons {
            grid-template-columns: 1fr;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .info-item {
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .grand-total .total-label {
            font-size: 18px;
        }

        .grand-total .total-value {
            font-size: 24px;
        }
    }

    @media (max-width: 480px) {
        .detail-container {
            padding: 15px;
        }

        .detail-card, .products-section, .map-section-admin, .action-section {
            padding: 16px;
        }

        .order-title {
            font-size: 20px;
        }

        .card-title {
            font-size: 18px;
        }

        .btn {
            padding: 12px 20px;
            font-size: 14px;
        }
    }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('admin.orders') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar Pesanan</span>
        </a>
    </div>

    <!-- Order Header -->
    <div class="order-header">
        <div class="order-title-section">
            <div>
                <h1 class="order-title">Pesanan {{ $order->order_number }}</h1>
                <p class="order-date">
                    <i class="far fa-calendar"></i>
                    {{ $order->created_at->format('d F Y, H:i') }} WIB
                </p>
            </div>
            <div>
                <span class="status-badge status-{{ strtolower($order->status) }}">
                    {{ $order->status }}
                </span>
            </div>
        </div>
    </div>

    <!-- Pickup Point Information (for Ready status) -->
    @if($order->status === 'Ready' || $order->status === 'Completed')
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
    @endif

    <!-- Products Ordered -->
    <div class="products-section">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i>
            Produk yang Dipesan
        </h3>
        
        @php
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
        @endphp

        @if(is_array($items) && count($items) > 0)
            @foreach($items as $item)
                @php
                    // Use unit_price if available, otherwise fallback to price
                    $unitPrice = $item['unit_price'] ?? $item['price'] ?? 0;
                    $quantity = $item['quantity'] ?? 0;
                    
                    // Use subtotal from item if available, otherwise calculate
                    $itemSubtotal = $item['subtotal'] ?? ($unitPrice * $quantity);
                    $calculatedSubtotal += $itemSubtotal;
                @endphp
                <div class="product-item">
                    @php
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
                            } else {
                                // Fallback based on item type
                                if(($item['type'] ?? '') === 'bibit') {
                                    $productImage = asset('images/bibit.jpg');
                                }
                            }
                        } elseif(($item['type'] ?? '') === 'bibit') {
                            $productImage = asset('images/bibit.jpg');
                        }
                    @endphp
                    
                    <div class="product-image">
                        <img src="{{ $productImage }}" 
                             alt="{{ $item['product_name'] ?? 'Produk' }}" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                             onerror="this.src='{{ asset('images/pupuk.jpg') }}'">
                    </div>
                    <div class="product-info">
                        <h4>{{ $item['product_name'] ?? 'Produk' }}</h4>
                        <p class="product-meta">
                            <span style="background: #e0e7ff; color: #5b21b6; padding: 3px 10px; border-radius: 5px; font-weight: 600;">
                                {{ ucfirst($item['type'] ?? 'N/A') }}
                            </span>
                            <span style="margin-left: 10px;">{{ $item['category'] ?? 'N/A' }}</span>
                        </p>
                        <p class="product-quantity">
                            <i class="fas fa-box"></i> Jumlah: {{ $quantity }} kg
                        </p>
                    </div>
                    <div class="product-price">
                        <div class="product-subtotal">
                            Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                        </div>
                        <div class="product-unit-price">
                            @ Rp {{ number_format($unitPrice, 0, ',', '.') }}/kg
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Total Section -->
            @php
                // Use order subtotal from DB if calculated is 0, otherwise use calculated
                $finalSubtotal = $calculatedSubtotal > 0 ? $calculatedSubtotal : ($order->subtotal ?? 0);
            @endphp
            <div class="total-section">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">Rp {{ number_format($finalSubtotal, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Ongkos Kirim</span>
                    <span class="total-value">Rp 0</span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Total Pembayaran</span>
                    <span class="total-value">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        @else
            <p style="text-align: center; color: #6b7280; padding: 40px;">
                <i class="fas fa-inbox" style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
                Tidak ada produk dalam pesanan ini
            </p>
        @endif
    </div>

    <!-- Rejection Reason (if rejected) -->
    @if($order->status === 'Rejected' && $order->rejection_reason)
    <div class="rejection-section">
        <div class="rejection-title">
            <i class="fas fa-exclamation-triangle"></i>
            Alasan Penolakan
        </div>
        <p class="rejection-reason">{{ $order->rejection_reason }}</p>
    </div>
    @endif

    <!-- Informasi Pengiriman -->
    <div class="detail-card" style="margin-bottom: 30px;">
        <h3 class="card-title">
            <i class="fas fa-truck"></i>
            Informasi Pengiriman
        </h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-calendar-alt"></i>
                    Tanggal Pesan
                </div>
                <div class="info-value">{{ $order->created_at->format('d F Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-clock"></i>
                    Waktu
                </div>
                <div class="info-value">{{ $order->created_at->format('H:i') }} WIB</div>
            </div>
        </div>
    </div>

    <!-- Management Grid: Action Buttons & Customer Info -->
    <div class="management-grid">
        <!-- Kelola Pesanan (Kiri) -->
        <div class="action-section">
            <h3 class="card-title">
                <i class="fas fa-cogs"></i>
                Kelola Pesanan
            </h3>
            <div class="action-buttons">
                @if($order->status === 'Pending')
                    <button class="btn btn-processing" onclick="updateStatus('Processing')">
                        <i class="fas fa-spinner"></i>
                        Proses Pesanan
                    </button>
                    <button class="btn btn-reject" onclick="rejectOrder()">
                        <i class="fas fa-times-circle"></i>
                        Tolak Pesanan
                    </button>
                @elseif($order->status === 'Processing')
                    <button class="btn btn-ready" onclick="updateStatus('Ready')">
                        <i class="fas fa-check"></i>
                        Siap Diambil
                    </button>
                    <button class="btn btn-reject" onclick="rejectOrder()">
                        <i class="fas fa-times-circle"></i>
                        Tolak Pesanan
                    </button>
                @elseif($order->status === 'Ready')
                    <button class="btn btn-complete" onclick="updateStatus('Completed')">
                        <i class="fas fa-check-double"></i>
                        Selesaikan Pesanan
                    </button>
                @endif
                
                <button class="btn btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Cetak Detail
                </button>
            </div>
        </div>

        <!-- Informasi Pelanggan (Kanan) -->
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
                    <div class="info-value">{{ $order->customer_name ?? $order->user->nama_lengkap ?? $order->user->name ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </div>
                    <div class="info-value">{{ $order->user->email ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-phone"></i>
                        No. HP
                    </div>
                    <div class="info-value">{{ $order->customer_phone ?? $order->user->no_hp ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat
                    </div>
                    <div class="info-value">{{ $order->customer_address ?? $order->user->alamat ?? 'Belum diisi' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-sticky-note"></i>
                        Catatan
                    </div>
                    <div class="info-value">{{ $order->customer_notes ?? 'Tidak ada catatan' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
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

<script>
    // Load nearest pickup point for Ready orders
    @if($order->status === 'Ready' || $order->status === 'Completed')
    document.addEventListener('DOMContentLoaded', function() {
        loadNearestPickupForAdmin();
    });

    function loadNearestPickupForAdmin() {
        const customerAddress = '{{ $order->customer_address ?? $order->user->alamat ?? "" }}';
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
            console.log('ℹ️ Using default Laguboti coordinates');
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
                
                console.log('🗺️ Google Maps URL:', mapsUrl);
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
    @endif

    function updateStatus(newStatus) {
        if (!confirm(`Apakah Anda yakin ingin mengubah status pesanan menjadi "${newStatus}"?`)) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/admin/orders/{{ $order->order_number }}/status`, {
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
        .then(response => {
            // Handle 419 error (CSRF token expired)
            if (response.status === 419) {
                alert('⚠️ Session Anda telah berakhir. Halaman akan di-refresh untuk memperbarui session.');
                location.reload();
                return Promise.reject('Session expired');
            }
            
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                alert('✅ Status pesanan berhasil diupdate!');
                location.reload();
            } else {
                alert('❌ Gagal mengupdate status: ' + (data?.message || 'Unknown error'));
            }
        })
        .catch(error => {
            if (error !== 'Session expired') {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan: ' + (error.message || 'Unknown error'));
            }
        });
    }

    function rejectOrder() {
        const reason = prompt('Masukkan alasan penolakan:');
        
        if (!reason || reason.trim() === '') {
            alert('❌ Alasan penolakan harus diisi!');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(`/admin/orders/{{ $order->order_number }}/status`, {
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
        .then(response => {
            // Handle 419 error (CSRF token expired)
            if (response.status === 419) {
                alert('⚠️ Session Anda telah berakhir. Halaman akan di-refresh untuk memperbarui session.');
                location.reload();
                return Promise.reject('Session expired');
            }
            
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                alert('✅ Pesanan berhasil ditolak!');
                location.reload();
            } else {
                alert('❌ Gagal menolak pesanan: ' + (data?.message || 'Unknown error'));
            }
        })
        .catch(error => {
            if (error !== 'Session expired') {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan: ' + (error.message || 'Unknown error'));
            }
        });
    }
</script>
@endpush
