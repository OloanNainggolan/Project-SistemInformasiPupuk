 @extends('layouts.user')

@section('title', 'Profil User')

@push('styles')
<style>
    /* Main Container */
    .container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 2rem;
        margin-top: 100px;
    }

    .dashboard-title {
        background: linear-gradient(135deg, #4caf50, #45a049);
        padding: 1.2rem 2rem;
        border-radius: 15px;
        display: inline-block;
        font-size: 1.6rem;
        font-weight: 700;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(76, 175, 80, 0.3);
    }

    .dashboard-content {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 2.5rem;
    }

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        height: fit-content;
        border: 1px solid #f0f0f0;
    }

    .profile-card .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        margin: 0 auto 1.2rem;
        overflow: hidden;
        border: 3px solid #4caf50;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-card .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .profile-name h2 {
        font-size: 1.3rem;
        color: #2e7d32;
        margin-bottom: 0.3rem;
        font-weight: 600;
    }

    .profile-name p {
        color: #888;
        font-size: 0.9rem;
    }

    .profile-info {
        margin: 1.5rem 0;
        padding: 1.5rem 0;
        border-top: 1px solid #e8e8e8;
        border-bottom: 1px solid #e8e8e8;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.9rem;
        margin-bottom: 1.1rem;
        color: #555;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        font-size: 18px;
        min-width: 20px;
        text-align: center;
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        margin-top: 1.5rem;
    }

    .btn {
        padding: 0.85rem 1rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
    }

    .btn-edit {
        background: #4caf50;
        color: white;
        box-shadow: 0 2px 8px rgba(76, 175, 80, 0.2);
    }

    .btn-edit:hover {
        background: #45a049;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .btn-logout {
        background: #f44336;
        color: white;
        box-shadow: 0 2px 8px rgba(244, 67, 54, 0.2);
    }

    .btn-logout:hover {
        background: #da190b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
    }

    /* Land Info Section */
    .land-info {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        border: 1px solid #f0f0f0;
    }

    .land-info h3 {
        font-size: 1.15rem;
        color: #2e7d32;
        margin-bottom: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .land-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .land-item {
        background: #fafafa;
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #f0f0f0;
    }

    .land-label {
        font-size: 0.85rem;
        color: #777;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .land-value {
        font-size: 1.05rem;
        font-weight: 600;
        color: #333;
    }

    .commodity-tags {
        display: flex;
        gap: 0.8rem;
        margin-top: 1rem;
    }

    .tag {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .tag-padi {
        background: #fff3e0;
        color: #f57c00;
    }

    .tag-jagung {
        background: #fff9c4;
        color: #f9a825;
    }

    /* Stats Section */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }

    .stat-card.purple {
        background: linear-gradient(135deg, #5e35b1, #7e57c2);
        color: white;
    }

    .stat-card.blue {
        background: linear-gradient(135deg, #1e88e5, #42a5f5);
        color: white;
    }

    .stat-card.red {
        background: linear-gradient(135deg, #e53935, #ef5350);
        color: white;
    }

    .stat-card.pink {
        background: linear-gradient(135deg, #d81b60, #ec407a);
        color: white;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.95;
        font-weight: 500;
    }

    /* Orders Table */
    .orders-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    }

    .orders-section h3 {
        font-size: 1.3rem;
        color: #2e7d32;
        margin-bottom: 1.5rem;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f5f5f5;
    }

    th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #555;
        font-size: 0.9rem;
        border-bottom: 2px solid #e0e0e0;
    }

    td {
        padding: 1.2rem 1rem;
        border-bottom: 1px solid #f0f0f0;
        color: #555;
    }

    tr {
        transition: background 0.2s ease;
    }

    tbody tr:hover {
        background: #f9f9f9;
    }

    .order-id {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 0.2rem;
    }

    .order-name {
        font-weight: 600;
        color: #333;
    }

    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        background: #c8e6c9;
        color: #2e7d32;
        display: inline-block;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }

    .page-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #e0e0e0;
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-weight: 600;
        color: #555;
    }

    .page-btn:hover {
        border-color: #4caf50;
        color: #4caf50;
    }

    .page-btn.active {
        background: #4caf50;
        color: white;
        border-color: #4caf50;
    }

    .page-arrow {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #4caf50;
        background: white;
        color: #4caf50;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .page-arrow:hover {
        background: #4caf50;
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .container {
            max-width: 100%;
            padding: 1.5rem;
        }

        .dashboard-content {
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }
    }

    @media (max-width: 1024px) {
        .container {
            margin-top: 90px;
            padding: 1.5rem;
        }

        .dashboard-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .profile-card {
            max-width: 400px;
            margin: 0 auto;
        }

        .main-content {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
            margin-top: 80px;
        }

        .dashboard-title {
            font-size: 1.4rem;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .profile-card {
            padding: 1.5rem;
            max-width: 100%;
        }

        .profile-card .profile-avatar {
            width: 90px;
            height: 90px;
            margin-bottom: 1rem;
        }

        .profile-name h2 {
            font-size: 1.1rem;
        }

        .info-item {
            font-size: 0.85rem;
            gap: 0.7rem;
        }

        .btn {
            padding: 0.75rem 0.9rem;
            font-size: 0.9rem;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-value {
            font-size: 1.8rem;
        }

        .stat-label {
            font-size: 0.8rem;
        }

        .section-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .land-info {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        table {
            font-size: 0.85rem;
        }

        th, td {
            padding: 0.8rem 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-buttons .btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0.75rem;
        }

        .dashboard-title {
            font-size: 1.2rem;
            padding: 0.9rem 1.2rem;
        }

        .profile-card {
            padding: 1.2rem;
        }

        .profile-card .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .profile-name h2 {
            font-size: 1rem;
        }

        .info-item {
            font-size: 0.8rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 0.8rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-value {
            font-size: 1.6rem;
        }

        .land-details {
            flex-direction: column;
            gap: 0.8rem;
        }

        table {
            font-size: 0.8rem;
        }

        th, td {
            padding: 0.6rem 0.4rem;
        }

        .order-number {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.8rem;">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    
    <div class="dashboard-title">User Dashboard</div>

    <div class="dashboard-content">
        <!-- Left Sidebar - Profile Card -->
        <aside>
            <div class="profile-card">
                <div class="profile-avatar">
                    <img src="{{ auth()->user()->foto ? asset('images/profiles/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_lengkap) . '&background=4caf50&color=fff&size=200' }}" alt="Profile">
                </div>
                <div class="profile-name">
                    <h2>{{ auth()->user()->nama_lengkap }}</h2>
                    <p>{{ auth()->user()->username ?? 'User' }}</p>
                </div>
                <div class="profile-info">
                    <div class="info-item">
                        <span class="info-icon">✉️</span>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">📞</span>
                        <span>{{ auth()->user()->no_telp }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">📍</span>
                        <span>{{ auth()->user()->alamat }}{{ auth()->user()->kabupaten ? ', ' . auth()->user()->kabupaten : '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">📅</span>
                        <span>Bergabung Sejak {{ auth()->user()->created_at->format('F Y') }}</span>
                    </div>
                </div>
                <div class="profile-actions">
                    <a href="{{ route('profil.edit') }}" class="btn btn-edit" style="text-decoration: none; text-align: center;">Edit Profil</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-logout" style="width: 100%;">➜ Keluar</button>
                    </form>
                </div>
            </div>

            <!-- Land Info -->
            <div class="land-info">
                <h3>Informasi Lahan</h3>
                <div class="land-details">
                    <div class="land-item">
                        <div class="land-label">Luas Lahan</div>
                        <div class="land-value">3 Ha</div>
                    </div>
                </div>
                <div class="land-label" style="margin-top: 1.5rem;">Komoditas</div>
                <div class="commodity-tags">
                    <span class="tag tag-padi">Padi</span>
                    <span class="tag tag-jagung">Jagung</span>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main>
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card purple">
                    <div class="stat-value">{{ $totalPesanan }}</div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-value">{{ number_format($totalPupuk / 1000, 1) }} Ton</div>
                    <div class="stat-label">Pupuk Diterima</div>
                </div>
                <div class="stat-card red">
                    <div class="stat-value">{{ number_format($totalBibit, 0) }} Kg</div>
                    <div class="stat-label">Bibit Diterima</div>
                </div>
                <div class="stat-card pink">
                    <div class="stat-value">{{ number_format($totalPenghematan / 1000000, 1) }} Jt</div>
                    <div class="stat-label">Penghematan</div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="orders-section">
                <h3>Riwayat Pesanan</h3>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Pesanan</th>
                                <th>Tanggal Order</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr style="cursor: pointer; transition: background 0.2s;" 
                                onmouseover="this.style.background='#f8f9fa'" 
                                onmouseout="this.style.background='white'"
                                onclick="showOrderDetail({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->created_at->format('d F Y') }}', {{ json_encode($order->items) }}, {{ $order->total_amount }}, '{{ $order->status }}', '{{ $order->user->nama_lengkap }}', '{{ $order->user->alamat }}', '{{ $order->user->phone }}')">
                                <td>
                                    <div class="order-id">{{ $order->order_number }}</div>
                                    <div class="order-name">
                                        @php
                                            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
                                            $productNames = array_column($items, 'name');
                                            echo implode(', ', array_slice($productNames, 0, 2));
                                            if(count($productNames) > 2) echo ' +' . (count($productNames) - 2) . ' lainnya';
                                        @endphp
                                    </div>
                                </td>
                                <td>{{ $order->created_at->format('d F Y') }}</td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->status === 'Pending')
                                        <span class="status-badge" style="background: #fff3cd; color: #856404;">Pending</span>
                                    @elseif($order->status === 'Processing')
                                        <span class="status-badge" style="background: #cfe2ff; color: #084298;">Diproses</span>
                                    @elseif($order->status === 'Ready')
                                        <span class="status-badge" style="background: #d1e7dd; color: #0f5132;">Siap Diambil</span>
                                    @elseif($order->status === 'Completed')
                                        <span class="status-badge">Selesai</span>
                                    @elseif($order->status === 'Cancelled')
                                        <span class="status-badge" style="background: #f8d7da; color: #842029;">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                    Belum ada riwayat pesanan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="pagination" style="margin-top: 2rem;">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

<!-- Order Detail Modal -->
<div id="orderDetailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 15px; max-width: 700px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
        <!-- Modal Header -->
        <div style="padding: 1.5rem 2rem; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
            <div>
                <h3 style="margin: 0; font-size: 1.3rem;">Detail Pesanan</h3>
                <p id="modalOrderNumber" style="margin: 0.5rem 0 0 0; opacity: 0.9; font-size: 0.95rem;"></p>
            </div>
            <button onclick="closeModal()" style="background: rgba(255,255,255,0.2); border: none; color: white; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 1.3rem; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                ×
            </button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 2rem;">
            <!-- Customer Info -->
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <h4 style="margin: 0 0 1rem 0; color: #333; font-size: 1.1rem;">
                    <i class="fas fa-user" style="margin-right: 0.5rem; color: #667eea;"></i>
                    Informasi Pemesan
                </h4>
                <div style="display: grid; gap: 0.8rem;">
                    <div style="display: flex;">
                        <span style="color: #666; width: 120px;">Nama</span>
                        <span style="color: #333; font-weight: 500;" id="modalCustomerName"></span>
                    </div>
                    <div style="display: flex;">
                        <span style="color: #666; width: 120px;">Telepon</span>
                        <span style="color: #333; font-weight: 500;" id="modalCustomerPhone"></span>
                    </div>
                    <div style="display: flex;">
                        <span style="color: #666; width: 120px;">Alamat</span>
                        <span style="color: #333; font-weight: 500;" id="modalCustomerAddress"></span>
                    </div>
                    <div style="display: flex;">
                        <span style="color: #666; width: 120px;">Tanggal Order</span>
                        <span style="color: #333; font-weight: 500;" id="modalOrderDate"></span>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div style="margin-bottom: 1.5rem;">
                <h4 style="margin: 0 0 1rem 0; color: #333; font-size: 1.1rem;">
                    <i class="fas fa-box" style="margin-right: 0.5rem; color: #667eea;"></i>
                    Produk yang Dipesan
                </h4>
                <div id="modalProducts" style="display: grid; gap: 0.8rem;"></div>
            </div>

            <!-- Status & Total -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; color: white;">
                <div>
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.3rem;">Status Pesanan</div>
                    <div id="modalStatus" style="font-size: 1.1rem; font-weight: 600;"></div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.3rem;">Total Pembayaran</div>
                    <div id="modalTotal" style="font-size: 1.4rem; font-weight: 700;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showOrderDetail(id, orderNumber, date, items, total, status, customerName, customerAddress, customerPhone) {
    // Parse items if string
    const products = typeof items === 'string' ? JSON.parse(items) : items;
    
    // Set modal content
    document.getElementById('modalOrderNumber').textContent = orderNumber;
    document.getElementById('modalOrderDate').textContent = date;
    document.getElementById('modalCustomerName').textContent = customerName;
    document.getElementById('modalCustomerPhone').textContent = customerPhone;
    document.getElementById('modalCustomerAddress').textContent = customerAddress;
    
    // Status translation
    const statusMap = {
        'Pending': 'Menunggu Konfirmasi',
        'Processing': 'Sedang Diproses',
        'Ready': 'Siap Diambil',
        'Completed': 'Selesai',
        'Cancelled': 'Dibatalkan'
    };
    document.getElementById('modalStatus').textContent = statusMap[status] || status;
    
    // Format total
    document.getElementById('modalTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    
    // Render products
    const productsHtml = products.map(item => `
        <div style="display: flex; justify-content: space-between; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
            <div>
                <div style="font-weight: 600; color: #333; margin-bottom: 0.3rem;">${item.name}</div>
                <div style="color: #666; font-size: 0.9rem;">
                    ${item.qty} Kg × Rp ${item.price.toLocaleString('id-ID')}
                </div>
            </div>
            <div style="font-weight: 700; color: #667eea; font-size: 1.1rem;">
                Rp ${(item.qty * item.price).toLocaleString('id-ID')}
            </div>
        </div>
    `).join('');
    
    document.getElementById('modalProducts').innerHTML = productsHtml;
    
    // Show modal
    const modal = document.getElementById('orderDetailModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('orderDetailModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('orderDetailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

@endsection

@push('scripts')
<script>
    // Pagination functionality
    const pageButtons = document.querySelectorAll('.page-btn');
    pageButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            pageButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush
