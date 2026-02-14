<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - DKPP Kota Surabaya</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", "Arial", sans-serif;
      }

      body {
        background-color: #f5f7fa;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
      }

      .login-container {
        width: 480px;
        background-color: white;
        padding: 50px 45px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #e1e5eb;
      }

      .header {
        text-align: center;
        margin-bottom: 40px;
      }

      .header h1 {
        color: #1a4ba1;
        font-size: 26px;
        margin-bottom: 5px;
        font-weight: 700;
        letter-spacing: 0.5px;
      }

      .header .subtitle {
        color: #4a5568;
        font-size: 16px;
        font-weight: 400;
        margin-top: 5px;
      }

      .form-group {
        margin-bottom: 25px;
        position: relative;
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2d3748;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }

      .form-group input {
        width: 100%;
        padding: 14px 18px;
        border: 1px solid #cbd5e0;
        border-radius: 6px;
        font-size: 16px;
        color: #2d3748;
        background-color: #fafafa;
        transition: all 0.3s ease;
      }

      .form-group input:focus {
        outline: none;
        border-color: #1a4ba1;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(26, 75, 161, 0.1);
      }

      .form-group input::placeholder {
        color: #a0aec0;
        font-weight: 400;
      }

      /* Style untuk input password dengan icon mata */
      .password-wrapper {
        position: relative;
        width: 100%;
      }

      .password-wrapper input {
        padding-right: 50px;
      }

      .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        user-select: none;
        font-size: 20px;
        color: #718096;
        transition: color 0.3s ease;
        z-index: 10;
        background: transparent;
        border: none;
        padding: 5px;
      }

      .toggle-password:hover {
        color: #1a4ba1;
      }

      .login-btn {
        width: 100%;
        padding: 15px;
        background-color: #1a4ba1;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 15px;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
      }

      .login-btn:hover {
        background-color: #153a7d;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26, 75, 161, 0.2);
      }

      .login-btn:active {
        transform: translateY(0);
      }

      .login-btn:disabled {
        background-color: #94a3b8;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
      }

      .demo-info {
        margin-top: 25px;
        padding: 15px;
        background-color: #f8fafc;
        border-radius: 6px;
        border-left: 4px solid #1a4ba1;
        font-size: 14px;
        color: #475569;
      }

      .demo-info h4 {
        margin-bottom: 8px;
        color: #1a4ba1;
        font-size: 14px;
        font-weight: 600;
      }

      .demo-account {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #e2e8f0;
        cursor: pointer;
        transition: background-color 0.2s;
      }

      .demo-account:last-child {
        border-bottom: none;
      }

      .demo-account:hover {
        background-color: #edf2f7;
        padding: 8px 10px;
        margin: 0 -10px;
        border-radius: 4px;
      }

      .demo-username {
        font-weight: 500;
        color: #2d3748;
      }

      .demo-role {
        font-size: 12px;
        color: #718096;
        background-color: #e2e8f0;
        padding: 2px 8px;
        border-radius: 12px;
      }

      .password-info {
        margin-top: 10px;
        font-size: 13px;
        color: #718096;
        text-align: center;
      }

      @media (max-width: 520px) {
        .login-container {
          width: 100%;
          padding: 40px 30px;
        }
      }
    </style>
    <!-- Menambahkan Font Awesome untuk icon mata -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  </head>
  <body>
    <div class="login-container">
      <div class="header">
        <h1>DKPP KOTA SURABAYA</h1>
        <div class="subtitle">Dinas Ketahanan Pangan dan Pertanian</div>
      </div>

      <form action="<?php echo site_url('login/cek_login'); ?>" method="POST">
        <div class="form-group">
          <label for="username">USERNAME</label>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Masukkan username"
            autocomplete="username"
          />
        </div>

        <div class="form-group">
          <label for="password">PASSWORD</label>
          <div class="password-wrapper">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Masukkan password"
              autocomplete="current-password"
            />
            <span class="toggle-password" onclick="togglePasswordVisibility()">
              <i id="password-icon" class="fa-regular fa-eye"></i>
            </span>
          </div>
        </div>

        <button type="submit" class="login-btn" id="loginButton">MASUK</button>
      </form>

     
    </div>

    <script>
      function togglePasswordVisibility() {
        const passwordInput = document.getElementById("password");
        const passwordIcon = document.getElementById("password-icon");
        
        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          passwordIcon.className = "fa-regular fa-eye-slash";
        } else {
          passwordInput.type = "password";
          passwordIcon.className = "fa-regular fa-eye";
        }
      }

      function fillDemo(username) {
        document.getElementById("username").value = username;
        document.getElementById("password").value = "password";
        
        // Highlight sebentar
        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("password");
        
        usernameInput.style.borderColor = "#1a4ba1";
        passwordInput.style.borderColor = "#1a4ba1";
        
        setTimeout(() => {
          usernameInput.style.borderColor = "#cbd5e0";
          passwordInput.style.borderColor = "#cbd5e0";
        }, 500);
      }
    </script>
  </body>
</html>