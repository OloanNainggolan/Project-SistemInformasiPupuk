@extends('layouts.user')

@section('title', 'Pesanan Berhasil - Pupuk & Bibit Subsidi')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #333;
        min-height: 100vh;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes checkmark {
        0% {
            transform: scale(0) rotate(45deg);
            opacity: 0;
        }
        50% {
            transform: scale(1.2) rotate(45deg);
            opacity: 1;
        }
        100% {
            transform: scale(1) rotate(45deg);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* Main Container */
    .success-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 50px;
        min-height: calc(100vh - 200px);
        animation: fadeIn 0.5s ease;
    }

    /* Success Card */
    .success-card {
        background: white;
        border-radius: 25px;
        padding: 60px 80px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        text-align: center;
        animation: slideInUp 0.6s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .success-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #004d00);
    }

    /* Success Icon */
    .success-icon-wrapper {
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        position: relative;
    }

    .success-circle {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 40px rgba(16, 185, 129, 0.5), 0 0 0 10px rgba(16, 185, 129, 0.1);
        animation: pulse 2s ease infinite;
        position: relative;
    }

    .success-circle::after {
        content: '';
        position: absolute;
        width: 145px;
        height: 145px;
        border: 4px solid rgba(16, 185, 129, 0.3);
        border-radius: 50%;
        animation: pulse 2s ease infinite;
    }

    .checkmark {
        width: 50px;
        height: 50px;
        position: relative;
        animation: checkmark 0.8s ease 0.3s both;
    }

    .checkmark::before,
    .checkmark::after {
        content: '';
        position: absolute;
        background: white;
        border-radius: 3px;
    }

    .checkmark::before {
        width: 6px;
        height: 25px;
        right: 15px;
        top: 12px;
        transform: rotate(45deg);
    }

    .checkmark::after {
        width: 6px;
        height: 15px;
        left: 15px;
        top: 22px;
        transform: rotate(-45deg);
    }

    /* Success Content */
    .success-title {
        font-size: 42px;
        font-weight: 800;
        color: #065f46;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #065f46 0%, #10b981 50%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 2px 10px rgba(16, 185, 129, 0.1);
    }

    .success-subtitle {
        font-size: 20px;
        color: #047857;
        font-weight: 500;
        margin-bottom: 50px;
        line-height: 1.8;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Order Info */
    .order-info {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #d1fae5 100%);
        border-radius: 24px;
        padding: 45px;
        margin: 50px 0;
        border: 3px solid #10b981;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.5);
        position: relative;
        overflow: hidden;
    }

    .order-info::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .order-number {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 2px dashed #10b981;
    }

    .order-number-label {
        font-size: 18px;
        color: #6b7280;
        font-weight: 600;
    }

    .order-number-value {
        font-size: 36px;
        font-weight: 800;
        background: linear-gradient(135deg, #065f46 0%, #10b981 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 3px;
        font-family: 'Courier New', monospace;
        padding: 10px 20px;
        border-radius: 12px;
        background-color: rgba(16, 185, 129, 0.05);
    }

    .order-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 30px;
    }

    .order-detail-row {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }

    .order-detail-row::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #10b981, #059669);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .order-detail-row:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 28px rgba(16, 185, 129, 0.25);
        border-color: #10b981;
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    }

    .order-detail-row:hover::before {
        transform: scaleY(1);
    }

    .order-detail-label {
        font-weight: 600;
        color: #6b7280;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-detail-label i {
        color: #004d00;
        width: 24px;
        font-size: 18px;
    }

    .order-detail-value {
        font-weight: 700;
        color: #065f46;
        font-size: 18px;
    }

    /* Payment Info */
    .payment-info-box {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 20px;
        padding: 40px;
        margin: 40px 0;
        border-left: 6px solid #f59e0b;
        text-align: left;
    }

    .payment-info-title {
        font-size: 22px;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .payment-info-title i {
        font-size: 28px;
    }

    .payment-info-text {
        font-size: 16px;
        color: #78350f;
        line-height: 1.8;
        margin-bottom: 25px;
    }

    .payment-locations {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 25px;
    }

    .payment-location {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 15px;
        padding: 25px 20px;
        background: white;
        border-radius: 15px;
        font-size: 15px;
        font-weight: 600;
        color: #92400e;
        transition: all 0.3s ease;
    }

    .payment-location:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.2);
    }

    .payment-location i {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    /* Next Steps */
    .next-steps {
        text-align: left;
        margin: 50px 0;
    }

    .next-steps-title {
        font-size: 24px;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .next-steps-title i {
        color: #004d00;
        font-size: 28px;
    }

    .steps-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .step-item {
        display: flex;
        gap: 20px;
        padding: 25px;
        background: linear-gradient(135deg, #f9fafb, #f3f4f6);
        border-radius: 15px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .step-item:hover {
        background: linear-gradient(135deg, #dcfce7, #d1fae5);
        transform: translateY(-5px);
        border-color: #10b981;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.15);
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #004d00, #047857);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 22px;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .step-text {
        flex: 1;
        color: #374151;
        font-size: 15px;
        line-height: 1.8;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 20px;
        margin-top: 50px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 18px 45px;
        border: none;
        border-radius: 15px;
        font-size: 17px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #004d00, #047857);
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #004d00, #047857);
        transform: translateY(-3px); 
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        background: white;
        color: #065f46;
        border: 2px solid #004d00;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #dcfce7, #d1fae5);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.2);
    }

    /* Support Info */
    .support-info {
        margin-top: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        border-radius: 15px;
        font-size: 15px;
        color: #6b7280;
        line-height: 1.8;
        text-align: center;
    }

    .support-info strong {
        color: #065f46;
        font-size: 17px;
    }

    .support-info a {
        color: #004d00;
        text-decoration: none;
        font-weight: 600;
    }

    .support-info a:hover {
        color: #004d00;
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .success-card {
            padding: 50px 60px;
        }

        .order-details {
            grid-template-columns: 1fr;
        }

        .payment-locations {
            grid-template-columns: 1fr;
        }

        .steps-list {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .success-container {
            padding: 40px 20px;
        }

        .success-card {
            padding: 35px 25px;
        }

        .success-title {
            font-size: 28px;
        }

        .success-subtitle {
            font-size: 16px;
        }

        .order-number {
            flex-direction: column;
            gap: 10px;
        }

        .order-number-label {
            font-size: 16px;
        }

        .order-number-value {
            font-size: 24px;
        }

        .order-details {
            grid-template-columns: 1fr;
        }

        .order-detail-row {
            padding: 15px;
        }

        .order-detail-value {
            font-size: 16px;
        }

        .payment-info-box {
            padding: 25px;
        }

        .payment-info-title {
            font-size: 18px;
        }

        .payment-locations {
            grid-template-columns: 1fr;
        }

        .next-steps-title {
            font-size: 20px;
        }

        .steps-list {
            grid-template-columns: 1fr;
        }

        .step-item {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
            padding: 16px 30px;
        }
    }
</style>
@endpush

@section('content')
    <div class="success-container">
        <div class="success-card">
            <!-- Success Icon -->
            <div class="success-icon-wrapper">
                <div class="success-circle">
                    <div class="checkmark"></div>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="success-title">Pesanan Berhasil Dikirim!</h1>
            <p class="success-subtitle">
                Terima kasih telah memesan. Pesanan Anda telah kami terima dan akan segera diproses oleh tim kami.
            </p>

            <!-- Order Information -->
            <div class="order-info">
                <div class="order-number">
                    <span class="order-number-label">Nomor Pesanan:</span>
                    <span class="order-number-value">{{ $orderNumber ?? '#ORDER123' }}</span>
                </div>

                <div class="order-details">
                    <div class="order-detail-row">
                        <span class="order-detail-label">
                            <i class="fas fa-box"></i>
                            Produk
                        </span>
                        <span class="order-detail-value">{{ $productName ?? 'Pupuk NPK' }}</span>
                    </div>
                    <div class="order-detail-row">
                        <span class="order-detail-label">
                            <i class="fas fa-weight"></i>
                            Jumlah
                        </span>
                        <span class="order-detail-value">{{ $quantity ?? '10' }} kg</span>
                    </div>
                    <div class="order-detail-row">
                        <span class="order-detail-label">
                            <i class="fas fa-money-bill-wave"></i>
                            Total Pembayaran
                        </span>
                        <span class="order-detail-value">Rp {{ number_format($totalAmount ?? 500000, 0, ',', '.') }}</span>
                    </div>
                    <div class="order-detail-row">
                        <span class="order-detail-label">
                            <i class="fas fa-calendar-alt"></i>
                            Tanggal Pesanan
                        </span>
                        <span class="order-detail-value">{{ $orderDate ?? date('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="payment-info-box">
                <div class="payment-info-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Pembayaran
                </div>
                <p class="payment-info-text">
                    Silakan lakukan pembayaran <strong>maksimal 3 hari</strong> setelah konfirmasi pesanan. 
                    Bawa <strong>nomor pesanan</strong> dan <strong>identitas diri (KTP)</strong> saat melakukan pembayaran.
                </p>
                <div class="payment-locations">
                    <div class="payment-location">
                        <i class="fas fa-1"></i>
                        <span>Balai Desa setempat</span>
                    </div>
                    <div class="payment-location">
                        <i class="fas fa-2"></i>
                        <span>Dinas Pertanian Kabupaten/Kota</span>
                    </div>
                    <div class="payment-location">
                        <i class="fas fa-3"></i>
                        <span>Kantor Penyuluhan Pertanian (BP3K)</span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="next-steps">
                <h3 class="next-steps-title">
                    <i class="fas fa-clipboard-list"></i>
                    Langkah Selanjutnya
                </h3>
                <div class="steps-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-text">
                            Simpan nomor pesanan Anda untuk referensi pembayaran
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-text">
                            Lakukan pembayaran di salah satu lokasi yang tersedia dalam waktu 3 hari
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-text">
                            Setelah pembayaran dikonfirmasi, pesanan akan diproses dan siap diambil
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-text">
                            Anda akan mendapatkan notifikasi saat pesanan siap untuk diambil
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('user.pupukbibit') }}" class="btn btn-secondary">
                    <i class="fas fa-shopping-bag"></i>
                    Belanja Lagi
                </a>
            </div>

            <!-- Support Information -->
            <div class="support-info">
                <i class="fas fa-headset"></i> 
                <strong>Butuh Bantuan?</strong><br>
                Hubungi customer service kami di <a href="tel:+6281234567890">0812-3456-7890</a> 
                atau email ke <a href="mailto:support@pupukbibit.go.id">support@pupukbibit.go.id</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Ambil data pesanan dari localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const lastOrderData = localStorage.getItem('lastOrder');
        
        if (lastOrderData) {
            const orderData = JSON.parse(lastOrderData);
            
            // Update nomor pesanan
            const orderNumberEl = document.querySelector('.order-number-value');
            if (orderNumberEl && orderData.orderNumber) {
                orderNumberEl.textContent = orderData.orderNumber;
            }
            
            // Update nama produk
            const productNameEl = document.querySelectorAll('.order-detail-value')[0];
            if (productNameEl && orderData.productName) {
                productNameEl.textContent = orderData.productName;
            }
            
            // Update jumlah
            const quantityEl = document.querySelectorAll('.order-detail-value')[1];
            if (quantityEl && orderData.quantity) {
                quantityEl.textContent = orderData.quantity + ' kg';
            }
            
            // Update total pembayaran
            const totalEl = document.querySelectorAll('.order-detail-value')[2];
            if (totalEl && orderData.totalAmount) {
                totalEl.textContent = 'Rp ' + orderData.totalAmount.toLocaleString('id-ID');
            }
            
            // Update tanggal pesanan
            const dateEl = document.querySelectorAll('.order-detail-value')[3];
            if (dateEl && orderData.orderDate) {
                dateEl.textContent = orderData.orderDate;
            }
            
            // Hapus data dari localStorage setelah ditampilkan
            // Uncomment baris ini jika ingin menghapus data setelah ditampilkan
            // localStorage.removeItem('lastOrder');
        }
    });
</script>
@endpush
