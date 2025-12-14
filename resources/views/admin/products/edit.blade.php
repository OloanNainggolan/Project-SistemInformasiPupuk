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

    /* Edit Product Container */
    .edit-product-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px 30px;
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
        background-clip: text;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .page-title i {
        font-size: 32px;
        background: linear-gradient(135deg, var(--blue) 0%, #60a5fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-top: 0;
        font-weight: 500;
    }

    .form-container {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 2px solid #f3f4f6;
    }

    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        line-height: 1.5;
    }

    .alert-success {
        background: #d1fae5;
        border: 2px solid var(--green-light);
        color: var(--green-dark);
    }

    .alert-danger {
        background: #fee2e2;
        border: 2px solid #f87171;
        color: #991b1b;
    }

    .alert i {
        font-size: 18px;
        margin-top: 2px;
        flex-shrink: 0;
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
        margin-bottom: 24px;
    }

    .form-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-label i {
        color: var(--green);
        font-size: 14px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #1f2937;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    .form-input.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    textarea.form-input {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    select.form-input {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 20px;
        padding-right: 40px;
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
        margin-bottom: 24px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .current-images-title {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .current-images-title i {
        color: var(--green);
    }

    .current-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
    }

    .current-image-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .current-image-item:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .current-image-item.marked-delete {
        opacity: 0.4;
        border-color: #ef4444;
    }

    .current-image-item img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        display: block;
    }

    .current-image-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .delete-image-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .delete-image-btn:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        transform: scale(1.1);
    }

    .delete-image-btn.restore {
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
    }

    .delete-image-btn.restore:hover {
        background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%);
    }

    .image-counter {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
        font-weight: 600;
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

    /* Flexible Image Upload */
    .btn-add-image {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.2);
    }

    .btn-add-image:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
    }

    .btn-add-image:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-add-image i {
        font-size: 16px;
    }

    .upload-hint {
        margin-top: 10px;
        font-size: 12px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Responsive */
    @media (max-width: 1440px) {
        .edit-product-container {
            padding: 25px 30px;
        }
    }

    @media (max-width: 768px) {
        .edit-product-container {
            padding: 20px 16px;
        }

        .form-container {
            padding: 24px 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 22px;
        }

        .page-title i {
            font-size: 26px;
        }

        .current-images-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .current-images-grid {
            grid-template-columns: 1fr;
        }
    }

    .upload-hint i {
        color: var(--green);
    }

    /* Image Previews Grid */
    .image-previews-grid {
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
    }

    .image-preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background: white;
        transition: all 0.3s ease;
    }

    .image-preview-item:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .image-preview-item img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        display: block;
    }

    .image-preview-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .image-preview-badge i {
        font-size: 12px;
    }

    .image-remove-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        background: rgba(239, 68, 68, 0.95);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .image-remove-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .image-preview-info {
        padding: 12px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    .image-preview-name {
        font-size: 12px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .image-preview-size {
        font-size: 11px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .image-preview-size i {
        font-size: 10px;
    }

    .image-counter-info {
        margin-top: 15px;
        padding: 12px 16px;
        background: var(--mint);
        border-radius: 8px;
        border: 1px solid #d1fae5;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--green-dark);
    }

    .image-counter-info i {
        font-size: 16px;
        color: var(--green);
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
<div class="edit-product-container">
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
            <div class="current-images-title">
                Gambar Saat Ini: 
                <span class="image-counter">(<span id="imageCount">{{ $product->images->count() }}</span> gambar)</span>
            </div>
            <div class="current-images-grid">
                @foreach($product->images as $image)
                <div class="current-image-item" data-image-id="{{ $image->id }}">
                    @if($image->is_primary)
                    <div class="current-image-badge">Utama</div>
                    @endif
                    <button type="button" class="delete-image-btn" onclick="toggleDeleteImage(this, {{ $image->id }})">
                        <i class="fas fa-times"></i>
                    </button>
                    <img src="{{ asset($image->image_path) }}" alt="Product Image">
                    <input type="hidden" name="existing_images[]" value="{{ $image->id }}" class="existing-image-input">
                </div>
                @endforeach
            </div>
            <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">
                <i class="fas fa-info-circle"></i> Klik tombol <i class="fas fa-times"></i> untuk menandai gambar yang akan dihapus
            </p>
        </div>
        @endif

        <!-- Upload Gambar Baru (Optional - Flexible) -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-images"></i>
                Tambah Gambar Baru (Opsional)
            </label>
            
            <!-- Add Image Button -->
            <button 
                type="button" 
                id="addNewImageBtn" 
                class="btn-add-image"
                onclick="document.getElementById('newGambarInput').click()"
            >
                <i class="fas fa-plus-circle"></i>
                Tambah Gambar Baru
            </button>
            
            <!-- Hidden File Input -->
            <input 
                type="file" 
                id="newGambarInput" 
                accept="image/jpeg,image/jpg,image/png,image/gif"
                style="display: none;"
            >
            
            <div class="upload-hint">
                <i class="fas fa-info-circle"></i>
                JPG, PNG, GIF | Max 2MB per gambar | Maksimal 5 gambar total (termasuk yang sudah ada)
            </div>
            
            <!-- New Image Previews Container -->
            <div class="image-previews-grid" id="newImagePreviewsGrid"></div>
            
            <div id="newImageCounter" class="image-counter-info" style="display: none;">
                <i class="fas fa-images"></i>
                <span id="newImageCountText">0 gambar baru</span>
            </div>
            
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
</div> <!-- End edit-product-container -->
@endsection

@push('scripts')
<script>
    // Toggle delete image
    function toggleDeleteImage(button, imageId) {
        const imageItem = button.closest('.current-image-item');
        const hiddenInput = imageItem.querySelector('.existing-image-input');
        
        if (imageItem.classList.contains('marked-delete')) {
            // Restore image
            imageItem.classList.remove('marked-delete');
            button.innerHTML = '<i class="fas fa-times"></i>';
            button.classList.remove('restore');
            hiddenInput.disabled = false;
        } else {
            // Mark for deletion
            imageItem.classList.add('marked-delete');
            button.innerHTML = '<i class="fas fa-undo"></i>';
            button.classList.add('restore');
            hiddenInput.disabled = true;
        }
        
        updateImageCount();
    }
    
    // Update image count
    function updateImageCount() {
        const existingImages = document.querySelectorAll('.current-image-item:not(.marked-delete)').length;
        document.getElementById('imageCount').textContent = existingImages;
    }
    
    // Flexible Image Upload System for New Images
    let newSelectedImages = []; // Array to store new selected images
    const maxImages = 5;
    const maxFileSize = 2 * 1024 * 1024; // 2MB

    // Handle new file selection
    document.getElementById('newGambarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (!file) return;

        // Get existing image count (not marked for deletion)
        const existingCount = document.querySelectorAll('.current-image-item:not(.marked-delete)').length;
        const totalCount = existingCount + newSelectedImages.length;

        // Check if max images reached
        if (totalCount >= maxImages) {
            alert(`Maksimal ${maxImages} gambar total! Anda sudah memiliki ${existingCount} gambar dan ${newSelectedImages.length} gambar baru.`);
            e.target.value = '';
            return;
        }

        // Validate file size
        if (file.size > maxFileSize) {
            alert(`File ${file.name} terlalu besar! Maksimal 2MB per gambar.`);
            e.target.value = '';
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert(`File ${file.name} bukan format gambar yang valid!`);
            e.target.value = '';
            return;
        }

        // Add image to array
        newSelectedImages.push(file);
        
        // Reset file input
        e.target.value = '';
        
        // Update UI
        updateNewImagePreviews();
        updateNewImageCounter();
        updateAddNewImageButton();
    });

    // Update new image previews
    function updateNewImagePreviews() {
        const grid = document.getElementById('newImagePreviewsGrid');
        grid.innerHTML = '';

        newSelectedImages.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview-item';
                
                const fileSize = (file.size / 1024).toFixed(2);
                
                previewDiv.innerHTML = `
                    <div class="image-preview-badge">
                        <i class="fas fa-plus-circle"></i> Baru
                    </div>
                    <button type="button" class="image-remove-btn" onclick="removeNewImage(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                    <img src="${e.target.result}" alt="${file.name}">
                    <div class="image-preview-info">
                        <div class="image-preview-name" title="${file.name}">${file.name}</div>
                        <div class="image-preview-size">
                            <i class="fas fa-weight-hanging"></i>
                            ${fileSize} KB
                        </div>
                    </div>
                `;
                
                grid.appendChild(previewDiv);
            };
            
            reader.readAsDataURL(file);
        });
    }

    // Remove new image from array
    window.removeNewImage = function(index) {
        newSelectedImages.splice(index, 1);
        updateNewImagePreviews();
        updateNewImageCounter();
        updateAddNewImageButton();
    };

    // Update new image counter
    function updateNewImageCounter() {
        const counter = document.getElementById('newImageCountText');
        const counterDiv = document.getElementById('newImageCounter');
        const count = newSelectedImages.length;
        
        if (count === 0) {
            counterDiv.style.display = 'none';
        } else {
            counter.textContent = `${count} gambar baru akan ditambahkan`;
            counterDiv.style.display = 'inline-flex';
        }
    }

    // Update add new image button state
    function updateAddNewImageButton() {
        const btn = document.getElementById('addNewImageBtn');
        const existingCount = document.querySelectorAll('.current-image-item:not(.marked-delete)').length;
        const totalCount = existingCount + newSelectedImages.length;
        
        if (totalCount >= maxImages) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-check-circle"></i> Maksimal gambar tercapai';
        } else {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plus-circle"></i> Tambah Gambar Baru';
        }
    }

    // Update button state when existing images are marked for deletion
    const originalToggleDeleteImage = window.toggleDeleteImage;
    window.toggleDeleteImage = function(button, imageId) {
        originalToggleDeleteImage(button, imageId);
        updateAddNewImageButton();
    };

    // Initialize
    updateNewImageCounter();
    updateAddNewImageButton();

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

    // Form validation and submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const hargaSubsidi = parseFloat(document.getElementById('harga_subsidi').value);
        const hargaNormal = parseFloat(document.getElementById('harga_normal').value);
        
        // Validasi harga
        if (hargaSubsidi >= hargaNormal) {
            alert('Harga subsidi harus lebih kecil dari harga normal!');
            return false;
        }
        
        // Validasi total gambar
        const existingCount = document.querySelectorAll('.current-image-item:not(.marked-delete)').length;
        
        if (existingCount === 0 && newSelectedImages.length === 0) {
            alert('Produk harus memiliki minimal 1 gambar!');
            return false;
        }

        // Create FormData and append all fields
        const formData = new FormData(this);
        
        // Remove any existing gambar[] fields from old input
        formData.delete('gambar[]');
        
        // Add new selected images to FormData
        newSelectedImages.forEach((file, index) => {
            formData.append('gambar[]', file);
        });
        
        // Submit form
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                window.location.href = data.redirect || '{{ route("admin.products.index") }}';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan produk. Silakan coba lagi.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
        
        return false;
    });
</script>
@endpush
