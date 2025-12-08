<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Pupuk & Bibit Subsidi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global-standards.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background: #f5f5f5; color: #333; padding-top: 100px; } /* offset for fixed header */
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        header {
            display:flex;
            align-items:center;
            justify-content:flex-start;
            background-color:#155d27;
            padding:15px 80px;
            color:white;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            z-index:1000;
        }
        .btn { 
            background: #004d00; color: white; padding: 12px 24px; 
            border: none; border-radius: 6px; cursor: pointer; font-weight: bold;
            text-decoration: none; display: inline-block;
        }
        
        .btn:hover { background: #004d00; }
        .btn-success { background: #003300; }
        .btn-sm { padding: 8px 16px; font-size: 0.9rem; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; }
        .form-group input, .form-group select {
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 1rem;
        }
        .text-center { text-align: center; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        footer { background: #004d00; color: white; text-align: center; padding: 20px; margin-top: 40px; }
        .alert { padding: 12px; border-radius: 6px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #004d00; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <!-- HEADER: included partial for consistent navigation -->
    @include('partials.header')

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Sistem Informasi Pupuk & Bibit. Semua hak cipta dilindungi.</p>
    </footer>
</body>
</html>