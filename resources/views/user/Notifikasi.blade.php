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
      max-width: 1024px;
      margin: 0 auto;
      padding: 0 20px;
  }

  /* Main */
  main {
      margin: 20px auto 60px;
      background-color: #f2f7f0;
      border-radius: 12px;
      padding: 20px 24px;
      box-shadow: 0 0 15px rgba(0,0,0,0.07);
  }

  main h2 {
      font-family: "Arial Black", Arial, sans-serif;
      color: #195619;
      font-size: 20px;
      margin-bottom: 18px;
      text-align: center;
  }

  /* Notification items */
  .notification-item {
      background-color: #d7d7d7;
      border-radius: 12px;
      padding: 14px 18px;
      margin-bottom: 14px;
      font-size: 14px;
      box-shadow: inset 0 0 12px #b1b1b1;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      color: inherit;
      display: block;
  }

  .notification-item:hover {
      background-color: #c5c5c5;
      transform: translateX(5px);
      box-shadow: inset 0 0 12px #a0a0a0;
  }

  .notif-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 700;
      font-family: "Arial Black", Arial, sans-serif;
      font-size: 14px;
      margin-bottom: 6px;
      color: #222;
  }

  .notif-header i {
      margin-right: 10px;
      font-size: 18px;
  }

  .notif-header .date {
      font-size: 12px;
      color: #555;
      font-weight: 400;
      font-family: Arial, sans-serif;
  }

  .notification-item p {
      font-weight: 400;
      font-family: Arial, sans-serif;
      font-size: 13px;
      color: #111;
      margin-left: 30px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }

  /* No notifications */
  .no-notifs {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      color: #195619;
      font-weight: 700;
      font-family: "Arial Black", Arial, sans-serif;
      margin-top: 10px;
      font-size: 14px;
  }

  .no-notifs hr {
      border: none;
      border-top: 1px solid #88b168;
      width: 28%;
  }

  /* Icon fonts - emoji substitutions */
  .notification-item i.fa-check-square::before {
    content: "✔️";
    margin-right: 6px;
  }

  .notification-item i.fa-file-alt::before {
    content: "📃";
    margin-right: 6px;
  }

  .notification-item i.fa-sync-alt::before {
    content: "⏳";
    margin-right: 6px;
  }

  .notification-item i.fa-check-circle::before {
    content: "✅";
    margin-right: 6px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .container {
        padding: 0 15px;
    }
  }
</style>
@endpush

@section('content')
<main class="container" role="main" aria-label="Daftar notifikasi">
  <h2>Notifikasi</h2>

  <section aria-live="polite">
    <a href="{{ route('notifikasi.detail') }}" class="notification-item" role="alert" aria-label="Pesanan Telah Selesai 10 September 2025">
      <div class="notif-header">
        <span><i class="fa-check-square"></i> Pesanan Telah Selesai</span>
        <span class="date">10/09/2025</span>
      </div>
      <p>"Halo Oloan, selamat atas kemajuan pesanan Anda di Pupuk & Bibit Subsidi! 🎉 Kami dengan senang menginformasikan bahwa.....</p>
    </a>

    <a href="{{ route('notifikasi.detail') }}" class="notification-item" role="alert" aria-label="Pesanan Sedang Diproses 6 September 2025">
      <div class="notif-header">
        <span><i class="fa-file-alt"></i> Pesanan Sedang Diproses</span>
        <span class="date">06/09/2025</span>
      </div>
      <p>"Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja seru Anda! 🎉 Kami senang melihat pesanan de.....</p>
    </a>

    <a href="{{ route('notifikasi.detail') }}" class="notification-item" role="alert" aria-label="Segera Lakukan Konfirmasi Pesanan 5 September 2025">
      <div class="notif-header">
        <span><i class="fa-sync-alt"></i> Segera Lakukan Konfirmasi Pesanan</span>
        <span class="date">05/09/2025</span>
      </div>
      <p>"Halo Oloan, terima kasih sudah memilih Pupuk dan Bibit Subsidi untuk belanja seru Anda! 🎉 Kami senang melihat pesanan de.....</p>
    </a>

    <a href="{{ route('notifikasi.detail') }}" class="notification-item" role="alert" aria-label="Verifikasi Akun Pengguna Berhasil 2 September 2025">
      <div class="notif-header">
        <span><i class="fa-check-circle"></i> Verifikasi Akun Pengguna Berhanang sekali mengumumkan bahwa proses verifikasi akun.....</p>
    </a>

    <div class="no-notifs" aria-live="polite" aria-atomic="true">
      <hr /><span>Tidak Ada Notifikasi Lain</span><hr />
    </div>
  </section>
</main>
@endsection
sil</span>
        <span class="date">02/09/2025</span>
      </div>
      <p>"Selamat datang secara resmi di [Nama Platform/Web Kamu]! 🎉 Kami se