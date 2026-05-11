<!DOCTYPE html>
<html class="h-full scroll-smooth">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
        font-family: 'Poppins', sans-serif;
    }

    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .input-field {
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }

    .input-field:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .form-card {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .logo-container {
        animation: fadeInDown 0.6s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .error-alert {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }
</style>

<body class="h-full">
    <div class="login-container">
        <div class="w-full max-w-md px-4">
            <!-- Logo Section -->
            <div class="logo-container text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg shadow-lg mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Payroll System</h1>
                <p class="text-gray-600 text-sm">Kelola penggajian dengan mudah dan efisien</p>
            </div>

            <!-- Error Messages - SweetAlert2 will handle this -->
            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const errors = {!! json_encode($errors->all()) !!};
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Gagal',
                            html: errors.join('<br>'),
                            confirmButtonColor: '#667eea',
                            confirmButtonText: 'Coba Lagi',
                            allowOutsideClick: false,
                            didOpen: function(modal) {
                                const confirmButton = modal.querySelector('.swal2-confirm');
                                confirmButton.style.background =
                                'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                                confirmButton.style.borderRadius = '8px';
                                confirmButton.style.padding = '10px 20px';
                            }
                        });
                    });
                </script>
            @endif

            <!-- Login Form Card -->
            <div class="form-card glass-effect rounded-2xl shadow-2xl p-8">
                <form action="{{ route('action.login') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Email Input -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">Email
                            Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" required autocomplete="email"
                                placeholder="Masukkan email Anda"
                                class="input-field w-full pl-12 pr-4 py-3 rounded-lg text-gray-800 placeholder:text-gray-400 focus:outline-none"
                                value="{{ old('email') }}" />
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="group">
                        <div class="flex items-center justify-between mb-3">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                            <a href="#"
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">Lupa
                                password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="Masukkan password Anda"
                                class="input-field w-full pl-12 pr-4 py-3 rounded-lg text-gray-800 placeholder:text-gray-400 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500 cursor-pointer" />
                        <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer">Ingat saya</label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="btn-login w-full py-3 px-4 rounded-lg text-white font-semibold text-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Masuk ke Akun
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-600">
                <p>© 2026 Payroll System. Semua hak dilindungi.</p>
            </div>
        </div>
    </div>

    <script>
        // Handle login form submission with SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');

            // Check for session messages (success or error)
            @if (session('message'))
                @if (str_contains(session('message'), 'berhasil'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: 'Anda berhasil masuk ke sistem',
                        confirmButtonColor: '#667eea',
                        confirmButtonText: 'Lanjutkan',
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: function(modal) {
                            const confirmButton = modal.querySelector('.swal2-confirm');
                            if (confirmButton) {
                                confirmButton.style.background =
                                    'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                                confirmButton.style.borderRadius = '8px';
                                confirmButton.style.padding = '10px 20px';
                            }
                        }
                    });
                @else
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: '{{ session('message') }}',
                        confirmButtonColor: '#667eea',
                        confirmButtonText: 'Coba Lagi',
                        allowOutsideClick: false,
                        didOpen: function(modal) {
                            const confirmButton = modal.querySelector('.swal2-confirm');
                            confirmButton.style.background =
                                'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                            confirmButton.style.borderRadius = '8px';
                            confirmButton.style.padding = '10px 20px';
                        }
                    });
                @endif
            @endif

            loginForm.addEventListener('submit', function(e) {
                // Show loading alert
                Swal.fire({
                    title: 'Memproses Login...',
                    html: 'Harap tunggu, sedang memverifikasi data Anda',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: async (modal) => {
                        Swal.showLoading();
                    }
                });
            });

            // Check if login was successful (after redirect)
            // This will be triggered if login succeeds and session is set
            if (sessionStorage.getItem('login_success')) {
                sessionStorage.removeItem('login_success');
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil!',
                    text: 'Anda berhasil masuk ke sistem',
                    confirmButtonColor: '#667eea',
                    confirmButtonText: 'Lanjutkan',
                    allowOutsideClick: false,
                    didOpen: function(modal) {
                        const confirmButton = modal.querySelector('.swal2-confirm');
                        confirmButton.style.background =
                            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        confirmButton.style.borderRadius = '8px';
                        confirmButton.style.padding = '10px 20px';
                    }
                });
            }
        });
    </script>
</body>

</html>
