@extends('layouts.user')

@section('title', 'Detail Notifikasi')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #f0f5f1 100%);
        font-family: 'Inter', Arial, sans-serif;
        color: #333;
    }

    .page-container {
        max-width: 900px;
        margin: 100px auto 90px;
        padding: 0 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: white;
        color: #2e7d32;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .back-button:hover {
        background: #2e7d32;
        color: white;
        transform: translateX(-3px);
        box-shadow: 0 5px 18px rgba(46, 125, 50, 0.2);
    }

    .back-button i {
        font-size: 1rem;
    }

    .notification-card {
        background: white;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(76, 175, 80, 0.1);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%);
        padding: 30px 40px;
        color: white;
        position: relative;
        border-bottom: 4px solid #2e7d32;
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 25px;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 18px;
        flex: 1;
    }

    .icon-box {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: white;
        box-shadow: 0 6px 18px rgba(0,0,0,0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .notification-title {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1.4;
        color: white;
    }

    .notification-date {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        opacity: 0.95;
        background: rgba(255, 255, 255, 0.15);
        padding: 8px 16px;
        border-radius: 20px;
        white-space: nowrap;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .notification-date i {
        font-size: 0.85rem;
    }

    .card-body {
        padding: 45px 40px 40px;
    }

    .detail-label {
        display: inline-block;
        background: linear-gradient(135deg, #4CAF50, #2e7d32);
        color: white;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .greeting-section {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8f4 100%);
        border-left: 5px solid #4CAF50;
        padding: 22px 26px;
        border-radius: 12px;
        margin-bottom: 32px;
        box-shadow: 0 3px 10px rgba(76, 175, 80, 0.08);
    }

    .greeting-section p {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2e7d32;
        line-height: 1.6;
        margin: 0;
    }

    .content-section {
        margin-bottom: 28px;
    }

    .content-section p {
        font-size: 1rem;
        line-height: 1.8;
        color: #444;
        margin-bottom: 20px;
    }

    .content-section p:last-child {
        margin-bottom: 0;
    }

    .content-section strong {
        color: #2e7d32;
        font-weight: 700;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2e7d32;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 22px;
        background: linear-gradient(180deg, #4CAF50, #2e7d32);
        border-radius: 2px;
    }

    .action-list {
        background: linear-gradient(135deg, #fafafa 0%, #f5f9f6 100%);
        border-radius: 14px;
        padding: 28px 32px;
        margin: 28px 0;
        border: 2px solid #e8f5e9;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }

    .action-list ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .action-list li {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 18px;
        font-size: 1rem;
        line-height: 1.7;
        color: #444;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .action-list li:last-child {
        margin-bottom: 0;
        border-bottom: none;
    }

    .action-list li::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        color: white;
        font-size: 0.75rem;
        flex-shrink: 0;
        margin-top: 4px;
        background: linear-gradient(135deg, #4CAF50, #2e7d32);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(76, 175, 80, 0.3);
    }

    .divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(76, 175, 80, 0.3), transparent);
        margin: 32px 0;
    }

    .closing-section {
        background: linear-gradient(135deg, #e8f5e9 0%, #f1f8f4 100%);
        border: 2px solid #c8e6c9;
        border-radius: 14px;
        padding: 26px 30px;
        margin-top: 32px;
        text-align: center;
        box-shadow: 0 3px 12px rgba(76, 175, 80, 0.08);
    }

    .closing-section p {
        font-size: 1.08rem;
        color: #2e7d32;
        font-weight: 700;
        line-height: 1.6;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-container {
            margin: 90px auto 70px;
            padding: 0 15px;
        }

        .card-header {
            padding: 28px 25px;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 18px;
        }

        .header-left {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }

        .icon-box {
            width: 55px;
            height: 55px;
            font-size: 24px;
        }

        .notification-title {
            font-size: 1.35rem;
        }

        .notification-date {
            align-self: flex-start;
        }

        .card-body {
            padding: 40px 25px 30px;
        }

        .greeting-section {
            padding: 18px 20px;
        }

        .greeting-section p {
            font-size: 1rem;
        }

        .content-section p {
            font-size: 0.95rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .action-list {
            padding: 22px 20px;
        }

        .action-list li {
            font-size: 0.95rem;
            gap: 12px;
            padding: 10px 0;
        }

        .action-list li::before {
            width: 22px;
            height: 22px;
            font-size: 0.7rem;
        }

        .closing-section {
            padding: 22px 20px;
        }

        .closing-section p {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .back-button {
            padding: 10px 16px;
            font-size: 0.9rem;
        }

        .notification-title {
            font-size: 1.3rem;
        }

        .card-body {
            padding: 35px 20px 25px;
        }
    }
</style>
@endpush

@section('content')
@php
$notifications = [
    'selesai' => [
        'title' => 'Pesanan Telah Selesai',
        'icon' => 'fa-check-circle',
        'date' => '10 September 2025',
        'greeting' => 'Halo Oloan, selamat atas kemajuan pesanan Anda di Pupuk & Bibit Subsidi!',
        'content1' => 'Kami dengan senang menginformasikan bahwa pesanan Anda telah selesai diproses dan siap untuk digunakan.',
        'content2' => 'Pesanan Anda telah berhasil diselesaikan dengan sempurna. Semua produk yang Anda pesan sudah siap dan dapat segera dimanfaatkan untuk kebutuhan pertanian Anda.',
        'actions' => [
            'Lihat detail pesanan lengkap di menu Riwayat Pesanan',
            'Berikan ulasan untuk produk yang telah Anda terima',
            'Lanjutkan berbelanja produk Pupuk & Bibit Subsidi lainnya'
        ],
        'footer' => 'Terima kasih telah mempercayai layanan kami!'
    ],
    'diproses' => [
        'title' => 'Pesanan Sedang Diproses',
        'icon' => 'fa-hourglass-half',
        'date' => '06 September 2025',
        'greeting' => 'Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja seru Anda!',
        'content1' => 'Kami senang melihat pesanan Anda sedang dalam proses dan akan segera selesai.',
        'content2' => 'Tim kami sedang memproses pesanan Anda dengan hati-hati untuk memastikan semua produk dikirim dalam kondisi terbaik. Mohon bersabar, pesanan Anda akan segera selesai.',
        'actions' => [
            'Pantau status pesanan secara real-time di menu Pesanan Saya',
            'Persiapkan pembayaran jika belum melakukan konfirmasi',
            'Hubungi customer service jika ada pertanyaan'
        ],
        'footer' => 'Kami akan memberikan notifikasi begitu pesanan selesai diproses!'
    ],
    'konfirmasi' => [
        'title' => 'Segera Lakukan Konfirmasi Pesanan',
        'icon' => 'fa-exclamation-circle',
        'date' => '05 September 2025',
        'greeting' => 'Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja seru Anda!',
        'content1' => 'Mohon segera lakukan konfirmasi pesanan agar dapat kami proses lebih lanjut.',
        'content2' => 'Pesanan Anda masih menunggu konfirmasi dari Anda. Untuk melanjutkan proses pesanan, silakan lakukan konfirmasi pembayaran dan detail pengiriman sesegera mungkin.',
        'actions' => [
            'Klik tombol Konfirmasi Pesanan di halaman detail pesanan',
            'Upload bukti pembayaran jika menggunakan transfer manual',
            'Pastikan alamat pengiriman sudah benar dan lengkap'
        ],
        'footer' => 'Segera konfirmasi agar pesanan Anda dapat diproses!'
    ],
    'verifikasi' => [
        'title' => 'Verifikasi Akun Pengguna Berhasil',
        'icon' => 'fa-user-check',
        'date' => '02 September 2025',
        'greeting' => 'Selamat datang secara resmi di Website Pupuk & Bibit Subsidi!',
        'content1' => 'Kami senang sekali mengumumkan bahwa proses verifikasi akun Anda telah berhasil diselesaikan dengan sempurna.',
        'content2' => 'Terima kasih banyak atas kesabaran dan kerjasama Anda selama langkah ini. Sekarang, akun Anda sudah siap untuk dijelajahi sepenuhnya! Anda bisa mulai:',
        'actions' => [
            'Mulai berbelanja produk Pupuk & Bibit Subsidi Pemerintah',
            'Berinteraksi dengan ribuan pengguna lain yang juga telah terverifikasi',
            'Menikmati pengalaman bebas bereksplorasi dan konsultasi terkait Pupuk dan Bibit Subsidi Pemerintah'
        ],
        'footer' => 'Terima kasih lagi, dan selamat berpetualang!'
    ]
];

$currentNotif = $notifications[$type] ?? $notifications['verifikasi'];
@endphp

<main class="page-container" role="main">
    <a href="{{ route('notifikasi') }}" class="back-button" aria-label="Kembali">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>

    <div class="notification-card">
        <div class="card-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="icon-box">
                        <i class="fas {{ $currentNotif['icon'] }}"></i>
                    </div>
                    <h2 class="notification-title">{{ $currentNotif['title'] }}</h2>
                </div>
                <div class="notification-date">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ $currentNotif['date'] }}</span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <span class="detail-label">Isi Notifikasi</span>

            <div class="greeting-section">
                <p>{{ $currentNotif['greeting'] }}</p>
            </div>

            <div class="content-section">
                <p>{{ $currentNotif['content1'] }}</p>
                <p>{{ $currentNotif['content2'] }}</p>
            </div>

            <h3 class="section-title">Yang Bisa Anda Lakukan</h3>
            <div class="action-list">
                <ul>
                    @foreach($currentNotif['actions'] as $action)
                    <li>{{ $action }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="divider"></div>

            <div class="content-section">
                <p>Kalau ada pertanyaan atau butuh bantuan lebih lanjut, tim kami siap membantu melalui menu <strong>Kontak</strong> atau chat langsung. Yuk, mulai perjalanan digital Anda sekarang!</p>
            </div>

            <div class="closing-section">
                <p>{{ $currentNotif['footer'] }}</p>
            </div>
        </div>
    </div>
</main>
@endsection
