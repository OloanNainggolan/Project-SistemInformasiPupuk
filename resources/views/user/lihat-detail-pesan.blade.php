@extends('layouts.user')

@section('title', 'Pupuk & Bibit Subsidi')

@push('styles')
<style>
    :root{
        --green-dark:#195619;
        --green-light:#eaf7ea;
        --muted:#6b6b6b;
        --card-bg:#f1f3f2;
        --panel-bg:#e6e6e6;
        --container-max:1100px;
        --radius:12px;
        font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
    }
    html,body{height:100%;margin:0;background:var(--green-light);color:#222}
    .page{max-width:var(--container-max);margin:18px auto;padding:0 18px}
    .back-row{display:flex;align-items:center;gap:12px;margin-bottom:14px}
    .back-btn{display:inline-flex;align-items:center;gap:8px;background:#fff;border-radius:999px;padding:8px 12px;color:var(--green-dark);text-decoration:none;box-shadow:0 2px 8px rgba(0,0,0,0.06)}

    .card-wrap{background:#fff;border-radius:14px;padding:22px;border:1px solid rgba(0,0,0,0.04);box-shadow:0 6px 18px rgba(0,0,0,0.04)}
    .notif-panel{background:var(--card-bg);border-radius:10px;padding:18px;border:1px solid rgba(0,0,0,0.03)}
    .notif-inner{background:var(--panel-bg);border-radius:14px;padding:20px;border:1px solid rgba(0,0,0,0.04)}

    .notif-head{display:flex;align-items:center;gap:14px;margin-bottom:12px}
    .icon-circle{width:44px;height:44px;border-radius:999px;background:var(--green-dark);color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px}
    .notif-title{font-weight:800;color:var(--green-dark);font-size:18px}
    .notif-date{margin-left:auto;color:var(--muted);font-size:13px}

    .notif-body{background:transparent;padding:6px 2px;color:#222;line-height:1.6}
    .notif-body p{margin:10px 0}
    .notif-body ul{margin:8px 0 12px 20px}

    /* responsive */
    @media (max-width:720px){
        .page{padding:12px}
        .card-wrap{padding:16px}
        .notif-inner{padding:16px}
        .notif-title{font-size:16px}
    }
</style>
@endpush

@section('content')
<main class="page" role="main">
    <a href="{{ url()->previous() }}" class="back-btn" aria-label="Kembali">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>

    <div class="card-wrap" style="margin-top:12px">
        <div class="notif-panel">
            <div class="notif-inner">
                <div class="notif-head">
                    <div class="icon-circle"><i class="fas fa-envelope"></i></div>
                    <div class="notif-title">Detail Pesan</div>
                    <div class="notif-date">{{ date('d/m/Y') }}</div>
                </div>

                <div class="notif-body">
                    <p>Ini adalah konten detail pesan yang dapat disesuaikan dengan kebutuhan Anda.</p>

                    <p>Halaman ini menampilkan informasi lengkap mengenai pesan atau notifikasi yang diterima pengguna.</p>

                    <p>Anda dapat menambahkan konten tambahan, gambar, atau informasi lainnya sesuai kebutuhan sistem.</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
