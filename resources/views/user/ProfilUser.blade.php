 @extends('layouts.user')

@section('title', 'Profil User')

@push('styles')
<style>
    /* Main Container */
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2.5rem;
        margin-top: 170px;
        margin-bottom: 4rem;
    }

    .dashboard-content {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 3rem;
    }

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 24px;
        padding: 3rem 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        height: fit-content;
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 50%, #4CAF50 100%);
    }

    .profile-card .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        margin: 0 auto 2rem;
        overflow: hidden;
        border: 5px solid #4caf50;
        box-shadow: 0 8px 24px rgba(76, 175, 80, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .profile-card .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-card .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-name h2 {
        font-size: 1.6rem;
        color: #1b5e20;
        margin-bottom: 0.8rem;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .profile-name p {
        color: #666;
        font-size: 0.95rem;
        background: #f5f5f5;
        padding: 0.5rem 1.4rem;
        border-radius: 25px;
        display: inline-block;
        font-weight: 600;
        border: 1px solid #e0e0e0;
    }

    .profile-info {
        margin: 2.5rem 0;
        padding: 2rem 0;
        border-top: 1px solid #e8e8e8;
        border-bottom: 1px solid #e8e8e8;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
        color: #555;
        font-size: 0.98rem;
        line-height: 1.5;
        padding: 0.4rem 0;
        transition: all 0.2s ease;
    }

    .info-item:hover {
        color: #2e7d32;
    }

    .info-item:hover .info-icon {
        background: #e8f5e9;
        transform: scale(1.08);
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        background: #f8f8f8;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #4caf50;
        transition: all 0.2s ease;
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 1.1rem 1.5rem;
        border: none;
        border-radius: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        letter-spacing: 0.2px;
    }

    .btn-edit {
        background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(76, 175, 80, 0.2);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(76, 175, 80, 0.35);
    }

    .btn-logout {
        background: linear-gradient(135deg, #f44336 0%, #e53935 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(244, 67, 54, 0.2);
    }

    .btn-logout:hover {
        background: linear-gradient(135deg, #e53935 0%, #d32f2f 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(244, 67, 54, 0.35);
    }

    /* Land Info Section */
    .land-info {
        background: white;
        border-radius: 24px;
        padding: 3rem 2.5rem;
        margin-top: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }

    .land-info::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(135deg, #66BB6A 0%, #4CAF50 50%, #2e7d32 100%);
    }

    .land-info h3 {
        font-size: 1.3rem;
        color: #1b5e20;
        margin-bottom: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        letter-spacing: -0.3px;
    }

    .land-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .land-item {
        background: #fafafa;
        padding: 1.8rem 1.5rem;
        border-radius: 16px;
        border: 1px solid #e8e8e8;
        transition: all 0.3s ease;
    }

    .land-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        border-color: #4caf50;
        background: white;
    }

    .land-label {
        font-size: 0.88rem;
        color: #777;
        margin-bottom: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .land-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1b5e20;
    }

    .commodity-tags {
        display: flex;
        gap: 0.9rem;
        margin-top: 1.2rem;
        flex-wrap: wrap;
    }

    .tag {
        padding: 0.65rem 1.4rem;
        border-radius: 25px;
        font-size: 0.92rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: default;
    }

    .tag:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
    }

    .tag-padi {
        background: #fff3e0;
        color: #e65100;
        border: 1.5px solid #ffcc80;
    }

    .tag-jagung {
        background: #fff9c4;
        color: #f57f17;
        border: 1.5px solid #fff176;
    }

    /* Stats Section */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
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
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
    }

    .orders-section h3 {
        font-size: 1.4rem;
        color: #1b5e20;
        margin-bottom: 2rem;
        font-weight: 700;
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
        <div style="background: linear-gradient(135deg, #d4edda 0%, #c8e6c9 100%); color: #155724; border: 2px solid #81c784; padding: 1.2rem 1.8rem; border-radius: 12px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.15);">
            <i class="fas fa-check-circle" style="font-size: 1.4rem;"></i>
            <span style="font-weight: 600; font-size: 0.98rem;">{{ session('success') }}</span>
        </div>
    @endif

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
                        <span class="info-icon"><i class="fas fa-envelope"></i></span>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fas fa-phone"></i></span>
                        <span>{{ auth()->user()->no_telp }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <span>{{ auth()->user()->alamat }}{{ auth()->user()->kabupaten ? ', ' . auth()->user()->kabupaten : '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fas fa-calendar-alt"></i></span>
                        <span>Bergabung Sejak {{ auth()->user()->created_at->format('F Y') }}</span>
                    </div>
                </div>
                <div class="profile-actions">
                    <a href="{{ route('profil.edit') }}" class="btn btn-edit" style="text-decoration: none; text-align: center;"><i class="fas fa-edit"></i> Edit Profil</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-logout" style="width: 100%;"><i class="fas fa-sign-out-alt"></i> Keluar</button>
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
                                <td><span class="status-badge">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-002</div>
                                    <div class="order-name">Pupuk NPK Phonska</div>
                                </td>
                                <td>26 Januari 2025</td>
                                <td>Rp 95.000</td>
                                <td><span class="status-badge">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="order-id">ORD-2025-003</div>
                                    <div class="order-name">Bibit Padi Unggul IR64</div>
                                </td>
                                <td>15 Maret 2025</td>
                                <td>Rp 35.000</td>
                                <td><span class="status-badge">Berhasil</span></td>
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
