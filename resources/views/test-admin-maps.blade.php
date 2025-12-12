<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Admin Maps Integration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #f3f4f6;
        }
        .test-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            color: #065f46;
            border-bottom: 3px solid #10b981;
            padding-bottom: 10px;
        }
        h2 {
            color: #047857;
            margin-top: 0;
        }
        .status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 700;
            margin-left: 10px;
        }
        .status.ready {
            background: #d1fae5;
            color: #065f46;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn-primary {
            background: #10b981;
            color: white;
        }
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        .info-box {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 15px 0;
        }
        .checklist {
            background: #fef3c7;
            padding: 20px;
            border-radius: 8px;
        }
        .checklist li {
            margin: 10px 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <h1>🧪 Test Admin Maps Integration</h1>

    <div class="test-card">
        <h2>📋 Quick Links</h2>
        <a href="/admin/orders/ORD-20251212-780630" class="btn btn-primary">
            🔍 Lihat Detail Pesanan Ready #1
        </a>
        <a href="/admin/orders/ORD-20251212-970F2F" class="btn btn-primary">
            🔍 Lihat Detail Pesanan Ready #2
        </a>
        <a href="/admin/dashboard" class="btn btn-secondary">
            🏠 Admin Dashboard
        </a>
    </div>

    <div class="test-card">
        <h2>✅ Checklist Testing</h2>
        <div class="checklist">
            <strong>Test di Halaman Admin Detail Pesanan:</strong>
            <ul>
                <li>
                    <input type="checkbox" id="test1">
                    <label for="test1">Klik salah satu link "Lihat Detail Pesanan Ready" di atas</label>
                </li>
                <li>
                    <input type="checkbox" id="test2">
                    <label for="test2">Scroll ke bawah halaman detail pesanan</label>
                </li>
                <li>
                    <input type="checkbox" id="test3">
                    <label for="test3">Harus muncul section <strong>"Informasi Pengambilan Pesanan"</strong> dengan background hijau</label>
                </li>
                <li>
                    <input type="checkbox" id="test4">
                    <label for="test4">Ada loading spinner, lalu muncul info: Kampus IT Del, Alamat, Jarak ~0.46 km</label>
                </li>
                <li>
                    <input type="checkbox" id="test5">
                    <label for="test5">Ada tombol hijau <strong>"Buka Rute di Google Maps"</strong></label>
                </li>
                <li>
                    <input type="checkbox" id="test6">
                    <label for="test6">Klik tombol → terbuka Google Maps dengan rute</label>
                </li>
            </ul>
        </div>
    </div>

    <div class="test-card">
        <h2>📱 Test di Halaman User Notifikasi</h2>
        <div class="info-box">
            <strong>Langkah:</strong>
            <ol>
                <li>Login sebagai user (bukan admin)</li>
                <li>Pergi ke <strong>Notifikasi</strong></li>
                <li>Klik notifikasi yang judulnya mengandung kata <strong>"Siap"</strong> atau <strong>"Ready"</strong></li>
                <li>Di bagian bawah detail notifikasi, harus ada:</li>
                <ul>
                    <li>🗺️ Icon peta besar</li>
                    <li>Card hijau dengan judul "Lihat Lokasi Pengambilan"</li>
                    <li>Tombol besar "Buka Peta Lokasi Pengambilan"</li>
                </ul>
                <li>Klik tombol → redirect ke halaman maps dengan markers</li>
            </ol>
        </div>
    </div>

    <div class="test-card">
        <h2>🗺️ Test Halaman Maps</h2>
        <a href="/maps?order=ORD-20251212-780630" class="btn btn-primary">
            🗺️ Test Maps Page Langsung
        </a>
        <div class="info-box" style="margin-top: 15px;">
            <strong>Yang Harus Muncul:</strong>
            <ul>
                <li>Google Maps dengan 3 marker (Kampus IT Del, Mr.DIY Balige, RSUD Porsea)</li>
                <li>Marker biru: Lokasi user (default: Laguboti)</li>
                <li>Marker hijau bouncing: Pickup point terdekat</li>
                <li>Marker orange: Pickup points lainnya</li>
                <li>Garis polyline menunjukkan rute</li>
                <li>Tombol "Buka di Google Maps" di kanan atas</li>
                <li>Tombol "Gunakan Lokasi Saya" untuk GPS</li>
                <li>Legend di kiri bawah menjelaskan setiap marker</li>
            </ul>
        </div>
    </div>

    <div class="test-card">
        <h2>🐛 Troubleshooting</h2>
        <div class="info-box" style="background: #fee2e2; border-left-color: #ef4444;">
            <strong>Jika tidak muncul:</strong>
            <ol>
                <li><strong>Hard Refresh:</strong> Ctrl + Shift + R</li>
                <li><strong>Clear Browser Cache:</strong> Ctrl + Shift + Delete → Clear browsing data</li>
                <li><strong>Cek Console:</strong> F12 → tab Console → screenshot error</li>
                <li><strong>Test API:</strong> <a href="/test-api" style="color: #dc2626;">Buka /test-api</a> → klik "Test API"</li>
            </ol>
        </div>
    </div>

    <div class="test-card">
        <h2>📊 Database Verification</h2>
        <p>Run this in MySQL/phpMyAdmin:</p>
        <pre style="background: #1f2937; color: #10b981; padding: 15px; border-radius: 6px; overflow-x: auto;">
-- Check pickup points
SELECT * FROM pickup_points;

-- Check Ready orders
SELECT order_number, status, customer_name, customer_address 
FROM orders 
WHERE status = 'Ready';

-- Check latest notifications
SELECT id, title, SUBSTRING(message, 1, 100) as message_preview, created_at
FROM notifications 
WHERE title LIKE '%Siap%' OR message LIKE '%SIAP DIAMBIL%'
ORDER BY created_at DESC 
LIMIT 5;</pre>
    </div>

    <div class="test-card" style="background: #d1fae5; border: 2px solid #10b981;">
        <h2 style="margin-top: 0;">✅ Summary</h2>
        <p><strong>3 Fitur Utama yang Diimplementasikan:</strong></p>
        <ol>
            <li>📍 <strong>Admin Detail Order:</strong> Section pickup point untuk status Ready/Completed</li>
            <li>📧 <strong>Notification Message:</strong> Pesan notifikasi mencantumkan info "Lihat Lokasi Pengambilan"</li>
            <li>🗺️ <strong>User Notification Detail:</strong> Tombol maps besar di detail notifikasi Ready</li>
        </ol>
        <p style="margin-top: 20px; padding: 15px; background: white; border-radius: 6px;">
            <strong>⚠️ PENTING:</strong> Pastikan clear cache browser dan Laravel sebelum testing!<br>
            <code>php artisan view:clear && php artisan cache:clear</code>
        </p>
    </div>
</body>
</html>
