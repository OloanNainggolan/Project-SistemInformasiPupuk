<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Pupuk & Bibit Subsidi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* CSS Variables - Mengikuti tema user login */
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
            --gold: #fbbf24;
        }

        /* Reset & Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: var(--text);
        }

        /* Animations */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        /* Main Container - Grid Layout seperti user login */
        .wrap {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            animation: fadeIn 0.5s ease;
        }

        /* Left Column - Admin Branding */
        .left {
            background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            position: relative;
            overflow: hidden;
        }

        .left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        /* Floating particles animation */
        .left::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.15) 2px, transparent 2px),
                radial-gradient(circle at 60% 30%, rgba(255,255,255,0.1) 3px, transparent 3px),
                radial-gradient(circle at 80% 70%, rgba(255,255,255,0.12) 2px, transparent 2px),
                radial-gradient(circle at 40% 80%, rgba(255,255,255,0.08) 4px, transparent 4px);
            background-size: 200% 200%;
            animation: floatParticles 15s ease-in-out infinite;
        }

        @keyframes floatParticles {
            0%, 100% { 
                background-position: 0% 0%, 100% 100%, 50% 50%, 75% 25%; 
            }
            25% { 
                background-position: 100% 0%, 0% 100%, 25% 75%, 50% 50%; 
            }
            50% { 
                background-position: 100% 100%, 0% 0%, 75% 25%, 25% 75%; 
            }
            75% { 
                background-position: 0% 100%, 100% 0%, 50% 50%, 75% 75%; 
            }
        }

        .left-inner {
            text-align: center;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        /* Admin Shield Icon with glow effect */
        .admin-shield-wrapper {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px auto;
            background: white;
            box-shadow: 
                0 10px 30px rgba(0,0,0,0.3),
                0 0 40px rgba(251, 191, 36, 0.3);
            animation: slideIn 0.8s ease, glowPulse 3s ease-in-out infinite;
            position: relative;
        }

        .admin-shield-wrapper::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--gold), #f59e0b, var(--gold));
            background-size: 200% 200%;
            animation: rotateBorder 3s linear infinite;
            z-index: -1;
            opacity: 0.6;
        }

        @keyframes glowPulse {
            0%, 100% { 
                box-shadow: 
                    0 10px 30px rgba(0,0,0,0.3),
                    0 0 40px rgba(251, 191, 36, 0.3);
            }
            50% { 
                box-shadow: 
                    0 15px 40px rgba(0,0,0,0.4),
                    0 0 60px rgba(251, 191, 36, 0.5);
            }
        }

        @keyframes rotateBorder {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .admin-shield {
            font-size: 70px;
            background: linear-gradient(135deg, var(--gold) 0%, #f59e0b 50%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: pulse 2s ease-in-out infinite;
            filter: drop-shadow(0 2px 8px rgba(251, 191, 36, 0.4));
        }

        .brand-title {
            font-size: 28px;
            line-height: 1.4;
            letter-spacing: 0.5px;
            font-weight: 700;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
            animation: slideIn 1s ease;
            background: linear-gradient(to right, #ffffff, #f0fdf4, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% auto;
            animation: slideIn 1s ease, shimmerText 3s linear infinite;
        }

        @keyframes shimmerText {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        .brand-subtitle {
            margin-top: 15px;
            font-size: 16px;
            opacity: 0.9;
            font-weight: 400;
            animation: slideIn 1.2s ease;
        }

        .admin-badge {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 24px;
            background: rgba(251, 191, 36, 0.15);
            border: 2px solid var(--gold);
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            animation: slideIn 1.4s ease, badgeGlow 2s ease-in-out infinite;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.2);
        }

        @keyframes badgeGlow {
            0%, 100% { 
                box-shadow: 0 4px 15px rgba(251, 191, 36, 0.2);
                border-color: var(--gold);
            }
            50% { 
                box-shadow: 0 6px 25px rgba(251, 191, 36, 0.4);
                border-color: #fbbf24;
            }
        }

        /* Decorative elements on left */
        .deco-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 6s ease-in-out infinite;
        }

        .deco-circle:nth-child(1) {
            width: 60px;
            height: 60px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .deco-circle:nth-child(2) {
            width: 40px;
            height: 40px;
            top: 70%;
            left: 15%;
            animation-delay: 1s;
        }

        .deco-circle:nth-child(3) {
            width: 50px;
            height: 50px;
            top: 30%;
            right: 10%;
            animation-delay: 2s;
        }

        .deco-circle:nth-child(4) {
            width: 35px;
            height: 35px;
            bottom: 15%;
            right: 20%;
            animation-delay: 1.5s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0) scale(1);
                opacity: 0.3;
            }
            50% { 
                transform: translateY(-20px) scale(1.1);
                opacity: 0.6;
            }
        }

        /* Right Column - Form */
        .right {
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            position: relative;
        }

        /* Subtle background pattern */
        .right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                linear-gradient(45deg, transparent 48%, rgba(6, 95, 70, 0.02) 49%, rgba(6, 95, 70, 0.02) 51%, transparent 52%),
                linear-gradient(-45deg, transparent 48%, rgba(6, 95, 70, 0.02) 49%, rgba(6, 95, 70, 0.02) 51%, transparent 52%);
            background-size: 40px 40px;
            opacity: 0.5;
        }

        .card {
            width: 100%;
            max-width: 460px;
            background: white;
            padding: 45px 40px;
            border-radius: 20px;
            box-shadow: 
                0 20px 60px rgba(0,0,0,0.15),
                0 0 0 1px rgba(6, 95, 70, 0.05) inset;
            animation: slideIn 0.6s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--green-dark), var(--green), var(--gold), var(--green), var(--green-dark));
            background-size: 200% 100%;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Back Button */
        .back {
            position: fixed;
            top: 30px;
            left: 30px;
            z-index: 9999;
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
            box-shadow: 0 4px 15px rgba(0,0,0,.1);
        }

        .back:hover {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color: white;
            border-color: var(--green);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5,150,105,0.3);
        }

        .back i {
            transition: transform 0.3s ease;
        }

        .back:hover i {
            transform: translateX(-3px);
        }

        /* Form Header */
        .form-header {
            text-align: center;
            margin-bottom: 35px;
            position: relative;
        }

        .form-header::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--green), transparent);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 8px;
            position: relative;
            display: inline-block;
        }

        .form-title::before {
            content: '🛡️';
            margin-right: 10px;
            font-size: 24px;
            vertical-align: middle;
        }

        .form-desc {
            font-size: 14px;
            color: var(--muted);
        }

        /* Alert Messages - Konsisten dengan user login */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.4s ease;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--error);
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-info {
            background: #dbeafe;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
        }

        .alert i {
            font-size: 18px;
        }

        /* Form Elements - Sama seperti user login */
        form label {
            display: block;
            font-size: 14px;
            color: var(--text);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .field {
            width: 100%;
            height: 48px;
            border: 2px solid var(--line);
            border-radius: 10px;
            background: white;
            padding: 0 14px 0 44px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .field:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 4px rgba(5,150,105,0.1);
            transform: translateY(-1px);
        }

        .field:focus + .input-icon {
            color: var(--green);
            transform: translateY(-50%) scale(1.1);
        }

        .field.error {
            border-color: var(--error);
        }

        .field-error-msg {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
            display: none;
            font-weight: 500;
        }

        .field-error-msg.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        /* Buttons - Tema hijau */
        .btn {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn:active {
            transform: translateY(2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(5,150,105,0.4);
            margin-bottom: 15px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--green-2) 0%, var(--green-dark) 100%);
            box-shadow: 0 8px 25px rgba(5,150,105,0.5);
            transform: translateY(-2px);
        }

        .btn-primary:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            box-shadow: none;
        }

        .btn-primary span,
        .btn-primary i {
            position: relative;
            z-index: 1;
        }

        /* Info Boxes */
        .info-box {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .credentials-info {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #7dd3fc;
            color: #0c4a6e;
        }

        .credentials-info strong {
            color: #075985;
        }

        .user-info {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid var(--gold);
            color: #78350f;
        }

        .user-info a {
            color: var(--green-dark);
            font-weight: 700;
            text-decoration: none;
            border-bottom: 2px solid var(--green);
            transition: all 0.3s;
            padding-bottom: 1px;
        }

        .user-info a:hover {
            color: var(--green-2);
            border-bottom-color: var(--green-2);
        }

        /* Already Logged In Box */
        .already-logged-in {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border: 2px solid var(--green-light);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            text-align: center;
        }

        .already-logged-in h3 {
            color: var(--green-dark);
            font-size: 20px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .already-logged-in p {
            color: var(--green-2);
            font-size: 15px;
            margin-bottom: 18px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-dashboard {
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color: white;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-dashboard:hover {
            background: linear-gradient(135deg, var(--green-2) 0%, var(--green-dark) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }

        .btn-logout {
            padding: 12px 24px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 28px 0;
            padding-top: 24px;
            border-top: 2px solid var(--line);
            color: var(--muted);
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .wrap {
                grid-template-columns: 1fr;
            }

            .left {
                min-height: 300px;
                padding: 36px 20px;
            }

            .brand-title {
                font-size: 24px;
            }

            .card {
                padding: 35px 30px;
            }

            .back {
                top: 20px;
                left: 20px;
                padding: 10px 18px;
                font-size: 14px;
            }
        }

        @media (max-width: 500px) {
            .admin-shield-wrapper {
                width: 100px;
                height: 100px;
            }

            .admin-shield {
                font-size: 50px;
            }

            .left {
                min-height: 250px;
            }

            .card {
                padding: 30px 25px;
            }

            .form-title {
                font-size: 24px;
            }

            .btn {
                height: 48px;
                font-size: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-dashboard,
            .btn-logout {
                width: 100%;
            }
        }

        /* Loading Animation */
        .btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <a href="{{ route('home') }}" class="back">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>

    <div class="wrap">
        <!-- Left Column - Admin Branding -->
        <div class="left">
            <!-- Decorative floating circles -->
            <div class="deco-circle"></div>
            <div class="deco-circle"></div>
            <div class="deco-circle"></div>
            <div class="deco-circle"></div>
            
            <div class="left-inner">
                <div class="admin-shield-wrapper">
                    <i class="fas fa-user-shield admin-shield"></i>
                </div>
                <h1 class="brand-title">Panel Admin</h1>
                <p class="brand-subtitle">Sistem Informasi Pupuk & Bibit Subsidi Pemerintah</p>
                <div class="admin-badge">
                    <i class="fas fa-crown"></i> Administrator Access
                </div>
            </div>
        </div>

        <!-- Right Column - Form -->
        <div class="right">
            <div class="card">
                <div class="form-header">
                    <h2 class="form-title">Login Admin</h2>
                    <p class="form-desc">Masukkan kredensial admin untuk melanjutkan</p>
                </div>

                @if(session('admin_logged_in'))
                <!-- Already Logged In Notice -->
                <div class="already-logged-in">
                    <h3>
                        <i class="fas fa-check-circle"></i>
                        Anda Sudah Login!
                    </h3>
                    <p>
                        <i class="fas fa-user"></i> <strong>{{ session('admin_username') }}</strong>
                        <br>
                        <small style="color: var(--green-2);">Login sejak: {{ session('admin_login_time') ? \Carbon\Carbon::parse(session('admin_login_time'))->locale('id')->diffForHumans() : 'Baru saja' }}</small>
                    </p>
                    <div class="action-buttons">
                        <a href="{{ route('admin.overview') }}" class="btn-dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            Ke Dashboard
                        </a>
                        <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
                @endif

                @if(!session('admin_logged_in'))
                <!-- Info untuk User (tanpa kredensial admin) -->
                <div class="info-box user-info">
                    <i class="fas fa-user"></i>
                    Bukan admin? Silakan login sebagai 
                    <a href="{{ route('login') }}">user biasa di sini</a>.
                </div>

                <form action="{{ route('admin.login.process') }}" method="POST" id="loginForm">
                    @csrf
                    
                    <!-- Username/Email -->
                    <div class="input-group">
                        <label for="username">
                            <i class="fas fa-user-circle" style="margin-right: 6px;"></i>
                            Username / Email
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="field" 
                                placeholder="Masukkan username atau email"
                                value="{{ old('username') }}"
                                required
                                autofocus
                            >
                        </div>
                        @error('username')
                            <div class="field-error-msg show">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label for="password">
                            <i class="fas fa-lock" style="margin-right: 6px;"></i>
                            Password
                        </label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="field" 
                                placeholder="Masukkan password"
                                required
                            >
                        </div>
                        @error('password')
                            <div class="field-error-msg show">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login Sekarang</span>
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>

    <script>
        // Form submission loading state (only if form exists)
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                const btn = document.getElementById('submitBtn');
                btn.classList.add('loading');
                const icon = btn.querySelector('i');
                const text = btn.querySelector('span');
                
                icon.classList.remove('fa-sign-in-alt');
                icon.classList.add('fa-spinner');
                text.textContent = 'Memproses...';
                
                btn.disabled = true;
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s, transform 0.5s';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Input field animations
        document.querySelectorAll('.field').forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            field.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Ripple effect on button
        const btn = document.querySelector('.btn-primary');
        if (btn) {
            btn.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        }
    </script>
</body>
</html>
