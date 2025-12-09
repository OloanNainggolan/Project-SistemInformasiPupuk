@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
<div class="edit-profile-container">
    <!-- Simple Header -->
    <div class="edit-header">
        <div class="header-background"></div>
        <div class="header-content">
            <a href="{{ route('profil.user') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="header-title">
                <h1><i class="fas fa-user-edit"></i> Edit Profil</h1>
                <p>Perbarui informasi profil Anda</p>
            </div>
        </div>
    </div>

    <!-- Edit Form Content -->
    <div class="edit-content">
        <div class="form-container">
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" id="editProfileForm">
                @csrf
                @method('PUT')

                <!-- Photo Upload Section -->
                <div class="form-card">
                    <div class="card-header">
                        <h2><i class="fas fa-camera"></i> Foto Profil</h2>
                        <span class="card-subtitle">JPG, PNG atau GIF. Maksimal 2MB</span>
                    </div>
                    <div class="photo-upload-wrapper">
                        <div class="photo-preview" id="photoPreview">
                            @if(Auth::user()->foto && file_exists(public_path(Auth::user()->foto)))
                                <img src="{{ asset(Auth::user()->foto) }}" alt="Foto Profil">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <div class="upload-controls">
                            <label for="foto" class="btn-upload">
                                <i class="fas fa-upload"></i> Pilih Foto Baru
                            </label>
                            <input type="file" name="foto" id="foto" accept="image/*" hidden>
                            <p class="upload-hint">Klik untuk memilih foto dari perangkat Anda</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="form-card">
                    <div class="card-header">
                        <h2><i class="fas fa-user"></i> Informasi Pribadi</h2>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama_lengkap">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" 
                                       value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}" 
                                       placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <div class="input-wrapper">
                                <i class="fas fa-at"></i>
                                <input type="text" id="username" name="username" 
                                       value="{{ old('username', Auth::user()->username) }}" 
                                       placeholder="Masukkan username">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">
                            Alamat <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                            <textarea id="alamat" name="alamat" rows="3" 
                                      placeholder="Masukkan alamat lengkap" required>{{ old('alamat', Auth::user()->alamat) }}</textarea>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="alamat_balai_desa">Alamat Balai Desa</label>
                            <div class="input-wrapper">
                                <i class="fas fa-building"></i>
                                <input type="text" id="alamat_balai_desa" name="alamat_balai_desa" 
                                       value="{{ old('alamat_balai_desa', Auth::user()->alamat_balai_desa) }}" 
                                       placeholder="Alamat balai desa">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="kabupaten">Kabupaten/Kota</label>
                            <div class="input-wrapper">
                                <i class="fas fa-city"></i>
                                <input type="text" id="kabupaten" name="kabupaten" 
                                       value="{{ old('kabupaten', Auth::user()->kabupaten) }}" 
                                       placeholder="Nama kabupaten/kota">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kode_pos">Kode Pos</label>
                        <div class="input-wrapper">
                            <i class="fas fa-mail-bulk"></i>
                            <input type="text" id="kode_pos" name="kode_pos" 
                                   value="{{ old('kode_pos', Auth::user()->kode_pos) }}" 
                                   placeholder="Kode pos" maxlength="5">
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="form-card">
                    <div class="card-header">
                        <h2><i class="fas fa-address-book"></i> Informasi Kontak</h2>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email">
                                Email <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email', Auth::user()->email) }}" 
                                       placeholder="email@example.com" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="no_telp">
                                Nomor Telepon <span class="required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="no_telp" name="no_telp" 
                                       value="{{ old('no_telp', Auth::user()->no_telp) }}" 
                                       placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Change (Optional) -->
                <div class="form-card">
                    <div class="card-header">
                        <h2><i class="fas fa-lock"></i> Ubah Password</h2>
                        <span class="card-subtitle">Kosongkan jika tidak ingin mengubah password</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key"></i>
                            <input type="password" id="current_password" name="current_password" 
                                   placeholder="Masukkan password saat ini">
                            <span class="toggle-password" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" 
                                       placeholder="Password baru">
                                <span class="toggle-password" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       placeholder="Konfirmasi password baru">
                                <span class="toggle-password" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <a href="{{ route('profil.user') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.edit-profile-container {
    min-height: 100vh;
    background: #f5f7fa;
    padding-bottom: 50px;
}

