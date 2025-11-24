@extends('layouts.admin')

@section('title', 'Daftar Produk')

@push('styles')
<style>
    .container {
        max-width: 1400px;
        margin: 30px auto;
        padding: 0 20px;
    }

    /* Header */
    .page-header {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 1.8em;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-add {
            background: #ffd700;
            color: #1b5e20;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-add:hover {
            background: #ffed4e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
        }

        /* Alert */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 20px 25px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            color: #2e7d32;
            font-size: 1.3em;
        }

        .stats {
            display: flex;
            gap: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: #f1f8f4;
            border-radius: 8px;
            color: #2e7d32;
            font-weight: 600;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #4CAF50 0%, #2e7d32 100%);
            color: white;
        }

        thead th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95em;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        tbody tr:hover {
            background-color: #f9fdf9;
        }

        tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-images {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .product-images img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-images img:hover {
            transform: scale(1.5);
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .image-count {
            display: inline-block;
            background: #4CAF50;
            color: white;
            font-size: 0.75em;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 5px;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
            display: inline-block;
        }

        .badge-pupuk {
            background: #4CAF50;
            color: white;
        }

        .badge-bibit {
            background: #2196F3;
            color: white;
        }

        .price {
            font-weight: 600;
            color: #2e7d32;
        }

        .price-normal {
            color: #999;
            text-decoration: line-through;
            font-size: 0.9em;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-size: 0.9em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit {
            background: #FF9800;
            color: white;
        }

        .btn-edit:hover {
            background: #F57C00;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(255, 152, 0, 0.3);
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(244, 67, 54, 0.3);
        }

        .btn-back {
            background: #757575;
            color: white;
        }

        .btn-back:hover {
            background: #616161;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(117, 117, 117, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 4em;
            margin-bottom: 20px;
            color: #ddd;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 1000px;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .page-header h1 {
                font-size: 1.5em;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
            }

            .stats {
                width: 100%;
                justify-content: space-around;
            }
        }
</style>
@endpush

@section('content')
<div class="container">
    <!-- Header -->
    <div class="page-header">
            <h1>
                <i class="fas fa-box"></i>
                Daftar Produk
            </h1>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Dashboard
                </a>
                <a href="{{ route('products.create') }}" class="btn-add">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Produk
                </a>
            </div>
        </div>

        <!-- Alert -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-header">
                <h2>
                    <i class="fas fa-list"></i>
                    Semua Produk
                </h2>
                <div class="stats">
                    <div class="stat-item">
                        <i class="fas fa-box"></i>
                        <span>Total: {{ $products->count() }} produk</span>
                    </div>
                </div>
            </div>

            @if($products->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 80px;">Gambar</th>
                        <th>Nama Produk</th>
                        <th style="width: 100px;">Tipe</th>
                        <th style="width: 120px;">Kategori</th>
                        <th style="width: 150px;">Harga</th>
                        <th style="width: 100px;">Stok</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($product->images->count() > 0)
                                <div class="product-images">
                                    @foreach($product->images as $image)
                                        <img src="{{ asset($image->image_path) }}" 
                                             alt="{{ $product->nama_produk }}" 
                                             title="Gambar {{ $loop->iteration }}"
                                             onerror="this.src='{{ asset('images/no-image.png') }}'">
                                    @endforeach
                                </div>
                                <small style="color: #666;">
                                    <span class="image-count">{{ $product->images->count() }} foto</span>
                                </small>
                            @else
                                <img src="{{ asset($product->gambar) }}" 
                                     alt="{{ $product->nama_produk }}" 
                                     class="product-img"
                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                            @endif
                        </td>
                        <td>
                            <strong>{{ $product->nama_produk }}</strong>
                            <br>
                            <small style="color: #999;">{{ Str::limit($product->deskripsi, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $product->tipe_produk }}">
                                {{ ucfirst($product->tipe_produk) }}
                            </span>
                        </td>
                        <td>{{ $product->kategori }}</td>
                        <td>
                            <div class="price">
                                Rp {{ number_format($product->harga_subsidi, 0, ',', '.') }}
                            </div>
                            <div class="price-normal">
                                Rp {{ number_format($product->harga_normal, 0, ',', '.') }}
                            </div>
                        </td>
                        <td>
                            <strong>{{ number_format($product->stok_produk, 0, ',', '.') }}</strong> kg
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('products.edit', $product->id_produk) }}" 
                                   class="btn btn-edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id_produk) }}" 
                                      method="POST" 
                                      style="margin: 0;"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->nama_produk }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Belum Ada Produk</h3>
                <p>Klik tombol "Tambah Produk" untuk menambahkan produk baru</p>
            </div>
            @endif
        </div>
    </div>
@endsection
