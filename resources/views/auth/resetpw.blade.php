<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reset Password - Pupuk dan Bibit Bersubsidi</title>
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
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            animation: scaleIn 0.6s ease-out;
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f5f5f5;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            color: #424242;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .back-button:hover {
            background: #00897b;
            color: white;
            border-color: #00897b;
        }

        .reset-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .reset-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #00897b 0%, #00695c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .reset-icon i {
            font-size: 40px;
            color: white;
        }

        .reset-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #212121;
            margin-bottom: 10px;
        }

        .reset-header p {
            font-size: 15px;
            color: #757575;
            line-height: 1.6;
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
        }

        .alert.show {
            display: flex;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #66bb6a;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef5350;
        }

        .form-group {
            margin-bottom: 25px;
        }

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

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9e9e9e;
            font-size: 18px;
            pointer-events: none;
        }

        .input-wrapper input:focus ~ i {
            color: #00897b;
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
            box-shadow: 0 8px 20px rgba(0, 137, 123, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #00695c 0%, #004d40 100%);
            box-shadow: 0 12px 30px rgba(0, 137, 123, 0.4);
            transform: translateY(-2px);
        }

        .btn-primary:disabled {
            background: #bdbdbd;
            cursor: not-allowed;
            box-shadow: none;
        }

        .info-text {
            text-align: center;
            margin-top: 25px;
            color: #757575;
            font-size: 14px;
        }

        .info-text a {
            color: #00897b;
            text-decoration: none;
            font-weight: 600;
        }

        .info-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/login" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Login
        </a>

        <div class="reset-header">
            <div class="reset-icon">
                <i class="fas fa-key"></i>
            </div>
            <h2>Lupa Kata Sandi?</h2>
            <p>Masukkan email Anda dan kami akan mengirimkan link untuk mereset password Anda</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success show">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error show">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form action="/reset-password" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Masukkan email Anda"
                        value="{{ old('email') }}"
                        required
                    />
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i>
                Kirim Link Reset Password
            </button>

            <p class="info-text">
                Sudah ingat password? 
                <a href="/login">Login di sini</a>
            </p>
        </form>
    </div>
</body>
</html>