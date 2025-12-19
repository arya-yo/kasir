<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KASIR</title>
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
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .login-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .login-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group.error input {
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .remember-forgot label {
            display: flex;
            align-items: center;
            margin: 0;
            cursor: pointer;
        }

        .remember-forgot input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
            cursor: pointer;
        }

        .remember-forgot a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s;
        }

        .remember-forgot a:hover {
            color: #764ba2;
        }

        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .login-footer p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .login-footer a:hover {
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

            .login-header h1 {
                font-size: 24px;
            }

            .login-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="login-header">
                <h1><i class="fas fa-cash-register"></i> KASIR</h1>
                <p>Sistem Manajemen Kasir</p>
            </div>

            <div class="login-body">
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

                <form id="loginForm" method="post" action="<?php echo site_url('auth/login'); ?>">
                    <div class="form-group">
                        <label for="email">Username</label>
                        <input type="text" id="email" name="email" placeholder="Masukkan username" required>
                        <div class="error-message">Username harus diisi</div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <div class="error-message">Password harus diisi</div>
                    </div>

                    <div class="remember-forgot">
                        <label>
                            <input type="checkbox" name="remember" value="1">
                            Ingat saya
                        </label>
                        <a href="<?php echo site_url('auth/forgot'); ?>">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-login">
                        <span class="loading">
                            <span class="spinner"></span>Masuk...
                        </span>
                        <span class="login-text">Masuk</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('loginForm');
        const submitBtn = form.querySelector('.btn-login');
        const loadingSpan = submitBtn.querySelector('.loading');
        const loginText = submitBtn.querySelector('.login-text');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!email || !password) {
                if (!email) document.getElementById('email').parentElement.classList.add('error');
                if (!password) document.getElementById('password').parentElement.classList.add('error');
                return;
            }

            // Show loading
            submitBtn.disabled = true;
            loadingSpan.style.display = 'inline';
            loginText.style.display = 'none';

            // Submit form
            form.submit();
        });

        // Remove error class on input
        document.getElementById('email').addEventListener('focus', function() {
            this.parentElement.classList.remove('error');
        });

        document.getElementById('password').addEventListener('focus', function() {
            this.parentElement.classList.remove('error');
        });
    </script>
</body>
</html>
