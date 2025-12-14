@extends('layouts.admin')

@section('title', 'Kirim Notifikasi ke User')

@push('styles')
<style>
    .notif-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 20px 40px;
    }

    /* Enhanced Page Header */
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        border-radius: 20px;
        padding: 35px 40px;
        margin-bottom: 35px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06), 0 8px 24px rgba(16, 185, 129, 0.08);
        border: 2px solid rgba(16, 185, 129, 0.15);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, #10b981, #059669);
    }

    .page-header h1 {
        font-size: 30px;
        font-weight: 800;
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 14px;
        letter-spacing: -0.5px;
    }

    .page-header h1 i {
        font-size: 36px;
        background: linear-gradient(135deg, #10b981, #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .page-header p {
        color: #6b7280;
        font-size: 15px;
        line-height: 1.6;
        margin-left: 50px;
    }

    /* Enhanced Form Card */
    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06), 0 4px 20px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .form-group {
        margin-bottom: 28px;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 12px;
    }

    .form-label i {
        color: #10b981;
        font-size: 16px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 2px;
        font-size: 16px;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        font-family: inherit;
        background: #fafafa;
    }

    .form-control:hover {
        border-color: #d1d5db;
        background: #ffffff;
    }

    .form-control:focus {
        outline: none;
        border-color: #10b981;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-control.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .text-danger {
        color: #dc2626;
        font-weight: 600;
        font-size: 13px;
    }

    textarea.form-control {
        min-height: 180px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='14' height='9' viewBox='0 0 14 9' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L7 7.5L13 1.5' stroke='%2310b981' stroke-width='2.5' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 18px center;
        padding-right: 45px;
        cursor: pointer;
    }

    /* Enhanced Recipient Type Cards */
    .recipient-type {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 12px;
    }

    .recipient-option {
        position: relative;
    }

    .recipient-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .recipient-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 700;
        font-size: 15px;
        color: #6b7280;
        background: #fafafa;
        min-height: 120px;
    }

    .recipient-option label:hover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.03);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .recipient-option input[type="radio"]:checked + label {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(5, 150, 105, 0.05));
        color: #047857;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.15);
        transform: translateY(-2px);
    }

    .recipient-option label i {
        display: block;
        font-size: 36px;
        margin-bottom: 12px;
        transition: transform 0.3s ease;
    }

    .recipient-option input[type="radio"]:checked + label i {
        color: #10b981;
        transform: scale(1.1);
    }

    .user-select-group {
        display: none;
        margin-top: 20px;
        padding: 20px;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-radius: 14px;
        border: 2px solid #10b981;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .user-select-group.active {
        display: block;
    }

    .user-select-group .form-label {
        color: #047857;
    }

    /* Enhanced Alert Messages */
    .alert {
        padding: 18px 24px;
        border-radius: 14px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        border: 2px solid;
        animation: slideIn 0.4s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .alert i {
        font-size: 22px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-color: #10b981;
    }

    .alert-success i {
        color: #10b981;
    }

    .alert-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border-color: #ef4444;
    }

    .alert-error i {
        color: #ef4444;
    }

    /* Enhanced Action Buttons */
    .btn-group {
        display: flex;
        gap: 14px;
        margin-top: 35px;
        padding-top: 30px;
        border-top: 2px solid #f3f4f6;
    }

    .btn {
        padding: 14px 28px;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        flex: 1;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-primary:active {
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        color: #374151;
        font-weight: 600;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #e5e7eb, #d1d5db);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Enhanced Character Counter */
    .char-count {
        text-align: right;
        font-size: 13px;
        color: #9ca3af;
        margin-top: 8px;
        font-weight: 600;
    }

    .char-count span {
        color: #10b981;
    }

    /* Enhanced Priority/Type Badges */
    .priority-badges {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-top: 12px;
    }

    .priority-option {
        position: relative;
    }

    .priority-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .priority-option label {
        padding: 16px 12px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        text-align: center;
        background: #fafafa;
    }

    .priority-option label i {
        font-size: 24px;
    }

    .priority-option.low label {
        color: #3b82f6;
    }

    .priority-option.normal label {
        color: #10b981;
    }

    .priority-option.high label {
        color: #f59e0b;
    }

    .priority-option.urgent label {
        color: #ef4444;
    }

    .priority-option label:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .priority-option input[type="radio"]:checked + label.low {
        border-color: #3b82f6;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(59, 130, 246, 0.08));
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.2);
    }

    .priority-option input[type="radio"]:checked + label.normal {
        border-color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(16, 185, 129, 0.08));
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
    }

    .priority-option input[type="radio"]:checked + label.high {
        border-color: #f59e0b;
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.12), rgba(245, 158, 11, 0.08));
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.2);
    }

    .priority-option input[type="radio"]:checked + label.urgent {
        border-color: #ef4444;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.12), rgba(239, 68, 68, 0.08));
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .notif-container {
            padding: 0 15px 30px;
        }

        .page-header {
            padding: 25px 20px;
        }

        .page-header h1 {
            font-size: 24px;
        }

        .page-header p {
            margin-left: 0;
            font-size: 14px;
        }

        .form-card {
            padding: 25px 20px;
        }

        .recipient-type {
            grid-template-columns: 1fr;
        }

        .priority-badges {
            grid-template-columns: repeat(2, 1fr);
        }

        .btn-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="notif-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-paper-plane"></i> Kirim Notifikasi ke User</h1>
        <p>Kirim notifikasi, pengumuman, atau pesan penting ke pengguna aplikasi</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 5px 0 0 20px; padding: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.notifications.send') }}" method="POST">
            @csrf

            <!-- Recipient Type -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-users"></i>
                    Kirim Ke <span class="required">*</span>
                </label>
                <div class="recipient-type">
                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" id="all_users" value="all" {{ old('recipient_type', 'all') == 'all' ? 'checked' : '' }} onchange="toggleUserSelect()">
                        <label for="all_users">
                            <i class="fas fa-users"></i>
                            Semua User
                        </label>
                    </div>
                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" id="specific_user" value="specific" {{ old('recipient_type') == 'specific' ? 'checked' : '' }} onchange="toggleUserSelect()">
                        <label for="specific_user">
                            <i class="fas fa-user"></i>
                            Pilih User
                        </label>
                    </div>
                </div>

                <!-- Specific User Selection -->
                <div class="user-select-group" id="userSelectGroup">
                    <label class="form-label">
                        <i class="fas fa-user-check"></i>
                        Pilih User
                    </label>
                    <select name="user_id" class="form-control form-select @error('user_id') is-invalid @enderror">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->nama_lengkap ?? $user->name ?? 'User #'.$user->id }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                @error('recipient_type')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Subject -->
            <div class="form-group">
                <label class="form-label" for="title">
                    <i class="fas fa-heading"></i>
                    Judul Notifikasi <span class="required">*</span>
                </label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                       placeholder="Contoh: Pengumuman Penting - Perubahan Jadwal Distribusi" 
                       value="{{ old('title') }}" required maxlength="100">
                <div class="char-count">
                    <span id="subjectCount">0</span>/100 karakter
                </div>
                @error('title')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Message -->
            <div class="form-group">
                <label class="form-label" for="message">
                    <i class="fas fa-comment-alt"></i>
                    Isi Pesan <span class="required">*</span>
                </label>
                <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" 
                          placeholder="Tulis pesan atau pengumuman yang akan dikirim ke user..." 
                          required maxlength="1000">{{ old('message') }}</textarea>
                <div class="char-count">
                    <span id="messageCount">0</span>/1000 karakter
                </div>
                @error('message')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Priority -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-tag"></i>
                    Tipe Notifikasi <span class="required">*</span>
                </label>
                <div class="priority-badges">
                    <div class="priority-option low">
                        <input type="radio" name="type" id="type_info" value="info" {{ old('type', 'info') == 'info' ? 'checked' : '' }}>
                        <label for="type_info" class="low">
                            <i class="fas fa-info-circle"></i> Info
                        </label>
                    </div>
                    <div class="priority-option normal">
                        <input type="radio" name="type" id="type_success" value="success" {{ old('type') == 'success' ? 'checked' : '' }}>
                        <label for="type_success" class="normal">
                            <i class="fas fa-check-circle"></i> Sukses
                        </label>
                    </div>
                    <div class="priority-option high">
                        <input type="radio" name="type" id="type_warning" value="warning" {{ old('type') == 'warning' ? 'checked' : '' }}>
                        <label for="type_warning" class="high">
                            <i class="fas fa-exclamation-circle"></i> Peringatan
                        </label>
                    </div>
                    <div class="priority-option urgent">
                        <input type="radio" name="type" id="type_important" value="important" {{ old('type') == 'important' ? 'checked' : '' }}>
                        <label for="type_important" class="urgent">
                            <i class="fas fa-exclamation-triangle"></i> Penting
                        </label>
                    </div>
                </div>
                @error('type')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Notifikasi
                </button>
                <a href="{{ route('admin.notifications.inbox') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Character counter
    document.getElementById('title').addEventListener('input', function() {
        document.getElementById('subjectCount').textContent = this.value.length;
    });

    document.getElementById('message').addEventListener('input', function() {
        document.getElementById('messageCount').textContent = this.value.length;
    });

    // Toggle user select
    function toggleUserSelect() {
        const specificRadio = document.getElementById('specific_user');
        const userSelectGroup = document.getElementById('userSelectGroup');
        
        if (specificRadio.checked) {
            userSelectGroup.classList.add('active');
        } else {
            userSelectGroup.classList.remove('active');
        }
    }

    // Initialize counters on page load
    window.addEventListener('DOMContentLoaded', function() {
        const title = document.getElementById('title').value;
        const message = document.getElementById('message').value;
        document.getElementById('subjectCount').textContent = title.length;
        document.getElementById('messageCount').textContent = message.length;
        
        // Check if specific user was selected (for validation errors)
        const specificRadio = document.getElementById('specific_user');
        if (specificRadio && specificRadio.checked) {
            toggleUserSelect();
        }
    });
</script>
@endsection
