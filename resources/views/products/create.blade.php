<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Pupuk & Bibit Subsidi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Reset & Global */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header */
        .page-header {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .page-header h1 {
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header p {
            margin-top: 8px;
            opacity: 0.9;
            font-size: 0.95em;
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 35px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Alert Messages */
        .alert {
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95em;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
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

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2e7d32;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group label .required {
            color: #d32f2f;
            margin-left: 3px;
        }

        .form-group .help-text {
            font-size: 0.85em;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }

        /* Input Fields */
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s;
            outline: none;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .form-control.is-invalid {
            border-color: #d32f2f;
        }

        .form-control:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* File Input Custom */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 15px;
            border: 2px dashed #4CAF50;
            border-radius: 8px;
            background-color: #f1f8f4;
            cursor: pointer;
            transition: all 0.3s;
            color: #2e7d32;
            font-weight: 600;
        }

        .file-input-label:hover {
            background-color: #e8f5e9;
            border-color: #2e7d32;
        }

        .file-name {
            margin-top: 8px;
            font-size: 0.9em;
            color: #666;
        }

        .file-info {
            margin-top: 8px;
        }

        /* Multiple Image Previews */
        .image-previews {
            margin-top: 15px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .preview-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background: #f9f9f9;
        }

        .preview-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .preview-item .preview-info {
            padding: 8px;
            font-size: 0.8em;
            color: #666;
            background: white;
            border-top: 1px solid #e0e0e0;
        }

        .preview-item .preview-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(76, 175, 80, 0.9);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75em;
            font-weight: 600;
        }

        .preview-item .preview-size {
            display: block;
            margin-top: 4px;
            color: #999;
        }

        .image-preview {
            margin-top: 12px;
            border-radius: 8px;
            overflow: hidden;
            max-width: 300px;
            display: none;
        }

        .image-preview img {
            width: 100%;
            height: auto;
        }

        /* Error Message */
        .invalid-feedback {
            color: #d32f2f;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-secondary {
            background: #757575;
            color: white;
        }

        .btn-secondary:hover {
            background: #616161;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(117, 117, 117, 0.3);
        }

        /* Info Box */
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .info-box i {
            color: #2196F3;
            margin-right: 8px;
        }

        .info-box p {
            margin: 0;
            font-size: 0.9em;
            color: #1565c0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 1.5em;
            }

            .form-container {
                padding: 25px 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-plus-circle"></i>
                Tambah Produk Baru
            </h1>
            <p>Lengkapi formulir di bawah ini untuk menambahkan produk pupuk atau bibit subsidi</p>
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
                    <ul style="margin: 5px 0 0 20px;">
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
                <strong>Catatan:</strong> Jika tipe produk adalah <strong>Bibit</strong>, maka kategori akan otomatis terisi <strong>"Organik"</strong>. Untuk <strong>Pupuk</strong>, kategori dapat diisi manual.
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" id="productForm">
                @csrf

                <!-- Nama Produk & Tipe -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_produk">
                            Nama Produk
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('nama_produk') is-invalid @enderror" 
                            id="nama_produk" 
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
                        <label for="tipe_produk">
                            Tipe Produk
                            <span class="required">*</span>
                        </label>
                        <select 
                            class="form-control @error('tipe_produk') is-invalid @enderror" 
                            id="tipe_produk" 
                            name="tipe_produk" 
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
                    <label for="kategori">
                        Kategori
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('kategori') is-invalid @enderror" 
                        id="kategori" 
                        name="kategori" 
                        value="{{ old('kategori') }}" 
                        placeholder="Kategori produk"
                        required
                    >
                    <small class="help-text" id="kategoriHelp">
                        Akan otomatis terisi "Organik" jika tipe adalah Bibit
                    </small>
                    @error('kategori')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Harga Subsidi & Harga Normal -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="harga_subsidi">
                            Harga Subsidi (Rp)
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            class="form-control @error('harga_subsidi') is-invalid @enderror" 
                            id="harga_subsidi" 
                            name="harga_subsidi" 
                            value="{{ old('harga_subsidi') }}" 
                            placeholder="0.00"
                            required
                        >
                        @error('harga_subsidi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="harga_normal">
                            Harga Normal (Rp)
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="number" 
                            step="0.01" 
                            class="form-control @error('harga_normal') is-invalid @enderror" 
                            id="harga_normal" 
                            name="harga_normal" 
                            value="{{ old('harga_normal') }}" 
                            placeholder="0.00"
                            required
                        >
                        @error('harga_normal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Stok -->
                <div class="form-group">
                    <label for="stok_produk">
                        Stok (kg)
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('stok_produk') is-invalid @enderror" 
                        id="stok_produk" 
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
                    <label for="gambar">
                        Gambar Produk (Multiple)
                        <span class="required">*</span>
                    </label>
                    <div class="file-input-wrapper">
                        <input 
                            type="file" 
                            id="gambar" 
                            name="gambar[]" 
                            accept="image/*"
                            multiple
                            required
                        >
                        <label for="gambar" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Klik untuk upload gambar (Bisa lebih dari 1)</span>
                        </label>
                    </div>
                    <div class="file-info" id="fileInfo">
                        <small style="color: #666;">Belum ada file dipilih</small>
                    </div>
                    
                    <!-- Image Previews Container -->
                    <div class="image-previews" id="imagePreviews"></div>
                    
                    @error('gambar')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @error('gambar.*')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Format: JPG, JPEG, PNG, GIF | Max 2MB per gambar | Min: 1 gambar, Max: 5 gambar
                    </small>
                </div>

                <!-- Manfaat -->
                <div class="form-group">
                    <label for="manfaat">
                        <i class="fas fa-leaf"></i> Manfaat
                        <span class="required">*</span>
                    </label>
                    <textarea 
                        class="form-control @error('manfaat') is-invalid @enderror" 
                        id="manfaat" 
                        name="manfaat" 
                        rows="5"
                        placeholder="Contoh: Meningkatkan produktivitas tanaman hingga 30%, Mempercepat pertumbuhan akar, Meningkatkan daya tahan terhadap hama..."
                        required
                    >{{ old('manfaat') }}</textarea>
                    @error('manfaat')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Jelaskan manfaat atau kegunaan produk untuk tanaman
                    </small>
                </div>

                <!-- Bahan/Komposisi -->
                <div class="form-group">
                    <label for="bahan">
                        <i class="fas fa-flask"></i> Bahan/Komposisi
                        <span class="required">*</span>
                    </label>
                    <textarea 
                        class="form-control @error('bahan') is-invalid @enderror" 
                        id="bahan" 
                        name="bahan" 
                        rows="5"
                        placeholder="Contoh: Nitrogen (N) 15%, Fosfor (P) 10%, Kalium (K) 15%, Bahan organik 50%..."
                        required
                    >{{ old('bahan') }}</textarea>
                    @error('bahan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Sebutkan kandungan atau komposisi bahan produk
                    </small>
                </div>

                <!-- Cara Penggunaan -->
                <div class="form-group">
                    <label for="cara_penggunaan">
                        <i class="fas fa-tasks"></i> Cara Penggunaan
                        <span class="required">*</span>
                    </label>
                    <textarea 
                        class="form-control @error('cara_penggunaan') is-invalid @enderror" 
                        id="cara_penggunaan" 
                        name="cara_penggunaan" 
                        rows="6"
                        placeholder="Contoh: 1. Larutkan 100 gram pupuk dalam 10 liter air, 2. Aduk hingga merata, 3. Siram pada tanaman setiap 2 minggu sekali..."
                        required
                    >{{ old('cara_penggunaan') }}</textarea>
                    @error('cara_penggunaan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Berikan petunjuk langkah demi langkah cara menggunakan produk
                    </small>
                </div>

                <!-- Buttons -->
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-fill kategori berdasarkan tipe produk
        document.getElementById('tipe_produk').addEventListener('change', function() {
            const kategoriInput = document.getElementById('kategori');
            const kategoriHelp = document.getElementById('kategoriHelp');
            
            if (this.value === 'bibit') {
                kategoriInput.value = 'Organik';
                kategoriInput.setAttribute('readonly', 'readonly');
                kategoriInput.style.backgroundColor = '#f5f5f5';
                kategoriHelp.textContent = '✓ Kategori otomatis terisi "Organik" untuk tipe Bibit';
                kategoriHelp.style.color = '#4CAF50';
            } else {
                kategoriInput.value = '';
                kategoriInput.removeAttribute('readonly');
                kategoriInput.style.backgroundColor = '#fff';
                kategoriHelp.textContent = 'Masukkan kategori produk pupuk (contoh: NPK, Urea, Organik, dll)';
                kategoriHelp.style.color = '#666';
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
                    fileInfo.innerHTML = '<small style="color: #d32f2f;">Maksimal 5 gambar!</small>';
                    return;
                }

                // Update file info
                fileInfo.innerHTML = `<small style="color: #4CAF50;"><i class="fas fa-check-circle"></i> ${files.length} gambar dipilih</small>`;
                
                // Show previews for each file
                Array.from(files).forEach((file, index) => {
                    // Validasi ukuran file
                    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                    if (file.size > maxSize) {
                        alert(`File ${file.name} terlalu besar! Maksimal 2MB per file.`);
                        e.target.value = '';
                        imagePreviews.innerHTML = '';
                        fileInfo.innerHTML = '<small style="color: #d32f2f;">Ada file yang terlalu besar!</small>';
                        return;
                    }

                    // Validasi tipe file
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert(`File ${file.name} bukan gambar yang valid!`);
                        e.target.value = '';
                        imagePreviews.innerHTML = '';
                        fileInfo.innerHTML = '<small style="color: #d32f2f;">Format file tidak valid!</small>';
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
                                <strong>Gambar ${index + 1}</strong>
                                <span class="preview-size">${fileSize} KB</span>
                            </div>
                        `;
                        
                        imagePreviews.appendChild(previewItem);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                fileInfo.innerHTML = '<small style="color: #666;">Belum ada file dipilih</small>';
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
</body>
</html>
