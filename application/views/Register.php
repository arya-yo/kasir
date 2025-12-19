<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KASIR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
        }

        .register-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .register-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .register-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .register-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group.error input,
        .form-group.error select {
            border-color: #e74c3c;
        }

        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        .form-group.error .error-message {
            display: block;
        }

        .password-strength {
            margin-top: 8px;
            font-size: 13px;
        }

        .strength-bar {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .strength-progress {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background-color 0.3s;
        }

        .strength-text {
            color: #666;
        }

        .terms {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .terms label {
            display: flex;
            align-items: flex-start;
            margin: 0;
            cursor: pointer;
        }

        .terms input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
            margin-top: 2px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .terms-text {
            color: #666;
            line-height: 1.5;
        }

        .terms a {
            color: #667eea;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-register:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .register-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .register-footer p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .register-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .register-footer a:hover {
            color: #764ba2;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .loading {
            display: none;
            text-align: center;
            color: #667eea;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .container {
                max-width: 100%;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .register-body {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <div class="register-header">
                <h1><i class="fas fa-cash-register"></i> KASIR</h1>
                <p>Buat Akun Baru</p>
            </div>

            <div class="register-body">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <form id="registerForm" method="post" action="<?php echo site_url('auth/register'); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">Nama Depan</label>
                            <input type="text" id="first_name" name="first_name" placeholder="John" required>
                            <div class="error-message">Nama depan harus diisi</div>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Nama Belakang</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Doe" required>
                            <div class="error-message">Nama belakang harus diisi</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@example.com" required>
                        <div class="error-message">Email tidak valid</div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="username123" required>
                        <div class="error-message">Username minimal 4 karakter</div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-progress" id="strengthProgress"></div>
                            </div>
                            <div class="strength-text" id="strengthText">Kekuatan: Lemah</div>
                        </div>
                        <div class="error-message">Password minimal 6 karakter</div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password" required>
                        <div class="error-message">Password tidak cocok</div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" placeholder="08xxxxxxxxxx">
                        <div class="error-message">Nomor telepon tidak valid</div>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" id="address" name="address" placeholder="Jalan, Kota">
                        <div class="error-message">Alamat harus diisi</div>
                    </div>

                    <div class="terms">
                        <label>
                            <input type="checkbox" id="agree_terms" name="agree_terms" required>
                            <span class="terms-text">
                                Saya setuju dengan <a href="#" target="_blank">Syarat dan Ketentuan</a> 
                                serta <a href="#" target="_blank">Kebijakan Privasi</a>
                            </span>
                        </label>
                        <div class="error-message" style="margin-left: 32px;">Anda harus menyetujui syarat dan ketentuan</div>
                    </div>

                    <button type="submit" class="btn-register">
                        <span class="loading">
                            <span class="spinner"></span>Mendaftar...
                        </span>
                        <span class="register-text">Daftar</span>
                    </button>
                </form>
            </div>

            <div class="register-footer">
                <p>Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>">Masuk di sini</a></p>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthProgress = document.getElementById('strengthProgress');
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let text = 'Lemah';
            let color = '#e74c3c';

            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            if (strength <= 1) {
                text = 'Lemah';
                color = '#e74c3c';
                strength = 20;
            } else if (strength === 2) {
                text = 'Sedang';
                color = '#f39c12';
                strength = 40;
            } else if (strength === 3) {
                text = 'Bagus';
                color = '#f1c40f';
                strength = 60;
            } else if (strength === 4) {
                text = 'Kuat';
                color = '#27ae60';
                strength = 80;
            } else {
                text = 'Sangat Kuat';
                color = '#2ecc71';
                strength = 100;
            }

            strengthProgress.style.width = strength + '%';
            strengthProgress.style.backgroundColor = color;
            strengthText.textContent = 'Kekuatan: ' + text;
            strengthText.style.color = color;
        });

        // Form validation
        const form = document.getElementById('registerForm');
        const submitBtn = form.querySelector('.btn-register');
        const loadingSpan = submitBtn.querySelector('.loading');
        const registerText = submitBtn.querySelector('.register-text');

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^(\+62|62|0)[0-9]{9,12}$/;
            return re.test(phone.replace(/\s/g, ''));
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Reset error states
            document.querySelectorAll('.form-group, .terms').forEach(el => {
                el.classList.remove('error');
            });

            let isValid = true;
            const firstName = document.getElementById('first_name').value.trim();
            const lastName = document.getElementById('last_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const phone = document.getElementById('phone').value.trim();
            const address = document.getElementById('address').value.trim();
            const agreeTerms = document.getElementById('agree_terms').checked;

            if (!firstName) {
                document.getElementById('first_name').parentElement.classList.add('error');
                isValid = false;
            }

            if (!lastName) {
                document.getElementById('last_name').parentElement.classList.add('error');
                isValid = false;
            }

            if (!email || !validateEmail(email)) {
                document.getElementById('email').parentElement.classList.add('error');
                isValid = false;
            }

            if (!username || username.length < 4) {
                document.getElementById('username').parentElement.classList.add('error');
                isValid = false;
            }

            if (!password || password.length < 6) {
                document.getElementById('password').parentElement.classList.add('error');
                isValid = false;
            }

            if (password !== confirmPassword) {
                document.getElementById('confirm_password').parentElement.classList.add('error');
                isValid = false;
            }

            if (phone && !validatePhone(phone)) {
                document.getElementById('phone').parentElement.classList.add('error');
                isValid = false;
            }

            if (!address) {
                document.getElementById('address').parentElement.classList.add('error');
                isValid = false;
            }

            if (!agreeTerms) {
                document.querySelector('.terms').classList.add('error');
                isValid = false;
            }

            if (!isValid) {
                return;
            }

            // Show loading
            submitBtn.disabled = true;
            loadingSpan.style.display = 'inline';
            registerText.style.display = 'none';

            // Submit form
            form.submit();
        });

        // Remove error on input
        document.querySelectorAll('.form-group input, .form-group select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.remove('error');
            });
        });

        document.getElementById('agree_terms').addEventListener('change', function() {
            document.querySelector('.terms').classList.remove('error');
        });
    </script>
</body>
</html>
