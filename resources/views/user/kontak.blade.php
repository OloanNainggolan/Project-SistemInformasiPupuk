@extends('layouts.user')

@section('title', 'Hubungi Kami')

@push('styles')
<style>
    :root {
        --primary-green: #4CAF50;
        --dark-green: #065f46;
        --medium-green: #1a4d1a;
        --light-green: #81c784;
        --text-color: #333;
        --white: #ffffff;
        --light-gray-bg: #f7f7f7;
        --border-color: #ddd;
    }

    body {
        background: linear-gradient(135deg, #f0f8f0 0%, #e8f5e8 100%);
        min-height: 100vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 20px 60px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
    }

    .page-header::after {
        content: '';
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #4CAF50, #2e7d32);
        display: block;
        margin: 20px auto 0;
        border-radius: 2px;
    }

    .page-header h1 {
        font-size: 2.8rem;
        color: #2e7d32;
        margin-bottom: 16px;
        font-weight: 700;
        position: relative;
        display: inline-block;
    }

    .page-subtitle {
        font-size: 1.1rem;
        color: #555;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .contact-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 35px;
        margin-top: 40px;
        animation: fadeIn 1s ease-out 0.4s both;
    }

    .contact-info-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fff9 100%);
        padding: 45px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(76, 175, 80, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(76, 175, 80, 0.15);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 25px;
    }

    .info-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #4CAF50, #2e7d32);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 35px;
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.3);
    }

    .info-header h3 {
        font-size: 1.4rem;
        color: var(--text-color);
        font-weight: 600;
    }

    .info-description {
        color: #555;
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 28px;
    }

    .contact-detail {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
        font-size: 1rem;
        color: var(--text-color);
        font-weight: 500;
    }

    .operating-hours {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid transparent;
        border-image: linear-gradient(90deg, transparent, rgba(76, 175, 80, 0.3), transparent) 1;
    }

    .hours-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.15rem;
        color: var(--text-color);
    }

    .hours-header::before {
        content: '';
        width: 4px;
        height: 22px;
        background: linear-gradient(180deg, #4CAF50, #2e7d32);
        border-radius: 2px;
    }

    .hours-table {
        width: 100%;
    }

    .hours-row {
        display: flex;
        justify-content: space-between;
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .hours-row:hover {
        background: rgba(76, 175, 80, 0.05);
    }

    .hours-row:last-child {
        border-bottom: none;
    }

    .day {
        color: var(--text-color);
        font-weight: 600;
    }

    .time {
        font-weight: 500;
        color: #666;
    }

    .contact-form-card {
        background: linear-gradient(135deg, #ffffff 0%, #fafffe 100%);
        padding: 45px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid rgba(76, 175, 80, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .contact-form-card:hover {
        box-shadow: 0 12px 40px rgba(76, 175, 80, 0.12);
    }

    .form-header {
        font-size: 1.4rem;
        color: var(--text-color);
        margin-bottom: 30px;
        font-weight: 700;
        position: relative;
        padding-bottom: 15px;
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #4CAF50, #2e7d32);
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 500;
        margin-bottom: 8px;
        color: var(--text-color);
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group textarea {
        padding: 14px 18px;
        border: 2px solid #e5e5e5;
        border-radius: 10px;
        font-size: 1rem;
        font-family: 'Arial', sans-serif;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-group input:hover,
    .form-group textarea:hover {
        border-color: #d0d0d0;
        background: #ffffff;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-green);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .submit-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #4CAF50, #2e7d32);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #45a049, #27692a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .faq-section {
        margin-top: 60px;
        padding-top: 50px;
        border-top: 2px solid transparent;
        border-image: linear-gradient(90deg, transparent, rgba(76, 175, 80, 0.3), transparent) 1;
    }

    .faq-header {
        font-size: 2rem;
        color: #2e7d32;
        margin-bottom: 35px;
        font-weight: 700;
        position: relative;
        padding-bottom: 15px;
    }

    .faq-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #4CAF50, #2e7d32);
        border-radius: 2px;
    }

    .faq-item {
        background: linear-gradient(135deg, #ffffff 0%, #f9fffb 100%);
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 18px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        border: 1px solid rgba(76, 175, 80, 0.08);
        transition: all 0.3s ease;
    }

    .faq-item:hover {
        transform: translateX(5px);
        box-shadow: 0 6px 25px rgba(76, 175, 80, 0.12);
        border-color: rgba(76, 175, 80, 0.15);
    }

    .faq-question {
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 12px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-question::before {
        content: '\f059';
        font-family: 'Font Awesome 6 Free';
        font-weight: 400;
        color: #4CAF50;
        font-size: 1.2rem;
    }

    .faq-answer {
        color: #555;
        line-height: 1.7;
        font-size: 1rem;
        padding-left: 30px;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Responsive Design */
    @media (max-width: 968px) {
        .contact-section {
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .page-header h1 {
            font-size: 2.2rem;
        }

        .page-subtitle {
            font-size: 1rem;
        }

        .container {
            padding: 50px 15px 40px;
        }

        .contact-info-card,
        .contact-form-card {
            padding: 30px 20px;
        }

        .faq-header {
            font-size: 1.7rem;
        }

        .faq-item {
            padding: 25px 20px;
        }

        .info-icon {
            width: 55px;
            height: 55px;
            font-size: 24px;
        }

        .faq-header {
            font-size: 1.6rem;
            flex-direction: column;
            gap: 8px;
        }

        .faq-header i {
            font-size: 1.4rem;
        }

        .contact-detail {
            gap: 10px;
        }

        .contact-detail i {
            width: 18px;
            font-size: 0.9rem;
        }

        .container::before,
        .container::after {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Hubungi Kami</h1>
        <p class="page-subtitle">Customer Service kami siap membantu Anda 24/7 dengan pertanyaan seputar program pupuk subsidi</p>
    </div>

    <div class="contact-section">
        <!-- Contact Info Card -->
        <div class="contact-info-card">
            <div class="info-header">
                <div class="info-icon"><i class="fas fa-headset"></i></div>
                <h3>Butuh Bantuan Cepat?</h3>
            </div>
            <p class="info-description">Hubungi kami langsung melalui WhatsApp untuk respon lebih cepat</p>
            
            <div class="contact-detail">
                <i class="fas fa-phone-alt"></i>
                <span>+62 812-3456-7890</span>
            </div>
            
            <div class="contact-detail">
                <i class="fab fa-whatsapp"></i>
                <span>+62 812-3456-7890 (WhatsApp)</span>
            </div>
            
            <div class="contact-detail">
                <i class="fas fa-envelope"></i>
                <span>info@pupuksubsidi.gov.id</span>
            </div>
            
            <div class="contact-detail">
                <i class="fas fa-map-marker-alt"></i>
                <span>Jl. Pertanian No. 123, Jakarta Pusat</span>
            </div>

            <!-- Operating Hours -->
            <div class="operating-hours">
                <div class="hours-header">
                    <i class="fas fa-clock" style="color: #4CAF50;"></i>
                    <span>Jam Operasional</span>
                </div>
                <div class="hours-table">
                    <div class="hours-row">
                        <span class="day">Senin - Jumat</span>
                        <span class="time">08.00 - 17.00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Sabtu</span>
                        <span class="time">08.00 - 12.00</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Minggu & Libur</span>
                        <span class="time">Tutup</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Card -->
        <div class="contact-form-card">
            <h3 class="form-header">
                <i class="fas fa-paper-plane"></i>
                Kirim Pesan Sekarang
            </h3>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('kontak.send') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No. Telp</label>
                        <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" required>{{ old('pesan') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
        <h2 class="faq-header">
            <i class="fas fa-question-circle"></i>
            Pertanyaan yang Sering Diajukan
        </h2>
        
        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-user-plus"></i>
                Bagaimana cara mendaftar program subsidi?
            </div>
            <div class="faq-answer">Anda dapat mendaftar melalui website ini atau datang langsung ke Balai Desa setempat dengan membawa KTP.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-shipping-fast"></i>
                Kapan pupuk akan dikirim?
            </div>
            <div class="faq-answer">Pupuk akan diambil 2-3 hari setelah konfirmasi pesanan. Anda akan menerima notifikasi saat pupuk siap diambil.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-money-bill-wave"></i>
                Bagaimana cara pembayaran?
            </div>
            <div class="faq-answer">Pembayaran hanya dapat dilakukan secara tunai di Balai Desa saat pengambilan pupuk.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <i class="fas fa-balance-scale"></i>
                Berapa batas maksimal pembelian?
            </div>
            <div class="faq-answer">Batas pembelian disesuaikan dengan luas lahan yang terdaftar, maksimal 2 ton per musim tanam.</div>
        </div>
    </div>
</div>
@endsection
