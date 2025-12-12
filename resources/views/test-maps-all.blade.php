<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🗺️ MAPS FEATURE - TEST ALL ORDERS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: white;
            font-size: 42px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .subtitle {
            text-align: center;
            color: #e0e7ff;
            font-size: 18px;
            margin-bottom: 40px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #10b981;
        }
        .order-number {
            font-size: 16px;
            font-weight: 700;
            color: #047857;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-ready {
            background: #d1fae5;
            color: #065f46;
        }
        .status-processing {
            background: #e0e7ff;
            color: #5b21b6;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .info-item {
            margin: 12px 0;
            padding: 10px;
            background: #f9fafb;
            border-radius: 8px;
            font-size: 14px;
        }
        .info-label {
            color: #6b7280;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }
        .info-value {
            color: #1f2937;
            font-weight: 400;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }
        .btn-maps {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        .btn-maps:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(16, 185, 129, 0.6);
        }
        .btn-admin {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
        .btn-admin:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(59, 130, 246, 0.6);
        }
        .btn-notif {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }
        .btn-notif:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(245, 158, 11, 0.6);
        }
        .icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 15px;
        }
        .alert {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border-left: 5px solid #10b981;
        }
        .alert h3 {
            color: #047857;
            margin-bottom: 15px;
            font-size: 20px;
        }
        .alert ul {
            list-style-position: inside;
            color: #374151;
            line-height: 1.8;
        }
        .alert ul li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗺️ MAPS FEATURE TEST</h1>
        <p class="subtitle">Test Semua Pesanan dengan UI Maps Interaktif</p>

        <div class="alert">
            <h3>✅ FITUR YANG SUDAH DIIMPLEMENTASI:</h3>
            <ul>
                <li><strong>UI Maps di Detail Notifikasi User:</strong> Card hijau dengan tombol "Buka Peta Lokasi Pengambilan"</li>
                <li><strong>UI Maps di Detail Pesanan Admin:</strong> Section "Informasi Pengambilan Pesanan" dengan data pickup point terdekat</li>
                <li><strong>Notification Message:</strong> Instruksi lengkap cara akses maps untuk semua pesanan dengan status "Ready"</li>
                <li><strong>Auto-detect Pickup Point Terdekat:</strong> Berdasarkan koordinat customer (default: IT Del area)</li>
                <li><strong>Google Maps Integration:</strong> Link langsung ke rute Google Maps</li>
            </ul>
        </div>

        <div class="grid">
            <!-- Order 1: ORD-20251212-4B75C0 -->
            <div class="card">
                <div class="icon">📦</div>
                <div class="card-header">
                    <span class="order-number">ORD-20251212-4B75C0</span>
                    <span class="status-badge status-ready">✅ READY</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Produk:</span>
                    <span class="info-value">Pesanan #1</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Customer:</span>
                    <span class="info-value">User ID: 2</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">Ready (Pesanan Lama)</span>
                </div>
                <a href="/admin/orders/ORD-20251212-4B75C0" class="btn btn-admin">
                    👤 Admin Detail Order
                </a>
                <a href="/notifikasi/1" class="btn btn-notif">
                    📧 User Notification #1
                </a>
            </div>

            <!-- Order 2: ORD-20251212-780630 -->
            <div class="card">
                <div class="icon">📦</div>
                <div class="card-header">
                    <span class="order-number">ORD-20251212-780630</span>
                    <span class="status-badge status-ready">✅ READY</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Produk:</span>
                    <span class="info-value">Pesanan #2</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Customer:</span>
                    <span class="info-value">User ID: 2</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">Ready (Pesanan Lama)</span>
                </div>
                <a href="/admin/orders/ORD-20251212-780630" class="btn btn-admin">
                    👤 Admin Detail Order
                </a>
                <a href="/notifikasi/2" class="btn btn-notif">
                    📧 User Notification #2
                </a>
            </div>

            <!-- Order 3: ORD-20251212-E2BDCB -->
            <div class="card">
                <div class="icon">🆕</div>
                <div class="card-header">
                    <span class="order-number">ORD-20251212-E2BDCB</span>
                    <span class="status-badge status-ready">✅ READY</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Produk:</span>
                    <span class="info-value">pupuk oloban (2 kg)</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Customer:</span>
                    <span class="info-value">User ID: 2</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">Ready (BARU DIUPDATE!)</span>
                </div>
                <a href="/admin/orders/ORD-20251212-E2BDCB" class="btn btn-admin">
                    👤 Admin Detail Order
                </a>
                <a href="/notifikasi/6" class="btn btn-notif">
                    📧 User Notification #6 (LATEST!)
                </a>
            </div>

            <!-- Order 4: ORD-20251212-970F2F -->
            <div class="card">
                <div class="icon">🆕</div>
                <div class="card-header">
                    <span class="order-number">ORD-20251212-970F2F</span>
                    <span class="status-badge status-ready">✅ READY</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Produk:</span>
                    <span class="info-value">Pesanan #4</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Customer:</span>
                    <span class="info-value">User ID: 2</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">Ready (BARU DIUPDATE!)</span>
                </div>
                <a href="/admin/orders/ORD-20251212-970F2F" class="btn btn-admin">
                    👤 Admin Detail Order
                </a>
            </div>
        </div>

        <div class="alert" style="border-left-color: #f59e0b;">
            <h3>📋 CARA TEST:</h3>
            <ul>
                <li><strong>Hard Refresh:</strong> Tekan <code>Ctrl + Shift + R</code> sebelum test</li>
                <li><strong>Admin Detail:</strong> Klik tombol biru "Admin Detail Order" → Scroll ke bawah → Cari section "📍 Informasi Pengambilan Pesanan"</li>
                <li><strong>User Notification:</strong> Klik tombol orange "User Notification" → Scroll ke bawah → Cari card hijau dengan icon peta besar</li>
                <li><strong>Incognito Mode:</strong> Jika tidak muncul, buka di Incognito Mode (Ctrl + Shift + N)</li>
                <li><strong>Console Check:</strong> Tekan F12 → Tab Console → Cari log "🔍 Loading pickup points..."</li>
            </ul>
        </div>
    </div>
</body>
</html>
