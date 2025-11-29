@extends('layouts.admin')

@section('title', 'Kirim Notifikasi')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
    }

    .notification-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Page Header */
    .notification-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .notification-header h1 {
        color: var(--green-dark);
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .notification-header h1 i {
        color: var(--green);
        font-size: 28px;
    }

    .notification-header p {
        color: #6b7280;
        font-size: 14px;
    }

    /* Notification Form */
    .notification-form {
        background: white;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-group label i {
        margin-right: 6px;
        color: var(--green);
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    .recipient-options {
        display: flex;
        gap: 16px;
        margin-top: 12px;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        flex: 1;
    }

    .radio-option:hover {
        border-color: var(--green);
        background: var(--mint);
    }

    .radio-option input[type="radio"]:checked ~ label {
        color: var(--green-dark);
        font-weight: 600;
    }

    .radio-option input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .radio-option label {
        margin: 0;
        cursor: pointer;
        font-size: 14px;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 2px solid #f3f4f6;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--green);
        color: white;
        flex: 1;
    }

    .btn-primary:hover {
        background: var(--green-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
    }

    .btn-secondary {
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    /* Alert */
    .alert {
        padding: 14px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 14px;
    }

    .alert-success {
        background: #d1fae5;
        border: 1px solid var(--green-light);
        color: var(--green-dark);
    }

    .alert-error {
        background: #fee2e2;
        border: 1px solid #f87171;
        color: #991b1b;
    }

    .alert i {
        font-size: 18px;
    }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-box {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        text-align: center;
    }

    .stat-box .icon {
        font-size: 32px;
        margin-bottom: 12px;
        color: var(--green);
    }

    .stat-box .value {
        font-size: 28px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 4px;
    }

    .stat-box .label {
        color: #6b7280;
        font-size: 13px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-page {
            padding: 16px;
        }

        .notification-form {
            padding: 24px;
        }

        .notification-header h1 {
            font-size: 24px;
        }

        .notification-header h1 i {
            font-size: 24px;
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

        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="notification-page">
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
