@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div style="background: #f0f4f8; min-height: 100vh; padding: 2rem 0;">
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 1.5rem;">
        
        <div style="display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start;">
            
            <!-- Left Sidebar - Profile Card -->
            <div>
                <!-- Main Profile Card -->
                <div style="background: white; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 1.5rem;">
                    
                    <!-- Avatar Section -->
                    <div style="padding: 2rem 1.5rem; text-align: center;">
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3); overflow: hidden; position: relative;">
                            @if(Auth::user()->foto)
                                <img src="{{ asset(Auth::user()->foto) }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="font-size: 3rem; font-weight: 700; color: white;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </span>
                            @endif
                        </div>
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">
                            {{ Auth::user()->name }}
                        </h2>
                        <p style="color: #10b981; font-size: 0.875rem; margin: 0; display: flex; align-items: center; justify-content: center; gap: 0.25rem;">
                            <i class="fas fa-user-check"></i>
                            User
                        </p>
                    </div>

                    <!-- Contact Info -->
                    <div style="padding: 0 1.5rem 1.5rem;">
                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px; margin-bottom: 0.75rem;">
                            <i class="fas fa-envelope" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">{{ Auth::user()->email }}</span>
                        </div>

                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px; margin-bottom: 0.75rem;">
                            <i class="fas fa-phone" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">{{ Auth::user()->no_telp ?? '-' }}</span>
                        </div>

                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px; margin-bottom: 0.75rem;">
                            <i class="fas fa-map-marker-alt" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">{{ Auth::user()->alamat ?? '-' }}</span>
                        </div>

                        <div style="display: flex; align-items: center; padding: 0.875rem; background: #f9fafb; border-radius: 8px;">
                            <i class="fas fa-calendar" style="color: #10b981; font-size: 1rem; width: 24px;"></i>
                            <span style="font-size: 0.875rem; color: #1f2937; margin-left: 0.75rem;">Bergabung {{ Auth::user()->created_at ? Auth::user()->created_at->format('F Y') : 'November 2025' }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="padding: 0 1.5rem 1.5rem;">
                        <a href="{{ route('profil.edit') }}" style="display: block; background: #10b981; color: white; text-align: center; padding: 0.875rem; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.875rem; margin-bottom: 0.75rem; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3); transition: all 0.3s;">
                            <i class="fas fa-edit" style="margin-right: 0.5rem;"></i>Edit Profil
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="width: 100%; background: #fee2e2; color: #dc2626; padding: 0.875rem; border-radius: 10px; border: none; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem;"></i>Keluar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Land Information Card -->
                <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 16px; padding: 1.25rem; border: 2px solid #10b981;">
                    <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                        <i class="fas fa-seedling" style="color: #10b981; font-size: 1.25rem; margin-right: 0.5rem;"></i>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #065f46; margin: 0;">Informasi Lahan</h3>
                    </div>
                    <div style="margin-bottom: 0.875rem;">
                        <p style="font-size: 0.75rem; color: #047857; margin: 0 0 0.25rem 0; font-weight: 600;">Luas Lahan</p>
                        <p style="font-size: 1.25rem; color: #065f46; margin: 0; font-weight: 700;">{{ Auth::user()->luas_lahan ? number_format(Auth::user()->luas_lahan, 2) : '0' }} Ha</p>
                    </div>
                    <div>
                        <p style="font-size: 0.75rem; color: #047857; margin: 0 0 0.5rem 0; font-weight: 600;">Jenis Tanaman</p>
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            @if(Auth::user()->jenis_tanaman)
                                @php
                                    $tanaman = explode(',', Auth::user()->jenis_tanaman);
                                @endphp
                                @foreach($tanaman as $item)
                                    <span style="background: #fef3c7; color: #92400e; padding: 0.375rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                        <i class="fas fa-leaf"></i> {{ trim($item) }}
                                    </span>
                                @endforeach
                            @else
                                <span style="background: #f3f4f6; color: #6b7280; padding: 0.375rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                    <i class="fas fa-info-circle"></i> Belum diisi
                                </span>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->lokasi_lahan)
                    <div style="margin-top: 0.875rem; padding-top: 0.875rem; border-top: 1px solid #d1fae5;">
                        <p style="font-size: 0.75rem; color: #047857; margin: 0 0 0.25rem 0; font-weight: 600;">
                            <i class="fas fa-map-marker-alt"></i> Lokasi Lahan
                        </p>
                        <p style="font-size: 0.875rem; color: #065f46; margin: 0;">{{ Auth::user()->lokasi_lahan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Side - Statistics & Orders -->
            <div>
                <!-- Statistics Cards Grid -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
                    <!-- Total Pesanan -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #8b5cf6;">
                        <div style="width: 48px; height: 48px; background: #ede9fe; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-shopping-bag" style="color: #8b5cf6; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">{{ $orders->count() }}</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Total Pesanan</p>
                    </div>

                    <!-- Pupuk Diterima -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #3b82f6;">
                        <div style="width: 48px; height: 48px; background: #dbeafe; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-box" style="color: #3b82f6; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">0.0 Ton</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Pupuk Diterima</p>
                    </div>

                    <!-- Bibit Diterima -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #f59e0b;">
                        <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-seedling" style="color: #f59e0b; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">0 Kg</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Bibit Diterima</p>
                    </div>

                    <!-- Penghematan -->
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-top: 3px solid #10b981;">
                        <div style="width: 48px; height: 48px; background: #d1fae5; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                            <i class="fas fa-piggy-bank" style="color: #10b981; font-size: 1.5rem;"></i>
                        </div>
                        <p style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0 0 0.25rem 0;">{{ number_format($orders->sum('total') / 1000, 1) }} Jt</p>
                        <p style="font-size: 0.8rem; color: #6b7280; margin: 0; font-weight: 500;">Total Belanja</p>
                    </div>
                </div>

                <!-- Orders Table -->
                <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-history" style="color: #10b981; font-size: 1.125rem;"></i>
                        <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0;">Riwayat Pesanan</h2>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead style="background: #f9fafb;">
                                <tr>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Pesanan</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal Order</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Total</th>
                                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr style="border-top: 1px solid #f3f4f6; transition: background 0.2s;">
                                    <td style="padding: 1rem 1.5rem;">
                                        <p style="font-size: 0.875rem; font-weight: 600; color: #1f2937; margin: 0 0 0.25rem 0;">{{ $order->order_number }}</p>
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">{{ $order->product_name ?? 'Produk tidak tersedia' }}</p>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <p style="font-size: 0.875rem; color: #1f2937; margin: 0;">{{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</p>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <p style="font-size: 0.875rem; font-weight: 600; color: #1f2937; margin: 0;">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    </td>
                                    <td style="padding: 1rem 1.5rem;">
                                        <span style="background: #d1fae5; color: #065f46; padding: 0.375rem 0.875rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-block;">
                                            {{ $order->status ?? 'Selesai' }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem 1.5rem; text-align: center;">
                                        <button style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 6px; border: none; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.375rem;">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="padding: 3rem; text-align: center;">
                                        <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                                        <p style="color: #6b7280; font-size: 0.875rem;">Belum ada riwayat pesanan</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 350px 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
