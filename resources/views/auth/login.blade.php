<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pupuk dan Bibit Bersubsidi Pemerintah – Masuk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Particles */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 137, 123, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 15s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 105, 92, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            animation: float 12s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
            animation: scaleIn 0.6s ease-out;
        }

        /* Left Side - Green */
        .left-side {
            background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
            animation: slideInLeft 0.8s ease-out;
        }

        .left-side::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -150px;
            right: -100px;
            animation: float 20s ease-in-out infinite;
        }

        .left-side::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -80px;
            animation: float 15s ease-in-out infinite reverse;
        }

        .logo-section {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo-circle {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: pulse 3s ease-in-out infinite;
            position: relative;
            overflow: hidden;
            padding: 0;
        }

        .logo-circle::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: rotate 3s linear infinite;
        }

        .logo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            z-index: 1;
            border-radius: 50%;
        }

        .logo-circle i {
            font-size: 70px;
            color: #00897b;
            position: relative;
            z-index: 1;
        }

        .left-side h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center;
            animation: slideInLeft 1s ease-out 0.3s both;
        }

        .left-side p {
            font-size: 16px;
            text-align: center;
            opacity: 0.95;
            line-height: 1.6;
            margin-bottom: 40px;
            animation: slideInLeft 1s ease-out 0.5s both;
        }

        .features {
            width: 100%;
            max-width: 350px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            margin-bottom: 15px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            animation: slideInLeft 0.6s ease-out both;
        }

        .feature-item:nth-child(1) { animation-delay: 0.7s; }
        .feature-item:nth-child(2) { animation-delay: 0.85s; }
        .feature-item:nth-child(3) { animation-delay: 1s; }
        .feature-item:nth-child(4) { animation-delay: 1.15s; }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .feature-item i {
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .feature-item:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        .feature-item span {
            font-size: 15px;
            font-weight: 500;
        }

        /* Right Side - Form */
        .right-side {
            background: white;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: slideInRight 0.8s ease-out;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            color: #424242;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .back-button:hover {
            background: #00897b;
            color: white;
            border-color: #00897b;
            transform: translateX(-3px);
            box-shadow: 0 4px 12px rgba(0, 137, 123, 0.3);
        }

        .form-header {
            margin-bottom: 35px;
            animation: slideInRight 1s ease-out 0.3s both;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #212121;
            margin-bottom: 10px;
        }

        .form-header p {
            font-size: 15px;
            color: #757575;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            animation: slideInRight 0.5s ease-out;
        }

        .alert.show {
            display: flex;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef5350;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #66bb6a;
        }

        .info-box {
            background: #fff3e0;
            border: 1px solid #ffb74d;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #e65100;
            animation: slideInRight 1s ease-out 0.5s both;
        }

        .info-box a {
            color: #00897b;
            font-weight: 600;
            text-decoration: none;
        }

        .info-box a:hover {
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 20px;
            animation: slideInRight 0.6s ease-out both;
        }

        .form-group:nth-child(1) { animation-delay: 0.7s; }
        .form-group:nth-child(2) { animation-delay: 0.85s; }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #424242;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            height: 50px;
            padding: 0 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            color: #212121;
            background: #fafafa;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-wrapper input:focus {
            background: white;
            border-color: #00897b;
            box-shadow: 0 0 0 4px rgba(0, 137, 123, 0.1);
        }

        .input-wrapper input.error {
            border-color: #ef5350;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9e9e9e;
            font-size: 18px;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-wrapper input:focus ~ i {
            color: #00897b;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9e9e9e;
            cursor: pointer;
            font-size: 18px;
            pointer-events: all;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            color: #00897b;
            transform: translateY(-50%) scale(1.1);
        }

        .error-msg {
            color: #c62828;
            font-size: 13px;
            margin-top: 5px;
            display: none;
            font-weight: 500;
        }

        .error-msg.show {
            display: block;
        }

        .btn-primary {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(0, 137, 123, 0.3);
            position: relative;
            overflow: hidden;
            animation: slideInRight 0.6s ease-out 1s both;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #00695c 0%, #004d40 100%);
            box-shadow: 0 12px 30px rgba(0, 137, 123, 0.4);
            transform: translateY(-2px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            background: #bdbdbd;
            cursor: not-allowed;
            box-shadow: none;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            animation: slideInRight 0.6s ease-out 1.1s both;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .divider span {
            padding: 0 15px;
            color: #9e9e9e;
            font-size: 13px;
        }

        /* Google Button - Authentic Style */
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
            animation: slideInRight 0.6s ease-out 1.2s both;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-google:hover {
            background: #f8f9fa;
            border-color: #d2d3d4;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-google:active {
            background: #f1f3f4;
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

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            animation: slideInRight 0.6s ease-out 1.3s both;
        }

        .links a {
            color: #00897b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #00695c;
            transition: width 0.3s ease;
        }

        .links a:hover {
            color: #00695c;
        }

        .links a:hover::after {
            width: 100%;
        }

        @media (max-width: 968px) {
            .container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .left-side {
                padding: 40px 30px;
            }

            .features {
                display: none;
            }

            .right-side {
                padding: 40px 30px;
            }
        }

        @media (max-width: 480px) {
            .right-side {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 26px;
            }

            .back-button {
                top: 10px;
                left: 10px;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <a href="/" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <div class="container">
        <!-- Left Side -->
        <div class="left-side">
            <div class="logo-section">
                <div class="logo-circle">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Pupuk & Bibit" />
                </div>
                <h1>Bergabung Bersama Kami</h1>
                <p>Akses mudah ke pupuk dan bibit subsidi berkualitas untuk meningkatkan hasil pertanian Anda</p>
            </div>

            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Harga Subsidi Terjangkau</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-leaf"></i>
                    <span>Produk Berkualitas Terjamin</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Proses Pemesanan Mudah</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-handshake"></i>
                    <span>Layanan Petani Indonesia</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="right-side">
            <div class="form-header">
                <h2>Masuk</h2>
                <p>Lengkapi data diri Anda untuk mendaftar</p>
            </div>

            <!-- Alerts -->
            @if($errors->any())
            <div class="alert alert-error show">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success show">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <!-- Info Box -->
            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <strong>Informasi:</strong> Halaman ini untuk user. Admin silakan ke 
                <a href="{{ route('admin.login') }}">halaman login admin</a>.
            </div>

            <!-- Form -->
            <form id="loginForm" action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="login">Username atau Email</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            placeholder="username atau email@example.com"
                            value="{{ old('login') }}"
                            required
                        />
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="error-msg" id="loginError"></div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password"
                            required
                        />
                        <i class="fas fa-lock"></i>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    <div class="error-msg" id="passwordError"></div>
                </div>

                <button type="submit" class="btn-primary" id="submitBtn">
                    <span id="btnText">Masuk Sekarang</span>
                    <span id="btnSpinner" style="display:none">
                        <i class="fas fa-spinner fa-spin"></i> Memproses...
                    </span>
                </button>

                <div class="divider">
                    <span>atau</span>
                </div>

                <a href="/auth/google" class="btn-google">
                    <div class="google-logo">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                    </div>
                    <span>Masuk dengan Google</span>
                </a>

                <div class="links">
                    <a href="/reset-password">Lupa Kata Sandi?</a>
                    <a href="{{ route('register') }}">Daftar Akun Baru</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Form validation
        const loginForm = document.getElementById('loginForm');
        const loginField = document.getElementById('login');
        const loginError = document.getElementById('loginError');
        const passwordError = document.getElementById('passwordError');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        loginForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Reset errors
            loginField.classList.remove('error');
            passwordField.classList.remove('error');
            loginError.classList.remove('show');
            passwordError.classList.remove('show');

            // Client-side validation
            if (!loginField.value.trim()) {
                loginField.classList.add('error');
                loginError.textContent = 'Username atau Email wajib diisi';
                loginError.classList.add('show');
                isValid = false;
            }

            if (!passwordField.value) {
                passwordField.classList.add('error');
                passwordError.textContent = 'Kata sandi wajib diisi';
                passwordError.classList.add('show');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            // Show loading state
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnSpinner.style.display = 'inline-block';
        });

        // Clear errors on input
        loginField.addEventListener('input', function() {
            this.classList.remove('error');
            loginError.classList.remove('show');
        });

        passwordField.addEventListener('input', function() {
            this.classList.remove('error');
            passwordError.classList.remove('show');
        });
    </script>
</body>
</html>
