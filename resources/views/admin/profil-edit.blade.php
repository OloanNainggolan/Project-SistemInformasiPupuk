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
        padding: 20px;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--green-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .page-title i {
        font-size: 28px;
        color: var(--green);
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    /* Alert Messages */
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

    /* Form Card */
    .form-card {
        background: white;
        padding: 32px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .form-section {
        margin-bottom: 32px;
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
        font-size: 20px;
    }

    /* Avatar Upload */
    .avatar-upload-section {
        text-align: center;
        padding: 28px;
        background: var(--mint);
        border-radius: 12px;
        margin-bottom: 28px;
        border: 1px solid var(--green-light);
    }

    .avatar-preview {
        width: 100px;
        height: 100px;
        background: var(--green);
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: white;
        transition: all 0.3s ease;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        overflow: hidden;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-upload-text {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 16px;
    }

    .btn-upload {
        background: white;
        color: var(--green-dark);
        padding: 10px 20px;
        border-radius: 8px;
        border: 2px solid var(--green);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-upload:hover {
        background: var(--green);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
    }

    /* Form Group */
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
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-label i {
        color: var(--green);
        font-size: 14px;
    }

    .form-label .required {
        color: #ef4444;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        color: #1f2937;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
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
        margin-top: 4px;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
        font-weight: 600;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 2px solid #f3f4f6;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
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

    /* Security Section */
    .security-note {
        background: #fef3c7;
        padding: 16px 20px;
        border-radius: 8px;
        border-left: 3px solid var(--gold);
        display: flex;
        align-items: start;
        gap: 12px;
        margin-bottom: 20px;
    }

    .security-note i {
        color: #92400e;
        font-size: 18px;
        margin-top: 2px;
    }

    .security-note-text {
        flex: 1;
    }

    .security-note-title {
        font-weight: 600;
        color: #92400e;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .security-note-desc {
        font-size: 12px;
        color: #78350f;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .edit-profile-page {
            padding: 16px;
        }

        .form-card {
            padding: 24px;
        }

        .form-actions {
            flex-direction: column;
        }

        .page-title {
            font-size: 24px;
        }

        .page-title i {
            font-size: 24px;
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
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const uploadBtn = document.querySelector('.btn-upload');
    
    // Handle file selection
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validasi ukuran file (max 2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB
        if (file.size > maxSize) {
            showAlert('❌ Ukuran file terlalu besar. Maksimal 2MB.', 'error');
            avatarInput.value = '';
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showAlert('❌ File harus berupa gambar (JPEG, PNG, JPG, atau GIF).', 'error');
            avatarInput.value = '';
            return;
        }
        
        // Preview gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            // Tambah loading effect
            avatarPreview.style.opacity = '0.6';
            avatarPreview.style.transform = 'scale(0.95)';
            
            // Update preview dengan smooth animation
            setTimeout(() => {
                avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">`;
                avatarPreview.style.opacity = '1';
                avatarPreview.style.transform = 'scale(1)';
            }, 150);
        };
        
        // Tampilkan info file
        const fileSize = (file.size / 1024).toFixed(2);
        const existingInfo = avatarInput.parentElement.querySelector('.file-info');
        if (existingInfo) {
            existingInfo.remove();
        }
        
        const fileInfo = document.createElement('p');
        fileInfo.className = 'form-help file-info';
        fileInfo.innerHTML = `
            <i class="fas fa-check-circle" style="color: #10b981; margin-right: 4px;"></i>
            File dipilih: <strong>${file.name}</strong> (${fileSize} KB)
        `;
        avatarInput.parentElement.appendChild(fileInfo);
        
        // Add visual feedback to button
        uploadBtn.style.background = 'var(--green)';
        uploadBtn.style.color = 'white';
        uploadBtn.innerHTML = '<i class="fas fa-check"></i> Foto Dipilih';
        
        reader.readAsDataURL(file);
    });

    // Form submission handling
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('.btn-primary');
    const originalBtnText = submitBtn.innerHTML;
    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return;
        }
        
        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    });

    // Restore button state if page is cached
    window.addEventListener('pageshow', function() {
        if (!isSubmitting) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.innerHTML = originalBtnText;
        }
    });

    // Alert function
    function showAlert(message, type = 'info') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());
        
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        const pageTitle = document.querySelector('.page-title');
        pageTitle.parentElement.insertBefore(alert, pageTitle.parentElement.firstChild);
        
        // Auto remove after 5 seconds
        if (type === 'error') {
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    }

    // File input drag and drop
    const uploadSection = document.querySelector('.avatar-upload-section');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadSection.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadSection.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadSection.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        uploadSection.style.background = '#e0f2fe';
        uploadSection.style.borderColor = 'var(--green-light)';
    }

    function unhighlight(e) {
        uploadSection.style.background = 'var(--mint)';
        uploadSection.style.borderColor = 'var(--green-light)';
    }

    uploadSection.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            avatarInput.files = files;
            const event = new Event('change', { bubbles: true });
            avatarInput.dispatchEvent(event);
        }
    }
</script>
@endpush
