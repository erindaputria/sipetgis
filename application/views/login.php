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

      .demo-email {
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
  </head>
  <body>
    <div class="login-container">
      <div class="header">
        <h1>DKPP KOTA SURABAYA</h1>
        <div class="subtitle">Dinas Ketahanan Pangan dan Pertanian</div>
      </div>

      <form id="loginForm">
        <div class="form-group">
          <label for="email">EMAIL</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Masukkan email"
            autocomplete="username"
          />
        </div>

        <div class="form-group">
          <label for="password">PASSWORD</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan password"
            autocomplete="current-password"
          />
        </div>

        <button type="submit" class="login-btn" id="loginButton">MASUK</button>
      </form>
    </div>

    <script>
      // Fungsi untuk mengisi kredensial demo
      function fillDemoCredentials(email) {
        document.getElementById("email").value = email;
        document.getElementById("password").value = "password";

        // Highlight input fields
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("password");

        emailInput.style.borderColor = "#1a4ba1";
        passwordInput.style.borderColor = "#1a4ba1";

        setTimeout(() => {
          emailInput.style.borderColor = "#cbd5e0";
          passwordInput.style.borderColor = "#cbd5e0";
        }, 1500);

        // Auto submit setelah mengisi
        setTimeout(() => {
          document
            .getElementById("loginForm")
            .dispatchEvent(new Event("submit"));
        }, 800);
      }

      // Fungsi untuk menentukan halaman tujuan berdasarkan role
      function getRedirectUrl(email) {
        const roleRoutes = {
          "admin@dkppsby.go.id": "index.html",
          "petugas@sawahan.go.id": "dashboard-petugas.html",
          "kepala@dkppsby.go.id": "dashboard-kepala.html",
        };

        return roleRoutes[email] || "index.html";
      }

      // Fungsi untuk mendapatkan nama role berdasarkan email
      function getRoleName(email) {
        const roleNames = {
          "admin@dkppsby.go.id": "Admin Bidang",
          "petugas@sawahan.go.id": "Petugas Kecamatan",
          "kepala@dkppsby.go.id": "Kepala Dinas",
        };

        return roleNames[email] || "Pengguna";
      }

      // Handle form submission
      document
        .getElementById("loginForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          const email = document.getElementById("email").value.trim();
          const password = document.getElementById("password").value;
          const loginBtn = document.getElementById("loginButton");

          // Validasi sederhana
          if (!email || !password) {
            alert("Mohon lengkapi semua field yang diperlukan.");
            return;
          }

          if (!isValidEmail(email)) {
            alert(
              "Format email tidak valid. Mohon masukkan alamat email yang benar.",
            );
            return;
          }

          // Simulasi proses autentikasi
          authenticateUser(email, password);
        });

      // Fungsi validasi email
      function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
      }

      // Fungsi simulasi autentikasi dengan redirect langsung
      function authenticateUser(email, password) {
        const loginBtn = document.getElementById("loginButton");
        const originalText = loginBtn.textContent;

        // Tampilkan loading state
        loginBtn.textContent = "Memproses...";
        loginBtn.disabled = true;

        // Simulasi delay proses login
        setTimeout(() => {
          // Daftar akun yang valid
          const validAccounts = [
            "admin@dkppsby.go.id",
            "petugas@sawahan.go.id",
            "kepala@dkppsby.go.id",
          ];

          // Password untuk semua akun adalah "password"
          if (validAccounts.includes(email) && password === "password") {
            // Dapatkan role dan halaman tujuan
            const role = getRoleName(email);
            const redirectUrl = getRedirectUrl(email);

            // Simpan informasi login ke localStorage
            localStorage.setItem(
              "loggedInUser",
              JSON.stringify({
                email: email,
                role: role,
                loginTime: new Date().toISOString(),
              }),
            );

            // Tampilkan pesan sukses di button
            loginBtn.textContent = "Login Berhasil!";
            loginBtn.style.backgroundColor = "#10b981";

            // Redirect langsung setelah 1 detik
            setTimeout(() => {
              // REDIRECT LANGSUNG KE HALAMAN YANG SESUAI
              window.location.href = redirectUrl;
            }, 1000);
          } else {
            // Reset button
            loginBtn.textContent = originalText;
            loginBtn.disabled = false;

            // Tampilkan pesan error
            if (!validAccounts.includes(email)) {
              alert(
                "Email tidak terdaftar. Gunakan salah satu akun demo yang tersedia.",
              );
            } else if (password !== "password") {
              alert(
                "Password salah. Password untuk semua akun demo adalah: password",
              );
            }
          }
        }, 800);
      }

      // Jika ada data login tersimpan, tampilkan informasi
      window.addEventListener("load", function () {
        const savedUser = localStorage.getItem("loggedInUser");
        if (savedUser) {
          const user = JSON.parse(savedUser);
          console.log(`Pengguna sebelumnya: ${user.email} (${user.role})`);
        }
      });
    </script>
  </body>
</html>
