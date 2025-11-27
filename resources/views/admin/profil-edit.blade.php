@extends('layouts.admin')

@section('title', 'Edit Profil Admin - Pupuk & Bibit Subsidi')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
        --gold: #fbbf24;
    }

    .edit-profile-page {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--green-dark);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .page-title i {
        color: var(--green);
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    /* Alert Messages */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 2px solid var(--green-light);
        color: var(--green-dark);
    }

    .alert-error {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 2px solid #f87171;
        color: #991b1b;
    }

    .alert i {
        font-size: 20px;
    }

    /* Form Card */
    .form-card {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(5, 150, 105, 0.1);
    }

    .form-section {
        margin-bottom: 35px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--mint);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-title i {
        color: var(--green);
    }

    /* Avatar Upload */
    .avatar-upload-section {
        text-align: center;
        padding: 30px;
        background: var(--mint);
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        color: white;
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
    }

    .avatar-upload-text {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 15px;
    }

    .btn-upload {
        background: white;
        color: var(--green-dark);
        padding: 10px 20px;
        border-radius: 8px;
        border: 2px solid var(--green);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-upload:hover {
        background: var(--green);
        color: white;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label i {
        color: var(--green);
        font-size: 16px;
    }

    .form-label .required {
        color: #ef4444;
    }

    .form-input {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 500;
        color: #1f2937;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--green);
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
    }

    .form-input:disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    textarea.form-input {
        resize: vertical;
        min-height: 100px;
    }

    .form-help {
        font-size: 12px;
        color: #6b7280;
        margin-top: 6px;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        font-weight: 600;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 2px solid var(--mint);
    }

    .btn {
        padding: 14px 28px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
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

    /* Security Section */
    .security-note {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 18px 20px;
        border-radius: 10px;
        border-left: 4px solid var(--gold);
        display: flex;
        align-items: start;
        gap: 12px;
        margin-bottom: 20px;
    }

    .security-note i {
        color: #92400e;
        font-size: 20px;
        margin-top: 2px;
    }

    .security-note-text {
        flex: 1;
    }

    .security-note-title {
        font-weight: 700;
        color: #92400e;
        margin-bottom: 4px;
    }

    .security-note-desc {
        font-size: 13px;
        color: #78350f;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }

        .page-title {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-profile-page">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-edit"></i>
            Edit Profil Administrator
        </h1>
        <p class="page-subtitle">Perbarui informasi profil dan pengaturan akun admin</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>Terdapat kesalahan pada form. Silakan periksa kembali.</span>
    </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Avatar Upload Section -->
            <div class="avatar-upload-section">
                <div class="avatar-preview" id="avatarPreview">
                    @if(session('admin_avatar'))
                        <img src="{{ asset(session('admin_avatar')) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                        <i class="fas fa-user-shield"></i>
                    @endif
                </div>
                <p class="avatar-upload-text">Foto Profil Administrator</p>
                <label for="avatar" class="btn-upload">
                    <i class="fas fa-camera"></i> Ubah Foto
                </label>
                <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
            </div>

            <!-- Personal Information -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-user"></i>
                    Informasi Pribadi
                </h3>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user-circle"></i>
                        Nama Lengkap
                        <span class="required">*</span>
                    </label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', session('admin_name', 'Administrator Sistem')) }}" required>
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-at"></i>
                        Username
                    </label>
                    <input type="text" name="username" class="form-input" value="{{ session('admin_username', 'admin') }}" disabled>
                    <p class="form-help">Username tidak dapat diubah untuk keamanan sistem</p>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email
                        <span class="required">*</span>
                    </label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', session('admin_email', 'admin@pupuksubsidi.id')) }}" required>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone"></i>
                        Nomor Telepon
                    </label>
                    <input type="tel" name="phone" class="form-input" value="{{ old('phone', session('admin_phone', '+62 812-3456-7890')) }}" placeholder="+62 xxx-xxxx-xxxx">
                    @error('phone')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat Lengkap
                    </label>
                    <textarea name="address" class="form-input" placeholder="Masukkan alamat lengkap">{{ old('address', session('admin_address', 'Jl. Sitoluama, Laguboti, Toba Samosir')) }}</textarea>
                    @error('address')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Security Settings -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fas fa-shield-alt"></i>
                    Pengaturan Keamanan
                </h3>

                <div class="security-note">
                    <i class="fas fa-info-circle"></i>
                    <div class="security-note-text">
                        <div class="security-note-title">Informasi Keamanan</div>
                        <div class="security-note-desc">Kosongkan field password jika tidak ingin mengubah password. Password minimal 8 karakter.</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Password Baru
                    </label>
                    <input type="password" name="password" class="form-input" placeholder="Masukkan password baru (opsional)">
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Konfirmasi Password
                    </label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.profil') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview avatar when file is selected
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
