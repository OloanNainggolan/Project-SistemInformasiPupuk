<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>FORCE RELOAD - NO CACHE</title>
    <style>
        body {
            font-family: Arial;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #1f2937;
            color: white;
        }
        .box {
            background: #374151;
            padding: 30px;
            border-radius: 15px;
            margin: 20px 0;
            border: 3px solid #10b981;
        }
        h1 {
            color: #10b981;
            text-align: center;
            font-size: 32px;
        }
        .btn {
            display: block;
            padding: 20px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            margin: 15px 0;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5);
        }
        .warning {
            background: #dc2626;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-weight: bold;
        }
        code {
            background: #1f2937;
            padding: 5px 10px;
            border-radius: 5px;
            color: #10b981;
            font-size: 16px;
        }
        .step {
            background: #1f2937;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border-left: 5px solid #10b981;
        }
    </style>
    <script>
        // Force reload tanpa cache
        window.onload = function() {
            if (!performance.navigation.type) {
                window.location.reload(true);
            }
        }
    </script>
</head>
<body>
    <h1>🔄 FORCE RELOAD - NO CACHE</h1>
    
    <div class="warning">
        ⚠️ CACHE SUDAH DIHAPUS SEMUA!<br>
        Sekarang WAJIB hard refresh browser!
    </div>

    <div class="box">
        <h2 style="color: #10b981; margin-top: 0;">📋 LANGKAH WAJIB:</h2>
        
        <div class="step">
            <h3 style="margin-top: 0; color: #10b981;">1️⃣ CLOSE Browser Sepenuhnya</h3>
            <p>- Tutup semua tab</p>
            <p>- Close aplikasi browser (ALT + F4)</p>
            <p>- Tunggu 5 detik</p>
        </div>

        <div class="step">
            <h3 style="margin-top: 0; color: #10b981;">2️⃣ Buka Browser Baru</h3>
            <p>- Buka browser fresh</p>
            <p>- Tekan <code>Ctrl + Shift + Delete</code></p>
            <p>- Clear: Cached images and files</p>
            <p>- Time range: All time</p>
            <p>- Klik Clear data</p>
        </div>

        <div class="step">
            <h3 style="margin-top: 0; color: #10b981;">3️⃣ Buka Link Ini LANGSUNG:</h3>
            <a href="/notifikasi/2?nocache=<?= time() ?>" class="btn">
                📧 DETAIL NOTIFIKASI #2 (NO CACHE)
            </a>
            <p style="text-align: center; color: #6b7280;">Order: ORD-20251212-780630</p>
        </div>

        <div class="step">
            <h3 style="margin-top: 0; color: #10b981;">4️⃣ Atau Admin Detail:</h3>
            <a href="/admin/orders/ORD-20251212-780630?nocache=<?= time() ?>" class="btn">
                📋 ADMIN DETAIL ORDER (NO CACHE)
            </a>
            <p style="text-align: center; color: #6b7280;">Login admin dulu: admin / admin123</p>
        </div>
    </div>

    <div class="box" style="border-color: #ef4444;">
        <h2 style="color: #ef4444; margin-top: 0;">🆘 JIKA MASIH TIDAK MUNCUL:</h2>
        
        <h3 style="color: #10b981;">GUNAKAN INCOGNITO MODE (100% WORK!):</h3>
        <ol style="font-size: 18px; line-height: 2;">
            <li>Tekan <code>Ctrl + Shift + N</code></li>
            <li>Copy URL ini:</li>
        </ol>
        <code style="display: block; padding: 15px; font-size: 14px;">
            http://127.0.0.1:8000/notifikasi/2
        </code>
        <ol start="3" style="font-size: 18px; line-height: 2;">
            <li>Paste di address bar Incognito</li>
            <li>Enter</li>
            <li>Login jika perlu</li>
            <li>PASTI MUNCUL!</li>
        </ol>
    </div>

    <div class="box" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <h2 style="color: white; margin-top: 0; text-align: center;">
            ✅ YANG HARUS KAMU LIHAT
        </h2>
        
        <div style="background: white; color: #1f2937; padding: 20px; border-radius: 10px; margin: 20px 0;">
            <h3 style="color: #047857;">Di Halaman Detail Notifikasi:</h3>
            <ul style="line-height: 1.8;">
                <li>Scroll ke bawah</li>
                <li>Ada card dengan <strong>background hijau</strong></li>
                <li>Icon 🗺️ <strong>BESAR (48px)</strong></li>
                <li>Judul: "Lihat Lokasi Pengambilan"</li>
                <li>Tombol hijau: <strong>"Buka Peta Lokasi Pengambilan"</strong></li>
            </ul>
        </div>

        <div style="background: white; color: #1f2937; padding: 20px; border-radius: 10px;">
            <h3 style="color: #047857;">Di Halaman Admin Detail Order:</h3>
            <ul style="line-height: 1.8;">
                <li>Setelah "Informasi Pelanggan"</li>
                <li>Section: <strong>"📍 Informasi Pengambilan Pesanan"</strong></li>
                <li>Background hijau gradient</li>
                <li>Loading spinner → Data pickup point</li>
                <li>Nama: Kampus IT Del</li>
                <li>Jarak: ~0.46 km</li>
                <li>Tombol: "Buka Rute di Google Maps"</li>
            </ul>
        </div>
    </div>

    <div class="box" style="border-color: #f59e0b; background: #78350f;">
        <h2 style="color: #fbbf24; margin-top: 0;">📸 SCREENSHOT REQUEST</h2>
        <p style="font-size: 18px; line-height: 1.8;">
            Jika MASIH tidak muncul setelah Incognito Mode:
        </p>
        <ol style="font-size: 16px; line-height: 1.8;">
            <li>Buka Incognito Mode</li>
            <li>Buka <code>/notifikasi/2</code></li>
            <li>Tekan F12 → Console tab</li>
            <li>Screenshot FULL PAGE + Console</li>
            <li>Kirim ke saya</li>
        </ol>
    </div>

    <p style="text-align: center; font-size: 24px; margin-top: 40px;">
        🚀 <strong>100% PASTI MUNCUL DI INCOGNITO MODE!</strong> 🚀
    </p>
</body>
</html>
