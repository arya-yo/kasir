<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KASIR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#3b82f6', secondary: '#2563eb' },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(20px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                    },
                },
            },
        }
    </script>
    <style>
        .error-message { display: none; }
        .form-group.error .error-message { display: block; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="min-h-screen bg-white flex items-center justify-center p-5 animate-fade-in">
    <div class="w-full max-w-md animate-slide-up">
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-center text-white">
                <h1 class="text-3xl font-bold mb-1"><i class="fas fa-cash-register"></i> KASIR</h1>
                <p class="text-sm opacity-90">Sistem Manajemen Kasir arya & alip</p>
            </div>

            <div class="p-8">
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5 animate-fade-in">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5 animate-fade-in">
                        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <form id="loginForm" method="post" action="<?php echo site_url('auth/login'); ?>" autocomplete="off">
                    <div class="mb-5 form-group">
                        <label for="email" class="block mb-2 text-gray-700 font-medium text-sm">Username</label>
                        <input type="text" id="email" name="email" placeholder="Masukkan username" required autocomplete="off" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <div class="error-message text-red-600 text-xs mt-1">Username harus diisi</div>
                    </div>

                    <div class="mb-5 form-group">
                        <label for="password" class="block mb-2 text-gray-700 font-medium text-sm">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="off" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <div class="error-message text-red-600 text-xs mt-1">Password harus diisi</div>
                    </div>

                    <div class="flex items-center mb-5 text-sm">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" value="1" class="mr-2 cursor-pointer">
                            Ingatkan saya
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg font-semibold text-base cursor-pointer transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 btn-login">
                        <span class="loading hidden">
                            <span class="inline-block w-5 h-5 border-3 border-white border-t-transparent rounded-full animate-spin mr-2"></span>Masuk...
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
                if (!email) {
                    document.getElementById('email').parentElement.classList.add('error');
                    document.getElementById('email').classList.add('border-red-500');
                }
                if (!password) {
                    document.getElementById('password').parentElement.classList.add('error');
                    document.getElementById('password').classList.add('border-red-500');
                }
                return;
            }

            submitBtn.disabled = true;
            loadingSpan.classList.remove('hidden');
            loginText.classList.add('hidden');

            // Submit form
            form.submit();
        });

        document.getElementById('email').addEventListener('focus', function() {
            this.parentElement.classList.remove('error');
            this.classList.remove('border-red-500');
        });

        document.getElementById('password').addEventListener('focus', function() {
            this.parentElement.classList.remove('error');
            this.classList.remove('border-red-500');
        });
    </script>
</body>
</html>
