@extends('layouts.auth')
@section('title', 'Selesaikan Pendaftaran')

@section('content')
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;">
    <div style="width:100%;max-width:720px;background:white;border-radius:12px;padding:28px;box-shadow:0 10px 30px rgba(0,0,0,0.08);">
        <h2 style="margin-bottom:8px">Selesaikan Pendaftaran</h2>
        <p style="color:#6b7280;margin-bottom:20px">Lengkapi beberapa data profil untuk menyelesaikan pendaftaran menggunakan akun Google Anda.</p>

        @if(session('error'))
            <div style="background:#fee2e2;padding:12px;border-radius:8px;margin-bottom:10px;color:#991b1b">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('register.complete.process') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px">
                <div>
                    <label style="display:block;font-weight:600;margin-bottom:6px">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $google['name'] ?? '') }}" required style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                </div>

                <div>
                    <label style="display:block;font-weight:600;margin-bottom:6px">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required placeholder="username" style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
                </div>
            </div>

            <div style="margin-bottom:12px">
                <label style="display:block;font-weight:600;margin-bottom:6px">No. Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}" required style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>

            <div style="margin-bottom:12px">
                <label style="display:block;font-weight:600;margin-bottom:6px">Alamat Lengkap</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" required placeholder="Jl. ..." style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>

            <div style="margin-bottom:12px">
                <label style="display:block;font-weight:600;margin-bottom:6px">Balai Desa</label>
                <input type="text" name="alamat_balai_desa" value="{{ old('alamat_balai_desa') }}" required style="width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px">
            </div>

            <div style="display:flex;gap:12px;align-items:center;margin-top:18px">
                <button type="submit" style="background:#059669;color:white;padding:12px 18px;border-radius:8px;border:none;font-weight:700">Selesaikan Pendaftaran</button>
                <a href="{{ route('login') }}" style="color:#6b7280;text-decoration:none">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
