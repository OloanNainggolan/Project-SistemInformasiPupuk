@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header Compact Version -->
            <div class="h-24 bg-gradient-to-r from-green-600 to-green-400 relative">
                <div class="absolute -bottom-10 left-6">
                    <div class="w-20 h-20 bg-white rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                        <i class="fas fa-user text-3xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Informasi Profil -->
            <div class="px-6 py-4 pt-14">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-600 text-sm mt-1">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profil.edit') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg inline-flex items-center gap-2 transition duration-200 text-sm">
                        <i class="fas fa-edit"></i>
                        Edit Profil
                    </a>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-envelope text-green-600 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="font-medium text-sm">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-phone text-green-600 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Telepon</p>
                                <p class="font-medium text-sm">{{ Auth::user()->phone ?? '122456' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-map-marker-alt text-green-600 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Alamat</p>
                                <p class="font-medium text-sm">{{ Auth::user()->address ?? 'bali' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 text-gray-700">
                            <i class="fas fa-calendar text-green-600 w-5"></i>
                            <div>
                                <p class="text-xs text-gray-500">Bergabung</p>
                                <p class="font-medium text-sm">{{ Auth::user()->created_at ? Auth::user()->created_at->format('F Y') : 'December 2025' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pesanan -->
            <div class="px-6 py-6 border-t">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-green-600"></i>
                    Riwayat Pesanan
                </h2>
                
                @if(isset($orders) && $orders->count() > 0)
                    <div class="space-y-3">
                        @foreach($orders as $order)
                        <div class="border rounded-lg p-4 hover:shadow-md transition duration-200">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-semibold text-base">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d F Y, H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($order->status == 'Selesai') bg-green-100 text-green-800
                                    @elseif($order->status == 'Diproses') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mt-3">
                                <p class="text-lg font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-5xl mb-3"></i>
                        <p class="text-base">Belum ada riwayat pesanan</p>
                    </div>
                @endif
            </div>

            <!-- Tombol Keluar -->
            <div class="px-6 py-4 border-t bg-gray-50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
