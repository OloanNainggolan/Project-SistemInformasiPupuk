@extends('layouts.user')

@section('title', 'Edit Profil')

@push('styles')
<style>
    :root {
        --primary-green: #4CAF50;
        --dark-green: #065f46;
        --medium-green: #1a4d1a;
        --light-green: #81c784;
        --text-color: #333;
        --white: #ffffff;
        --light-gray-bg: #f7f7f7;
        --border-color: #ddd;
    }

    .container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 2rem;
        padding-top: 0; /* Jarak dari header yang sudah diatur content-wrapper */
    }

    .edit-profile-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-green), #2e7d32);
        color: white;
        padding: 1.5rem;
        text-align: left;
    }

    .card-header h2 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .card-body {
        padding: 2rem;
    }

    .section-title {
        background: var(--primary-green);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .profile-photo-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid var(--light-gray-bg);
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid var(--primary-green);
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-upload-info {
        flex: 1;
    }

    .photo-upload-info p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .upload-btn {
        background: var(--primary-green);
        color: white;
        padding: 0.7rem 1.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .upload-btn:hover {
        background: #45a049;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    .upload-btn input[type="file"] {
        display: none;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-color);
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select {
        padding: 0.9rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .form-group input[readonly] {
        background: #f5f5f5;
        color: #666;
        cursor: not-allowed;
    }

    .password-input-wrapper {
        position: relative;
    }

    .password-input-wrapper input {
        padding-right: 3rem;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #666;
        font-size: 1.2rem;
        padding: 0.5rem;
    }

    .toggle-password:hover {
        color: var(--primary-green);
    }

    .password-hint {
        font-size: 0.85rem;
        color: #666;
        margin-top: 0.3rem;
        font-style: italic;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-start;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--light-gray-bg);
    }

    .btn {
        padding: 0.9rem 2.5rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-save {
        background: var(--primary-green);
        color: white;
    }

    .btn-save:hover {
        background: #45a049;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
    }

    .btn-cancel {
        background: #f44336;
        color: white;
    }

    .btn-cancel:hover {
        background: #da190b;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(244, 67, 54, 0.4);
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

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .profile-photo-section {
            flex-direction: column;
            text-align: center;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .container {
            padding: 0 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="edit-profile-card">
        <div class="card-header">
            <h2>Edit Profil</h2>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- EDIT AKUN Section -->
                <div class="section-title">EDIT AKUN</div>

                <!-- Profile Photo -->
                <div class="profile-photo-section">
                    <div class="profile-avatar">
                        <img id="profilePreview" src="{{ auth()->user()->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_lengkap ?? 'User') . '&background=4caf50&color=fff&size=200' }}" alt="Profile">
                    </div>
                    <div class="photo-upload-info">
                        <p>Unggah foto profil baru (Maksimal 2MB, format: JPG, PNG, GIF)</p>
                        <label class="upload-btn">
                            <i class="fas fa-camera"></i>
                            Pilih Foto
                            <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event)">
                        </label>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', auth()->user()->username ?? '') }}" placeholder="Contoh: Budi123">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap ?? '') }}" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat', auth()->user()->alamat ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="no_telp">Phone Number</label>
                        <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', auth()->user()->no_telp ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <input type="text" id="kabupaten" name="kabupaten" value="{{ old('kabupaten', auth()->user()->kabupaten ?? '') }}" placeholder="Contoh: Subang">
                    </div>

                    <div class="form-group">
                        <label for="kode_pos">Kode Pos</label>
                        <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', auth()->user()->kode_pos ?? '') }}" placeholder="Contoh: 41237">
                    </div>
                </div>

                <!-- UBAH SANDI Section -->
                <div class="section-title">UBAH SANDI</div>

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="sandi_saat_ini">Sandi saat ini</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="sandi_saat_ini" name="current_password" placeholder="8+ characters">
                            <button type="button" class="toggle-password" onclick="togglePassword('sandi_saat_ini')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        <p class="password-hint">Kosongkan jika tidak ingin mengubah password</p>
                    </div>

                    <div class="form-group">
                        <label for="sandi_baru">Sandi Baru</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="sandi_baru" name="password" placeholder="8+ characters">
                            <button type="button" class="toggle-password" onclick="togglePassword('sandi_baru')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="konfirmasi_sandi">Konfirmasi Sandi</label>
                        <div class="password-input-wrapper">
                            <input type="password" id="konfirmasi_sandi" name="password_confirmation" placeholder="8+ characters">
                            <button type="button" class="toggle-password" onclick="togglePassword('konfirmasi_sandi')">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                    <button type="button" class="btn btn-cancel" onclick="logoutUser()">
                        <i class="fas fa-sign-out-alt"></i>
                        Keluar
                    </button>
                </div>
            </form>
            
            <!-- Form Logout tersembunyi -->
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Logout function
    function logoutUser() {
        if (confirm('Apakah Anda yakin ingin keluar dari akun?')) {
            document.getElementById('logoutForm').submit();
        }
    }

    // Preview uploaded image
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profilePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            button.classList.remove('fa-eye');
            button.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            button.classList.remove('fa-eye-slash');
            button.classList.add('fa-eye');
        }
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const currentPassword = document.getElementById('sandi_saat_ini').value;
        const newPassword = document.getElementById('sandi_baru').value;
        const confirmPassword = document.getElementById('konfirmasi_sandi').value;

        // If changing password
        if (newPassword || confirmPassword) {
            if (!currentPassword) {
                e.preventDefault();
                alert('Masukkan sandi saat ini untuk mengubah password');
                return false;
            }

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Konfirmasi sandi tidak cocok dengan sandi baru');
                return false;
            }

            if (newPassword.length < 3) {
                e.preventDefault();
                alert('Sandi baru minimal 3 karakter');
                return false;
            }
        }
    });
</script>
@endpush
