<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Step 3: Password Baru - Reset Password</title>
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

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }

        .toggle-password:hover {
            color: var(--green);
        }

        .form-group input {
            width: 100%;
            padding: 14px 45px 14px 45px;
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

        .password-strength {
            margin-top: 8px;
            font-size: 12px;
        }

        .strength-bar {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .strength-weak { width: 33%; background: #f44336; }
        .strength-medium { width: 66%; background: #ff9800; }
        .strength-strong { width: 100%; background: #4caf50; }

        .password-requirements {
            background: #f5f5f5;
            border-radius: 8px;
            padding: 12px 15px;
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }

        .password-requirements ul {
            margin: 5px 0 0 20px;
            padding: 0;
        }

        .password-requirements li {
            margin: 3px 0;
        }

        .requirement-met {
            color: var(--green);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <i class="fas fa-lock-open"></i>
            <h2>Step 3: Buat Password Baru</h2>
            <p>Masukkan password baru untuk akun Anda</p>
        </div>

        <div id="alertMessage"></div>
        <div id="loadingMessage" class="loading">
            <i class="fas fa-spinner fa-spin"></i> Mereset password...
        </div>

        <form id="resetForm">
            <input type="hidden" id="email" value="<?php echo e(request('email')); ?>">
            <input type="hidden" id="code" value="<?php echo e(request('code')); ?>">

            <div class="form-group">
                <label for="password">Password Baru</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        id="password" 
                        placeholder="Minimal 6 karakter"
                        required
                        autofocus
                    >
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthBar"></div>
                    </div>
                    <span id="strengthText"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        placeholder="Ketik ulang password"
                        required
                    >
                    <i class="fas fa-eye toggle-password" id="togglePasswordConfirm"></i>
                </div>
            </div>

            <div class="password-requirements">
                <strong>Persyaratan Password:</strong>
                <ul>
                    <li id="req-length">Minimal 6 karakter</li>
                    <li id="req-match">Password harus sama</li>
                </ul>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-save"></i> Reset Password
            </button>
        </form>

        <div class="back-link">
            <a href="/login"><i class="fas fa-arrow-left"></i> Kembali ke Login</a>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Password strength checker
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const length = password.length;
            
            strengthBar.className = 'strength-fill';
            
            if (length === 0) {
                strengthBar.style.width = '0';
                strengthText.textContent = '';
            } else if (length < 6) {
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = 'Lemah';
                strengthText.style.color = '#f44336';
            } else if (length < 10) {
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = 'Sedang';
                strengthText.style.color = '#ff9800';
            } else {
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = 'Kuat';
                strengthText.style.color = '#4caf50';
            }

            checkRequirements();
        });

        passwordConfirmInput.addEventListener('input', checkRequirements);

        function checkRequirements() {
            const password = passwordInput.value;
            const passwordConfirm = passwordConfirmInput.value;
            
            // Check length
            const reqLength = document.getElementById('req-length');
            if (password.length >= 6) {
                reqLength.classList.add('requirement-met');
                reqLength.innerHTML = '<i class="fas fa-check"></i> Minimal 6 karakter';
            } else {
                reqLength.classList.remove('requirement-met');
                reqLength.innerHTML = 'Minimal 6 karakter';
            }

            // Check match
            const reqMatch = document.getElementById('req-match');
            if (passwordConfirm && password === passwordConfirm) {
                reqMatch.classList.add('requirement-met');
                reqMatch.innerHTML = '<i class="fas fa-check"></i> Password harus sama';
            } else {
                reqMatch.classList.remove('requirement-met');
                reqMatch.innerHTML = 'Password harus sama';
            }
        }

        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            resetPassword();
        });

        function resetPassword() {
            const email = document.getElementById("email").value;
            const code = document.getElementById("code").value;
            const password = document.getElementById("password").value;
            const passwordConfirm = document.getElementById("password_confirmation").value;
            const alertDiv = document.getElementById("alertMessage");
            const loadingDiv = document.getElementById("loadingMessage");
            const submitBtn = document.getElementById("submitBtn");

            // Validasi
            if (password.length < 6) {
                showAlert('Password minimal 6 karakter', 'error');
                return;
            }

            if (password !== passwordConfirm) {
                showAlert('Konfirmasi password tidak sama', 'error');
                return;
            }

            // Show loading
            loadingDiv.classList.add('active');
            submitBtn.disabled = true;
            alertDiv.innerHTML = '';

            fetch('/api/v1/password/reset', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, code, password })
            })
            .then(res => res.json())
            .then(data => {
                loadingDiv.classList.remove('active');
                submitBtn.disabled = false;

                if (data.message === 'Password berhasil direset') {
                    showAlert('Password berhasil direset! Silakan login dengan password baru Anda.', 'success');
                    setTimeout(() => {
                        window.location.href = "/login";
                    }, 2000);
                } else {
                    showAlert(data.message || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                loadingDiv.classList.remove('active');
                submitBtn.disabled = false;
                showAlert('Terjadi kesalahan. Silakan coba lagi.', 'error');
                console.error('Error:', error);
            });
        }

        function showAlert(message, type) {
            const alertDiv = document.getElementById("alertMessage");
            alertDiv.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\Project-SistemInformasiPupuk\resources\views/auth/reset-password-new.blade.php ENDPATH**/ ?>