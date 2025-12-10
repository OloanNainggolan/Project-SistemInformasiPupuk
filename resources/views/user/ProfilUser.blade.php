@extends('layouts.user')

@section('title', 'Profil Saya')

@push('styles')
<style>
    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .modal-close:hover {
        color: #1f2937;
        background: #f3f4f6;
        border-radius: 8px;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .order-detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.875rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .order-detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        font-size: 0.875rem;
        color: #1f2937;
        font-weight: 600;
    }

    .order-status-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-processing {
        background: #fef3c7;
        color: #92400e;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background: #dbeafe;
        color: #0c4a6e;
    }

    .modal-loading {
        text-align: center;
        padding: 2rem;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f4f6;
        border-top: 4px solid #10b981;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .modal-error {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div style="background: #f0f4f8; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 1.5rem;">
        
        <div style="display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start;">
            
            <!-- Left Sidebar - Profile Card -->
            <div>
                <!-- Main Profile Card -->
                <div style="background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 1.5rem;">
                    
                    <!-- Avatar Section -->
                    <div style="padding: 2rem 1.5rem; text-align: center;">
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3); overflow: hidden; position: relative;">
                            @if(Auth::user()->foto)
                                <img src="{{ asset(Auth::user()->foto) }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="font-size: 3rem; font-weight: 700; color: white;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">
                            {{ Auth::user()->name }}
                        </h2>
                        <p style="color: #10b981; font-size: 0.875rem; margin: 0; display: flex; align-items: center; justify-content: center; gap: 0.25rem;">
                            <i class="fas fa-user-check"></i>
                            User
                        </p>
                    </div>

                    <!-- Contact Info -->
                    <div style="padding: 0 1.5rem 1.5rem;">
                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px; margin-bottom: 0.75rem;">
                            <i class="fas fa-envelope" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">{{ Auth::user()->email }}</span>
                        </div>

                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px; margin-bottom: 0.75rem;">
                            <i class="fas fa-phone" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">{{ Auth::user()->no_telp ?? '-' }}</span>
                        </div>

                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px; margin-bottom: 0.75rem;">
                            <i class="fas fa-map-marker-alt" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">{{ Auth::user()->alamat ?? '-' }}</span>
                        </div>

                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px;">
                            <i class="fas fa-calendar" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">Bergabung {{ Auth::user()->created_at ? Auth::user()->created_at->format('F Y') : 'November 2025' }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="padding: 0 1.5rem 1.5rem;">
                        <a href="{{ route('profil.edit') }}" style="display: block; background: #10b981; color: white; text-align: center; padding: 0.875rem; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.75rem; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); transition: all 0.3s;">
                            <i class="fas fa-edit" style="margin-right: 0.5rem;"></i>Edit Profil
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="width: 100%; background: #fee2e2; color: #dc2626; padding: 0.875rem; border-radius: 10px; border: none; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem;"></i>Keluar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Land Information Card -->
                <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 16px; padding: 1.25rem; border: 2px solid #10b981;">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <i class="fas fa-seedling" style="color: #10b981; font-size: 1.25rem; margin-right: 0.5rem;"></i>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #065f46; margin: 0;">Informasi Lahan</h3>
                    </div>
                    <div style="margin-bottom: 0.875rem;">
                        <p style="font-size: 0.75rem; color: #047857; margin: 0 0 0.25rem 0; font-weight: 600;">Luas Lahan</p>
                        <p style="font-size: 1.25rem; color: #065f46; margin: 0; font-weight: 700;">{{ Auth::user()->luas_lahan ? number_format(Auth::user()->luas_lahan, 2) : '0' }} Ha</p>
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; color: #047857; margin: 0 0 0.5rem 0; font-weight: 600;">Jenis Tanaman</p>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            @if(Auth::user()->jenis_tanaman)
                                @php
                                    $tanaman = explode(',', Auth::user()->jenis_tanaman);
                                @endphp
                                @foreach($tanaman as $item)
                                    <span style="background: #fef3c7; color: #92400e; padding: 0.375rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                        <i class="fas fa-leaf"></i> {{ trim($item) }}
                                    </span>
                                @endforeach
                            @else
                                <span style="background: #f3f4f6; color: #6b7280; padding: 0.375rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                    <i class="fas fa-info-circle"></i> Belum diisi
                                </span>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->lokasi_lahan)
                    <div style="margin-top: 0.875rem; padding-top: 0.875rem; border-top: 1px solid #d1fae5;">
                        <p style="font-size: 0.75rem; color: #047857; margin: 0 0 0.25rem 0; font-weight: 600;">
                            <i class="fas fa-map-marker-alt"></i> Lokasi Lahan
                        </p>
                        <p style="font-size: 0.875rem; color: #065f46; margin: 0;">{{ Auth::user()->lokasi_lahan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Side - Statistics & Orders -->
            <div>
                <!-- Statistics Cards Grid -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
                    <!-- Total Pesanan -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #8b5cf6;">
                        <div style="width: 48px; height: 48px; background: #ede9fe; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-shopping-bag" style="color: #8b5cf6; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">{{ $orders->count() }}</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Total Pesanan</p>
                    </div>

                    <!-- Pupuk Diterima -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #3b82f6;">
                        <div style="width: 48px; height: 48px; background: #dbeafe; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-box" style="color: #3b82f6; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">0.0 Ton</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Pupuk Diterima</p>
                    </div>

                    <!-- Bibit Diterima -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #f59e0b;">
                        <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-seedling" style="color: #f59e0b; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">0 Kg</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Bibit Diterima</p>
                    </div>

                    <!-- Penghematan -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #10b981;">
                        <div style="width: 48px; height: 48px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-piggy-bank" style="color: #10b981; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">{{ number_format($orders->sum('total') / 1000, 1) }} Jt</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Total Belanja</p>
                    </div>
                </div>

                <!-- Orders Table -->
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-history" style="color: #10b981; font-size: 1.125rem;"></i>
                        <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0;">Riwayat Pesanan</h2>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f9fafb;">
                                <tr>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Pesanan</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Order</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Total</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr style="border-top: 1px solid #f3f4f6; transition: background 0.2s;">
                                    <td style="padding: 1rem 1.5rem;">
                                        <p style="font-size: 0.875rem; font-weight: 600; color: #1f2937; margin: 0 0 0.25rem 0;">{{ $order->order_number }}</p>
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">{{ $order->product_name ?? 'Produk tidak tersedia' }}</p>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <p style="font-size: 0.875rem; color: #1f2937; margin: 0;">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</p>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <p style="font-size: 0.875rem; font-weight: 600; color: #1f2937; margin: 0;">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="background: #d1fae5; color: #065f46; padding: 0.375rem 0.875rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block;">
                                            {{ $order->status ?? 'Selesai' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: center;">
                                        <button onclick="viewOrderDetail({{ $order->id }})" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 6px; border: none; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.375rem; transition: all 0.3s;">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="padding: 3rem; text-align: center;">
                                        <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                                        <p style="color: #6b7280; font-size: 0.875rem;">Belum ada riwayat pesanan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 350px 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Modal Order Detail -->
<div id="orderDetailModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Detail Pesanan</h2>
            <button class="modal-close" onclick="closeOrderDetail()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalBodyContent">
            <!-- Content diisi oleh JavaScript -->
        </div>
    </div>
</div>

<script>
    function viewOrderDetail(orderId) {
        const modal = document.getElementById('orderDetailModal');
        const modalBody = document.getElementById('modalBodyContent');
        
        // Tampilkan loading state
        modalBody.innerHTML = `
            <div class="modal-loading">
                <div class="spinner"></div>
                <p style="color: #6b7280;">Memuat detail pesanan...</p>
            </div>
        `;
        
        modal.classList.add('show');
        
        // Fetch data dari API
        fetch(`/user/orders/${orderId}/detail`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.success && data.order) {
                    const order = data.order;
                    
                    // Format status untuk styling
                    let statusClass = 'status-pending';
                    if (order.status.toLowerCase() === 'processing') {
                        statusClass = 'status-processing';
                    } else if (order.status.toLowerCase() === 'completed' || order.status.toLowerCase() === 'selesai') {
                        statusClass = 'status-completed';
                    }
                    
                    // Build HTML untuk detail order
                    const html = `
                        <div class="order-detail-row">
                            <span class="detail-label">Nomor Pesanan</span>
                            <span class="detail-value">${order.order_number}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="detail-label">Tanggal Pesanan</span>
                            <span class="detail-value">${order.created_at}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="detail-label">Status</span>
                            <span class="order-status-badge ${statusClass}">${order.status}</span>
                        </div>
                        <div style="padding: 1rem 0; border-top: 2px solid #e5e7eb; border-bottom: 2px solid #e5e7eb; margin: 1rem 0;">
                            <h3 style="font-size: 0.875rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin: 0 0 1rem 0;">Informasi Produk</h3>
                            <div class="order-detail-row">
                                <span class="detail-label">Nama Produk</span>
                                <span class="detail-value">${order.product_name}</span>
                            </div>
                            <div class="order-detail-row">
                                <span class="detail-label">Jumlah</span>
                                <span class="detail-value">${order.quantity} unit</span>
                            </div>
                            <div class="order-detail-row">
                                <span class="detail-label">Harga Satuan</span>
                                <span class="detail-value">Rp ${order.unit_price_formatted}</span>
                            </div>
                            <div class="order-detail-row">
                                <span class="detail-label">Subtotal</span>
                                <span class="detail-value">Rp ${order.subtotal_formatted}</span>
                            </div>
                        </div>
                        <div style="padding: 1rem 0; border-bottom: 2px solid #e5e7eb; margin-bottom: 1rem;">
                            <h3 style="font-size: 0.875rem; color: #6b7280; text-transform: uppercase; font-weight: 600; margin: 0 0 1rem 0;">Informasi Pembeli</h3>
                            <div class="order-detail-row">
                                <span class="detail-label">Nama</span>
                                <span class="detail-value">${order.customer_name}</span>
                            </div>
                            <div class="order-detail-row">
                                <span class="detail-label">No. Telepon</span>
                                <span class="detail-value">${order.customer_phone}</span>
                            </div>
                            <div class="order-detail-row">
                                <span class="detail-label">Alamat</span>
                                <span class="detail-value">${order.customer_address}</span>
                            </div>
                            <div class="order-detail-row">
                                <span class="detail-label">Balai Desa</span>
                                <span class="detail-value">${order.village_office || '-'}</span>
                            </div>
                        </div>
                        <div style="background: #f0fdf4; padding: 1rem; border-radius: 8px; border-left: 4px solid #10b981;">
                            <div class="order-detail-row" style="border-bottom: none;">
                                <span class="detail-label" style="font-size: 1rem; font-weight: 700;">Total Pesanan</span>
                                <span class="detail-value" style="font-size: 1rem; color: #10b981;">Rp ${order.total_formatted}</span>
                            </div>
                        </div>
                    `;
                    
                    modalBody.innerHTML = html;
                } else {
                    modalBody.innerHTML = `
                        <div class="modal-error">
                            <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                            ${data.message || 'Gagal memuat data pesanan. Coba lagi nanti.'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                modalBody.innerHTML = `
                    <div class="modal-error">
                        <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                        Terjadi kesalahan: ${error.message}
                    </div>
                `;
            });
    }

    function closeOrderDetail() {
        const modal = document.getElementById('orderDetailModal');
        modal.classList.remove('show');
    }

    // Close modal ketika klik di luar modal
    document.getElementById('orderDetailModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrderDetail();
        }
    });

    // Close modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeOrderDetail();
        }
    });
</script>
@endsection
