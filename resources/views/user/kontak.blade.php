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
        padding: 60px 20px;
        position: relative;
    }

    /* Decorative background elements */
    .container::before {
        content: '';
        position: absolute;
        top: 10%;
        left: -5%;
        width: 150px;
        height: 150px;
        background: linear-gradient(45deg, rgba(76, 175, 80, 0.1), rgba(76, 175, 80, 0.05));
        border-radius: 50%;
        z-index: -1;
        animation: float 6s ease-in-out infinite;
    }

    .container::after {
        content: '';
        position: absolute;
        bottom: 20%;
        right: -3%;
        width: 120px;
        height: 120px;
        background: linear-gradient(45deg, rgba(46, 125, 50, 0.08), rgba(46, 125, 50, 0.04));
        border-radius: 50%;
        z-index: -1;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .page-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
        padding: 40px 0;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #4CAF50, #2e7d32);
        border-radius: 2px;
        animation: slideIn 1s ease-out;
    }

    .page-header h1 {
        font-size: 3rem;
        background: linear-gradient(135deg, #2e7d32, #4CAF50);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 15px;
        font-weight: 700;
        animation: fadeInUp 0.8s ease-out;
        position: relative;
    }

    .page-subtitle {
        font-size: 1.1rem;
        color: #555;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.7;
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    @keyframes slideIn {
        from { width: 0; }
        to { width: 80px; }
    }

    @keyframes fadeInUp {
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .contact-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-top: 40px;
        animation: fadeIn 1s ease-out 0.4s both;
    }

    .contact-info-card {
        background: linear-gradient(145deg, #ffffff, #f8fffe);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08), 
                    0 1px 8px rgba(0,0,0,0.05);
        border: 1px solid rgba(76, 175, 80, 0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        transform: translateY(0);
    }

    .contact-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4CAF50, #2e7d32, #4CAF50);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    .contact-info-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12), 
                    0 5px 15px rgba(76, 175, 80, 0.1);
    }

    @keyframes shimmer {
        0%, 100% { background-position: -200% 0; }
        50% { background-position: 200% 0; }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 30px;
    }

    .info-icon {
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, #e8f5e8, #f0f8f0);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #4CAF50;
        border: 2px solid rgba(76, 175, 80, 0.2);
        transition: all 0.3s ease;
        position: relative;
    }

    .info-icon i {
        transition: all 0.3s ease;
    }

    .info-icon::after {
        content: '';
        position: absolute;
        inset: -2px;
        border-radius: 18px;
        padding: 2px;
        background: linear-gradient(45deg, #4CAF50, #2e7d32);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: xor;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .contact-info-card:hover .info-icon::after {
        opacity: 1;
    }

    .contact-info-card:hover .info-icon {
        transform: scale(1.1);
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
    }

    .info-header h3 {
        font-size: 1.3rem;
        color: var(--text-color);
    }

    .info-description {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .contact-detail {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
        font-size: 0.95rem;
        color: var(--text-color);
        padding: 10px 0;
        transition: all 0.3s ease;
    }

    .contact-detail:hover {
        color: #4CAF50;
        transform: translateX(5px);
    }

    .contact-detail i {
        width: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .operating-hours {
        margin-top: 30px;
    }

    .hours-header {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 1rem;
        padding: 12px 0;
        border-bottom: 2px solid rgba(76, 175, 80, 0.1);
    }

    .hours-header i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .hours-table {
        width: 100%;
    }

    .hours-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .hours-row:last-child {
        border-bottom: none;
    }

    .day {
        color: #666;
    }

    .time {
        font-weight: 600;
        color: var(--text-color);
    }

    .contact-form-card {
        background: linear-gradient(145deg, #ffffff, #f8fffe);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08), 
                    0 1px 8px rgba(0,0,0,0.05);
        border: 1px solid rgba(76, 175, 80, 0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .contact-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2e7d32, #4CAF50, #2e7d32);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    .contact-form-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12), 
                    0 5px 15px rgba(76, 175, 80, 0.1);
    }

    .form-header {
        font-size: 1.3rem;
        color: var(--text-color);
        margin-bottom: 25px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-header i {
        color: #4CAF50;
        font-size: 1.2rem;
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
        padding: 14px 16px;
        border: 2px solid #e8e8e8;
        border-radius: 12px;
        font-size: 0.95rem;
        font-family: 'Segoe UI', sans-serif;
        transition: all 0.3s ease;
        background: #fafafa;
        position: relative;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.15);
        background: white;
        transform: translateY(-2px);
    }

    .form-group input:hover,
    .form-group textarea:hover {
        border-color: #c8c8c8;
        background: white;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .submit-btn {
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .submit-btn:hover::before {
        left: 100%;
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #45a049, #3d8b40);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
    }

    .submit-btn:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .faq-section {
        margin-top: 80px;
        animation: fadeInUp 0.8s ease-out 0.6s both;
    }

    .faq-header {
        font-size: 2.2rem;
        background: linear-gradient(135deg, #2e7d32, #4CAF50);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 40px;
        font-weight: 700;
        text-align: center;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }

    .faq-header i {
        font-size: 2rem;
        color: #4CAF50;
        background: none;
        -webkit-text-fill-color: #4CAF50;
    }

    .faq-header::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #4CAF50, #2e7d32);
        border-radius: 2px;
    }

    .faq-item {
        background: linear-gradient(145deg, #ffffff, #f9fffa);
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(76, 175, 80, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .faq-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #4CAF50, #2e7d32);
        border-radius: 0 2px 2px 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .faq-item:hover {
        transform: translateX(10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .faq-item:hover::before {
        opacity: 1;
    }

    .faq-question {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 12px;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-question i {
        color: #4CAF50;
        font-size: 0.9rem;
        min-width: 16px;
    }

    .faq-answer {
        color: #666;
        line-height: 1.6;
        font-size: 0.95rem;
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
            gap: 30px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .page-header h1 {
            font-size: 2.4rem;
        }

        .page-subtitle {
            font-size: 1rem;
        }

        .container {
            padding: 40px 20px;
        }

        .contact-info-card,
        .contact-form-card {
            padding: 30px;
        }

        .faq-item:hover {
            transform: translateX(5px);
        }

        .faq-header {
            font-size: 1.8rem;
            flex-direction: column;
            gap: 10px;
        }

        .faq-header i {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 640px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .container {
            padding: 30px 15px;
        }

        .contact-info-card,
        .contact-form-card {
            padding: 25px;
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
