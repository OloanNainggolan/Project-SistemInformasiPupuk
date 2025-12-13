<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Step 2: Verifikasi Kode OTP - Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --green-dark: #184e2b;
            --green: #2f7d32;
            --green-2: #1f6b22;
        }

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
            padding: 40px 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            max-width: 450px;
            width: 100%;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header i {
            font-size: 50px;
            color: var(--green);
            margin-bottom: 15px;
        }

        .header h2 {
            color: var(--green-dark);
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: var(--green-dark);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--green);
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(47, 125, 50, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-2) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(47, 125, 50, 0.3);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: var(--green);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: none;
            text-align: center;
            color: var(--green);
        }

        .loading.active {
            display: block;
        }

        .info-box {
            background: #e8f5e9;
            border-left: 4px solid var(--green);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box p {
            color: #1b5e20;
            font-size: 13px;
            margin: 0;
        }

        .resend-code {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .resend-code button {
            background: none;
            border: none;
            color: var(--green);
            cursor: pointer;
            font-weight: 600;
            text-decoration: underline;
            padding: 0;
        }

        .resend-code button:hover {
            color: var(--green-dark);
        }

        .resend-code button:disabled {
            color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-key"></i>
            <h2>Step 2: Verifikasi Kode</h2>
            <p>Masukkan kode 6 digit yang telah dikirim ke email Anda</p>
        </div>

        <div class="info-box">
            <p><i class="fas fa-info-circle"></i> Kode akan kedaluwarsa dalam 5 menit</p>
        </div>

        <div id="alertMessage"></div>
        <div id="loadingMessage" class="loading">
            <i class="fas fa-spinner fa-spin"></i> Memverifikasi kode...
        </div>

        <form id="verifyForm">
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input 
                        type="email" 
                        id="email" 
                        placeholder="nama@email.com"
                        value="<?php echo e(request('email')); ?>"
                        readonly
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="code">Kode Verifikasi</label>
                <div class="input-wrapper">
                    <i class="fas fa-shield-alt"></i>
                    <input 
                        type="text" 
                        id="code" 
                        placeholder="Masukkan kode 6 digit"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        required
                        autofocus
                    >
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-check-circle"></i> Verify
            </button>
        </form>

        <div class="resend-code">
            <p>Tidak menerima kode? <button type="button" onclick="resendCode()" id="resendBtn">Kirim Ulang</button></p>
        </div>

        <div class="back-link">
            <a href="/reset-password-email"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <script>
        document.getElementById('verifyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            verifyCode();
        });

        // Auto-format input code
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function verifyCode() {
            const email = document.getElementById("email").value;
            const code = document.getElementById("code").value;
            const alertDiv = document.getElementById("alertMessage");
            const loadingDiv = document.getElementById("loadingMessage");
            const submitBtn = document.getElementById("submitBtn");

            if (!email || !code) {
                showAlert('Email dan kode harus diisi', 'error');
                return;
            }

            if (code.length !== 6) {
                showAlert('Kode harus 6 digit', 'error');
                return;
            }

            // Show loading
            loadingDiv.classList.add('active');
            submitBtn.disabled = true;
            alertDiv.innerHTML = '';

            fetch('/api/v1/password/verify-code', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, code })
            })
            .then(res => res.json())
            .then(data => {
                loadingDiv.classList.remove('active');
                submitBtn.disabled = false;

                if (data.message === "Kode valid") {
                    showAlert('Kode berhasil diverifikasi!', 'success');
                    setTimeout(() => {
                        window.location.href = "/reset-password-new?email=" + encodeURIComponent(email) + "&code=" + code;
                    }, 1000);
                } else {
                    showAlert(data.message || 'Kode tidak valid', 'error');
                }
            })
            .catch(error => {
                loadingDiv.classList.remove('active');
                submitBtn.disabled = false;
                showAlert('Terjadi kesalahan. Silakan coba lagi.', 'error');
                console.error('Error:', error);
            });
        }

        function resendCode() {
            const email = document.getElementById("email").value;
            const resendBtn = document.getElementById("resendBtn");
            
            resendBtn.disabled = true;
            resendBtn.textContent = 'Mengirim...';

            fetch('/api/v1/password/send-code', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(res => res.json())
            .then(data => {
                resendBtn.disabled = false;
                resendBtn.textContent = 'Kirim Ulang';
                showAlert(data.message || 'Kode berhasil dikirim ulang', 'success');
            })
            .catch(error => {
                resendBtn.disabled = false;
                resendBtn.textContent = 'Kirim Ulang';
                showAlert('Gagal mengirim ulang kode', 'error');
            });
        }

        function showAlert(message, type) {
            const alertDiv = document.getElementById("alertMessage");
            alertDiv.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\Project-SistemInformasiPupuk\resources\views/auth/reset-password-verify.blade.php ENDPATH**/ ?>