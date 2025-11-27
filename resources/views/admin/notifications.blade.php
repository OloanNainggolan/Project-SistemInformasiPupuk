@extends('layouts.admin')

@section('title', 'Kirim Notifikasi')

@push('styles')
<style>
    /* Page Header */
    .notification-header {
        background: white;
        padding: 28px 32px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .notification-header h1 {
        color: #065f46;
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .notification-header h1 i {
        color: #10b981;
    }

    .notification-header p {
        color: #6b7280;
        font-size: 15px;
    }

    /* Notification Form */
    .notification-form {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        max-width: 900px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .form-group label i {
        margin-right: 8px;
        color: #10b981;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    .recipient-options {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 22px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .radio-option:hover {
        border-color: #10b981;
        background: linear-gradient(135deg, #dcfce7, #d1fae5);
    }

    .radio-option input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #10b981;
    }

    .radio-option input[type="radio"]:checked + label {
        color: #065f46;
        font-weight: 600;
    }

    .radio-option label {
        margin: 0;
        cursor: pointer;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        padding: 14px 30px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #4b5563;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    /* Alert */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 1px solid #6ee7b7;
        color: #065f46;
    }

    .alert-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid #fca5a5;
        color: #991b1b;
    }

    .alert i {
        font-size: 20px;
    }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-box {
        background: white;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .stat-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
    }

    .stat-box .icon {
        font-size: 48px;
        margin-bottom: 12px;
        color: #10b981;
    }

    .stat-box .value {
        font-size: 36px;
        font-weight: 800;
        color: #065f46;
        margin-bottom: 8px;
    }

    .stat-box .label {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-form {
            padding: 25px 20px;
        }

        .recipient-options {
            flex-direction: column;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="notification-header">
    <h1>
        <i class="fas fa-paper-plane"></i>
        Kirim Notifikasi
    </h1>
    <p>Kirim pemberitahuan kepada semua petani terdaftar</p>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

@if($errors->any())
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin-top: 8px; margin-left: 20px;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<!-- Statistics -->
<div class="stats-row">
    <div class="stat-box">
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="value">{{ $totalUsers }}</div>
        <div class="label">Total Petani</div>
    </div>
    <div class="stat-box">
        <div class="icon">
            <i class="fas fa-bell"></i>
        </div>
        <div class="value">{{ $notificationsSent }}</div>
        <div class="label">Notifikasi Terkirim</div>
    </div>
</div>

<!-- Notification Form -->
<div class="notification-form">
    <form action="{{ route('admin.notifications.send') }}" method="POST">
        @csrf

        <!-- Title -->
        <div class="form-group">
            <label>
                <i class="fas fa-heading"></i>
                Judul Notifikasi
            </label>
            <input 
                type="text" 
                name="title" 
                class="form-control" 
                placeholder="Masukkan judul notifikasi..."
                value="{{ old('title') }}"
                required
            >
        </div>

        <!-- Message -->
        <div class="form-group">
            <label>
                <i class="fas fa-align-left"></i>
                Isi Pesan
            </label>
            <textarea 
                name="message" 
                class="form-control" 
                placeholder="Tulis pesan notifikasi untuk petani..."
                required
            >{{ old('message') }}</textarea>
        </div>

        <!-- Recipient Type -->
        <div class="form-group">
            <label>
                <i class="fas fa-user-friends"></i>
                Penerima
            </label>
            <div class="recipient-options">
                <div class="radio-option">
                    <input 
                        type="radio" 
                        name="recipient_type" 
                        value="all" 
                        id="recipientAll"
                        checked
                    >
                    <label for="recipientAll">Semua Petani</label>
                </div>
                <div class="radio-option">
                    <input 
                        type="radio" 
                        name="recipient_type" 
                        value="active" 
                        id="recipientActive"
                    >
                    <label for="recipientActive">Petani Aktif (Pernah Pesan)</label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i>
                Kirim Notifikasi
            </button>
            <button type="reset" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Character counter for textarea
    const textarea = document.querySelector('textarea[name="message"]');
    if (textarea) {
        textarea.addEventListener('input', function() {
            console.log('Message length:', this.value.length);
        });
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const title = document.querySelector('input[name="title"]').value.trim();
        const message = textarea.value.trim();

        if (!title || !message) {
            e.preventDefault();
            alert('Judul dan pesan harus diisi!');
            return false;
        }

        if (message.length < 10) {
            e.preventDefault();
            alert('Pesan minimal 10 karakter!');
            return false;
        }

        return confirm('Apakah Anda yakin ingin mengirim notifikasi ini?');
    });
</script>
@endpush
