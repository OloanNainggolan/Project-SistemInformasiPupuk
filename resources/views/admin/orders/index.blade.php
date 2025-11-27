@extends('layouts.admin')

@section('title', 'Manajemen Pesanan - Admin Pupuk & Bibit')

@push('styles')
<style>
    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #10b981;
    }

    .page-subtitle {
        font-size: 15px;
        color: #6b7280;
    }

    /* Controls Section */
    .controls-section {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-box {
        flex: 1;
        min-width: 300px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 14px 45px 14px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .search-box input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }

    .search-box i {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #10b981;
        font-size: 16px;
    }

    .filter-select {
        padding: 14px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        cursor: pointer;
        background: white;
        transition: all 0.3s;
        min-width: 180px;
        font-weight: 500;
    }

    .filter-select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }

    /* Orders List */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .order-card:hover {
        box-shadow: 0 8px 25px rgba(16,185,129,0.15);
        transform: translateY(-2px);
    }

    .order-header {
        background: linear-gradient(135deg, #f8faf8, #f0f4f0);
        padding: 18px 24px;
        display: grid;
        grid-template-columns: 1.5fr 2fr 2fr 1.5fr auto;
        gap: 15px;
        align-items: center;
        border-bottom: 2px solid #e5e7eb;
    }

    .order-id {
        font-weight: 700;
        color: #065f46;
        font-size: 15px;
    }

    .order-customer {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .customer-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    .customer-phone {
        font-size: 13px;
        color: #6b7280;
    }

    .customer-phone i {
        color: #10b981;
        margin-right: 5px;
    }

    .order-village {
        font-size: 14px;
        color: #4b5563;
    }

    .order-village i {
        color: #10b981;
        margin-right: 5px;
    }

    .order-date {
        font-size: 13px;
        color: #6b7280;
    }

    .order-date i {
        color: #10b981;
        margin-right: 5px;
    }

    .order-body {
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 25px;
        align-items: start;
    }

    .order-items {
        flex: 1;
    }

    .items-title {
        font-size: 13px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .item-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    .item-name {
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    .item-details {
        font-size: 13px;
        color: #666;
    }

    .order-total-section {
        background: #f8f9fa;
        padding: 15px 20px;
        border-radius: 8px;
        min-width: 200px;
    }

    .total-label {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
    }

    .total-amount {
        font-size: 24px;
        font-weight: 700;
        color: #2d5016;
    }

    .order-status-section {
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: flex-end;
        min-width: 220px;
    }

    .status-label {
        font-size: 13px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-dropdown {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .status-dropdown:focus {
        outline: none;
        border-color: #10b981;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
    }

    .status-badge.processing {
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        color: #5b21b6;
    }

    .status-badge.ready {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .status-badge.completed {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }

    .status-badge.rejected {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }

    /* Loading */
    .loading-container {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .loading-spinner {
        display: inline-block;
        width: 50px;
        height: 50px;
        border: 4px solid #f3f4f6;
        border-top: 4px solid #10b981;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 60px;
        color: #ddd;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 16px;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
        padding: 20px 0;
    }

    .pagination button {
        padding: 10px 20px;
        border: 1px solid #e0e0e0;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .pagination button:hover:not(:disabled) {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
    }

    .pagination button:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .page-info {
        font-size: 14px;
        color: #666;
        font-weight: 500;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.6);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }

    .modal-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .modal-header i {
        font-size: 32px;
        color: #f44336;
    }

    .modal-title {
        font-size: 22px;
        font-weight: 700;
        color: #333;
    }

    .modal-body {
        margin-bottom: 25px;
    }

    .modal-body p {
        font-size: 15px;
        color: #555;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .modal-body textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        min-height: 80px;
        resize: vertical;
    }

    .modal-body textarea:focus {
        outline: none;
        border-color: #4CAF50;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .modal-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }

    .modal-btn-cancel {
        background: #e0e0e0;
        color: #666;
    }

    .modal-btn-cancel:hover {
        background: #d0d0d0;
    }

    .modal-btn-confirm {
        background: #f44336;
        color: white;
    }

    .modal-btn-confirm:hover {
        background: #d32f2f;
    }

    /* Toast */
    .toast {
        position: fixed;
        top: 90px;
        right: 20px;
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        z-index: 10000;
        display: none;
        align-items: center;
        gap: 12px;
        min-width: 320px;
        max-width: 400px;
    }

    .toast.active {
        display: flex;
        animation: slideIn 0.4s ease-out;
    }

    .toast.success {
        border-left: 4px solid #4CAF50;
    }

    .toast.success i {
        color: #4CAF50;
        font-size: 20px;
    }

    .toast.error {
        border-left: 4px solid #f44336;
    }

    .toast.error i {
        color: #f44336;
        font-size: 20px;
    }

    .toast-message {
        flex: 1;
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .order-header {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .order-body {
            grid-template-columns: 1fr;
        }

        .order-status-section {
            align-items: flex-start;
            width: 100%;
        }

        .order-total-section {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .controls-section {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            min-width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        .page-title {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-shopping-cart"></i>
        Manajemen Pesanan
    </h1>
    <p class="page-subtitle">Kelola dan monitor semua pesanan yang masuk dari petani</p>
</div>

<!-- Controls: Search & Filter -->
<div class="controls-section">
    <div class="search-box">
        <input 
            type="text" 
            id="searchInput" 
            placeholder="Cari berdasarkan nama, ID pesanan..."
            autocomplete="off"
        >
        <i class="fas fa-search"></i>
    </div>
    
    <select id="statusFilter" class="filter-select">
        <option value="all">Semua Status</option>
        <option value="Pending">Pending</option>
        <option value="Processing">Processing</option>
        <option value="Ready">Ready</option>
        <option value="Completed">Completed</option>
        <option value="Rejected">Rejected</option>
    </select>
</div>

<!-- Orders List -->
<div class="orders-list" id="ordersList">
    <div class="loading-container">
        <div class="loading-spinner"></div>
        <p>Memuat data pesanan...</p>
    </div>
</div>

<!-- Pagination -->
<div class="pagination" id="paginationContainer" style="display: none;">
    <button id="prevPage" onclick="prevPage()">
        <i class="fas fa-chevron-left"></i> Sebelumnya
    </button>
    <span class="page-info" id="pageInfo">Halaman 1 dari 1</span>
    <button id="nextPage" onclick="nextPage()">
        Selanjutnya <i class="fas fa-chevron-right"></i>
    </button>
</div>

<!-- Modal Konfirmasi Reject -->
<div class="modal" id="rejectModal">
    <div class="modal-content">
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle"></i>
            <h3 class="modal-title">Konfirmasi Penolakan</h3>
        </div>
        <div class="modal-body">
            <p>Anda akan menolak pesanan <strong id="rejectOrderId">-</strong>.</p>
            <p>Silakan masukkan alasan penolakan:</p>
            <textarea 
                id="rejectionReason" 
                placeholder="Contoh: Stok pupuk tidak mencukupi..."
                required
            ></textarea>
        </div>
        <div class="modal-actions">
            <button class="modal-btn modal-btn-cancel" onclick="closeRejectModal()">
                Batal
            </button>
            <button class="modal-btn modal-btn-confirm" onclick="confirmReject()">
                Ya, Tolak Pesanan
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle" id="toastIcon"></i>
    <span class="toast-message" id="toastMessage">Success!</span>
</div>
@endsection

@push('scripts')
<script>
    // State Management
    let currentPage = 1;
    let currentStatus = 'all';
    let currentSearch = '';
    let pendingStatusChange = null;

    // Load orders
    async function loadOrders(page = 1, status = 'all', search = '') {
        currentPage = page;
        currentStatus = status;
        currentSearch = search;

        const container = document.getElementById('ordersList');
        container.innerHTML = `
            <div class="loading-container">
                <div class="loading-spinner"></div>
                <p>Memuat data pesanan...</p>
            </div>
        `;

        try {
            const url = `/admin/api/orders?page=${page}&limit=10&status=${status}&query=${encodeURIComponent(search)}`;
            const response = await fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error('Failed to fetch orders');
            }

            const data = await response.json();
            renderOrders(data.orders);
            renderPagination(data);
        } catch (error) {
            console.error('Error loading orders:', error);
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Gagal memuat data pesanan. Silakan coba lagi.</p>
                </div>
            `;
        }
    }

    // Render orders
    function renderOrders(orders) {
        const container = document.getElementById('ordersList');

        if (orders.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Tidak ada pesanan yang ditemukan</p>
                </div>
            `;
            return;
        }

        const html = orders.map(order => `
            <div class="order-card">
                <div class="order-header">
                    <div class="order-id">${order.id}</div>
                    <div class="order-customer">
                        <div class="customer-name">${order.name}</div>
                        <div class="customer-phone">
                            <i class="fas fa-phone"></i> ${order.phone}
                        </div>
                    </div>
                    <div class="order-village">
                        <i class="fas fa-map-marker-alt"></i> ${order.village_office}
                    </div>
                    <div class="order-date">
                        <i class="fas fa-calendar"></i> ${order.date_formatted}
                    </div>
                </div>
                <div class="order-body">
                    <div class="order-items">
                        <div class="items-title">Detail Pesanan</div>
                        <div class="item-list">
                            ${order.items.map(item => `
                                <div class="item-row">
                                    <div>
                                        <div class="item-name">${item.name}</div>
                                        <div class="item-details">${item.qty} × Rp${formatNumber(item.price)}</div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    <div style="display: flex; gap: 20px; flex-direction: column;">
                        <div class="order-total-section">
                            <div class="total-label">Total Pembayaran</div>
                            <div class="total-amount">${order.total_formatted}</div>
                        </div>
                        <div class="order-status-section">
                            <div class="status-label">Update Status :</div>
                            <select 
                                class="status-dropdown" 
                                data-order-id="${order.id}"
                                data-current-status="${order.status}"
                                onchange="handleStatusChange(this)"
                            >
                                <option value="Pending" ${order.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="Processing" ${order.status === 'Processing' ? 'selected' : ''}>Processing</option>
                                <option value="Ready" ${order.status === 'Ready' ? 'selected' : ''}>Ready</option>
                                <option value="Completed" ${order.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                <option value="Rejected" ${order.status === 'Rejected' ? 'selected' : ''}>Rejected</option>
                            </select>
                            <div class="status-badge ${order.status.toLowerCase()}">${order.status}</div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');

        container.innerHTML = html;
    }

    // Render pagination
    function renderPagination(data) {
        const container = document.getElementById('paginationContainer');
        const pageInfo = document.getElementById('pageInfo');
        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        if (data.total === 0) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'flex';
        pageInfo.textContent = `Halaman ${data.page} dari ${data.last_page}`;
        
        prevBtn.disabled = data.page <= 1;
        nextBtn.disabled = data.page >= data.last_page;
    }

    // Handle status change
    function handleStatusChange(selectElement) {
        const orderId = selectElement.getAttribute('data-order-id');
        const currentStatus = selectElement.getAttribute('data-current-status');
        const newStatus = selectElement.value;

        if (newStatus === currentStatus) {
            return;
        }

        if (newStatus === 'Rejected') {
            // Show confirmation modal
            pendingStatusChange = { orderId, newStatus, selectElement };
            document.getElementById('rejectOrderId').textContent = orderId;
            document.getElementById('rejectModal').classList.add('active');
        } else {
            // Update immediately
            updateOrderStatus(orderId, newStatus, selectElement);
        }
    }

    // Confirm reject
    async function confirmReject() {
        const reason = document.getElementById('rejectionReason').value.trim();
        
        if (!reason) {
            showToast('Alasan penolakan harus diisi', 'error');
            return;
        }

        if (pendingStatusChange) {
            await updateOrderStatus(
                pendingStatusChange.orderId, 
                pendingStatusChange.newStatus, 
                pendingStatusChange.selectElement,
                reason
            );
        }

        closeRejectModal();
    }

    // Close reject modal
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('active');
        document.getElementById('rejectionReason').value = '';
        
        if (pendingStatusChange) {
            // Reset dropdown to current status
            pendingStatusChange.selectElement.value = pendingStatusChange.selectElement.getAttribute('data-current-status');
            pendingStatusChange = null;
        }
    }

    // Update order status
    async function updateOrderStatus(orderId, newStatus, selectElement, rejectionReason = '') {
        try {
            const response = await fetch(`/admin/api/orders/${orderId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ 
                    status: newStatus,
                    rejection_reason: rejectionReason
                })
            });

            const data = await response.json();

            if (data.success) {
                showToast('Status pesanan berhasil diupdate!', 'success');
                // Reload orders to reflect changes
                loadOrders(currentPage, currentStatus, currentSearch);
            } else {
                throw new Error(data.message || 'Update failed');
            }
        } catch (error) {
            console.error('Error updating status:', error);
            showToast('Gagal mengupdate status pesanan', 'error');
            // Reset dropdown
            selectElement.value = selectElement.getAttribute('data-current-status');
        }
    }

    // Format number
    function formatNumber(num) {
        return Number(num).toLocaleString('id-ID');
    }

    // Show toast
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const icon = document.getElementById('toastIcon');
        const msg = document.getElementById('toastMessage');

        toast.className = `toast ${type}`;
        icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        msg.textContent = message;

        toast.classList.add('active');

        setTimeout(() => {
            toast.classList.remove('active');
        }, 3500);
    }

    // Pagination
    function prevPage() {
        if (currentPage > 1) {
            loadOrders(currentPage - 1, currentStatus, currentSearch);
        }
    }

    function nextPage() {
        loadOrders(currentPage + 1, currentStatus, currentSearch);
    }

    // Search & Filter
    let searchTimeout;
    document.getElementById('searchInput').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadOrders(1, currentStatus, e.target.value);
        }, 500);
    });

    document.getElementById('statusFilter').addEventListener('change', function(e) {
        loadOrders(1, e.target.value, currentSearch);
    });

    // Initial load
    document.addEventListener('DOMContentLoaded', function() {
        loadOrders();
    });
</script>
@endpush
