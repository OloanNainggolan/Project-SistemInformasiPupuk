<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>LANGSUNG KE NOTIFIKASI</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #667eea;
            text-align: center;
            margin-top: 0;
            font-size: 28px;
        }
        .big-text {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
            margin: 20px 0;
        }
        .step {
            background: #f0f9ff;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border-left: 5px solid #667eea;
        }
        .step h2 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 20px;
        }
        a.btn {
            display: block;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s;
        }
        a.btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        .warning {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .success {
            background: #d1fae5;
            border: 2px solid #10b981;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        code {
            background: #1f2937;
            color: #10b981;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🎯 BUKA HALAMAN NOTIFIKASI</h1>
        
        <div class="success">
            <p style="margin: 0; font-size: 16px; font-weight: bold;">✅ Syntax error sudah diperbaiki!</p>
            <p style="margin: 10px 0 0 0;">Sekarang tombol maps pasti muncul.</p>
        </div>

        <div class="big-text">
            <strong>Halaman yang benar adalah:</strong><br>
            <code>/notifikasi/1</code> atau <code>/notifikasi/2</code>
        </div>

        <div class="warning">
            <strong>⚠️ PENTING!</strong><br>
            Halaman <code>/maps?order=...</code> yang kamu buka tadi itu BUKAN halaman notifikasi!<br><br>
            Tombol maps ada di halaman <strong>DETAIL NOTIFIKASI</strong>.
        </div>

        <div class="step">
            <h2>1️⃣ Klik Tombol Ini:</h2>
            <a href="/notifikasi/2" class="btn">
                📧 BUKA DETAIL NOTIFIKASI #2
            </a>
            <p style="margin: 0; color: #6b7280; font-size: 14px;">
                Ini adalah halaman detail notifikasi untuk order ORD-20251212-780630
            </p>
        </div>

        <div class="step">
            <h2>2️⃣ Atau Notifikasi #1:</h2>
            <a href="/notifikasi/1" class="btn">
                📧 BUKA DETAIL NOTIFIKASI #1
            </a>
            <p style="margin: 0; color: #6b7280; font-size: 14px;">
                Untuk order ORD-20251212-4B75C0
            </p>
        </div>

        <div class="step">
            <h2>✅ Yang Harus Kamu Lihat:</h2>
            <div style="background: white; padding: 15px; border-radius: 8px; border: 2px dashed #10b981; margin-top: 10px;">
                <p style="margin: 0 0 10px 0; font-weight: bold; color: #047857;">Scroll ke bawah halaman notifikasi, akan ada:</p>
                <ul style="margin: 0; padding-left: 20px; color: #065f46;">
                    <li>Card dengan background hijau</li>
                    <li>Icon 🗺️ besar (48px)</li>
                    <li>Judul "Lihat Lokasi Pengambilan"</li>
                    <li>Tombol hijau "Buka Peta Lokasi Pengambilan"</li>
                </ul>
            </div>
        </div>

        <div class="warning" style="background: #fef2f2; border-color: #ef4444;">
            <strong>❌ Jangan Buka:</strong><br>
            <code>/maps?order=...</code> ← Ini langsung ke maps!<br><br>
            
            <strong>✅ Yang Benar:</strong><br>
            <code>/notifikasi/1</code> atau <code>/notifikasi/2</code> ← Detail notifikasi (ada tombol maps di sini!)
        </div>

        <div class="big-text" style="text-align: center; margin-top: 30px;">
            <p style="font-size: 24px; margin: 0;">👆</p>
            <p style="margin: 10px 0 0 0; font-weight: bold; color: #667eea;">
                Klik salah satu tombol di atas!
            </p>
        </div>
    </div>
</body>
</html>
