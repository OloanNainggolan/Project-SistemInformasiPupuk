@extends('layouts.user')

@section('title', 'Edit Profil - Pupuk & Bibit Subsidi')

@push('styles')
<style>
    :root {
        --primary-green: #10b981;
        --primary-green-dark: #059669;
        --primary-green-darker: #047857;
        --mint-light: #ecfdf5;
        --mint: #d1fae5;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-500: #6b7280;
        --gray-700: #374151;
        --gray-900: #111827;
        --red: #ef4444;
        --red-light: #fee2e2;
        --blue: #3b82f6;
        --yellow: #fbbf24;
    }

    body {
        background: linear-gradient(135deg, #f0f9ff 0%, #ecfdf5 100%);
        min-height: 100vh;
    }

    .edit-profile-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header Section */
    .page-header {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border-left: 4px solid var(--primary-green);
    }

    .back-button {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-dark));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .back-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .header-content h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 0.5rem 0;
    }

    .header-content p {
        color: var(--gray-500);
        margin: 0;
        font-size: 0.95rem;
    }

    /* Form Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 2rem;
        align-items: start;
    }

    /* Profile Photo Card */
    .photo-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 2rem;
        text-align: center;
        border: 2px solid var(--mint);
    }

    .photo-preview-wrapper {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto 1.5rem;
    }

    .photo-preview {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-green);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
    }

    .photo-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
        font-weight: 700;
        border: 4px solid var(--primary-green);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
    }

    .user-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .user-email {
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .upload-btn,
    .remove-btn {
        width: 100%;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .upload-btn {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-dark));
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .upload-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .remove-btn {
        background: var(--red-light);
        color: var(--red);
        border: 2px solid var(--red);
    }

    .remove-btn:hover {
        background: var(--red);
        color: white;
    }

    .file-info {
        font-size: 0.8rem;
        color: var(--gray-500);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    /* Form Cards */
    .form-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--gray-200);
    }

    .form-card h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-card h3 svg {
        color: var(--primary-green);
    }

    .form-card p {
        color: var(--gray-600);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .form-label svg {
        width: 16px;
        height: 16px;
        color: var(--primary-green);
        flex-shrink: 0;
    }

    .form-label .required {
        color: var(--red);
        margin-left: 0.125rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .form-input::placeholder {
        color: var(--gray-400);
    }

    .help-text {
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-top: 0.375rem;
    }

    .error-text {
        font-size: 0.8rem;
        color: var(--red);
        margin-top: 0.375rem;
    }

    /* Input with Icon */
    .input-with-icon {
        position: relative;
    }

    .input-with-icon svg {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .input-with-icon svg:hover {
        color: var(--gray-600);
    }

    .input-with-icon input {
        padding-right: 3rem;
    }

    /* Password Strength */
    .password-strength {
        margin-top: 0.5rem;
    }

    .strength-bar {
        height: 6px;
        background: var(--gray-200);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 0.375rem;
    }

    .strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .strength-text {
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Grid Layout for Inputs */
    .input-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.875rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-cancel {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .btn-cancel:hover {
        background: var(--gray-200);
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary-green), var(--primary-green-dark));
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Alert Messages */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideDown 0.3s ease;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid var(--primary-green);
    }

    .alert-error {
        background: var(--red-light);
        color: #991b1b;
        border-left: 4px solid var(--red);
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

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .photo-card {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .edit-profile-wrapper {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-content h1 {
            font-size: 1.5rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .input-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .photo-preview-wrapper {
            width: 150px;
            height: 150px;
        }

        .photo-placeholder {
            font-size: 3rem;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-profile-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <a href="{{ route('profil.user') }}" class="back-button">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="header-content">
            <h1>Edit Profil</h1>
            <p>Perbarui informasi profil dan pengaturan akun Anda</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success" id="successAlert">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error" id="errorAlert">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <form id="editProfilForm" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="remove_foto" id="remove_foto" value="0">

        <div class="form-grid">
            <!-- Photo Section -->
            <div class="photo-card">
                <div class="photo-preview-wrapper">
                    @if($user->foto)
                    <img src="{{ asset($user->foto) }}" alt="Foto Profil" id="photoPreview" class="photo-preview">
                    @else
                    <div class="photo-placeholder" id="photoPlaceholder">
                        {{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 2)) }}
                    </div>
                    @endif
                </div>

                <div class="user-name">{{ $user->nama_lengkap }}</div>
                <div class="user-email">{{ $user->email }}</div>
            </div>

            <!-- Form Sections -->
            <div class="form-section">
                <!-- Informasi Pribadi -->
                <div class="form-card">
                    <h3>
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Informasi Pribadi
                    </h3>

                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama_lengkap" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            Nama Lengkap
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="nama_lengkap" 
                               name="nama_lengkap" 
                               value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                               class="form-input"
                               required>
                        @error('nama_lengkap')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                            </svg>
                            Username
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="{{ old('username', $user->username) }}"
                               class="form-input"
                               placeholder="Username untuk login">
                        <p class="help-text">Opsional - Untuk login selain email</p>
                        @error('username')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            Email
                            <span class="required">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}"
                               class="form-input"
                               required>
                        @error('email')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="form-group">
                        <label for="no_telp" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            Nomor Telepon
                            <span class="required">*</span>
                        </label>
                        <input type="tel" 
                               id="no_telp" 
                               name="no_telp" 
                               value="{{ old('no_telp', $user->no_telp) }}"
                               class="form-input"
                               required>
                        @error('no_telp')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Alamat -->
                <div class="form-card">
                    <h3>
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Informasi Alamat
                    </h3>

                    <!-- Alamat Lengkap -->
                    <div class="form-group">
                        <label for="alamat" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Alamat Lengkap
                            <span class="required">*</span>
                        </label>
                        <textarea id="alamat" 
                                  name="alamat" 
                                  rows="3"
                                  class="form-input"
                                  style="resize: vertical; min-height: 80px;"
                                  required>{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="input-grid">
                        <!-- Alamat Balai Desa -->
                        <div class="form-group">
                            <label for="alamat_balai_desa" class="form-label">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                </svg>
                                Alamat Balai Desa
                            </label>
                            <input type="text" 
                                   id="alamat_balai_desa" 
                                   name="alamat_balai_desa" 
                                   value="{{ old('alamat_balai_desa', $user->alamat_balai_desa) }}"
                                   class="form-input"
                                   placeholder="Untuk pengambilan pupuk/bibit subsidi">
                            @error('alamat_balai_desa')
                            <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kabupaten -->
                        <div class="form-group">
                            <label for="kabupaten" class="form-label">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
                                </svg>
                                Kabupaten
                            </label>
                            <input type="text" 
                                   id="kabupaten" 
                                   name="kabupaten" 
                                   value="{{ old('kabupaten', $user->kabupaten) }}"
                                   class="form-input"
                                   placeholder="Nama Kabupaten">
                            @error('kabupaten')
                            <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kode Pos -->
                    <div class="form-group">
                        <label for="kode_pos" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            Kode Pos
                        </label>
                        <input type="text" 
                               id="kode_pos" 
                               name="kode_pos" 
                               value="{{ old('kode_pos', $user->kode_pos) }}"
                               maxlength="5"
                               class="form-input"
                               placeholder="12345">
                        @error('kode_pos')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Lahan -->
                <div class="form-card">
                    <h3>
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                        </svg>
                        Informasi Lahan Pertanian
                    </h3>
                    <p>Data lahan akan ditampilkan di profil Anda dan membantu perhitungan kebutuhan pupuk/bibit</p>

                    <div class="input-grid">
                        <!-- Luas Lahan -->
                        <div class="form-group">
                            <label for="luas_lahan" class="form-label">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Luas Lahan (Hektar)
                            </label>
                            <input type="number" 
                                   id="luas_lahan" 
                                   name="luas_lahan" 
                                   value="{{ old('luas_lahan', $user->luas_lahan) }}"
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="Contoh: 2.5">
                            <p class="help-text">Masukkan luas lahan dalam hektar (contoh: 2.5 ha)</p>
                            @error('luas_lahan')
                            <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Tanaman -->
                        <div class="form-group">
                            <label for="jenis_tanaman" class="form-label">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd"/>
                                </svg>
                                Jenis Tanaman
                            </label>
                            <input type="text" 
                                   id="jenis_tanaman" 
                                   name="jenis_tanaman" 
                                   value="{{ old('jenis_tanaman', $user->jenis_tanaman) }}"
                                   class="form-input"
                                   placeholder="Contoh: Padi, Jagung, Cabai">
                            <p class="help-text">Tanaman utama yang Anda budidayakan</p>
                            @error('jenis_tanaman')
                            <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Lokasi Lahan -->
                    <div class="form-group">
                        <label for="lokasi_lahan" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Lokasi Lahan
                        </label>
                        <input type="text" 
                               id="lokasi_lahan" 
                               name="lokasi_lahan" 
                               value="{{ old('lokasi_lahan', $user->lokasi_lahan) }}"
                               class="form-input"
                               placeholder="Contoh: Desa Sukamaju, Kec. Sukaraja">
                        <p class="help-text">Alamat atau lokasi lahan pertanian Anda</p>
                        @error('lokasi_lahan')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keamanan Akun -->
                <div class="form-card">
                    <h3>
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        Keamanan Akun
                    </h3>
                    <p>Ubah password jika diperlukan (kosongkan jika tidak ingin mengubah)</p>

                    <!-- Password Saat Ini -->
                    <div class="form-group">
                        <label for="current_password" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"/>
                            </svg>
                            Password Saat Ini
                        </label>
                        <div class="input-with-icon">
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password"
                                   class="form-input"
                                   placeholder="Wajib diisi jika ingin mengubah password">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" onclick="togglePassword('current_password')">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <p class="help-text">Wajib diisi jika ingin mengubah password</p>
                        @error('current_password')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Password Baru
                        </label>
                        <div class="input-with-icon">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="form-input"
                                   placeholder="minimal 3 karakter"
                                   oninput="checkPasswordStrength(this.value)">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" onclick="togglePassword('password')">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div id="strengthFill" class="strength-fill" style="width: 0%"></div>
                            </div>
                            <p id="strengthText" class="strength-text"></p>
                        </div>
                        @error('password')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Konfirmasi Password
                        </label>
                        <div class="input-with-icon">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   class="form-input"
                                   placeholder="Ulangi password baru">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" onclick="togglePassword('password_confirmation')">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        @error('password_confirmation')
                        <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <a href="{{ route('profil.user') }}" class="btn btn-cancel">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" id="submitBtn" class="btn btn-submit">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Auto-dismiss alerts
    setTimeout(() => {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        
        if (successAlert) {
            successAlert.style.animation = 'slideDown 0.3s ease reverse';
            setTimeout(() => successAlert.remove(), 300);
        }
        
        if (errorAlert) {
            errorAlert.style.animation = 'slideDown 0.3s ease reverse';
            setTimeout(() => errorAlert.remove(), 300);
        }
    }, 5000);

    // Preview photo
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            // Validate file size
            if (input.files[0].size > 2048000) { // 2MB
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                input.value = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(input.files[0].type)) {
                alert('Tipe file tidak valid! Hanya JPG, PNG, dan GIF');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photoPreview');
                const placeholder = document.getElementById('photoPlaceholder');
                
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    placeholder.outerHTML = `<img src="${e.target.result}" alt="Foto Profil" id="photoPreview" class="photo-preview">`;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove photo
    function removeFoto() {
        if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            document.getElementById('remove_foto').value = '1';
            
            const preview = document.getElementById('photoPreview');
            const userName = '{{ $user->nama_lengkap }}';
            const initials = userName.substring(0, 2).toUpperCase();
            
            preview.outerHTML = `<div class="photo-placeholder" id="photoPlaceholder">${initials}</div>`;
            
            // Hide remove button
            event.target.style.display = 'none';
        }
    }

    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling.nextElementSibling;
        
        if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = `
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                </svg>
            `;
        } else {
            input.type = 'password';
            button.innerHTML = `
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            `;
        }
    }

    // Check password strength
    function checkPasswordStrength(password) {
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        
        if (!password) {
            strengthFill.style.width = '0%';
            strengthText.textContent = '';
            return;
        }

        let strength = 0;
        
        // Length check
        if (password.length >= 3) strength += 25;
        if (password.length >= 6) strength += 25;
        
        // Contains number
        if (/\d/.test(password)) strength += 25;
        
        // Contains special character
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 25;

        strengthFill.style.width = strength + '%';
        
        if (strength <= 25) {
            strengthFill.style.background = '#ef4444'; // Red
            strengthText.textContent = 'Lemah';
            strengthText.style.color = '#ef4444';
        } else if (strength <= 50) {
            strengthFill.style.background = '#fbbf24'; // Yellow
            strengthText.textContent = 'Cukup';
            strengthText.style.color = '#fbbf24';
        } else if (strength <= 75) {
            strengthFill.style.background = '#3b82f6'; // Blue
            strengthText.textContent = 'Baik';
            strengthText.style.color = '#3b82f6';
        } else {
            strengthFill.style.background = '#10b981'; // Green
            strengthText.textContent = 'Kuat';
            strengthText.style.color = '#10b981';
        }
    }

    // Form validation
    document.getElementById('editProfilForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        const currentPassword = document.getElementById('current_password').value;

        // If password fields are filled
        if (password || passwordConfirm) {
            // Check if current password is provided
            if (!currentPassword) {
                e.preventDefault();
                alert('Password saat ini wajib diisi jika ingin mengubah password!');
                return false;
            }

            // Check password length
            if (password.length < 3) {
                e.preventDefault();
                alert('Password baru minimal 3 karakter!');
                return false;
            }

            // Check password confirmation
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Konfirmasi password tidak cocok!');
                return false;
            }
        }

        // Show loading state with progress indicator
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        
        // Add loading message
        const loadingMessages = [
            'Memvalidasi data...',
            'Menyimpan perubahan...',
            'Memproses foto...',
            'Hampir selesai...'
        ];
        
        let messageIndex = 0;
        submitBtn.innerHTML = `
            <svg class="animate-spin" width="20" height="20" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span id="loadingText">${loadingMessages[0]}</span>
        `;
        
        // Rotate loading messages every 1 second
        const messageInterval = setInterval(() => {
            messageIndex = (messageIndex + 1) % loadingMessages.length;
            const loadingText = document.getElementById('loadingText');
            if (loadingText) {
                loadingText.textContent = loadingMessages[messageIndex];
            }
        }, 1000);
        
        // Store interval ID to clear it if needed
        submitBtn.dataset.intervalId = messageInterval;
    });

    // Phone number validation (numbers only)
    document.getElementById('no_telp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9+]/g, '');
    });

    // Postal code validation (numbers only, max 5)
    document.getElementById('kode_pos').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 5);
    });
</script>
@endpush
@endsection