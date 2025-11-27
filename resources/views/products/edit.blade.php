@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Produk</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.update', $product->id_produk) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                   id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                            @error('nama_produk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipe_produk" class="form-label">Tipe Produk</label>
                            <select class="form-select @error('tipe_produk') is-invalid @enderror" 
                                    id="tipe_produk" name="tipe_produk" required>
                                <option value="">Pilih Tipe Produk</option>
                                <option value="pupuk" {{ old('tipe_produk', $product->tipe_produk) == 'pupuk' ? 'selected' : '' }}>Pupuk</option>
                                <option value="bibit" {{ old('tipe_produk', $product->tipe_produk) == 'bibit' ? 'selected' : '' }}>Bibit</option>
                            </select>
                            @error('tipe_produk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control @error('kategori') is-invalid @enderror" 
                                   id="kategori" name="kategori" value="{{ old('kategori', $product->kategori) }}" required>
                            @error('kategori')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga_subsidi" class="form-label">Harga Subsidi</label>
                            <input type="number" step="0.01" class="form-control @error('harga_subsidi') is-invalid @enderror" 
                                   id="harga_subsidi" name="harga_subsidi" value="{{ old('harga_subsidi', $product->harga_subsidi) }}" required>
                            @error('harga_subsidi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga_normal" class="form-label">Harga Normal</label>
                            <input type="number" step="0.01" class="form-control @error('harga_normal') is-invalid @enderror" 
                                   id="harga_normal" name="harga_normal" value="{{ old('harga_normal', $product->harga_normal) }}" required>
                            @error('harga_normal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stok_produk" class="form-label">Stok Produk (kg)</label>
                            <input type="number" class="form-control @error('stok_produk') is-invalid @enderror" 
                                   id="stok_produk" name="stok_produk" value="{{ old('stok_produk', $product->stok_produk) }}" required>
                            @error('stok_produk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                            @if($product->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset($product->gambar) }}" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" name="gambar" accept="image/*">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                            @error('gambar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Manfaat -->
                        <div class="mb-3">
                            <label for="manfaat" class="form-label">
                                <i class="fas fa-leaf"></i> Manfaat <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('manfaat') is-invalid @enderror" 
                                      id="manfaat" name="manfaat" rows="5" required 
                                      placeholder="Contoh: Meningkatkan produktivitas tanaman, Mempercepat pertumbuhan akar...">{{ old('manfaat', $product->manfaat ?? '') }}</textarea>
                            @error('manfaat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Jelaskan manfaat atau kegunaan produk
                            </small>
                        </div>

                        <!-- Bahan/Komposisi -->
                        <div class="mb-3">
                            <label for="bahan" class="form-label">
                                <i class="fas fa-flask"></i> Bahan/Komposisi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('bahan') is-invalid @enderror" 
                                      id="bahan" name="bahan" rows="5" required 
                                      placeholder="Contoh: Nitrogen (N) 15%, Fosfor (P) 10%, Kalium (K) 15%...">{{ old('bahan', $product->bahan ?? '') }}</textarea>
                            @error('bahan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Sebutkan kandungan atau komposisi bahan
                            </small>
                        </div>

                        <!-- Cara Penggunaan -->
                        <div class="mb-3">
                            <label for="cara_penggunaan" class="form-label">
                                <i class="fas fa-tasks"></i> Cara Penggunaan <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('cara_penggunaan') is-invalid @enderror" 
                                      id="cara_penggunaan" name="cara_penggunaan" rows="6" required 
                                      placeholder="Contoh: 1. Larutkan 100 gram pupuk dalam 10 liter air, 2. Aduk hingga merata...">{{ old('cara_penggunaan', $product->cara_penggunaan ?? '') }}</textarea>
                            @error('cara_penggunaan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Berikan petunjuk langkah demi langkah
                            </small>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
