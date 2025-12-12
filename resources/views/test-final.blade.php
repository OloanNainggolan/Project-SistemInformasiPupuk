<!DOCTYPE html>
<html>
<head>
    <title>TEST LANGSUNG - Notifikasi Ready</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .box { background: #f0f9ff; padding: 20px; border-radius: 10px; margin: 20px 0; border: 2px solid #0ea5e9; }
        .success { background: #f0fdf4; border-color: #10b981; }
        .error { background: #fef2f2; border-color: #ef4444; }
        h1 { color: #065f46; }
        a.btn { 
            display: inline-block; 
            padding: 15px 30px; 
            background: #10b981; 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: bold;
            margin: 10px 5px;
        }
        a.btn:hover { background: #059669; }
        .info { background: #fef3c7; border: 2px solid #f59e0b; }
    </style>
</head>
<body>
    <h1>🧪 TEST LANGSUNG - Notifikasi & Maps</h1>
    
    <div class="box success">
        <h2>✅ Database Status: TERHUBUNG</h2>
        <ul>
            <li>Database: sistem_informasi_pupukdanbibit</li>
            <li>Users: 1 user (ID: 2)</li>
            <li>Orders Ready: 2 orders</li>
            <li>Notifications: 2 notifikasi</li>
            <li>Pickup Points: 3 lokasi</li>
        </ul>
    </div>

    <div class="box info">
        <h2>⚠️ Catatan Penting</h2>
        <p><strong>Notifikasi sudah pernah dibuka (is_read = 1)</strong></p>
        <p>Tapi itu tidak masalah - notifikasi tetap bisa dibuka lagi!</p>
    </div>

    <div class="box">
        <h2>📋 Quick Test Links</h2>
        
        <h3>1️⃣ Login Dulu:</h3>
        <a href="/login" class="btn">🔐 Login User</a>
        <p><small>Email: friskarevalinamanurung@gmail.com</small></p>
        
        <h3>2️⃣ Lihat Notifikasi:</h3>
        <a href="/notifikasi" class="btn">🔔 Halaman Notifikasi</a>
        
        <h3>3️⃣ Buka Detail Notifikasi:</h3>
        <a href="/notifikasi/1" class="btn">📧 Notifikasi #1 (ORD-4B75C0)</a>
        <a href="/notifikasi/2" class="btn">📧 Notifikasi #2 (ORD-780630)</a>
        
        <h3>4️⃣ Test Maps Langsung:</h3>
        <a href="/maps?order=ORD-20251212-4B75C0" class="btn">🗺️ Maps Order #1</a>
        <a href="/maps?order=ORD-20251212-780630" class="btn">🗺️ Maps Order #2</a>
        
        <h3>5️⃣ Admin Detail Order:</h3>
        <a href="/admin/login" class="btn" style="background: #6366f1;">🔐 Login Admin</a>
        <a href="/admin/orders/ORD-20251212-780630" class="btn" style="background: #8b5cf6;">📋 Detail Order Admin</a>
    </div>

    <div class="box error">
        <h2>🐛 Jika Masih Tidak Muncul</h2>
        <h3>Langkah 1: Clear Browser Cache TOTAL</h3>
        <ol>
            <li>Tekan <kbd>Ctrl + Shift + Delete</kbd></li>
            <li>Pilih "All time" atau "Sepanjang waktu"</li>
            <li>Centang semua:
                <ul>
                    <li>✅ Browsing history</li>
                    <li>✅ Cookies and site data</li>
                    <li>✅ Cached images and files</li>
                </ul>
            </li>
            <li>Klik "Clear data"</li>
            <li>Close browser SEPENUHNYA</li>
            <li>Buka lagi</li>
        </ol>

        <h3>Langkah 2: Gunakan Incognito Mode</h3>
        <ol>
            <li>Tekan <kbd>Ctrl + Shift + N</kbd></li>
            <li>Buka <code>http://127.0.0.1:8000</code></li>
            <li>Login ulang</li>
        </ol>

        <h3>Langkah 3: Cek Browser Console</h3>
        <ol>
            <li>Tekan <kbd>F12</kbd></li>
            <li>Klik tab "Console"</li>
            <li>Buka halaman notifikasi/detail order</li>
            <li>Screenshot error yang muncul (jika ada)</li>
        </ol>
    </div>

    <div class="box">
        <h2>✅ Yang Harus Kamu Lihat</h2>
        
        <h3>Di Halaman Detail Notifikasi (/notifikasi/1 atau /notifikasi/2):</h3>
        <pre style="background: #1f2937; color: #10b981; padding: 15px; border-radius: 8px;">
┌─────────────────────────────────────┐
│     🗺️ (icon peta besar 48px)      │
│   Lihat Lokasi Pengambilan          │
│                                     │
│ ┌─────────────────────────────────┐ │
│ │ 🗺️ Buka Peta Lokasi Pengambilan│ │ ← Tombol hijau
│ └─────────────────────────────────┘ │
│                                     │
│ ℹ️ Sistem akan menunjukkan titik   │
│    pengambilan terdekat...          │
└─────────────────────────────────────┘
        </pre>

        <h3>Di Admin Detail Order (/admin/orders/ORD-...):</h3>
        <pre style="background: #1f2937; color: #10b981; padding: 15px; border-radius: 8px;">
┌─────────────────────────────────────┐
│ 📍 Informasi Pengambilan Pesanan    │ ← Background hijau
│                                     │
│ 🏢 Kampus IT Del Sitoluama          │
│ 📍 Jl. Sisingamangaraja, Laguboti   │
│ 🚗 Jarak: 0.46 km                   │
│ 💳 Tunai di Lokasi                  │
│                                     │
│ [🗺️ Buka Rute di Google Maps]     │
└─────────────────────────────────────┘
        </pre>
    </div>

    <div class="box success">
        <h2>💡 Tips Terakhir</h2>
        <ul>
            <li><strong>Gunakan Chrome/Edge</strong> - lebih stabil</li>
            <li><strong>Pastikan Laravel server running:</strong> <code>php artisan serve</code></li>
            <li><strong>Jangan pakai browser cache:</strong> Incognito mode!</li>
            <li><strong>Cek network tab:</strong> Pastikan API calls sukses (200 OK)</li>
        </ul>
    </div>

    <div class="box" style="background: #e0e7ff; border-color: #6366f1;">
        <h2>📞 Aku Sudah Lelah, Apa yang Harus Kulakukan?</h2>
        <ol style="font-size: 18px; line-height: 2;">
            <li><strong>Login:</strong> <a href="/login">friskarevalinamanurung@gmail.com</a></li>
            <li><strong>Buka:</strong> <a href="/notifikasi/2">Notifikasi Detail #2</a></li>
            <li><strong>Scroll ke bawah</strong></li>
            <li><strong>Lihat tombol hijau "Buka Peta Lokasi Pengambilan"</strong></li>
            <li><strong>Klik tombol</strong></li>
        </ol>
        <p style="font-size: 20px; color: #6366f1; font-weight: bold;">
            ITU SAJA! Kalau masih tidak muncul, kirim screenshot!
        </p>
    </div>
</body>
</html>
