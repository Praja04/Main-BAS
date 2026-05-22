<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Sign In | Corporate Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/kecap.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <!-- Sweet Alerts js & css via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F5F7F9] font-body-md text-on-surface flex flex-col min-h-screen relative">

    <!-- Hero Background -->
    <div class="absolute inset-0 z-0">
        <img class="w-full h-full object-cover opacity-20 brightness-50"
            alt="corporate background"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCj3-I0iwUPe8-YZVZ_aLZdwjTPhYQCK4VojWMQiOuwfmU66K0MecvAFulu1xII21A2d1OY8zBZqY1daGyM7STMeKGqz74XghAqg0UxTE48TyYH4hbhu5b-WjYqLv2jTAyCfDP2JM_C8eC2WGyYlpoz2YDgKnRkU1F4rCBdzpwWua5Q1B34P1PnOpegJfwwOmCo2O7TFlAZM694N3GQuSL9yn_Tn3u1NWuh00lng_nJV3ghssKccv8kPcBA_apUA9ZVB7DL878Ue18" />
        <div class="absolute inset-0 bg-gradient-to-br from-white/90 via-white/70 to-transparent"></div>
    </div>

    <!-- Login Container -->
    <div class="relative z-10 flex flex-col items-center justify-center flex-grow px-6 py-12">
        <div class="glass-card rounded-[24px] shadow-2xl p-10 w-full max-w-[480px] border border-white/50 relative overflow-hidden">
            <!-- Decorative gradient orb -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary-fixed-dim rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-tertiary-fixed-dim rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>

            <div class="text-center mb-8 relative z-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4">
                    <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="Logo Kecap" class="w-16 h-16 object-contain">
                </div>
                <h1 class="font-h2 text-h2 text-on-surface mb-2">PT. Bumi Alam Segar</h1>
                <p class="text-secondary font-body-md">Sign in to access your operations dashboard.</p>
            </div>

            <form id="loginForm" class="flex flex-col gap-5 relative z-10">
                <!-- Username -->
                <div>
                    <label for="username" class="block font-label-bold text-on-surface mb-2">Username / NIK</label>
                    <div class="relative">
                        <x-heroicon-o-user class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                        <input type="text" id="username" name="username" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 outline-none transition-all bg-white/80 backdrop-blur-sm shadow-inner" placeholder="Enter your username or NIK" required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block font-label-bold text-on-surface">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs text-primary-container hover:underline font-semibold">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <x-heroicon-o-lock-closed class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                        <input type="password" id="password" name="password" class="w-full pl-12 pr-12 py-3 rounded-xl border border-gray-300 focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 outline-none transition-all bg-white/80 backdrop-blur-sm shadow-inner" placeholder="Enter your password" required>
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-container transition-colors focus:outline-none">
                            <x-heroicon-o-eye-slash id="eyeSlashIcon" class="w-5 h-5" />
                            <x-heroicon-o-eye id="eyeIcon" class="w-5 h-5 hidden" />
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-primary-container text-on-primary-container px-8 py-4 rounded-xl font-label-bold text-label-bold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all active:scale-95 mt-4 group cursor-pointer">
                    Login
                    <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200 text-center relative z-10">
                <p class="font-label-bold text-sm text-secondary">PT. Bumi Alam Segar</p>
                <p class="text-xs text-gray-400 mt-1">Management & Integrated System v1.0</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Password Toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            }
        });

        // AJAX Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Login Form Submit
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('login.submit') }}",
                    method: "POST",
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();

                        if (xhr.status === 401) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Unauthorized!',
                                text: 'Username atau password salah.'
                            });
                        } else if (xhr.status === 403) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Akses Ditolak!',
                                text: 'Jabatan tidak dikenali.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan!',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>