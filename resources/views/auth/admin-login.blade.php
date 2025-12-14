<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin - Pupuk & Bibit Subsidi</title>
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
            background: radial-gradient(circle, rgba(0, 137, 123, 0.15) 0%, transparent 70%);
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
            background: radial-gradient(circle, rgba(0, 105, 92, 0.12) 0%, transparent 70%);
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

        @keyframes glowPulse {
            0%, 100% { 
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2),
                            0 0 40px rgba(0, 137, 123, 0.3);
            }
            50% { 
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3),
                            0 0 60px rgba(0, 137, 123, 0.5);
            }
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

        /* Left Side - Green Theme for Admin */
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
            background: rgba(255, 255, 255, 0.08);
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
            animation: pulse 3s ease-in-out infinite, glowPulse 3s ease-in-out infinite;
            position: relative;
            overflow: hidden;
            padding: 0;
        }

        .logo-circle::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, transparent, rgba(0, 137, 123, 0.5), transparent);
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
            background: linear-gradient(135deg, #00897b 0%, #26a69a 50%, #00897b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 2px 8px rgba(0, 137, 123, 0.3));
        }

        .admin-badge {
            display: inline-block;
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 25px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
            animation: slideInLeft 1s ease-out 0.2s both;
            box-shadow: 0 4px 15px rgba(0, 137, 123, 0.2);
        }

        .left-side h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center;
            animation: slideInLeft 1s ease-out 0.4s both;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .left-side p {
            font-size: 16px;
            text-align: center;
            opacity: 0.95;
            line-height: 1.6;
            margin-bottom: 40px;
            animation: slideInLeft 1s ease-out 0.6s both;
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
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            animation: slideInLeft 0.6s ease-out both;
        }

        .feature-item:nth-child(1) { animation-delay: 0.8s; }
        .feature-item:nth-child(2) { animation-delay: 0.95s; }
        .feature-item:nth-child(3) { animation-delay: 1.1s; }
        .feature-item:nth-child(4) { animation-delay: 1.25s; }

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
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-header h2 i {
            color: #00897b;
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

        .links {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            animation: slideInRight 0.6s ease-out 1.1s both;
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
        <!-- Left Side - Admin Branding -->
        <div class="left-side">
            <div class="logo-section">
                <div class="admin-badge">
                    <i class="fas fa-crown"></i> Administrator
                </div>
                <div class="logo-circle">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Pupuk & Bibit" />
                </div>
                <h1>Panel Admin</h1>
                <p>Sistem manajemen pupuk dan bibit bersubsidi. Akses khusus untuk administrator sistem</p>
            </div>

            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-cogs"></i>
                    <span>Kelola Sistem Lengkap</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <span>Manajemen Pengguna</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Monitoring Real-time</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Akses Aman Terlindungi</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Admin Login Form -->
        <div class="right-side">
            <div class="form-header">
                <h2>
                    <i class="fas fa-lock"></i>
                    Login Admin
                </h2>
                <p>Masukkan kredensial admin untuk mengakses panel</p>
            </div>

            <!-- Alerts -->
            @if($errors->any())
            <div class="alert alert-error show">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error show">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
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
                <strong>Perhatian:</strong> Halaman ini khusus untuk admin. 
                User biasa silakan ke <a href="/login">halaman login user</a>.
            </div>

            <!-- Admin Login Form -->
            <form id="adminLoginForm" action="/admin/login" method="POST">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Masukkan username admin"
                            value="{{ old('username') }}"
                            required
                        />
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="error-msg" id="usernameError"></div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password admin"
                            required
                        />
                        <i class="fas fa-key"></i>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    <div class="error-msg" id="passwordError"></div>
                </div>

                <button type="submit" class="btn-primary" id="submitBtn">
                    <span id="btnText">
                        <i class="fas fa-sign-in-alt"></i> Login sebagai Admin
                    </span>
                    <span id="btnSpinner" style="display:none">
                        <i class="fas fa-spinner fa-spin"></i> Memverifikasi...
                    </span>
                </button>

                <div class="links">
                    <a href="/login">
                        <i class="fas fa-user"></i> Login sebagai User Biasa
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Form validation
        const adminLoginForm = document.getElementById('adminLoginForm');
        const usernameField = document.getElementById('username');
        const usernameError = document.getElementById('usernameError');
        const passwordError = document.getElementById('passwordError');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        adminLoginForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Reset errors
            usernameField.classList.remove('error');
            passwordField.classList.remove('error');
            usernameError.classList.remove('show');
            passwordError.classList.remove('show');

            // Validate username
            if (!usernameField.value.trim()) {
                usernameField.classList.add('error');
                usernameError.textContent = 'Username admin wajib diisi';
                usernameError.classList.add('show');
                isValid = false;
            }

            // Validate password
            if (!passwordField.value) {
                passwordField.classList.add('error');
                passwordError.textContent = 'Password admin wajib diisi';
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
        usernameField.addEventListener('input', function() {
            this.classList.remove('error');
            usernameError.classList.remove('show');
        });

        passwordField.addEventListener('input', function() {
            this.classList.remove('error');
            passwordError.classList.remove('show');
        });
    </script>
</body>
</html>
