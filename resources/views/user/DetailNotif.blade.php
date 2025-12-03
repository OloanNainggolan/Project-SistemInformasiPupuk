@extends('layouts.user')

@section('title', 'Detail Notifikasi')

@push('styles')
<style>
    /* Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Container */
    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* Main */
    main {
        margin: 100px auto 120px;
    }

    /* Back Button */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 18px;
        color: #065f46;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .back-btn:hover {
        background: #f0fdf4;
        border-color: #059669;
        transform: translateX(-4px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);
    }

    .back-btn i {
        font-size: 14px;
    }

    /* Notification Card */
    .notif-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    /* Header Section */
    .notif-header {
        background: linear-gradient(135deg, #059669, #047857);
        padding: 32px 40px;
        position: relative;
        overflow: hidden;
    }

    .notif-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .notif-header-content {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        position: relative;
        z-index: 1;
    }

    .notif-icon {
        width: 64px;
        height: 64px;
        background: white;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .notif-icon i {
        font-size: 28px;
        color: #059669;
    }

    .notif-header-text {
        flex: 1;
    }

    .notif-title {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .notif-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
    }

    .notif-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .notif-meta i {
        font-size: 13px;
    }

    /* Body Section */
    .notif-body {
        padding: 44px 48px;
        background: #fafbfc;
    }

    /* Greeting Section */
    .greeting-section {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border-left: 5px solid #059669;
        border-radius: 14px;
        padding: 24px 28px;
        margin-bottom: 28px;
    }

    .greeting-section p {
        color: #065f46;
        font-size: 18px;
        font-weight: 600;
        line-height: 1.6;
        margin: 0;
    }

    /* Content Section */
    .content-section {
        background: white;
        border-radius: 12px;
        padding: 24px 28px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .content-section p {
        color: #374151;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 16px;
    }

    .content-section p:last-child {
        margin-bottom: 0;
    }

    .content-section strong {
        color: #065f46;
        font-weight: 600;
    }

    /* Action List */
    .action-list {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 14px;
        padding: 28px 32px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        position: relative;
    }

    .action-list::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: linear-gradient(180deg, #10b981, #059669);
        border-radius: 14px 0 0 14px;
    }

    .action-list ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .action-list li {
        color: #374151;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 16px;
        padding-left: 32px;
        position: relative;
    }

    .action-list li:last-child {
        margin-bottom: 0;
    }

    .action-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        top: 0;
        width: 24px;
        height: 24px;
        background: #10b981;
        color: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }

    /* Closing Section */
    .closing-section {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-left: 5px solid #f59e0b;
        border-radius: 14px;
        padding: 24px 28px;
        text-align: center;
    }

    .closing-section p {
        color: #92400e;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.6;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 0 20px;
        }

        main {
            margin: 60px auto 80px;
        }

        .notif-header {
            padding: 24px 24px;
        }

        .notif-header-content {
            flex-direction: column;
            gap: 16px;
        }

        .notif-icon {
            width: 56px;
            height: 56px;
        }

        .notif-icon i {
            font-size: 24px;
        }

        .notif-title {
            font-size: 20px;
        }

        .notif-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .notif-body {
            padding: 32px 28px;
        }

        .greeting-section {
            padding: 20px 24px;
        }

        .greeting-section p {
            font-size: 16px;
        }

        .content-section {
            padding: 20px 24px;
        }

        .content-section p {
            font-size: 14px;
        }

        .action-list {
            padding: 24px 28px;
        }

        .action-list li {
            font-size: 14px;
            padding-left: 28px;
        }

        .action-list li::before {
            width: 22px;
            height: 22px;
            font-size: 13px;
        }

        .closing-section {
            padding: 20px 24px;
        }

        .closing-section p {
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 16px;
        }

        main {
            margin: 40px auto 60px;
        }

        .back-btn {
            padding: 8px 14px;
            font-size: 13px;
        }

        .notif-header {
            padding: 20px;
        }

        .notif-icon {
            width: 48px;
            height: 48px;
        }

        .notif-icon i {
            font-size: 20px;
        }

        .notif-title {
            font-size: 18px;
        }

        .notif-body {
            padding: 28px 20px;
        }

        .greeting-section {
            padding: 18px 20px;
            margin-bottom: 20px;
        }

        .greeting-section p {
            font-size: 15px;
        }

        .content-section {
            padding: 18px 20px;
            margin-bottom: 16px;
        }

        .content-section p {
            font-size: 13px;
        }

        .action-list {
            padding: 20px 24px;
            margin-bottom: 16px;
        }

        .action-list li {
            font-size: 13px;
            padding-left: 26px;
            margin-bottom: 14px;
        }

        .action-list li::before {
            width: 20px;
            height: 20px;
            font-size: 12px;
        }

        .closing-section {
            padding: 18px 20px;
        }

        .closing-section p {
            font-size: 14px;
        }
    }
</style>
@endpush

@section('content')
<main class="container" role="main">
    <a href="{{ route('notifikasi') }}" class="back-btn" aria-label="Kembali ke halaman notifikasi">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>

    @php
    $notifications = [
        'selesai' => [
            'icon' => 'fa-check-circle',
            'title' => 'Pesanan Telah Selesai',
            'date' => '10/09/2025',
            'greeting' => 'Halo Oloan, selamat atas kemajuan pesanan Anda di Pupuk & Bibit Subsidi!',
            'content1' => 'Kami dengan senang hati menginformasikan bahwa pesanan Anda telah selesai diproses dan siap untuk diambil.',
            'content2' => 'Pesanan Anda telah melalui proses quality control dan dikemas dengan baik untuk memastikan kualitas produk tetap terjaga. Silakan mengambil pesanan Anda sesuai jadwal yang telah ditentukan.',
            'actions' => [
                'Datang ke lokasi pengambilan sesuai alamat yang tertera',
                'Bawa kartu identitas dan bukti pemesanan',
                'Periksa kondisi produk saat pengambilan'
            ],
            'footer' => 'Terima kasih telah mempercayai layanan kami. Selamat bertani dan semoga hasil panen melimpah!'
        ],
        'diproses' => [
            'icon' => 'fa-clock',
            'title' => 'Pesanan Sedang Diproses',
            'date' => '06/09/2025',
            'greeting' => 'Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja Anda!',
            'content1' => 'Kami senang melihat pesanan sedang dalam proses dan akan segera siap untuk diambil.',
            'content2' => 'Tim kami sedang mempersiapkan pesanan Anda dengan teliti. Proses ini meliputi verifikasi stok, pengecekan kualitas produk, dan pengemasan yang aman untuk memastikan produk sampai dalam kondisi terbaik.',
            'actions' => [
                'Pantau status pesanan melalui dashboard Anda',
                'Anda akan menerima notifikasi saat pesanan siap diambil',
                'Persiapkan dokumen yang diperlukan untuk pengambilan'
            ],
            'footer' => 'Mohon bersabar, pesanan Anda sedang kami proses dengan sebaik mungkin!'
        ],
        'konfirmasi' => [
            'icon' => 'fa-exclamation-circle',
            'title' => 'Segera Lakukan Konfirmasi Pesanan',
            'date' => '05/09/2025',
            'greeting' => 'Halo Oloan, pesanan Anda memerlukan konfirmasi.',
            'content1' => 'Mohon segera lakukan konfirmasi untuk melanjutkan proses pemesanan produk subsidi Anda.',
            'content2' => 'Konfirmasi pesanan diperlukan untuk memastikan bahwa data pemesanan Anda sudah benar dan sesuai. Tanpa konfirmasi, pesanan Anda tidak dapat diproses lebih lanjut dan akan otomatis dibatalkan setelah batas waktu yang ditentukan.',
            'actions' => [
                'Periksa kembali detail pesanan Anda',
                'Pastikan jumlah dan jenis produk sudah sesuai',
                'Klik tombol konfirmasi pada halaman pesanan'
            ],
            'footer' => 'Segera konfirmasi pesanan Anda untuk menghindari pembatalan otomatis!'
        ],
        'verifikasi' => [
            'icon' => 'fa-user-check',
            'title' => 'Verifikasi Akun Pengguna Berhasil',
            'date' => '02/09/2025',
            'greeting' => 'Selamat datang secara resmi di Website Pupuk & Bibit Subsidi! 🎉',
            'content1' => 'Kami senang sekali mengumumkan bahwa proses verifikasi akun Anda telah berhasil diselesaikan dengan sempurna.',
            'content2' => 'Terima kasih banyak atas kesabaran dan kerjasama Anda selama langkah ini. Sekarang, akun Anda sudah siap untuk dijelajahi sepenuhnya! Anda bisa mulai:',
            'actions' => [
                'Mulai berbelanja produk Pupuk & Bibit Subsidi Pemerintah.',
                'Berinteraksi dengan ribuan pengguna lain yang juga telah terverifikasi.',
                'Menikmati pengalaman bebas bereksplorasi dan konsultasi terkait Pupuk dan Bibit Subsidi Pemerintah.'
            ],
            'footer' => 'Terima kasih lagi, dan selamat berpetualang! 🚜🌾'
        ]
    ];

    $notif = $notifications[$type] ?? $notifications['verifikasi'];
    @endphp

    <div class="notif-card">
        <!-- Header Section -->
        <div class="notif-header">
            <div class="notif-header-content">
                <div class="notif-icon">
                    <i class="fas {{ $notif['icon'] }}"></i>
                </div>
                <div class="notif-header-text">
                    <h1 class="notif-title">{{ $notif['title'] }}</h1>
                    <div class="notif-meta">
                        <span>
                            <i class="far fa-calendar"></i>
                            {{ $notif['date'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Body Section -->
        <div class="notif-body">
            <div class="greeting-section">
                <p>{{ $notif['greeting'] }}</p>
            </div>

            <div class="content-section">
                <p>{{ $notif['content1'] }}</p>
                <p>{{ $notif['content2'] }}</p>
            </div>

            <div class="action-list">
                <ul>
                    @foreach($notif['actions'] as $action)
                    <li>{{ $action }}</li>
                    @endforeach
                </ul>
            </div>

            @if($type === 'verifikasi')
            <div class="content-section">
                <p>Kalau ada pertanyaan atau butuh bantuan lebih lanjut, tim kami siap membantu melalui menu <strong>Kontak</strong> atau chat langsung. Yuk, mulai perjalanan digital Anda sekarang!</p>
            </div>
            @endif

            <div class="closing-section">
                <p>{{ $notif['footer'] }}</p>
            </div>
        </div>
    </div>
</main>
@endsection
