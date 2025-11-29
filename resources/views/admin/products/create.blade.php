@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - Admin Panel')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        font-size: 32px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-top: 5px;
    }

    /* Form Container */
    .form-container {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(5, 150, 105, 0.1);
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

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border: 2px solid #f87171;
        color: #991b1b;
    }

    .alert i {
        font-size: 20px;
    }

    .alert ul {
        margin: 5px 0 0 20px;
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #fbbf24;
        padding: 18px 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        display: flex;
        align-items: start;
        gap: 12px;
    }

    .info-box i {
        color: #92400e;
        font-size: 20px;
        margin-top: 2px;
    }

    .info-box-content {
        flex: 1;
    }

    .info-box strong {
        color: #92400e;
        display: block;
        margin-bottom: 4px;
    }

    .info-box p {
        color: #78350f;
        font-size: 14px;
        margin: 0;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-grid.full {
        grid-template-columns: 1fr;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 20px;
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

    .form-input:disabled,
    .form-input[readonly] {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    .form-input.is-invalid {
        border-color: #ef4444;
    }

    textarea.form-input {
        resize: vertical;
        min-height: 120px;
    }

    select.form-input {
        cursor: pointer;
    }

    .form-help {
        font-size: 12px;
        color: #6b7280;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-help i {
        font-size: 14px;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        font-weight: 600;
        display: block;
    }

    /* File Upload */
    .file-upload-area {
        border: 2px dashed var(--green);
        background: var(--mint);
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-area:hover {
        background: #d1fae5;
        border-color: var(--green-dark);
    }

    .file-upload-area input[type="file"] {
        display: none;
    }

    .file-upload-label {
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .file-upload-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .file-upload-text {
        font-weight: 600;
        color: var(--green-dark);
        font-size: 15px;
    }

    .file-upload-hint {
        font-size: 12px;
        color: #6b7280;
    }

    /* Image Previews */
    .image-previews {
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }

    .preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background: #f9fafb;
    }

    .preview-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .preview-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .preview-info {
        padding: 10px;
        background: white;
        border-top: 1px solid #e5e7eb;
    }

    .preview-name {
        font-size: 12px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .preview-size {
        font-size: 11px;
        color: #9ca3af;
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

    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .page-title {
            font-size: 22px;
        }

        .form-container {
            padding: 25px 20px;
        }
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-plus-circle"></i>
        Tambah Produk Baru
    </h1>
    <p class="page-subtitle">Lengkapi formulir di bawah ini untuk menambahkan produk pupuk atau bibit subsidi</p>
</div>

<!-- Form Container -->
<div class="form-container">
    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terdapat kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Info Box -->
    <div class="info-box">
        <i class="fas fa-info-circle"></i>
        <div class="info-box-content">
            <strong>Catatan Penting:</strong>
            <p>Jika tipe produk adalah <strong>Bibit</strong>, maka kategori akan otomatis terisi <strong>"Organik"</strong>. Untuk <strong>Pupuk</strong>, kategori dapat diisi manual.</p>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
        @csrf

        <!-- Nama Produk & Tipe -->
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-box"></i>
                    Nama Produk
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-input @error('nama_produk') is-invalid @enderror" 
                    name="nama_produk" 
                    value="{{ old('nama_produk') }}" 
                    placeholder="Contoh: Pupuk Urea Premium"
                    required
                >
                @error('nama_produk')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-tag"></i>
                    Tipe Produk
                    <span class="required">*</span>
                </label>
                <select 
                    class="form-input @error('tipe_produk') is-invalid @enderror" 
                    name="tipe_produk" 
                    id="tipe_produk"
                    required
                >
                    <option value="">-- Pilih Tipe --</option>
                    <option value="pupuk" {{ old('tipe_produk') == 'pupuk' ? 'selected' : '' }}>Pupuk</option>
                    <option value="bibit" {{ old('tipe_produk') == 'bibit' ? 'selected' : '' }}>Bibit</option>
                </select>
                @error('tipe_produk')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Kategori -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-list"></i>
                Kategori
                <span class="required">*</span>
            </label>
            <input 
                type="text" 
                class="form-input @error('kategori') is-invalid @enderror" 
                name="kategori" 
                id="kategori"
                value="{{ old('kategori') }}" 
                placeholder="Kategori produk"
                required
            >
            <small class="form-help" id="kategoriHelp">
                <i class="fas fa-info-circle"></i>
                Akan otomatis terisi "Organik" jika tipe adalah Bibit
            </small>
            @error('kategori')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Harga Subsidi & Harga Normal -->
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-money-bill-wave"></i>
                    Harga Subsidi (Rp)
                    <span class="required">*</span>
                </label>
                <input 
                    type="number" 
                    step="0.01" 
                    class="form-input @error('harga_subsidi') is-invalid @enderror" 
                    name="harga_subsidi" 
                    id="harga_subsidi"
                    value="{{ old('harga_subsidi') }}" 
                    placeholder="0"
                    required
                >
                @error('harga_subsidi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-tag"></i>
                    Harga Normal (Rp)
                    <span class="required">*</span>
                </label>
                <input 
                    type="number" 
                    step="0.01" 
                    class="form-input @error('harga_normal') is-invalid @enderror" 
                    name="harga_normal" 
                    id="harga_normal"
                    value="{{ old('harga_normal') }}" 
                    placeholder="0"
                    required
                >
                @error('harga_normal')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Stok -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-warehouse"></i>
                Stok (kg)
                <span class="required">*</span>
            </label>
            <input 
                type="number" 
                class="form-input @error('stok_produk') is-invalid @enderror" 
                name="stok_produk" 
                value="{{ old('stok_produk') }}" 
                placeholder="0"
                required
            >
            @error('stok_produk')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Upload Gambar (Multiple) -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-images"></i>
                Gambar Produk (Multiple)
                <span class="required">*</span>
            </label>
            <div class="file-upload-area">
                <input 
                    type="file" 
                    id="gambar" 
                    name="gambar[]" 
                    accept="image/*"
                    multiple
                    required
                >
                <label for="gambar" class="file-upload-label">
                    <div class="file-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="file-upload-text">Klik untuk upload gambar</div>
                    <div class="file-upload-hint">JPG, PNG, GIF | Max 2MB/gambar | Min 1, Max 5 gambar</div>
                </label>
            </div>
            
            <div id="fileInfo" style="margin-top: 10px; font-size: 13px; color: #6b7280;"></div>
            
            <!-- Image Previews Container -->
            <div class="image-previews" id="imagePreviews"></div>
            
            @error('gambar')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            @error('gambar.*')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Manfaat -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-leaf"></i>
                Manfaat
                <span class="required">*</span>
            </label>
            <textarea 
                class="form-input @error('manfaat') is-invalid @enderror" 
                name="manfaat" 
                rows="5"
                placeholder="Contoh: Meningkatkan produktivitas tanaman hingga 30%, Mempercepat pertumbuhan akar..."
                required
            >{{ old('manfaat') }}</textarea>
            @error('manfaat')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-help">
                <i class="fas fa-info-circle"></i>
                Jelaskan manfaat atau kegunaan produk untuk tanaman
            </small>
        </div>

        <!-- Bahan/Komposisi -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-flask"></i>
                Bahan/Komposisi
                <span class="required">*</span>
            </label>
            <textarea 
                class="form-input @error('bahan') is-invalid @enderror" 
                name="bahan" 
                rows="5"
                placeholder="Contoh: Nitrogen (N) 15%, Fosfor (P) 10%, Kalium (K) 15%..."
                required
            >{{ old('bahan') }}</textarea>
            @error('bahan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-help">
                <i class="fas fa-info-circle"></i>
                Sebutkan kandungan atau komposisi bahan produk
            </small>
        </div>

        <!-- Cara Penggunaan -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-tasks"></i>
                Cara Penggunaan
                <span class="required">*</span>
            </label>
            <textarea 
                class="form-input @error('cara_penggunaan') is-invalid @enderror" 
                name="cara_penggunaan" 
                rows="6"
                placeholder="Contoh: 1. Larutkan 100 gram pupuk dalam 10 liter air, 2. Aduk hingga merata..."
                required
            >{{ old('cara_penggunaan') }}</textarea>
            @error('cara_penggunaan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="form-help">
                <i class="fas fa-info-circle"></i>
                Berikan petunjuk langkah demi langkah cara menggunakan produk
            </small>
        </div>

        <!-- Buttons -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan Produk
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Auto-fill kategori berdasarkan tipe produk
    document.getElementById('tipe_produk').addEventListener('change', function() {
        const kategoriInput = document.getElementById('kategori');
        const kategoriHelp = document.getElementById('kategoriHelp');
        
        if (this.value === 'bibit') {
            kategoriInput.value = 'Organik';
            kategoriInput.setAttribute('readonly', 'readonly');
            kategoriInput.style.backgroundColor = '#f3f4f6';
            kategoriHelp.innerHTML = '<i class="fas fa-check-circle"></i> Kategori otomatis terisi "Organik" untuk tipe Bibit';
            kategoriHelp.style.color = '#059669';
        } else {
            kategoriInput.value = '';
            kategoriInput.removeAttribute('readonly');
            kategoriInput.style.backgroundColor = '#fff';
            kategoriHelp.innerHTML = '<i class="fas fa-info-circle"></i> Akan otomatis terisi "Organik" jika tipe adalah Bibit';
            kategoriHelp.style.color = '#6b7280';
        }
    });

    // Handle multiple file upload preview
    document.getElementById('gambar').addEventListener('change', function(e) {
        const files = e.target.files;
        const fileInfo = document.getElementById('fileInfo');
        const imagePreviews = document.getElementById('imagePreviews');
        
        // Clear previous previews
        imagePreviews.innerHTML = '';
        
        if (files.length > 0) {
            // Validasi jumlah file
            if (files.length > 5) {
                alert('Maksimal upload 5 gambar!');
                e.target.value = '';
                fileInfo.innerHTML = '<span style="color: #ef4444;"><i class="fas fa-exclamation-circle"></i> Maksimal 5 gambar!</span>';
                return;
            }

            // Update file info
            fileInfo.innerHTML = `<span style="color: #059669;"><i class="fas fa-check-circle"></i> ${files.length} gambar dipilih</span>`;
            
            // Show previews for each file
            Array.from(files).forEach((file, index) => {
                // Validasi ukuran file
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                if (file.size > maxSize) {
                    alert(`File ${file.name} terlalu besar! Maksimal 2MB per file.`);
                    e.target.value = '';
                    imagePreviews.innerHTML = '';
                    fileInfo.innerHTML = '<span style="color: #ef4444;"><i class="fas fa-exclamation-circle"></i> Ada file yang terlalu besar!</span>';
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert(`File ${file.name} bukan gambar yang valid!`);
                    e.target.value = '';
                    imagePreviews.innerHTML = '';
                    fileInfo.innerHTML = '<span style="color: #ef4444;"><i class="fas fa-exclamation-circle"></i> Format file tidak valid!</span>';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    
                    const badge = index === 0 ? '<div class="preview-badge">Gambar Utama</div>' : '';
                    const fileSize = (file.size / 1024).toFixed(2);
                    
                    previewItem.innerHTML = `
                        ${badge}
                        <img src="${e.target.result}" alt="Preview ${index + 1}">
                        <div class="preview-info">
                            <div class="preview-name">Gambar ${index + 1}</div>
                            <div class="preview-size">${fileSize} KB</div>
                        </div>
                    `;
                    
                    imagePreviews.appendChild(previewItem);
                }
                reader.readAsDataURL(file);
            });
        } else {
            fileInfo.innerHTML = '<span style="color: #6b7280;">Belum ada file dipilih</span>';
        }
    });

    // Trigger auto-fill on page load if old value exists
    window.addEventListener('DOMContentLoaded', function() {
        const tipeSelect = document.getElementById('tipe_produk');
        if (tipeSelect.value) {
            tipeSelect.dispatchEvent(new Event('change'));
        }
    });

    // Form validation before submit
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const hargaSubsidi = parseFloat(document.getElementById('harga_subsidi').value);
        const hargaNormal = parseFloat(document.getElementById('harga_normal').value);
        const files = document.getElementById('gambar').files;
        
        // Validasi harga
        if (hargaSubsidi >= hargaNormal) {
            e.preventDefault();
            alert('Harga subsidi harus lebih kecil dari harga normal!');
            return false;
        }

        // Validasi jumlah file
        if (files.length === 0) {
            e.preventDefault();
            alert('Minimal upload 1 gambar produk!');
            return false;
        }

        if (files.length > 5) {
            e.preventDefault();
            alert('Maksimal upload 5 gambar produk!');
            return false;
        }

        // Validasi ukuran setiap file
        const maxSize = 2 * 1024 * 1024; // 2MB
        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                e.preventDefault();
                alert(`File ${files[i].name} terlalu besar! Maksimal 2MB per file.`);
                return false;
            }
        }
    });
</script>
@endpush