/* Header */
.edit-header {
    position: relative;
    margin-bottom: 30px;
}

.header-background {
    height: 160px;
    background: linear-gradient(135deg, #1a5f3a 0%, #2d7a4f 50%, #00897b 100%);
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
    position: relative;
    top: -80px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: white;
    color: #1a5f3a;
    border-radius: 12px;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.btn-back:hover {
    background: #00897b;
    color: white;
    transform: translateX(-3px);
}

.header-title {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.header-title h1 {
    font-size: 1.8em;
    color: #1a5f3a;
    margin-bottom: 8px;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-title p {
    color: #666;
    font-size: 0.95em;
}

/* Edit Content */
.edit-content {
    max-width: 1200px;
    margin: -50px auto 0;
    padding: 0 40px;
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

/* Alerts */
.alert {
    padding: 15px 20px;
    border-radius: 12px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.alert i {
    font-size: 1.2em;
    margin-top: 2px;
}

.alert-success {
    background: #d1f2eb;
    color: #0c5140;
    border: 1px solid #0c5140;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
    flex: 1;
}

/* Form Cards */
.form-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.form-card:hover {
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.12);
}

.card-header {
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
}

.card-header h2 {
    font-size: 1.4em;
    color: #1a5f3a;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}

.card-header h2 i {
    color: #00897b;
}

.card-subtitle {
    color: #666;
    font-size: 0.9em;
}

/* Photo Upload */
.photo-upload-wrapper {
    display: flex;
    gap: 30px;
    align-items: center;
}

.photo-preview {
    width: 150px;
    height: 150px;
    border-radius: 16px;
    background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
    flex-shrink: 0;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-preview i {
    font-size: 60px;
    color: #00897b;
}

.upload-controls {
    flex: 1;
}

.btn-upload {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 25px;
    background: linear-gradient(135deg, #00897b, #00695c);
    color: white;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 137, 123, 0.3);
}

.btn-upload:hover {
    background: linear-gradient(135deg, #00695c, #004d40);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 137, 123, 0.4);
}

.upload-hint {
    color: #666;
    font-size: 0.9em;
    margin-top: 12px;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #333;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95em;
}

.required {
    color: #e74c3c;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper i {
    position: absolute;
    left: 15px;
    color: #00897b;
    font-size: 1.1em;
    z-index: 1;
}

.input-wrapper input,
.input-wrapper textarea {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 0.95em;
    transition: all 0.3s ease;
    font-family: inherit;
}

.input-wrapper textarea {
    padding-top: 12px;
    resize: vertical;
}

.input-wrapper input:focus,
.input-wrapper textarea:focus {
    outline: none;
    border-color: #00897b;
    box-shadow: 0 0 0 3px rgba(0, 137, 123, 0.1);
}

.toggle-password {
    position: absolute;
    right: 15px;
    color: #999;
    cursor: pointer;
    transition: color 0.3s ease;
    z-index: 1;
}

.toggle-password:hover {
    color: #00897b;
}

/* Action Buttons */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    padding-top: 10px;
}

.btn-cancel,
.btn-save {
    padding: 14px 30px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1em;
}

.btn-cancel {
    background: #f0f0f0;
    color: #666;
}

.btn-cancel:hover {
    background: #e0e0e0;
    color: #333;
}

.btn-save {
    background: linear-gradient(135deg, #00897b, #00695c);
    color: white;
    box-shadow: 0 4px 15px rgba(0, 137, 123, 0.3);
}

.btn-save:hover {
    background: linear-gradient(135deg, #00695c, #004d40);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 137, 123, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content,
    .edit-content {
        padding: 0 20px;
    }

    .header-background {
        height: 140px;
    }

    .header-content {
        top: -70px;
    }

    .header-title {
        padding: 25px 20px;
    }

    .header-title h1 {
        font-size: 1.5em;
    }

    .form-card {
        padding: 25px 20px;
    }

    .photo-upload-wrapper {
        flex-direction: column;
        text-align: center;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn-cancel,
    .btn-save {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
// Photo preview
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    }
});

// Toggle password visibility
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection
