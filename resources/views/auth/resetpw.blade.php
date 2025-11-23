<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reset Password | Pupuk & Bibit Subsidi</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
  />
  <style>
    :root {
      --primary-green: #059669;
      --dark-green: #065f46;
      --light-green: #10b981;
      --gradient-start: #ecfdf5;
      --gradient-end: #d1fae5;
      --white: #ffffff;
      --text-color: #1f2937;
      --border-color: #d1d5db;
      --error-red: #ef4444;
      --success-green: #10b981;
      --font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Reset dasar */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-family);
      background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
      color: var(--text-color);
      line-height: 1.6;
      min-height: 100vh;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.02); }
    }

    .container {
      max-width: 1200px;
      width: 90%;
      margin: 0 auto;
    }

    a {
      color: inherit;
      text-decoration: none;
    }
    ul {
      list-style: none;
    }

    /* Tombol kembali */
    .back-btn {
      position: fixed;
      top: 25px;
      left: 25px;
      z-index: 9999;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      background: white;
      border-radius: 50px;
      box-shadow: 0 8px 20px rgba(0,0,0,.12);
      color: #374151;
      text-decoration: none;
      font-size: 15px;
      font-weight: 700;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      animation: slideIn 0.6s ease;
    }
    .back-btn:hover {
      background: linear-gradient(135deg, var(--primary-green), var(--light-green));
      color: white;
      transform: translateX(-8px) scale(1.05);
      box-shadow: 0 12px 30px rgba(5,150,105,0.3);
    }
    .back-btn i {
      font-size: 18px;
      transition: transform 0.3s ease;
    }
    .back-btn:hover i {
      transform: translateX(-3px);
    }

    /* Reset Password Section */
    .reset-password-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 80px 20px;
    }

    .reset-password-container {
      background: white;
      padding: 50px 45px;
      border-radius: 30px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
      max-width: 520px;
      width: 100%;
      margin: 0 auto;
      text-align: center;
      color: var(--text-color);
      position: relative;
      overflow: hidden;
      animation: fadeIn 0.8s ease;
    }

    .reset-password-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, var(--primary-green), var(--light-green), var(--primary-green));
      background-size: 200% 100%;
      animation: gradientMove 3s linear infinite;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .reset-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 25px;
      background: linear-gradient(135deg, var(--primary-green), var(--light-green));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 30px rgba(5,150,105,0.3);
      animation: pulse 2s ease-in-out infinite;
    }

    .reset-icon i {
      font-size: 40px;
      color: white;
    }

    .reset-password-container h2 {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 15px;
      background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .reset-password-container p {
      font-size: 1.05rem;
      color: #6b7280;
      margin-bottom: 35px;
      line-height: 1.7;
    }

    .form-group {
      margin-bottom: 25px;
      text-align: left;
    }
    .form-group label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 700;
      margin-bottom: 10px;
      font-size: 15px;
      color: var(--text-color);
    }
    .form-group label i {
      color: var(--primary-green);
      font-size: 16px;
    }
    .input-wrapper {
      position: relative;
    }
    .form-group input {
      width: 100%;
      padding: 16px 20px;
      font-size: 16px;
      border: 2px solid var(--border-color);
      border-radius: 15px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 500;
      color: var(--text-color);
      background: #f9fafb;
    }
    .form-group input::placeholder {
      color: #9ca3af;
    }
    .form-group input:focus {
      outline: none;
      border-color: var(--primary-green);
      background: white;
      box-shadow: 0 0 0 4px rgba(5,150,105,0.1);
      transform: translateY(-2px);
    }

    .error-message {
      color: var(--error-red);
      font-size: 14px;
      margin-top: 8px;
      display: none;
      font-weight: 600;
      padding: 10px 15px;
      background: #fee2e2;
      border-radius: 10px;
      border-left: 4px solid var(--error-red);
      text-align: left;
      animation: fadeIn 0.3s ease;
    }

    .error-message i {
      margin-right: 6px;
    }

    .cta-button {
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%);
      color: white;
      font-size: 17px;
      font-weight: 700;
      padding: 18px;
      border: none;
      border-radius: 50px;
      width: 100%;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 10px 30px rgba(5,150,105,0.4);
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-top: 10px;
      position: relative;
      overflow: hidden;
    }

    .cta-button::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    .cta-button:hover::before {
      width: 400px;
      height: 400px;
    }

    .cta-button:hover {
      transform: translateY(-5px) scale(1.02);
      box-shadow: 0 15px 40px rgba(5,150,105,0.5);
    }

    .cta-button:active {
      transform: translateY(-2px) scale(1);
    }

    .back-to-login {
      text-align: center;
      margin-top: 25px;
    }
    .back-to-login a {
      font-weight: 600;
      font-size: 0.95rem;
      color: var(--primary-green);
      transition: color 0.3s ease;
    }
    .back-to-login a:hover {
      text-decoration: underline;
      color: #0c3f07;
    }

    /* Responsif */
    @media (max-width: 768px) {
      .reset-password-section {
        padding: 60px 20px;
      }

      .reset-password-container {
        padding: 40px 30px;
        max-width: 95%;
      }

      .reset-password-container h2 {
        font-size: 2rem;
      }

      .back-btn {
        top: 15px;
        left: 15px;
        padding: 10px 16px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      .reset-password-container {
        padding: 35px 25px;
      }

      .reset-password-container h2 {
        font-size: 1.8rem;
      }

      .reset-icon {
        width: 70px;
        height: 70px;
      }

      .reset-icon i {
        font-size: 35px;
      }

      .cta-button {
        font-size: 15px;
        padding: 16px;
      }
    }
  </style>
</head>
<body>
  <!-- Tombol kembali ke login -->
  <a href="{{ route('login') }}" class="back-btn">
    <i class="fas fa-arrow-left"></i>
    Kembali ke Login
  </a>

  <!-- Reset Password -->
  <section class="reset-password-section">
    <div class="container">
      <div class="reset-password-container" role="main" aria-label="Reset Password Form">
        <div class="reset-icon">
          <i class="fas fa-key"></i>
        </div>
        <h2>Reset Password</h2>
        <p>
          Masukkan alamat email dan password baru Anda untuk mereset akun.
        </p>
        <form id="reset-form" action="{{ route('password.reset.post') }}" method="post" novalidate>
          @csrf
          <div class="form-group">
            <label for="email">
              <i class="fas fa-envelope"></i>
              Alamat Email
            </label>
            <div class="input-wrapper">
              <input
                type="email"
                id="email"
                name="email"
                placeholder="contoh@email.com"
                required
                autocomplete="email"
              />
            </div>
          </div>
          <div class="form-group">
            <label for="new-password">
              <i class="fas fa-lock"></i>
              Password Baru
            </label>
            <div class="input-wrapper">
              <input
                type="password"
                id="new-password"
                name="new_password"
                placeholder="Minimal 4 karakter (huruf + angka)"
                minlength="4"
                required
                autocomplete="new-password"
              />
            </div>
          </div>
          <div class="form-group">
            <label for="confirm-password">
              <i class="fas fa-lock-open"></i>
              Konfirmasi Password
            </label>
            <div class="input-wrapper">
              <input
                type="password"
                id="confirm-password"
                name="new_password_confirmation"
                placeholder="Ulangi password baru"
                minlength="4"
                required
                autocomplete="new-password"
              />
            </div>
            <div class="error-message" id="password-error" aria-live="polite">
              <i class="fas fa-exclamation-circle"></i>
              Password tidak cocok. Silakan coba lagi.
            </div>
          </div>
          <button type="submit" class="cta-button">
            <span>Reset Password</span>
          </button>
        </form>
      </div>
    </div>
  </section>
  @include('partials.footer')

  <script>
    // Script validasi password konfirmasi and redirect to login on success
    (function(){
      const form = document.getElementById("reset-form");
      const newPasswordInput = document.getElementById("new-password");
      const confirmPasswordInput = document.getElementById("confirm-password");
      const errorMessage = document.getElementById("password-error");

      form.addEventListener("submit", function(e) {
        // validate on submit; allow normal submission when valid
        const newPassword = newPasswordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();
        errorMessage.style.display = "none";

        if (newPassword === '' || confirmPassword === '') {
          e.preventDefault();
          errorMessage.textContent = 'Semua field harus diisi.';
          errorMessage.style.display = 'block';
          return;
        }

        // rule: letters + digits, min 4
        const rule = /(?=.*[A-Za-z])(?=.*\d).{4,}/;
        if (!rule.test(newPassword)){
          e.preventDefault();
          errorMessage.textContent = 'Password harus mengandung huruf dan angka, minimal 4 karakter.';
          errorMessage.style.display = 'block';
          newPasswordInput.focus();
          return;
        }

        if (newPassword !== confirmPassword) {
          e.preventDefault();
          errorMessage.textContent = 'Password tidak cocok. Silakan coba lagi.';
          errorMessage.style.display = 'block';
          confirmPasswordInput.focus();
          return;
        }

        // if here, allow form to submit to server
      });
    })();
  </script>

</body>
</html>