@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>Selamat Datang, {{ session('admin_name', 'Administrator') }}! 👋</h1>
                <p>Berikut adalah ringkasan sistem hari ini - {{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="welcome-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="stats-grid">
        <!-- Total Pesanan Card -->
        <div class="stat-card card-blue" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ number_format($totalPesanan) }}</div>
                <div class="stat-change {{ $pertumbuhanPesanan >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $pertumbuhanPesanan >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs($pertumbuhanPesanan) }}% dari bulan lalu
                </div>
            </div>
        </div>

        <!-- Total Pendapatan Card -->
        <div class="stat-card card-green" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-change {{ $pertumbuhanPendapatan >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $pertumbuhanPendapatan >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs($pertumbuhanPendapatan) }}% dari bulan lalu
                </div>
            </div>
        </div>

        <!-- Total Petani Card -->
        <div class="stat-card card-purple" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Petani</div>
                <div class="stat-value">{{ number_format($totalPetani) }}</div>
                <div class="stat-change {{ $pertumbuhanPetani >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $pertumbuhanPetani >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs($pertumbuhanPetani) }}% dari bulan lalu
                </div>
            </div>
        </div>

        <!-- Total Produk Card -->
        <div class="stat-card card-orange" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Produk</div>
                <div class="stat-value">{{ number_format($totalProduk) }}</div>
                <div class="stat-change {{ $pertumbuhanProduk >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $pertumbuhanProduk >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs($pertumbuhanProduk) }}% dari bulan lalu
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Tables Row -->
    <div class="content-grid">
        <!-- Order Status Chart -->
        <div class="chart-card" data-aos="fade-right" data-aos-delay="500">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Status Pesanan</h3>
                <div class="total-badge">{{ number_format($totalPesanan) }} Total</div>
            </div>
            <div class="chart-container">
                <canvas id="orderStatusChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-color" style="background: #FFC107"></span>
                    <span class="legend-label">Pending</span>
                    <span class="legend-value">{{ $pendingCount }}</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #2196F3"></span>
                    <span class="legend-label">Processing</span>
                    <span class="legend-value">{{ $processingCount }}</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #9C27B0"></span>
                    <span class="legend-label">Ready</span>
                    <span class="legend-value">{{ $readyCount }}</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #4CAF50"></span>
                    <span class="legend-label">Completed</span>
                    <span class="legend-value">{{ $completedCount }}</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background: #F44336"></span>
                    <span class="legend-label">Rejected</span>
                    <span class="legend-value">{{ $rejectedCount }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="table-card" data-aos="fade-left" data-aos-delay="600">
            <div class="card-header">
                <h3><i class="fas fa-clock"></i> Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders') }}" class="view-all-btn">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="table-container">
                @if($recentOrders->count() > 0)
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Petani</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>{{ $order->customer_name ?? ($order->user->name ?? 'N/A') }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ substr($order->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span>{{ $order->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($order->status) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <span class="date">{{ $order->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Belum ada pesanan</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions" data-aos="fade-up" data-aos-delay="700">
        <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
        <div class="actions-grid">
            <a href="{{ route('admin.products.create') }}" class="action-btn btn-primary">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Produk</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="action-btn btn-info">
                <i class="fas fa-list-alt"></i>
                <span>Kelola Pesanan</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="action-btn btn-success">
                <i class="fas fa-box-open"></i>
                <span>Kelola Produk</span>
            </a>
            <a href="{{ route('admin.notifications') }}" class="action-btn btn-warning">
                <i class="fas fa-bell"></i>
                <span>Kirim Notifikasi</span>
            </a>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    padding: 30px;
    background: #f5f7fa;
    min-height: 100vh;
}

/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    box-shadow: 0 10px 40px rgba(0, 137, 123, 0.2);
    color: white;
    position: relative;
    overflow: hidden;
}

.welcome-banner::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    top: -100px;
    right: -50px;
}

.welcome-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.welcome-text h1 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
}

.welcome-text p {
    font-size: 16px;
    opacity: 0.9;
}

.welcome-icon i {
    font-size: 80px;
    opacity: 0.2;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    opacity: 0.1;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stat-card:hover::before {
    width: 150px;
    height: 150px;
}

.card-blue { border-left: 4px solid #2196F3; }
.card-blue .stat-icon { background: linear-gradient(135deg, #2196F3, #1976D2); }
.card-blue::before { background: #2196F3; }

.card-green { border-left: 4px solid #4CAF50; }
.card-green .stat-icon { background: linear-gradient(135deg, #4CAF50, #388E3C); }
.card-green::before { background: #4CAF50; }

.card-purple { border-left: 4px solid #9C27B0; }
.card-purple .stat-icon { background: linear-gradient(135deg, #9C27B0, #7B1FA2); }
.card-purple::before { background: #9C27B0; }

.card-orange { border-left: 4px solid #FF9800; }
.card-orange .stat-icon { background: linear-gradient(135deg, #FF9800, #F57C00); }
.card-orange::before { background: #FF9800; }

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-label {
    font-size: 13px;
    color: #757575;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #212121;
    margin-bottom: 8px;
}

.stat-change {
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

.stat-change.positive { color: #4CAF50; }
.stat-change.negative { color: #F44336; }

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 25px;
    margin-bottom: 30px;
}

.chart-card, .table-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f5f5f5;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #212121;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header h3 i {
    color: #00897b;
}

.total-badge {
    background: linear-gradient(135deg, #00897b, #00695c);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.view-all-btn {
    color: #00897b;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    gap: 8px;
    color: #00695c;
}

/* Chart */
.chart-container {
    height: 250px;
    margin-bottom: 20px;
}

.chart-legend {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.legend-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
}

.legend-label {
    flex: 1;
    font-size: 14px;
    color: #424242;
    font-weight: 500;
}

.legend-value {
    font-weight: 700;
    color: #212121;
}

/* Table */
.table-container {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.modern-table thead th {
    background: #f8f9fa;
    color: #757575;
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 15px;
    text-align: left;
    border: none;
}

.modern-table thead th:first-child {
    border-radius: 8px 0 0 8px;
}

.modern-table thead th:last-child {
    border-radius: 0 8px 8px 0;
}

.modern-table tbody tr {
    background: white;
    transition: all 0.3s ease;
}

.modern-table tbody tr:hover {
    background: #f5f7fa;
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.modern-table tbody td {
    padding: 15px;
    border-top: 1px solid #f0f0f0;
    border-bottom: 1px solid #f0f0f0;
}

.modern-table tbody tr td:first-child {
    border-left: 1px solid #f0f0f0;
    border-radius: 8px 0 0 8px;
}

.modern-table tbody tr td:last-child {
    border-right: 1px solid #f0f0f0;
    border-radius: 0 8px 8px 0;
}

.order-id {
    font-weight: 700;
    color: #00897b;
}

.user-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00897b, #00695c);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
}

.amount {
    font-weight: 700;
    color: #4CAF50;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
}

.status-pending { background: #FFF3CD; color: #856404; }
.status-processing { background: #CCE5FF; color: #004085; }
.status-ready { background: #E1BEE7; color: #4A148C; }
.status-completed { background: #C8E6C9; color: #2E7D32; }
.status-rejected { background: #F8D7DA; color: #721C24; }

.date {
    font-size: 13px;
    color: #757575;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #9e9e9e;
}

.empty-state i {
    font-size: 60px;
    margin-bottom: 15px;
}

/* Quick Actions */
.quick-actions {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.quick-actions h3 {
    font-size: 18px;
    font-weight: 700;
    color: #212121;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.quick-actions h3 i {
    color: #FFC107;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-btn {
    padding: 15px 20px;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.action-btn i {
    font-size: 20px;
}

.btn-primary { background: linear-gradient(135deg, #2196F3, #1976D2); }
.btn-info { background: linear-gradient(135deg, #00BCD4, #0097A7); }
.btn-success { background: linear-gradient(135deg, #4CAF50, #388E3C); }
.btn-warning { background: linear-gradient(135deg, #FF9800, #F57C00); }

@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 20px;
    }

    .welcome-banner {
        padding: 25px;
    }

    .welcome-text h1 {
        font-size: 24px;
    }

    .welcome-icon {
        display: none;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
// Initialize AOS
AOS.init({
    duration: 800,
    once: true,
    offset: 100
});

// Order Status Chart
const ctx = document.getElementById('orderStatusChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Processing', 'Ready', 'Completed', 'Rejected'],
        datasets: [{
            data: [
                {{ $pendingCount }},
                {{ $processingCount }},
                {{ $readyCount }},
                {{ $completedCount }},
                {{ $rejectedCount }}
            ],
            backgroundColor: [
                '#FFC107',
                '#2196F3',
                '#9C27B0',
                '#4CAF50',
                '#F44336'
            ],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: {
                    size: 14,
                    weight: 'bold'
                },
                bodyFont: {
                    size: 13
                },
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        },
        cutout: '70%'
    }
});

// Table row animation
document.querySelectorAll('.table-row-animate').forEach((row, index) => {
    row.style.animation = `fadeInUp 0.5s ease ${index * 0.05}s both`;
});

// Add fadeInUp animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection
