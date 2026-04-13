// Fungsi toggle password visibility
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

// Fungsi untuk mengisi demo account
function fillDemo(username) {
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    
    usernameInput.value = username;
    passwordInput.value = "password";
    
    // Highlight sebentar
    usernameInput.style.borderColor = "#832706";
    passwordInput.style.borderColor = "#832706";
    
    setTimeout(() => {
        usernameInput.style.borderColor = "#cbd5e0";
        passwordInput.style.borderColor = "#cbd5e0";
    }, 500);
}

// Optional: Tambahkan validasi form sebelum submit
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const loginBtn = document.getElementById('loginButton');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (username === '') {
                e.preventDefault();
                alert('Username tidak boleh kosong!');
                document.getElementById('username').focus();
                return false;
            }
            
            if (password === '') {
                e.preventDefault();
                alert('Password tidak boleh kosong!');
                document.getElementById('password').focus();
                return false;
            }
        });
    }
});