@extends('layouts.admin')

@section('title', 'Kirim Notifikasi')

@section('content')
<div class="notification-send-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-paper-plane"></i>
                Kirim Notifikasi
            </h1>
            <p class="page-subtitle">Kirim notifikasi ke user secara individual atau broadcast ke semua user</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <div class="notification-grid">
        <!-- Form Kirim ke User Spesifik -->
        <div class="notification-card">
            <div class="card-header">
                <div class="card-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h3 class="card-title">Kirim ke User Tertentu</h3>
                    <p class="card-description">Pilih user dan kirim notifikasi personal</p>
                </div>
            </div>

            <form action="{{ route('admin.notifications.send') }}" method="POST" class="notification-form">
                @csrf
                <div class="form-group">
                    <label for="user_id" class="form-label">
                        <i class="fas fa-users"></i>
                        Pilih User
                    </label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->nama_lengkap }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="title" class="form-label">
                        <i class="fas fa-heading"></i>
                        Judul Notifikasi
                    </label>
                    <input type="text" name="title" id="title" class="form-input" 
                           placeholder="Contoh: Pesanan Anda Siap Diambil" required maxlength="100">
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">
                        <i class="fas fa-comment-alt"></i>
                        Pesan
                    </label>
                    <textarea name="message" id="message" class="form-textarea" rows="5" 
                              placeholder="Tulis pesan notifikasi..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">
                        <i class="fas fa-tag"></i>
                        Tipe Notifikasi
                    </label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="info">Info (Biru)</option>
                        <option value="success">Sukses (Hijau)</option>
                        <option value="warning">Peringatan (Kuning)</option>
                        <option value="important">Penting (Merah)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Notifikasi
                </button>
            </form>
        </div>

        <!-- Form Broadcast ke Semua User -->
        <div class="notification-card">
            <div class="card-header">
                <div class="card-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div>
                    <h3 class="card-title">Broadcast ke Semua User</h3>
                    <p class="card-description">Kirim notifikasi ke semua user terdaftar</p>
                </div>
            </div>

            <form action="{{ route('admin.notifications.sendBroadcast') }}" method="POST" class="notification-form" 
                  onsubmit="return confirm('Yakin ingin mengirim notifikasi ke SEMUA user?');">
                @csrf
                <div class="broadcast-info">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Total User:</strong> {{ $totalUsers }} user
                        <p style="margin: 4px 0 0 0; font-size: 12px; color: #666;">
                            Notifikasi akan dikirim ke semua user yang terdaftar
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="broadcast_title" class="form-label">
                        <i class="fas fa-heading"></i>
                        Judul Broadcast
                    </label>
                    <input type="text" name="title" id="broadcast_title" class="form-input" 
                           placeholder="Contoh: Pengumuman Penting!" required maxlength="100">
                </div>

                <div class="form-group">
                    <label for="broadcast_message" class="form-label">
                        <i class="fas fa-comment-alt"></i>
                        Pesan Broadcast
                    </label>
                    <textarea name="message" id="broadcast_message" class="form-textarea" rows="5" 
                              placeholder="Tulis pesan broadcast..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="broadcast_type" class="form-label">
                        <i class="fas fa-tag"></i>
                        Tipe Notifikasi
                    </label>
                    <select name="type" id="broadcast_type" class="form-select" required>
                        <option value="info">Info (Biru)</option>
                        <option value="success">Sukses (Hijau)</option>
                        <option value="warning">Peringatan (Kuning)</option>
                        <option value="important">Penting (Merah)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-block">
                    <i class="fas fa-bullhorn"></i>
                    Kirim Broadcast
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.notification-send-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 8px 0;
}

.page-title i {
    color: #10b981;
}

.page-subtitle {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
}

.notification-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

.notification-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 24px;
    display: flex;
    align-items: start;
    gap: 16px;
    border-bottom: 1px solid #e5e7eb;
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
}

.card-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 4px 0;
}

.card-description {
    font-size: 13px;
    color: #666;
    margin: 0;
}

.notification-form {
    padding: 24px;
}

.broadcast-info {
    background: #e0f2fe;
    border: 1px solid #38bdf8;
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    align-items: start;
    gap: 12px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #075985;
}

.broadcast-info i {
    font-size: 18px;
    color: #0284c7;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-label i {
    color: #10b981;
    font-size: 14px;
}

.form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 12px 14px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    transition: all 0.3s;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.btn {
    padding: 14px 24px;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-block {
    width: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
}

@media (max-width: 1024px) {
    .notification-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
