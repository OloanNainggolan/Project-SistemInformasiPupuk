<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Pupuk & Bibit Subsidi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .btn { 
            background: #2e8b57; color: white; padding: 12px 24px; 
            border: none; border-radius: 6px; cursor: pointer; font-weight: bold;
            text-decoration: none; display: inline-block;
        }
        .btn:hover { background: #1a5d1a; }
    </style>
</head>
<body>
    <!-- HEADER: Simple header without navigation -->
    @include('partials.header-home')

    @yield('content')

    <!-- Simple Footer for Home Page -->
    <footer style="background: #065f46; color: white; text-align: center; padding: 35px 20px; margin-top: 0;">
        <p style="font-size: 14px; margin: 0 0 8px 0;">&copy; {{ date('Y') }} Pupuk & Bibit Subsidi - Sistem Informasi Pemerintah. Semua hak cipta dilindungi.</p>
        <p style="font-size: 12px; margin: 0; opacity: 0.8;">INFORMATION SYSTEMS - Del Institute of Technology</p>
    </footer>
</body>
</html>
