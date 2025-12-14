<?php $__env->startSection('title', 'Hubungi Kami'); ?>

<?php $__env->startPush('styles'); ?>
<style>

    .contact-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-2xl);
        margin-top: var(--space-3xl);
    }

    .contact-info-card {
        background: var(--white);
        padding: var(--space-2xl);
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        transition: all var(--transition-base);
    }

    .contact-info-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: var(--space-lg);
        margin-bottom: var(--space-xl);
    }

    .info-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-medium));
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: var(--shadow-green);
        color: var(--white);
    }

    .info-header h3 {
        font-size: var(--font-size-xl);
        color: var(--text-primary);
        font-weight: 700;
    }

    .info-description {
        color: var(--text-secondary);
        font-size: var(--font-size-base);
        line-height: 1.6;
        margin-bottom: var(--space-xl);
    }

    .contact-detail {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        margin-bottom: var(--space-lg);
        font-size: var(--font-size-base);
        color: var(--text-secondary);
        font-weight: 600;
    }

    .operating-hours {
        margin-top: var(--space-2xl);
        padding-top: var(--space-2xl);
        border-top: 1px solid var(--border-light);
    }

    .hours-header {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        font-weight: 700;
        margin-bottom: var(--space-lg);
        font-size: var(--font-size-lg);
        color: var(--text-primary);
    }

    .hours-table {
        width: 100%;
    }

    .hours-row {
        display: flex;
        justify-content: space-between;
        padding: var(--space-md) var(--space-lg);
        border-bottom: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        transition: background var(--transition-fast);
    }

    .hours-row:hover {
        background: var(--gray-50);
    }

    .hours-row:last-child {
        border-bottom: none;
    }

    .day {
        color: var(--text-secondary);
        font-weight: 600;
    }

    .time {
        font-weight: 600;
        color: var(--text-tertiary);
    }

    .contact-form-card {
        background: var(--white);
        padding: var(--space-2xl);
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        transition: all var(--transition-base);
    }

    .contact-form-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .form-header {
        font-size: var(--font-size-xl);
        color: var(--text-primary);
        margin-bottom: var(--space-xl);
        font-weight: 700;
        position: relative;
        padding-bottom: var(--space-lg);
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--primary-green-medium));
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-lg);
        margin-bottom: var(--space-xl);
    }

    .full-width {
        grid-column: 1 / -1;
    }
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
        background: var(--white);
        padding: var(--space-xl);
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
        transition: all var(--transition-base);
    }

    .faq-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-green-light);
    }

    .faq-question {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-md);
        font-size: var(--font-size-lg);
        display: flex;
        align-items: center;
        gap: var(--space-md);
    }

    .faq-question::before {
        content: '\f059';
        font-family: 'Font Awesome 6 Free';
        font-weight: 400;
        color: var(--primary-green);
        font-size: var(--font-size-xl);
    }

    .faq-answer {
        color: var(--text-secondary);
        line-height: 1.6;
        font-size: var(--font-size-base);
        padding-left: var(--space-2xl);
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-wrapper-user">
    <div class="container-user-md">
        <div class="page-header-user">
            <h1 class="page-title">Hubungi Kami</h1>
            <p class="page-subtitle">Customer Service kami siap membantu Anda 24/7 dengan pertanyaan seputar program pupuk subsidi</p>
        </div>

    <div class="contact-section">
        <!-- Contact Info Card -->
        <div class="contact-info-card">
            <div class="info-header">
                <div class="info-icon"><i class="fas fa-comments"></i></div>
                <h3>Butuh Bantuan Cepat?</h3>
            </div>
            <p class="info-description">Hubungi kami langsung melalui WhatsApp untuk respon lebih cepat</p>
            
            <div class="contact-detail">
                <span class="icon-box-user"><i class="fas fa-phone"></i></span>
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
                    <span class="icon-box-user"><i class="fas fa-clock"></i></span>
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

            <?php if(session('success')): ?>
                <div class="alert-user alert-user-success">
                    <i class="fas fa-check-circle" style="font-size: 1.4rem;"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('kontak.send')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-grid">
                    <div class="form-group-user">
                        <label for="nama" class="form-label-user">Nama</label>
                        <input type="text" id="nama" name="nama" value="<?php echo e(old('nama')); ?>" class="form-input-user" required>
                    </div>
                    <div class="form-group-user">
                        <label for="no_telp" class="form-label-user">No. Telp</label>
                        <input type="text" id="no_telp" name="no_telp" value="<?php echo e(old('no_telp')); ?>" class="form-input-user" required>
                    </div>
                    <div class="form-group-user full-width">
                        <label for="email" class="form-label-user">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" class="form-input-user" required>
                    </div>
                    <div class="form-group-user full-width">
                        <label for="pesan" class="form-label-user">Pesan</label>
                        <textarea id="pesan" name="pesan" class="form-input-user form-textarea-user" required><?php echo e(old('pesan')); ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-user btn-user-primary btn-user-lg" style="width: 100%;">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section" style="margin-top: var(--space-4xl);">
        <h2 class="section-title" style="text-align: center; margin-bottom: var(--space-3xl);">Pertanyaan yang Sering Diajukan</h2>
        
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
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Project-SistemInformasiPupuk\resources\views/user/kontak.blade.php ENDPATH**/ ?>