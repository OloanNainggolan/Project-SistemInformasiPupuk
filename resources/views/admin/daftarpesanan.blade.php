@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@push('styles')
<style>
    .orders-container {
        padding: 30px;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .page-header {
        background: white;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #00897b;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stat-icon.all { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-icon.pending { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-icon.processing { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .stat-icon.ready { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .stat-icon.completed { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

    .stat-info h4 {
        font-size: 14px;
        color: #64748b;
        margin: 0 0 5px 0;
        font-weight: 500;
    }

    .stat-info p {
        font-size: 24px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    /* Filters */
    .filters-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .filter-input {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .filter-input:focus {
        outline: none;
        border-color: #00897b;
    }

    .btn-filter {
        padding: 10px 25px;
        background: #00897b;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        align-self: flex-end;
    }

    .btn-filter:hover {
        background: #00695c;
    }

    .btn-reset {
        padding: 10px 25px;
        background: #e2e8f0;
        color: #4a5568;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        align-self: flex-end;
    }

    .btn-reset:hover {
        background: #cbd5e0;
    }

    /* Orders Table */
    .orders-table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead {
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
        color: white;
    }

    .orders-table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
    }

    .orders-table td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
    }

    .orders-table tbody tr {
        transition: background 0.2s;
    }

    .orders-table tbody tr:hover {
        background: #f7fafc;
    }

    .order-id {
        font-weight: 700;
        color: #00897b;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
    }

    .user-details h5 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #1a202c;
    }

    .user-details p {
        margin: 0;
        font-size: 12px;
        color: #64748b;
    }

    .product-info {
        max-width: 250px;
    }

    .product-name {
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 3px;
    }

    .product-qty {
        font-size: 12px;
        color: #64748b;
    }

    .price {
        font-weight: 700;
        color: #00897b;
        font-size: 15px;
    }

    /* Status Badge */
    .status-select {
        padding: 8px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
    }

    .status-select:focus {
        outline: none;
        border-color: #00897b;
    }

    .status-select.Pending {
        background: #fef3c7;
        color: #92400e;
        border-color: #fbbf24;
    }

    .status-select.Processing {
        background: #dbeafe;
        color: #1e40af;
        border-color: #3b82f6;
    }

    .status-select option[value="Ready for Pickup"] {
        background: #d1fae5;
        color: #065f46;
    }

    .status-select.Completed {
        background: #d1fae5;
        color: #065f46;
        border-color: #10b981;
    }

    .status-select.Cancelled {
        background: #fee2e2;
        color: #991b1b;
        border-color: #ef4444;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 35px;
        height: 35px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-view {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-view:hover {
        background: #3b82f6;
        color: white;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }

    /* Pagination */
    .pagination-container {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 5px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination li {
        margin: 0;
    }

    .pagination a,
    .pagination span {
        padding: 8px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        color: #4a5568;
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 600;
        font-size: 14px;
        display: block;
    }

    .pagination a:hover {
        background: #00897b;
        color: white;
        border-color: #00897b;
    }

    .pagination .active span {
        background: #00897b;
        color: white;
        border-color: #00897b;
    }

    .pagination .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #4a5568;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #718096;
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

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 12px;
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e2e8f0;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 22px;
        color: #1a202c;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #4a5568;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .modal-close:hover {
        background: #e2e8f0;
    }

    .detail-group {
        margin-bottom: 20px;
    }

    .detail-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        color: #1a202c;
        padding: 10px;
        background: #f7fafc;
        border-radius: 6px;
    }

    /* Loading Spinner */
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #00897b;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-left: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filters-section {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .btn-filter,
        .btn-reset {
            width: 100%;
        }

        .table-responsive {
            overflow-x: scroll;
        }
    }
</style>
@endpush

@section('content')
<div class="orders-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-clipboard-list"></i>
            Daftar Pesanan
        </h1>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon all">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h4>Total Pesanan</h4>
                <p>{{ $orders->total() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h4>Pending</h4>
                <p>{{ $orders->where('status', 'Pending')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon processing">
                <i class="fas fa-sync-alt"></i>
            </div>
            <div class="stat-info">
                <h4>Diproses</h4>
                <p>{{ $orders->where('status', 'Processing')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon ready">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-info">
                <h4>Siap Diambil</h4>
                <p>{{ $orders->where('status', 'Ready for Pickup')->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon completed">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h4>Selesai</h4>
                <p>{{ $orders->where('status', 'Completed')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.daftarpesanan') }}" style="display: contents;">
            <div class="filter-group">
                <label>Cari Pesanan</label>
                <input type="text" name="search" class="filter-input" placeholder="Cari Order ID atau Nama User..." value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <label>Filter Status</label>
                <select name="status" class="filter-input">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Processing" {{ request('status') == 'Processing' ? 'selected' : '' }}>Processing</option>
                    <option value="Ready for Pickup" {{ request('status') == 'Ready for Pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.daftarpesanan') }}" class="btn-reset">
                <i class="fas fa-redo"></i> Reset
            </a>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="orders-table-container">
        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <span class="order-id">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($order->user->nama_lengkap ?? 'U', 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <h5>{{ $order->user->nama_lengkap ?? 'N/A' }}</h5>
                                    <p>{{ $order->user->no_telp ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="product-info">
                                <div class="product-name">{{ $order->product->nama_produk ?? 'N/A' }}</div>
                                <div class="product-qty">Qty: {{ $order->quantity ?? 0 }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="price">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <select class="status-select {{ $order->status }}" data-order-id="{{ $order->id }}" onchange="updateStatus(this)">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                <option value="Ready for Pickup" {{ $order->status == 'Ready for Pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}<br><small style="color: #64748b;">{{ $order->created_at->format('H:i') }}</small></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-view" onclick="viewOrder({{ $order->id }})" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteOrder({{ $order->id }})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h3>Tidak Ada Pesanan</h3>
                                <p>Belum ada pesanan yang masuk saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="pagination-container">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail Order -->
<div class="modal" id="orderModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-file-invoice"></i> Detail Pesanan</h3>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="orderDetails">
            <!-- Details will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update Order Status
    function updateStatus(selectElement) {
        const orderId = selectElement.getAttribute('data-order-id');
        const newStatus = selectElement.value;
        const oldClass = selectElement.className.split(' ').find(c => ['Pending', 'Processing', 'Completed', 'Cancelled'].includes(c));
        
        // Show loading
        selectElement.style.opacity = '0.6';
        selectElement.disabled = true;

        fetch(`/admin/daftarpesanan/${orderId}/update-status`, {
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
                // Update class for styling
                selectElement.classList.remove(oldClass);
                selectElement.classList.add(newStatus);
                selectElement.style.opacity = '1';
                selectElement.disabled = false;
                
                // Show success notification
                showNotification('Status berhasil diupdate! Notifikasi telah dikirim ke user.', 'success');
            } else {
                throw new Error(data.message || 'Gagal update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            selectElement.value = oldClass || 'Pending';
            selectElement.style.opacity = '1';
            selectElement.disabled = false;
            showNotification('Gagal update status: ' + error.message, 'error');
        });
    }

    // View Order Details
    function viewOrder(orderId) {
        const modal = document.getElementById('orderModal');
        const detailsContainer = document.getElementById('orderDetails');
        
        detailsContainer.innerHTML = '<div style="text-align: center; padding: 40px;"><div class="spinner"></div></div>';
        modal.classList.add('active');

        fetch(`/admin/daftarpesanan/${orderId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const order = data.order;
                    let itemsHtml = '';
                    
                    if (order.items && order.items.length > 0) {
                        itemsHtml = '<div class="detail-group"><div class="detail-label">Items</div><div class="detail-value">';
                        order.items.forEach(item => {
                            itemsHtml += `<div style="padding: 5px 0;">${item.name} - ${item.quantity}x - Rp ${item.price.toLocaleString('id-ID')}</div>`;
                        });
                        itemsHtml += '</div></div>';
                    }

                    detailsContainer.innerHTML = `
                        <div class="detail-group">
                            <div class="detail-label">Order ID</div>
                            <div class="detail-value">#${String(order.id).padStart(4, '0')}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Nama Customer</div>
                            <div class="detail-value">${order.user_name}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">No. Telepon</div>
                            <div class="detail-value">${order.user_phone}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value">${order.user_address}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Produk</div>
                            <div class="detail-value">${order.product_name}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Jumlah</div>
                            <div class="detail-value">${order.quantity}</div>
                        </div>
                        ${itemsHtml}
                        <div class="detail-group">
                            <div class="detail-label">Total Pembayaran</div>
                            <div class="detail-value" style="font-weight: 700; color: #00897b; font-size: 18px;">Rp ${order.total_amount.toLocaleString('id-ID')}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Status</div>
                            <div class="detail-value"><span class="status-badge ${order.status}">${order.status}</span></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Tanggal Pesanan</div>
                            <div class="detail-value">${order.created_at}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Terakhir Update</div>
                            <div class="detail-value">${order.updated_at}</div>
                        </div>
                    `;
                } else {
                    detailsContainer.innerHTML = '<p style="text-align: center; color: #e53e3e;">Gagal memuat detail pesanan</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                detailsContainer.innerHTML = '<p style="text-align: center; color: #e53e3e;">Terjadi kesalahan saat memuat data</p>';
            });
    }

    // Delete Order
    function deleteOrder(orderId) {
        if (!confirm('Apakah Anda yakin ingin menghapus pesanan ini? Notifikasi akan dikirim ke user.')) {
            return;
        }

        fetch(`/admin/daftarpesanan/${orderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Pesanan berhasil dihapus! Notifikasi telah dikirim ke user.', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                throw new Error(data.message || 'Gagal menghapus pesanan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal menghapus pesanan: ' + error.message, 'error');
        });
    }

    // Close Modal
    function closeModal() {
        document.getElementById('orderModal').classList.remove('active');
    }

    // Click outside modal to close
    document.getElementById('orderModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Notification System
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'success' ? '#10b981' : '#ef4444'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            font-weight: 600;
            animation: slideIn 0.3s ease-out;
        `;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            ${message}
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Add animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(400px); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
