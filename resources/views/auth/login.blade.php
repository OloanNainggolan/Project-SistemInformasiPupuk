<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pupuk dan Bibit Bersubsidi Pemerintah – Masuk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root{
            --green-dark:#065f46;
            --green:#059669;
            --green-2:#047857;
            --green-light:#10b981;
            --mint:#ecfdf5;
            --line:#d1d5db;
            --text:#111827;
            --muted:#6b7280;
            --white:#ffffff;
            --error:#ef4444;
            --success:#10b981;
        }

        *{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%}
        body{
            margin:0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            color:var(--text);
            background:linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .wrap{
            min-height:100vh;
            display:grid;
            grid-template-columns: 1fr 1fr;
            animation: fadeIn 0.5s ease;
        }

        /* Kolom kiri */
        .left{
            background:linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:48px 24px;
            position:relative;
            overflow:hidden;
        }
        .left::before{
            content:'';
            position:absolute;
            top:-50%;
            right:-50%;
            width:200%;
            height:200%;
            background:radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .left-inner{
            text-align:center;
            max-width:420px;
            position:relative;
            z-index:1;
        }
        .brand{
            width:140px;
            height:140px;
            border-radius:50%;
            display:block;
            margin:0 auto 25px auto;
            object-fit:cover;
            background:white;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
            animation: slideIn 0.8s ease;
            overflow:hidden;
        }
        .title{
            font-size:28px;
            line-height:1.4;
            letter-spacing:.5px;
            font-weight:700;
            margin:0;
            text-shadow:2px 2px 4px rgba(0,0,0,0.2);
            animation: slideIn 1s ease;
        }
        .subtitle{
            margin-top:15px;
            font-size:16px;
            opacity:0.9;
            font-weight:400;
            animation: slideIn 1.2s ease;
        }

        /* Kolom kanan (form) */
        .right{
            background:transparent;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:40px 24px;
        }
        .card{
            width:100%;
            max-width:460px;
            background:white;
            padding:45px 40px;
            border-radius:20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.15);
            animation: slideIn 0.6s ease;
        }

        /* Tombol kembali */
        .back {
            position:fixed;
            top:30px;
            left:30px;
            z-index:9999;
            display:inline-flex;
            align-items:center;
            gap:10px;
            padding:12px 24px;
            background:linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border:2px solid rgba(6, 95, 70, 0.2);
            border-radius:50px;
            color:var(--green-dark);
            text-decoration:none;
            font-size:15px;
            font-weight:700;
            transition:all 0.3s ease;
            box-shadow:0 4px 15px rgba(0,0,0,.1);
        }
        .back:hover{
            background:linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color:white;
            border-color:var(--green);
            transform:translateY(-2px);
            box-shadow:0 8px 25px rgba(5,150,105,0.3);
        }
        .back svg{
            width:16px;
            height:16px;
            display:block;
            transition:transform 0.3s ease;
        }
        .back:hover svg{
            transform:translateX(-3px);
        }

        .form-header{
            text-align:center;
            margin-bottom:35px;
        }
        .wheat{
            width:48px;
            height:48px;
            display:block;
            margin:0 auto 15px auto;
            object-fit:cover;
            border-radius:50%;
            overflow:hidden;
        }
        .form-title{
            font-size:28px;
            font-weight:700;
            color:var(--green-dark);
            margin-bottom:8px;
        }
        .form-desc{
            font-size:14px;
            color:var(--muted);
        }

        .alert{
            padding:12px 16px;
            border-radius:10px;
            margin-bottom:20px;
            font-size:14px;
            font-weight:500;
            display:none;
            animation: slideIn 0.4s ease;
        }
        .alert.show{display:block}
        .alert-error{
            background:#fee2e2;
            color:#991b1b;
            border-left:4px solid var(--error);
        }
        .alert-success{
            background:#d1fae5;
            color:#065f46;
            border-left:4px solid var(--success);
        }

        form label{
            display:block;
            font-size:14px;
            color:var(--text);
            margin-bottom:8px;
            font-weight:600;
        }
        .input-group{
            margin-bottom:20px;
            position:relative;
        }
        .input-wrapper{
            position:relative;
        }
        .input-icon{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            color:var(--muted);
            font-size:18px;
        }
        .field{
            width:100%;
            height:48px;
            border:2px solid var(--line);
            border-radius:10px;
            background:white;
            padding:0 14px 0 44px;
            font-size:15px;
            outline:none;
            transition:all 0.3s ease;
            font-weight:500;
        }
        .field:focus{
            border-color:var(--green);
            box-shadow:0 0 0 4px rgba(5,150,105,0.1);
        }
        .field.error{
            border-color:var(--error);
        }
        .field-error-msg{
            color:var(--error);
            font-size:13px;
            margin-top:6px;
            display:none;
            font-weight:500;
        }
        .field-error-msg.show{
            display:block;
        }

        .toggle-password{
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
            cursor:pointer;
            color:var(--muted);
            font-size:18px;
            transition:color 0.3s ease;
        }
        .toggle-password:hover{
            color:var(--green);
        }

        .btn{
            width:100%;
            height:50px;
            border:none;
            border-radius:12px;
            font-weight:700;
            cursor:pointer;
            transition:all 0.3s ease;
            font-size:16px;
            letter-spacing:0.5px;
        }
        .btn:active{transform:translateY(2px)}
        .btn-primary{
            background:linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color:white;
            box-shadow:0 6px 20px rgba(5,150,105,0.4);
            margin-bottom:15px;
        }
        .btn-primary:hover{
            background:linear-gradient(135deg, var(--green-2) 0%, var(--green-dark) 100%);
            box-shadow:0 8px 25px rgba(5,150,105,0.5);
        }
        .btn-primary:disabled{
            background:#9ca3af;
            cursor:not-allowed;
            box-shadow:none;
        }
        .btn-ghost{
            background:white;
            color:#374151;
            border:2px solid var(--line);
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
        }
        .btn-ghost:hover{
            border-color:var(--green);
            background:#f9fafb;
        }
        .google-icon{
            width:20px; height:20px; object-fit:contain;
        }

        .divider{
            text-align:center;
            margin:25px 0;
            position:relative;
        }
        .divider::before{
            content:'';
            position:absolute;
            top:50%;
            left:0;
            right:0;
            height:1px;
            background:var(--line);
        }
        .divider span{
            background:white;
            padding:0 15px;
            color:var(--muted);
            font-size:13px;
            position:relative;
            z-index:1;
        }

        .links{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-top:20px;
        }
        .link{
            font-size:14px;
            color:var(--green);
            text-decoration:none;
            font-weight:600;
            transition:color 0.3s ease;
        }
        .link:hover{
            color:var(--green-dark);
            text-decoration:underline;
        }

        @media (max-width: 920px){
            .wrap{grid-template-columns:1fr}
            .left{order:2; padding:40px 20px; min-height:300px}
            .right{order:1; padding:32px 20px}
            .left-inner .title{font-size:24px}
            .brand{width:100px; height:100px}
            .back{top:10px; left:10px; padding:8px 12px}
            .card{padding:35px 25px}
        }

        @media (max-width: 480px){
            .form-title{font-size:24px}
            .card{padding:30px 20px}
        }
    </style>
</head>
<body>
    <div class="wrap">
        <!-- KIRI -->
        <aside class="left">
            <div class="left-inner">
                <img class="brand" src="{{ asset('images/logo.png') }}" alt="Logo Program" />
                <h1 class="title">
                    Pupuk dan Bibit Bersubsidi<br/>Pemerintah
                </h1>
                <p class="subtitle">
                    <i class="fas fa-seedling"></i> Mendukung Pertanian Indonesia
                </p>
            </div>
        </aside>

        <!-- KANAN -->
        <main class="right">
            <div class="card">
                <!-- Tombol kembali -->
                <a class="back" href="{{ route('home') }}">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kembali
                </a>

                <div class="form-header">
                    <h2 class="form-title">Selamat Datang!</h2>
                    <p class="form-desc">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <!-- Alert Messages -->
                @if($errors->any())
                <div class="alert alert-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success show">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
                @endif

                <div id="clientError" class="alert alert-error"></div>

                <!-- Form -->
                <form id="loginForm" action="{{ route('login') }}" method="POST" autocomplete="on">
                    @csrf

                    <div class="input-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                class="field" 
                                id="email" 
                                name="email" 
                                type="email" 
                                placeholder="nama@email.com" 
                                value="{{ old('email') }}"
                                required 
                            />
                        </div>
                        <div class="field-error-msg" id="emailError"></div>
                    </div>

                    <div class="input-group">
                        <label for="password">Kata Sandi</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                class="field" 
                                id="password" 
                                name="password" 
                                type="password" 
                                placeholder="Masukkan kata sandi" 
                                required 
                            />
                            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                        </div>
                        <div class="field-error-msg" id="passwordError"></div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span id="btnText">Masuk</span>
                        <i class="fas fa-spinner fa-spin" id="btnSpinner" style="display:none"></i>
                    </button>

                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <button type="button" class="btn btn-ghost">
                        <img class="google-icon" src="{{ asset('images/google.png') }}" alt="Google" />
                        Masuk dengan Google
                    </button>

                    <div class="links">
                        <a class="link" href="{{ route('password.reset') }}">Lupa Kata Sandi?</a>
                        <a class="link" href="{{ route('register') }}">Daftar Akun Baru</a>
                    </div>
                </form>
            </div>
        </main>
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
        const loginForm = document.getElementById('loginForm');
        const emailField = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const clientError = document.getElementById('clientError');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');

        loginForm.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Reset errors
            emailField.classList.remove('error');
            passwordField.classList.remove('error');
            emailError.classList.remove('show');
            passwordError.classList.remove('show');
            clientError.classList.remove('show');

            // Validate email
            const emailValue = emailField.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailValue) {
                emailField.classList.add('error');
                emailError.textContent = 'Email wajib diisi';
                emailError.classList.add('show');
                isValid = false;
            } else if (!emailRegex.test(emailValue)) {
                emailField.classList.add('error');
                emailError.textContent = 'Format email tidak valid';
                emailError.classList.add('show');
                isValid = false;
            }

            // Validate password
            const passwordValue = passwordField.value;
            if (!passwordValue) {
                passwordField.classList.add('error');
                passwordError.textContent = 'Kata sandi wajib diisi';
                passwordError.classList.add('show');
                isValid = false;
            } else if (passwordValue.length < 3) {
                passwordField.classList.add('error');
                passwordError.textContent = 'Kata sandi minimal 3 karakter';
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

        // Clear error on input
        emailField.addEventListener('input', function() {
            this.classList.remove('error');
            emailError.classList.remove('show');
        });

        passwordField.addEventListener('input', function() {
            this.classList.remove('error');
            passwordError.classList.remove('show');
        });
    </script>
</body>
</html>
