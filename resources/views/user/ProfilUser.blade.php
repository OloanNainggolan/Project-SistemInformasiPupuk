@extends('layouts.user')

@section('title', 'Profil User')

@push('styles')
<style>
    /* Main Container */
    .container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 2rem;
        margin-top: 80px;
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

    .profile-avatar {
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

    .profile-avatar img {
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
    @media (max-width: 1024px) {
        .dashboard-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 0 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .stat-value {
            font-size: 2rem;
        }

        table {
            font-size: 0.85rem;
        }

        th, td {
            padding: 0.8rem 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .dashboard-title {
            font-size: 1.4rem;
            padding: 1rem 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .land-details {
            flex-direction: column;
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
                    <div class="stat-value">24</div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-value">2,8 Ton</div>
                    <div class="stat-label">Pupuk Diterima</div>
                </div>
                <div class="stat-card red">
                    <div class="stat-value">125 Kg</div>
                    <div class="stat-label">Bibit Diterima</div>
                </div>
                <div class="stat-card pink">
                    <div class="stat-value">2.4 Jt</div>
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
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-001</div>
                                    <div class="order-name">Pupuk Urea Bersubsidi</div>
                                </td>
                                <td>24 Januari 2025</td>
                                <td>Rp 85.000</td>
                                <td><span class="status-badge">Success</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-002</div>
                                    <div class="order-name">Pupuk NPK Phonska</div>
                                </td>
                                <td>26 Januari 2025</td>
                                <td>Rp 95.000</td>
                                <td><span class="status-badge">Success</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-003</div>
                                    <div class="order-name">Bibit Padi Unggul IR64</div>
                                </td>
                                <td>15 Maret 2025</td>
                                <td>Rp 35.000</td>
                                <td><span class="status-badge">Success</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="page-arrow">←</button>
                    <button class="page-btn active">01</button>
                    <button class="page-btn">02</button>
                    <button class="page-btn">03</button>
                    <button class="page-arrow">→</button>
                </div>
            </div>
        </main>
    </div>
</div>
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
