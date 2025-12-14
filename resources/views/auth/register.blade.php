@extends('layouts.auth')
@section('title', 'Register')

@section('content')
    <style>
        :root {
            --green-dark: #065f46;
            --green: #059669;
            --green-2: #047857;
            --green-light: #10b981;
            --mint: #ecfdf5;
            --line: #d1d5db;
            --text: #111827;
            --muted: #6b7280;
            --white: #ffffff;
            --error: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overscroll-behavior: none;
            -webkit-overflow-scrolling: touch;
        }

        html::before {
            content: '';
            position: fixed;
            top: -100vh;
            left: 0;
            right: 0;
            height: 200vh;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            z-index: -2;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            z-index: -1;
        }

        /* Prevent white gaps during overscroll */
        html, body {
            overscroll-behavior: none;
            background-color: #ecfdf5;
        }

        html::before {
            content: '';
            position: fixed;
            top: -100vh;
            left: 0;
            right: 0;
            height: 200vh;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            z-index: -1;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
            min-height: 100dvh;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
            position: relative;
            overflow-x: hidden;
            overscroll-behavior: none;
        }

        html {
            height: 100%;
            min-height: 100vh;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            overscroll-behavior: none;
        }

        .register-wrapper {
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 45% 55%;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            animation: slideUp 0.6s ease;
            position: relative;
            z-index: 1;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-left {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .register-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .register-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .left-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .register-icon {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: float 3s ease-in-out infinite;
            overflow: hidden;
        }

        .register-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .left-content h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .left-content p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.95;
            margin-bottom: 30px;
        }

        .features {
            text-align: left;
            width: 100%;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .feature-item i {
            width: 24px;
            height: 24px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .register-right {
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
        }

        .back-link {
            position: absolute;
            top: 30px;
            left: 30px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border: 2px solid rgba(6, 95, 70, 0.2);
            border-radius: 50px;
            color: var(--green-dark);
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 10;
        }

        .back-link:hover {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color: white;
            border-color: var(--green);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5,150,105,0.3);
        }

        .back-link i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .back-link:hover i {
            transform: translateX(-3px);
        }

        .back-link span {
            display: block;
            letter-spacing: 0.5px;
        }

        .register-header {
            margin-bottom: 30px;
        }

        .register-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .register-header p {
            color: var(--muted);
            font-size: 14px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper input {
            flex: 1;
        }

        .input-wrapper i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 14px;
            width: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 38px;
            border: 2px solid var(--line);
            border-radius: 12px;
            font-size: 14px;
            color: var(--text);
            transition: all 0.3s ease;
            background: white;
            line-height: 1.2;
            text-align: left;
        }

        .form-group input::placeholder {
            color: #9ca3af;
            font-size: 14px;
            text-align: left;
            padding-left: 0;
            opacity: 0.8;
            text-indent: 0;
            margin-left: 0;
            position: relative;
            left: 0;
        }

        /* Pastikan placeholder dimulai dari posisi yang tepat */
        .input-wrapper input::placeholder {
            transform: translateX(0);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--green);
            background: var(--mint);
        }

        .form-group input:focus::placeholder {
            opacity: 0.6;
            color: #6b7280;
        }

        .input-wrapper:focus-within i {
            color: var(--green);
        }



        .form-group input.error {
            border-color: var(--error);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted);
            font-size: 15px;
            transition: all 0.3s ease;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .password-toggle:hover {
            color: var(--green);
            background: rgba(16, 185, 129, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(5,150,105,0.4);
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5,150,105,0.5);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e6e6e6;
        }

        .divider span {
            padding: 0 12px;
            color: #9aa0a6;
            font-size: 13px;
        }

        .btn-google {
            width: 100%;
            height: 52px;
            background: white;
            color: #3c4043;
            border: 1px solid #dadce0;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
            font-family: 'Google Sans', 'Roboto', sans-serif;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .btn-google:hover {
            background: #f8f9fa;
            border-color: #d2d3d4;
        }

        .google-logo {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .google-logo svg {
            width: 100%;
            height: 100%;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--muted);
        }

        .login-link a {
            color: var(--green);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            text-decoration: underline;
            color: var(--green-2);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .register-wrapper {
                grid-template-columns: 1fr;
            }

            .register-left {
                padding: 40px 30px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
                min-height: 100vh;
                min-height: -webkit-fill-available;
            }

            html {
                height: -webkit-fill-available;
            }

            .register-right {
                padding: 30px 25px;
            }

            .register-header h2 {
                font-size: 24px;
            }

            .left-content h1 {
                font-size: 26px;
            }

            .form-group input {
                font-size: 16px;
                padding: 15px 16px 15px 38px;
            }

            .form-group input::placeholder {
                font-size: 15px;
            }

            .input-wrapper i {
                font-size: 15px;
                width: 20px;
                left: 12px;
            }

            .password-toggle {
                font-size: 16px;
                width: 22px;
                height: 22px;
            }
        }
    </style>

    <div class="register-wrapper">
        <!-- Left Side - Welcome -->
        <div class="register-left">
            <div class="left-content">
                <div class="register-icon">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
                <h1>Bergabung Bersama Kami</h1>
                <p>Akses mudah ke pupuk dan bibit subsidi berkualitas untuk meningkatkan hasil pertanian Anda</p>
                
                <div class="features">
                    <div class="feature-item">
                        <i>✓</i>
                        <span>Harga Subsidi Terjangkau</span>
                    </div>
                    <div class="feature-item">
                        <i>✓</i>
                        <span>Produk Berkualitas Terjamin</span>
                    </div>
                    <div class="feature-item">
                        <i>✓</i>
                        <span>Proses Pemesanan Mudah</span>
                    </div>
                    <div class="feature-item">
                        <i>✓</i>
                        <span>Layanan Petani Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="register-right">
            <a href="{{ route('home') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>

            <div class="register-header">
                <h2>Buat Akun Baru</h2>
                <p>Lengkapi data diri Anda untuk mendaftar</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <ul style="margin: 8px 0 0 20px; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}" id="registerForm">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>No. Telepon</label>
                        <div class="input-wrapper">
                            <i class="fas fa-phone"></i>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" required placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" required placeholder="Jl. Nama Jalan, RT/RW, Kelurahan">
                    </div>
                </div>

                <div class="form-group">
                    <label>Balai Desa</label>
                    <div class="input-wrapper">
                        <i class="fas fa-building"></i>
                        <input type="text" name="alamat_balai_desa" value="{{ old('alamat_balai_desa') }}" required placeholder="Nama Balai Desa">
                    </div>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-circle"></i>
                        <input type="text" name="username" value="{{ old('username') }}" required placeholder="username (huruf, angka, underscore, dash)" pattern="[a-zA-Z0-9_-]+" title="Username hanya boleh mengandung huruf, angka, underscore (_), dan dash (-)">
                    </div>
                    <small style="color: #666; font-size: 0.85rem; margin-top: 4px; display: block;">
                        <i class="fas fa-info-circle"></i> Username akan digunakan untuk login
                    </small>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" required minlength="3" placeholder="Minimal 3 karakter">
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ketik ulang password">
                            <i class="fas fa-eye password-toggle" id="togglePasswordConfirm"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>

                <div class="divider">
                    <span>atau daftar dengan</span>
                </div>

                <a href="{{ route('auth.google') }}" class="btn-google">
                    <div class="google-logo">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </div>
                    <span>Daftar dengan Google</span>
                </a>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const password = document.getElementById('password_confirmation');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak sama!');
                return false;
            }
        });
    </script>
@endsection
