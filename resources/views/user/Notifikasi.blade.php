@extends('layouts.user')

@section('title', 'Notifikasi')

@push('styles')
<style>
  /* Reset dan base */
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
  }

  /* Container */
  .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 30px;
  }

  /* Main */
  main {
      margin: 130px auto 100px;
      background: linear-gradient(135deg, #ffffff 0%, #f5fdf7 100%);
      border-radius: 20px;
      padding: 45px 40px;
      box-shadow: 0 8px 35px rgba(0,0,0,0.08);
      border: 1px solid rgba(76, 175, 80, 0.1);
  }

  main h2 {
      font-family: Arial, sans-serif;
      color: #2e7d32;
      font-size: 2.2rem;
      margin-bottom: 25px;
      font-weight: 700;
      position: relative;
      padding-bottom: 25px;
      letter-spacing: -0.5px;
  }

  main h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 70px;
      height: 4px;
      background: linear-gradient(90deg, #4CAF50, #2e7d32);
      border-radius: 2px;
  }

  .subtitle {
      color: #666;
      font-size: 1rem;
      margin-bottom: 45px;
      font-weight: 400;
      line-height: 1.6;
  }

  /* Notification items */
  .notification-item {
      background: linear-gradient(135deg, #ffffff 0%, #fafffe 100%);
      border-radius: 16px;
      padding: 26px 28px;
      margin-bottom: 20px;
      border: 1.5px solid #e8e8e8;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      color: inherit;
      display: flex;
      align-items: flex-start;
      gap: 20px;
      box-shadow: 0 3px 12px rgba(0,0,0,0.05);
      position: relative;
      overflow: hidden;
  }

  .notification-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(180deg, #4CAF50, #2e7d32);
      opacity: 0;
      transition: opacity 0.3s ease;
  }

  .notification-item:hover {
      border-color: rgba(76, 175, 80, 0.3);
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(76, 175, 80, 0.15);
  }

  .notification-item:hover::before {
      opacity: 1;
  }

  .notif-icon {
      flex-shrink: 0;
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      color: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .notif-icon.success {
      background: linear-gradient(135deg, #4CAF50, #2e7d32);
  }

  .notif-icon.processing {
      background: linear-gradient(135deg, #2196F3, #1565C0);
  }

  .notif-icon.warning {
      background: linear-gradient(135deg, #FF9800, #F57C00);
  }

  .notif-icon.info {
      background: linear-gradient(135deg, #00BCD4, #0097A7);
  }

  .notif-content {
      flex: 1;
      min-width: 0;
  }

  .notif-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 12px;
      gap: 18px;
  }

  .notif-title {
      font-weight: 700;
      font-family: Arial, sans-serif;
      font-size: 1.05rem;
      color: #222;
      line-height: 1.5;
  }

  .notif-date {
      font-size: 0.85rem;
      color: #888;
      font-weight: 500;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 5px;
  }

  .notif-date i {
      font-size: 0.8rem;
  }

  .notification-item p {
      font-weight: 400;
      font-family: Arial, sans-serif;
      font-size: 0.95rem;
      color: #555;
      line-height: 1.65;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
  }

  /* No notifications */
  .no-notifs {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      color: #4CAF50;
      font-weight: 600;
      font-family: Arial, sans-serif;
      margin-top: 25px;
      padding: 25px 0;
      font-size: 1rem;
  }

  .no-notifs hr {
      border: none;
      border-top: 2px solid transparent;
      border-image: linear-gradient(90deg, transparent, rgba(76, 175, 80, 0.4), transparent) 1;
      width: 30%;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .container {
        padding: 0 15px;
    }

    main {
        margin: 90px auto 80px;
        padding: 30px 20px;
    }

    main h2 {
        font-size: 1.8rem;
    }

    .subtitle {
        font-size: 0.9rem;
        margin-bottom: 25px;
    }

    .notification-item {
        padding: 18px 16px;
        gap: 14px;
    }

    .notif-icon {
        width: 42px;
        height: 42px;
        font-size: 18px;
    }

    .notif-title {
        font-size: 0.95rem;
    }

    .notif-date {
        font-size: 0.8rem;
    }

    .notification-item p {
        font-size: 0.88rem;
    }

    .no-notifs {
        font-size: 0.9rem;
        gap: 15px;
    }

    .no-notifs hr {
        width: 25%;
    }
  }

  @media (max-width: 480px) {
    .notification-item {
        flex-direction: column;
        gap: 12px;
    }

    .notif-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .notif-date {
        font-size: 0.78rem;
    }
  }
</style>
@endpush

@section('content')
<main class="container" role="main" aria-label="Daftar notifikasi">
  <h2>Notifikasi</h2>
  <p class="subtitle">Pantau semua pemberitahuan penting terkait pesanan dan akun Anda</p>

  <section aria-live="polite">
    <a href="{{ route('notifikasi.detail', ['type' => 'selesai']) }}" class="notification-item" role="alert" aria-label="Pesanan Telah Selesai 10 September 2025">
      <div class="notif-icon success">
        <i class="fas fa-check-circle"></i>
      </div>
      <div class="notif-content">
        <div class="notif-header">
          <span class="notif-title">Pesanan Telah Selesai</span>
          <span class="notif-date"><i class="far fa-clock"></i> 10/09/2025</span>
        </div>
        <p>Halo Oloan, selamat atas kemajuan pesanan Anda di Pupuk & Bibit Subsidi! Kami dengan senang menginformasikan bahwa pesanan Anda telah selesai diproses dan siap untuk digunakan.</p>
      </div>
    </a>

    <a href="{{ route('notifikasi.detail', ['type' => 'diproses']) }}" class="notification-item" role="alert" aria-label="Pesanan Sedang Diproses 6 September 2025">
      <div class="notif-icon processing">
        <i class="fas fa-hourglass-half"></i>
      </div>
      <div class="notif-content">
        <div class="notif-header">
          <span class="notif-title">Pesanan Sedang Diproses</span>
          <span class="notif-date"><i class="far fa-clock"></i> 06/09/2025</span>
        </div>
        <p>Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja seru Anda! Kami senang melihat pesanan Anda sedang dalam proses dan akan segera selesai.</p>
      </div>
    </a>

    <a href="{{ route('notifikasi.detail', ['type' => 'konfirmasi']) }}" class="notification-item" role="alert" aria-label="Segera Lakukan Konfirmasi Pesanan 5 September 2025">
      <div class="notif-icon warning">
        <i class="fas fa-exclamation-circle"></i>
      </div>
      <div class="notif-content">
        <div class="notif-header">
          <span class="notif-title">Segera Lakukan Konfirmasi Pesanan</span>
          <span class="notif-date"><i class="far fa-clock"></i> 05/09/2025</span>
        </div>
        <p>Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja seru Anda! Mohon segera lakukan konfirmasi pesanan agar dapat kami proses lebih lanjut.</p>
      </div>
    </a>

    <a href="{{ route('notifikasi.detail', ['type' => 'verifikasi']) }}" class="notification-item" role="alert" aria-label="Verifikasi Akun Pengguna Berhasil 2 September 2025">
      <div class="notif-icon info">
        <i class="fas fa-user-check"></i>
      </div>
      <div class="notif-content">
        <div class="notif-header">
          <span class="notif-title">Verifikasi Akun Pengguna Berhasil</span>
          <span class="notif-date"><i class="far fa-clock"></i> 02/09/2025</span>
        </div>
        <p>Selamat datang secara resmi di Pupuk & Bibit Subsidi! Kami senang sekali mengumumkan bahwa proses verifikasi akun Anda telah berhasil dilakukan.</p>
      </div>
    </a>

    <div class="no-notifs" aria-live="polite" aria-atomic="true">
      <hr><span>Tidak Ada Notifikasi Lain</span><hr>
    </div>
  </section>
</main>
@endsection
sil</span>
        <span class="date">02/09/2025</span>
      </div>
      <p>"Selamat datang secara resmi di [Nama Platform/Web Kamu]! 🎉 Kami se