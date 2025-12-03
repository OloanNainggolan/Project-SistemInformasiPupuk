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
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 30px;
  }

  /* Main */
  main {
      margin: 120px auto 120px;
      background: white;
      border-radius: 16px;
      padding: 40px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  main h2 {
      font-family: system-ui, -apple-system, sans-serif;
      color: #065f46;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 32px;
      padding-bottom: 16px;
      border-bottom: 3px solid #e5e7eb;
      display: flex;
      align-items: center;
      gap: 12px;
  }

  main h2::before {
      content: '';
      width: 4px;
      height: 28px;
      background: linear-gradient(180deg, #059669, #065f46);
      border-radius: 2px;
  }

  /* Notification items */
  .notification-item {
      background: #f9fafb;
      border: 2px solid #e5e7eb;
      border-left: 4px solid #059669;
      border-radius: 12px;
      padding: 20px 24px;
      margin-bottom: 16px;
      text-decoration: none;
      color: inherit;
      display: block;
      transition: all 0.25s ease;
      position: relative;
      overflow: hidden;
  }

  .notification-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: linear-gradient(180deg, #059669, #047857);
      transition: width 0.25s ease;
  }

  .notification-item:hover {
      background: white;
      border-color: #059669;
      box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
      transform: translateX(4px);
  }

  .notification-item:hover::before {
      width: 6px;
  }

  .notif-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 16px;
      margin-bottom: 12px;
  }

  .notif-title {
      display: flex;
      align-items: center;
      gap: 12px;
      flex: 1;
  }

  .notif-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 18px;
      color: white;
  }

  .notif-icon.success {
      background: linear-gradient(135deg, #10b981, #059669);
  }

  .notif-icon.process {
      background: linear-gradient(135deg, #3b82f6, #2563eb);
  }

  .notif-icon.warning {
      background: linear-gradient(135deg, #f59e0b, #d97706);
  }

  .notif-icon.info {
      background: linear-gradient(135deg, #06b6d4, #0891b2);
  }

  .notif-title-text {
      font-weight: 600;
      font-size: 16px;
      color: #111827;
      line-height: 1.4;
  }

  .notif-header .date {
      font-size: 13px;
      color: #6b7280;
      font-weight: 500;
      white-space: nowrap;
      display: flex;
      align-items: center;
      gap: 6px;
  }

  .notif-header .date::before {
      content: '';
      width: 4px;
      height: 4px;
      background: #9ca3af;
      border-radius: 50%;
  }

  .notification-item p {
      font-size: 14px;
      color: #4b5563;
      line-height: 1.6;
      margin-left: 52px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
  }

  /* Notification badge (unread indicator) */
  .notification-item.unread {
      background: #ecfdf5;
      border-left-color: #10b981;
  }

  .notification-item.unread .notif-title-text::after {
      content: '';
      display: inline-block;
      width: 8px;
      height: 8px;
      background: #10b981;
      border-radius: 50%;
      margin-left: 8px;
      animation: pulse 2s ease-in-out infinite;
  }

  @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
  }

  /* No notifications */
  .no-notifs {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      color: #6b7280;
      font-weight: 500;
      margin-top: 32px;
      padding-top: 24px;
      font-size: 14px;
  }

  .no-notifs hr {
      border: none;
      border-top: 2px solid #e5e7eb;
      flex: 1;
  }

  /* Responsive */
  @media (max-width: 768px) {
      .container {
          padding: 0 20px;
      }

      main {
          margin: 80px auto 100px;
          padding: 24px 20px;
          border-radius: 12px;
      }

      main h2 {
          font-size: 22px;
          margin-bottom: 24px;
      }

      .notification-item {
          padding: 16px 18px;
      }

      .notif-header {
          flex-direction: column;
          align-items: flex-start;
          gap: 8px;
      }

      .notif-icon {
          width: 36px;
          height: 36px;
          font-size: 16px;
      }

      .notif-title-text {
          font-size: 15px;
      }

      .notif-header .date {
          font-size: 12px;
          margin-left: 48px;
      }

      .notification-item p {
          font-size: 13px;
          margin-left: 48px;
          -webkit-line-clamp: 3;
      }
  }

  @media (max-width: 480px) {
      .container {
          padding: 0 16px;
      }

      main {
          margin: 60px auto 80px;
          padding: 20px 16px;
      }

      main h2 {
          font-size: 20px;
      }

      .notification-item {
          padding: 14px 16px;
          margin-bottom: 12px;
      }

      .notif-icon {
          width: 32px;
          height: 32px;
          font-size: 14px;
      }

      .notif-title-text {
          font-size: 14px;
      }

      .notification-item p {
          margin-left: 44px;
      }

      .notif-header .date {
          margin-left: 44px;
      }
  }
</style>
@endpush

@section('content')
<main class="container" role="main" aria-label="Daftar notifikasi">
  <h2>Notifikasi</h2>

  <section aria-live="polite">
    <a href="{{ route('notifikasi.detail', ['type' => 'selesai']) }}" class="notification-item unread" role="alert" aria-label="Pesanan Telah Selesai 10 September 2025">
      <div class="notif-header">
        <div class="notif-title">
          <div class="notif-icon success">
            <i class="fas fa-check-circle"></i>
          </div>
          <span class="notif-title-text">Pesanan Telah Selesai</span>
        </div>
        <span class="date">10/09/2025</span>
      </div>
      <p>Halo Oloan, selamat atas kemajuan pesanan Anda di Pupuk & Bibit Subsidi! Kami dengan senang menginformasikan bahwa pesanan Anda telah selesai diproses dan siap untuk diambil.</p>
    </a>

    <a href="{{ route('notifikasi.detail', ['type' => 'diproses']) }}" class="notification-item" role="alert" aria-label="Pesanan Sedang Diproses 6 September 2025">
      <div class="notif-header">
        <div class="notif-title">
          <div class="notif-icon process">
            <i class="fas fa-clock"></i>
          </div>
          <span class="notif-title-text">Pesanan Sedang Diproses</span>
        </div>
        <span class="date">06/09/2025</span>
      </div>
      <p>Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja Anda! Kami senang melihat pesanan sedang dalam proses dan akan segera siap untuk diambil.</p>
    </a>

    <a href="{{ route('notifikasi.detail', ['type' => 'konfirmasi']) }}" class="notification-item" role="alert" aria-label="Segera Lakukan Konfirmasi Pesanan 5 September 2025">
      <div class="notif-header">
        <div class="notif-title">
          <div class="notif-icon warning">
            <i class="fas fa-exclamation-circle"></i>
          </div>
          <span class="notif-title-text">Segera Lakukan Konfirmasi Pesanan</span>
        </div>
        <span class="date">05/09/2025</span>
      </div>
      <p>Halo Oloan, pesanan Anda memerlukan konfirmasi. Mohon segera lakukan konfirmasi untuk melanjutkan proses pemesanan produk subsidi Anda.</p>
    </a>

    <a href="{{ route('notifikasi.detail', ['type' => 'verifikasi']) }}" class="notification-item" role="alert" aria-label="Verifikasi Akun Pengguna Berhasil 2 September 2025">
      <div class="notif-header">
        <div class="notif-title">
          <div class="notif-icon info">
            <i class="fas fa-user-check"></i>
          </div>
          <span class="notif-title-text">Verifikasi Akun Pengguna Berhasil</span>
        </div>
        <span class="date">02/09/2025</span>
      </div>
      <p>Selamat datang secara resmi di Pupuk & Bibit Subsidi! Kami senang sekali mengumumkan bahwa proses verifikasi akun Anda telah berhasil dan Anda dapat mulai menggunakan layanan kami.</p>
    </a>

    <div class="no-notifs" aria-live="polite" aria-atomic="true">
      <hr><span>Tidak Ada Notifikasi Lain</span><hr>
    </div>
  </section>
</main>
@endsection
