@extends('layouts.admin')

@section('title', 'Kirim Notifikasi ke User')

@push('styles')
<style>
    .notif-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .page-header {
        background: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h1 i {
        color: #00897b;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 3px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #00897b;
        box-shadow: 0 0 0 3px rgba(0, 137, 123, 0.1);
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%2364748b' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 40px;
    }

    .recipient-type {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 15px;
    }

    .recipient-option {
        position: relative;
    }

    .recipient-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .recipient-option label {
        display: block;
        padding: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 14px;
        color: #64748b;
    }

    .recipient-option input[type="radio"]:checked + label {
        border-color: #00897b;
        background: rgba(0, 137, 123, 0.05);
        color: #00897b;
    }

    .recipient-option label i {
        display: block;
        font-size: 24px;
        margin-bottom: 8px;
    }

    .user-select-group {
        display: none;
        margin-top: 15px;
    }

    .user-select-group.active {
        display: block;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
        color: white;
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 137, 123, 0.3);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
    }

    .char-count {
        text-align: right;
        font-size: 12px;
        color: #94a3b8;
        margin-top: 5px;
    }

    .priority-badges {
        display: flex;
        gap: 10px;
    }

    .priority-option {
        position: relative;
    }

    .priority-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .priority-option label {
        padding: 8px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
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

    .priority-option input[type="radio"]:checked + label.low {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.1);
    }

    .priority-option input[type="radio"]:checked + label.normal {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }

    .priority-option input[type="radio"]:checked + label.high {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
    }

    .priority-option input[type="radio"]:checked + label.urgent {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
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
                <label class="form-label">Kirim Ke <span class="required">*</span></label>
                <div class="recipient-type">
                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" id="all_users" value="all" checked onchange="toggleUserSelect()">
                        <label for="all_users">
                            <i class="fas fa-users"></i>
                            Semua User
                        </label>
                    </div>
                    <div class="recipient-option">
                        <input type="radio" name="recipient_type" id="specific_user" value="specific" onchange="toggleUserSelect()">
                        <label for="specific_user">
                            <i class="fas fa-user"></i>
                            Pilih User
                        </label>
                    </div>
                </div>

                <!-- Specific User Selection -->
                <div class="user-select-group" id="userSelectGroup">
                    <label class="form-label">Pilih User</label>
                    <select name="user_id" class="form-control form-select">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->nama_lengkap ?? $user->name ?? 'User #'.$user->id }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Subject -->
            <div class="form-group">
                <label class="form-label" for="subject">Judul Notifikasi <span class="required">*</span></label>
                <input type="text" name="subject" id="subject" class="form-control" 
                       placeholder="Contoh: Pengumuman Penting - Perubahan Jadwal Distribusi" 
                       value="{{ old('subject') }}" required maxlength="100">
                <div class="char-count">
                    <span id="subjectCount">0</span>/100 karakter
                </div>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label class="form-label" for="message">Isi Pesan <span class="required">*</span></label>
                <textarea name="message" id="message" class="form-control" 
                          placeholder="Tulis pesan atau pengumuman yang akan dikirim ke user..." 
                          required maxlength="1000">{{ old('message') }}</textarea>
                <div class="char-count">
                    <span id="messageCount">0</span>/1000 karakter
                </div>
            </div>

            <!-- Priority -->
            <div class="form-group">
                <label class="form-label">Prioritas</label>
                <div class="priority-badges">
                    <div class="priority-option low">
                        <input type="radio" name="priority" id="priority_low" value="low">
                        <label for="priority_low" class="low">
                            <i class="fas fa-info-circle"></i> Rendah
                        </label>
                    </div>
                    <div class="priority-option normal">
                        <input type="radio" name="priority" id="priority_normal" value="normal" checked>
                        <label for="priority_normal" class="normal">
                            <i class="fas fa-bell"></i> Normal
                        </label>
                    </div>
                    <div class="priority-option high">
                        <input type="radio" name="priority" id="priority_high" value="high">
                        <label for="priority_high" class="high">
                            <i class="fas fa-exclamation"></i> Tinggi
                        </label>
                    </div>
                    <div class="priority-option urgent">
                        <input type="radio" name="priority" id="priority_urgent" value="urgent">
                        <label for="priority_urgent" class="urgent">
                            <i class="fas fa-exclamation-triangle"></i> Urgent
                        </label>
                    </div>
                </div>
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
    document.getElementById('subject').addEventListener('input', function() {
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
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value;
        document.getElementById('subjectCount').textContent = subject.length;
        document.getElementById('messageCount').textContent = message.length;
    });
</script>
@endsection
