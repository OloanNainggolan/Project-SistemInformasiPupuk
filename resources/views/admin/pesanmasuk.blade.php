@extends('layouts.admin')

@section('title', 'Pesan Masuk - Kelola Pesanan')

@push('styles')
<style>
    .pesanan-wrapper {
        background: linear-gradient(135deg, #e8f5f1 0%, #d4f1e8 100%);
        min-height: 100vh;
        padding: 30px;
    }

    /* Header Section */
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
    }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card-small {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stat-card-small:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card-small.active {
        border: 2px solid #00897b;
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .stat-icon-small {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
    }

    .stat-icon-small.all { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    .stat-icon-small.pending { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); }
    .stat-icon-small.processing { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .stat-icon-small.ready { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
    .stat-icon-small.completed { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-icon-small.rejected { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }

    .stat-label-small {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .stat-value-small {
        font-size: 26px;
        font-weight: 800;
        color: #1e293b;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .filter-row {
        display: grid;
        grid-template-columns: 2fr 2fr 2fr 1fr;
        gap: 15px;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
    }

    .form-control {
        padding: 10px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #00897b;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 137, 123, 0.3);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }

    /* Orders Table */
    .orders-container {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead {
        background: #f8fafc;
    }

    .orders-table th {
        text-align: left;
        padding: 15px;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .orders-table td {
        padding: 18px 15px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #1e293b;
    }

    .orders-table tbody tr {
        transition: all 0.2s ease;
    }

    .orders-table tbody tr:hover {
        background: #f8fafc;
    }

    .order-number {
        font-weight: 700;
        color: #00897b;
    }

    .customer-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
    }

    .customer-details {
        display: flex;
        flex-direction: column;
    }

    .customer-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }

    .customer-email {
        font-size: 12px;
        color: #64748b;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-image {
        width: 45px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #f1f5f9;
    }

    .product-details {
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .product-qty {
        font-size: 12px;
        color: #64748b;
    }

    .status-select {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .status-select.pending {
        background: #fef3c7;
        color: #92400e;
        border-color: #fbbf24;
    }

    .status-select.processing {
        background: #dbeafe;
        color: #1e40af;
        border-color: #3b82f6;
    }

    .status-select.ready {
        background: #ede9fe;
        color: #5b21b6;
        border-color: #8b5cf6;
    }

    .status-select.completed {
        background: #d1fae5;
        color: #065f46;
        border-color: #10b981;
    }

    .status-select.rejected {
        background: #fee2e2;
        color: #991b1b;
        border-color: #ef4444;
    }

    .status-select:hover {
        opacity: 0.8;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 35px;
        height: 35px;
        border: none;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-view {
        background: #dbeafe;
        color: #2563eb;
    }

    .btn-view:hover {
        background: #3b82f6;
        color: white;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }

    .amount {
        font-weight: 700;
        color: #059669;
        font-size: 14px;
    }

    .date-text {
        color: #64748b;
        font-size: 13px;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 700px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        padding: 25px 30px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
    }

    .modal-close {
        width: 35px;
        height: 35px;
        border: none;
        background: #f1f5f9;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: #e2e8f0;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 30px;
    }

    .detail-section {
        margin-bottom: 25px;
    }

    .detail-section h4 {
        font-size: 14px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .detail-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }

    .detail-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
    }

    .product-detail-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .product-detail-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
    }

    .product-detail-info {
        flex: 1;
    }

    .product-detail-name {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .product-detail-meta {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .product-detail-price {
        font-size: 18px;
        font-weight: 800;
        color: #059669;
    }

    .modal-footer {
        padding: 20px 30px;
        border-top: 2px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state i {
        font-size: 80px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h4 {
        font-size: 20px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #94a3b8;
        font-size: 14px;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 25px;
    }

    .page-btn {
        width: 35px;
        height: 35px;
        border: 2px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: #64748b;
    }

    .page-btn:hover, .page-btn.active {
        background: #00897b;
        color: white;
        border-color: #00897b;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-row {
            grid-template-columns: repeat(3, 1fr);
        }

        .filter-row {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-row {
            grid-template-columns: 1fr;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="pesanan-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-inbox"></i> Pesan Masuk - Kelola Pesanan</h1>
        <p>Kelola semua pesanan yang masuk dari pelanggan</p>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card-small" onclick="filterByStatus('all')">
            <div class="stat-header">
                <div class="stat-icon-small all">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
            <div class="stat-label-small">Semua Pesanan</div>
            <div class="stat-value-small">{{ $totalPesanan ?? 0 }}</div>
        </div>

        <div class="stat-card-small" onclick="filterByStatus('pending')">
            <div class="stat-header">
                <div class="stat-icon-small pending">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-label-small">Pending</div>
            <div class="stat-value-small">{{ $pendingCount ?? 0 }}</div>
        </div>

        <div class="stat-card-small" onclick="filterByStatus('processing')">
            <div class="stat-header">
                <div class="stat-icon-small processing">
                    <i class="fas fa-spinner"></i>
                </div>
            </div>
            <div class="stat-label-small">Processing</div>
            <div class="stat-value-small">{{ $processingCount ?? 0 }}</div>
        </div>

        <div class="stat-card-small" onclick="filterByStatus('ready')">
            <div class="stat-header">
                <div class="stat-icon-small ready">
                    <i class="fas fa-box-open"></i>
                </div>
            </div>
            <div class="stat-label-small">Ready</div>
            <div class="stat-value-small">{{ $readyCount ?? 0 }}</div>
        </div>

        <div class="stat-card-small" onclick="filterByStatus('completed')">
            <div class="stat-header">
                <div class="stat-icon-small completed">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-label-small">Completed</div>
            <div class="stat-value-small">{{ $completedCount ?? 0 }}</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('admin.pesanmasuk') }}">
            <div class="filter-row">
                <div class="form-group">
                    <label>Cari Pesanan</label>
                    <input type="text" name="search" class="form-control" placeholder="No. Pesanan atau Nama Pelanggan" value="{{ request('search') }}">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                        <option value="Ready" {{ request('status') == 'Ready' ? 'selected' : '' }}>Ready</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="orders-container">
        <div class="table-header">
            <h3>Daftar Pesanan ({{ $orders->total() ?? 0 }})</h3>
        </div>

        @if(isset($orders) && $orders->count() > 0)
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <span class="order-number">#{{ $order->order_number }}</span>
                        </td>
                        <td>
                            <div class="customer-info">
                                <div class="customer-avatar">
                                    {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="customer-details">
                                    <div class="customer-name">{{ $order->user->name ?? 'N/A' }}</div>
                                    <div class="customer-email">{{ $order->user->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="product-info">
                                @if($order->product && $order->product->gambar)
                                    <img src="{{ asset('images/products/' . $order->product->gambar) }}" alt="{{ $order->product->nama_produk ?? 'Product' }}" class="product-image">
                                @else
                                    <div class="product-image" style="background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-box" style="color: #94a3b8;"></i>
                                    </div>
                                @endif
                                <div class="product-details">
                                    <div class="product-name">{{ $order->product->nama_produk ?? 'N/A' }}</div>
                                    <div class="product-qty">Qty: {{ $order->quantity ?? 0 }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <select class="status-select {{ strtolower($order->status) }}" 
                                    onchange="updateStatus('{{ $order->order_number }}', this.value)">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Ready" {{ $order->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Rejected" {{ $order->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </td>
                        <td>
                            <span class="date-text">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="viewOrderDetail('{{ $order->order_number }}')" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteOrder('{{ $order->order_number }}')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4>Belum ada pesanan</h4>
                <p>Pesanan dari pelanggan akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Detail Pesanan -->
<div class="modal" id="orderDetailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-file-invoice"></i> Detail Pesanan</h2>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Content will be loaded via AJAX -->
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 40px; color: #00897b;"></i>
                <p style="margin-top: 15px; color: #64748b;">Memuat data...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterByStatus(status) {
        const url = new URL(window.location.href);
        if (status === 'all') {
            url.searchParams.delete('status');
        } else {
            url.searchParams.set('status', status.charAt(0).toUpperCase() + status.slice(1));
        }
        window.location.href = url.toString();
    }

    function updateStatus(orderNumber, newStatus) {
        if (!confirm(`Ubah status pesanan #${orderNumber} menjadi ${newStatus}?`)) {
            location.reload();
            return;
        }

        fetch(`/admin/pesanmasuk/${orderNumber}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status pesanan berhasil diubah!');
                location.reload();
            } else {
                alert('Gagal mengubah status: ' + (data.message || 'Unknown error'));
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengubah status');
            location.reload();
        });
    }

    function viewOrderDetail(orderNumber) {
        document.getElementById('orderDetailModal').classList.add('show');
        
        fetch(`/admin/pesanmasuk/${orderNumber}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const order = data.order;
                    const modalBody = document.getElementById('modalBody');
                    
                    modalBody.innerHTML = `
                        <div class="detail-section">
                            <h4>Informasi Pesanan</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <span class="detail-label">No. Pesanan</span>
                                    <span class="detail-value">#${order.order_number}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Status</span>
                                    <span class="detail-value">${order.status}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Tanggal Order</span>
                                    <span class="detail-value">${new Date(order.created_at).toLocaleString('id-ID')}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Total Pembayaran</span>
                                    <span class="detail-value">Rp ${parseInt(order.total_amount).toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4>Informasi Pelanggan</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <span class="detail-label">Nama</span>
                                    <span class="detail-value">${order.user.name}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Email</span>
                                    <span class="detail-value">${order.user.email}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Telepon</span>
                                    <span class="detail-value">${order.user.phone || '-'}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Alamat</span>
                                    <span class="detail-value">${order.delivery_address || '-'}</span>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4>Informasi Produk</h4>
                            <div class="product-detail-card">
                                ${order.product.gambar ? 
                                    `<img src="/images/products/${order.product.gambar}" alt="${order.product.nama_produk}" class="product-detail-image">` :
                                    `<div class="product-detail-image" style="background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-box" style="color: #94a3b8; font-size: 24px;"></i>
                                    </div>`
                                }
                                <div class="product-detail-info">
                                    <div class="product-detail-name">${order.product.nama_produk}</div>
                                    <div class="product-detail-meta">
                                        Kategori: ${order.product.kategori} | Tipe: ${order.product.tipe_produk}
                                    </div>
                                    <div class="product-detail-meta">
                                        Quantity: ${order.quantity} ${order.product.satuan}
                                    </div>
                                    <div class="product-detail-price">
                                        Rp ${parseInt(order.product.harga_subsidi).toLocaleString('id-ID')} / ${order.product.satuan}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    alert('Gagal memuat detail pesanan');
                    closeModal();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat detail');
                closeModal();
            });
    }

    function closeModal() {
        document.getElementById('orderDetailModal').classList.remove('show');
    }

    function deleteOrder(orderNumber) {
        if (!confirm(`Apakah Anda yakin ingin menghapus pesanan #${orderNumber}?`)) {
            return;
        }

        fetch(`/admin/pesanmasuk/${orderNumber}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pesanan berhasil dihapus!');
                location.reload();
            } else {
                alert('Gagal menghapus pesanan: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus pesanan');
        });
    }

    // Close modal when clicking outside
    document.getElementById('orderDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endpush
