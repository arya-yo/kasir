<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KASIR</title>
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
    <div class="w-full max-w-lg animate-slide-up">
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-center text-white">
                <h1 class="text-3xl font-bold mb-1"><i class="fas fa-cash-register"></i> KASIR</h1>
                <p class="text-sm opacity-90">Buat Akun Baru</p>
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

                <form id="registerForm" method="post" action="<?php echo site_url('auth/register'); ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                        <div class="form-group">
                            <label for="first_name" class="block mb-2 text-gray-700 font-medium text-sm">Nama Depan</label>
                            <input type="text" id="first_name" name="first_name" placeholder="John" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <div class="error-message text-red-600 text-xs mt-1">Nama depan harus diisi</div>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="block mb-2 text-gray-700 font-medium text-sm">Nama Belakang</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Doe" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <div class="error-message text-red-600 text-xs mt-1">Nama belakang harus diisi</div>
                    </div>
                </div>

                <div class="mb-5 form-group">
                    <label for="email" class="block mb-2 text-gray-700 font-medium text-sm">Email</label>
                    <input type="email" id="email" name="email" placeholder="email@example.com" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <div class="error-message text-red-600 text-xs mt-1">Email tidak valid</div>
                </div>

                <div class="mb-5 form-group">
                    <label for="username" class="block mb-2 text-gray-700 font-medium text-sm">Username</label>
                    <input type="text" id="username" name="username" placeholder="username123" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <div class="error-message text-red-600 text-xs mt-1">Username minimal 4 karakter</div>
                </div>

                <div class="mb-5 form-group">
                    <label for="password" class="block mb-2 text-gray-700 font-medium text-sm">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <div class="mt-2 text-sm">
                            <div class="h-1 bg-gray-200 rounded-full overflow-hidden mb-1">
                                <div class="h-full transition-all duration-300" id="strengthProgress"></div>
                            </div>
                            <div class="text-gray-600" id="strengthText">Kekuatan: Lemah</div>
                        </div>
                        <div class="error-message text-red-600 text-xs mt-1">Password minimal 6 karakter</div>
                    </div>

                    <div class="mb-5 form-group">
                        <label for="confirm_password" class="block mb-2 text-gray-700 font-medium text-sm">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <div class="error-message text-red-600 text-xs mt-1">Password tidak cocok</div>
                </div>

                <div class="mb-5 form-group">
                    <label for="phone" class="block mb-2 text-gray-700 font-medium text-sm">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    <div class="error-message text-red-600 text-xs mt-1">Nomor telepon tidak valid</div>
                </div>

                <div class="mb-5 form-group">
                    <label for="address" class="block mb-2 text-gray-700 font-medium text-sm">Alamat</label>
                    <input type="text" id="address" name="address" placeholder="Jalan, Kota" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-sm transition-all duration-300 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <div class="error-message text-red-600 text-xs mt-1">Alamat harus diisi</div>
                    </div>

                    <div class="mb-5 terms">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" id="agree_terms" name="agree_terms" required class="mr-2.5 mt-0.5 cursor-pointer flex-shrink-0">
                            <span class="text-gray-600 text-sm leading-relaxed">
                                Saya setuju dengan <a href="#" target="_blank" class="text-blue-600 hover:text-blue-700 transition-colors duration-300">Syarat dan Ketentuan</a> 
                                serta <a href="#" target="_blank" class="text-blue-600 hover:text-blue-700 transition-colors duration-300">Kebijakan Privasi</a>
                            </span>
                        </label>
                        <div class="error-message text-red-600 text-xs mt-1 ml-8">Anda harus menyetujui syarat dan ketentuan</div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg font-semibold text-base cursor-pointer transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed">
                        <span class="loading hidden">
                            <span class="inline-block w-5 h-5 border-3 border-white border-t-transparent rounded-full animate-spin mr-2"></span>Mendaftar...
                        </span>
                        <span class="register-text">Daftar</span>
                    </button>
                </form>
            </div>

            <div class="bg-gray-50 p-5 text-center border-t border-gray-200">
                <p class="text-sm text-gray-600 m-0">Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors duration-300">Masuk di sini</a></p>
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

            submitBtn.disabled = true;
            loadingSpan.classList.remove('hidden');
            registerText.classList.add('hidden');

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
