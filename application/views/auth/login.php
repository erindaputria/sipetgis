<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - DKPP Kota Surabaya</title>
    
    <!-- CSS External -->
    <link rel="stylesheet" href="assets/css/login.css">
    
    <!-- Font Awesome -->
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
                <input type="text" id="username" name="username" placeholder="Masukkan username" autocomplete="username" />
            </div>

            <div class="form-group">
                <label for="password">PASSWORD</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" />
                    <span class="toggle-password" onclick="togglePasswordVisibility()">
                        <i id="password-icon" class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="login-btn" id="loginButton">MASUK</button>
        </form>
    </div>

    <!-- JS External -->
    <script src="assets/js/login.js"></script>
</body>
</html>