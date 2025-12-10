@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Profile Header Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <!-- Compact Banner -->
            <div class="h-32 bg-gradient-to-r from-green-600 to-green-400 relative">
                <div class="absolute -bottom-12 left-8">
                    <div class="w-24 h-24 bg-white rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- User Info Section -->
            <div class="pt-16 pb-6 px-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-600 mt-1 flex items-center gap-2">
                            <i class="fas fa-envelope text-green-600"></i>
                            <span>{{ Auth::user()->email }}</span>
                        </p>
                    </div>
                    <a href="{{ route('profil.edit') }}" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg transition duration-200 shadow-sm">
                        <i class="fas fa-edit"></i>
                        <span>Edit Profil</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Information Cards Grid -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <!-- Personal Info Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-circle text-green-600"></i>
                    <span>Informasi Pribadi</span>
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium text-gray-900">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Telepon</p>
                            <p class="font-medium text-gray-900">{{ Auth::user()->phone ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium text-gray-900">{{ Auth::user()->address ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar text-green-600"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Bergabung</p>
                            <p class="font-medium text-gray-900">{{ Auth::user()->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Stats Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-line text-green-600"></i>
                    <span>Statistik Akun</span>
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <i class="fas fa-shopping-cart text-2xl text-green-600 mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->count() ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Total Pesanan</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <i class="fas fa-check-circle text-2xl text-blue-600 mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->where('status', 'Selesai')->count() ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Selesai</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4 text-center">
                        <i class="fas fa-clock text-2xl text-yellow-600 mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->whereIn('status', ['Pending', 'Diproses'])->count() ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Diproses</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        <i class="fas fa-wallet text-2xl text-purple-600 mb-2"></i>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($orders->sum('total') ?? 0, 0) }}</p>
                        <p class="text-sm text-gray-600">Total Belanja</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-green-600"></i>
                    <span>Riwayat Pesanan</span>
                </h2>
            </div>
            
            @if(isset($orders) && $orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Order</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-900">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->product_name ?? 'Produk tidak tersedia' }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status == 'Selesai') bg-green-100 text-green-800
                                        @elseif($order->status == 'Diproses') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'Pending') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <button class="inline-flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-xs font-medium transition duration-200">
                                        <i class="fas fa-eye"></i>
                                        <span>Detail</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16 text-gray-500">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-inbox text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-lg font-medium text-gray-700">Belum ada riwayat pesanan</p>
                    <p class="text-sm text-gray-500 mt-1">Pesanan Anda akan muncul di sini</p>
                    <a href="{{ route('pupuk-bibit') }}" class="inline-flex items-center gap-2 mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg transition duration-200">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Mulai Belanja</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Logout Section -->
        <div class="mt-8 text-center">
            <form action="{{ route('logout') }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg transition duration-200 shadow-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar dari Akun</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
