@extends('layouts.admin')

@section('title', 'Edit Produk - Admin Panel')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
        --blue: #3b82f6;
    }

    /* Same styles as create.blade.php */
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
        background: linear-gradient(135deg, var(--blue) 0%, #60a5fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-top: 5px;
    }

    .form-container {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(5, 150, 105, 0.1);
    }

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

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

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

    .invalid-feedback {
        color: #ef4444;
        font-size: 12px;
        margin-top: 6px;
        font-weight: 600;
        display: block;
    }

    /* Current Images Display */
    .current-images {
        margin-bottom: 15px;
    }

    .current-images-title {
        font-size: 13px;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .current-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
    }

    .current-image-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .current-image-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .current-image-badge {
        position: absolute;
        top: 6px;
        left: 6px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
    }

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
        background: linear-gradient(135deg, var(--blue) 0%, #60a5fa 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        flex: 1;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
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
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-edit"></i>
        Edit Produk
    </h1>
    <p class="page-subtitle">Perbarui informasi produk {{ $product->nama_produk }}</p>
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

    <!-- Form -->
    <form method="POST" action="{{ route('admin.products.update', $product->id_produk) }}" enctype="multipart/form-data" id="productForm">
        @csrf
        @method('PUT')

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
                    value="{{ old('nama_produk', $product->nama_produk) }}" 
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
                    <option value="pupuk" {{ old('tipe_produk', $product->tipe_produk) == 'pupuk' ? 'selected' : '' }}>Pupuk</option>
                    <option value="bibit" {{ old('tipe_produk', $product->tipe_produk) == 'bibit' ? 'selected' : '' }}>Bibit</option>
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
                value="{{ old('kategori', $product->kategori) }}" 
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
                    value="{{ old('harga_subsidi', $product->harga_subsidi) }}" 
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
                    value="{{ old('harga_normal', $product->harga_normal) }}" 
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
                value="{{ old('stok_produk', $product->stok_produk) }}" 
                required
            >
            @error('stok_produk')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Current Images -->
        @if($product->images && $product->images->count() > 0)
        <div class="current-images">
            <div class="current-images-title">Gambar Saat Ini:</div>
            <div class="current-images-grid">
                @foreach($product->images as $image)
                <div class="current-image-item">
                    @if($image->is_primary)
                    <div class="current-image-badge">Utama</div>
                    @endif
                    <img src="{{ asset($image->image_path) }}" alt="Product Image">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Upload Gambar Baru (Optional) -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-images"></i>
                Upload Gambar Baru (Opsional)
            </label>
            <div class="file-upload-area">
                <input 
                    type="file" 
                    id="gambar" 
                    name="gambar" 
                    accept="image/*"
                >
                <label for="gambar" class="file-upload-label">
                    <div class="file-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="file-upload-text">Klik untuk upload gambar baru</div>
                    <div class="file-upload-hint">JPG, PNG, GIF | Max 2MB | Biarkan kosong jika tidak ingin mengubah</div>
                </label>
            </div>
            @error('gambar')
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
                required
            >{{ old('manfaat', $product->manfaat) }}</textarea>
            @error('manfaat')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
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
                required
            >{{ old('bahan', $product->bahan) }}</textarea>
            @error('bahan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
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
                required
            >{{ old('cara_penggunaan', $product->cara_penggunaan) }}</textarea>
            @error('cara_penggunaan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Update Produk
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
            // Don't clear value on edit, just remove readonly
            kategoriInput.removeAttribute('readonly');
            kategoriInput.style.backgroundColor = '#fff';
            kategoriHelp.innerHTML = '<i class="fas fa-info-circle"></i> Akan otomatis terisi "Organik" jika tipe adalah Bibit';
            kategoriHelp.style.color = '#6b7280';
        }
    });

    // Trigger auto-fill on page load if bibit
    window.addEventListener('DOMContentLoaded', function() {
        const tipeSelect = document.getElementById('tipe_produk');
        if (tipeSelect.value === 'bibit') {
            tipeSelect.dispatchEvent(new Event('change'));
        }
    });

    // Form validation before submit
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const hargaSubsidi = parseFloat(document.getElementById('harga_subsidi').value);
        const hargaNormal = parseFloat(document.getElementById('harga_normal').value);
        
        // Validasi harga
        if (hargaSubsidi >= hargaNormal) {
            e.preventDefault();
            alert('Harga subsidi harus lebih kecil dari harga normal!');
            return false;
        }
    });
</script>
@endpush
