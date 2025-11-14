<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Sign In | MAIN-BAS - PT. Bumi Alam Segar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="MAIN-BAS - PT. Bumi Alam Segar" name="description" />
    <meta content="PT. Bumi Alam Segar" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/icon-utility/kecap.png') }}">

    <!-- Layout config Js -->
    <link href="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('material/assets/js/layout.js') }}"></script>

    <!-- Bootstrap Css -->
    <link href="{{ asset('material/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('material/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('material/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('material/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Sweet Alerts js -->
    <script src="{{ asset('material/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/sweetalerts.init.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .auth-page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #1a1a3e 0%, #232347 50%, #2d2d5a 100%);
            overflow: hidden;
        }

        /* Soybean Pattern Background */
        .animated-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            opacity: 0.08;
        }

        .soybean-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .soybean {
            position: absolute;
            width: 40px;
            height: 25px;
            background: #ffd700;
            border-radius: 50%;
            opacity: 0.3;
            animation: float-soybean 25s infinite ease-in-out;
        }

        .soybean:nth-child(1) {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .soybean:nth-child(2) {
            top: 20%;
            left: 85%;
            animation-delay: 2s;
            width: 35px;
            height: 20px;
        }

        .soybean:nth-child(3) {
            top: 40%;
            left: 15%;
            animation-delay: 4s;
            width: 45px;
            height: 28px;
        }

        .soybean:nth-child(4) {
            top: 60%;
            left: 75%;
            animation-delay: 1s;
        }

        .soybean:nth-child(5) {
            top: 75%;
            left: 25%;
            animation-delay: 3s;
            width: 38px;
            height: 23px;
        }

        .soybean:nth-child(6) {
            top: 35%;
            left: 90%;
            animation-delay: 5s;
        }

        .soybean:nth-child(7) {
            top: 85%;
            left: 65%;
            animation-delay: 2.5s;
            width: 42px;
            height: 26px;
        }

        .soybean:nth-child(8) {
            top: 15%;
            left: 45%;
            animation-delay: 4.5s;
        }

        @keyframes float-soybean {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-40px) rotate(180deg);
                opacity: 0.5;
            }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.6);
            overflow: hidden;
            border: 1px solid rgba(255, 215, 0, 0.3);
        }

        .login-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 650px;
        }

        /* Left Side - Brand Side - Navy Blue Theme */
        .brand-side {
            background: linear-gradient(135deg, #1a1a3e 0%, #232347 30%, #2d2d5a 70%, #3a3a6f 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        /* Gold accents on brand side */
        .brand-side::before {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .brand-side::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -80px;
            left: -80px;
        }

        .soybean-icon {
            position: absolute;
            font-size: 60px;
            opacity: 0.1;
            animation: rotate-slow 30s infinite linear;
        }

        .soybean-icon:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .soybean-icon:nth-child(2) {
            top: 70%;
            right: 15%;
            animation-delay: 5s;
        }

        .soybean-icon:nth-child(3) {
            bottom: 15%;
            left: 15%;
            animation-delay: 10s;
        }

        @keyframes rotate-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .brand-logo {
            position: relative;
            z-index: 2;
            margin-bottom: 35px;
            animation: fadeInDown 1s ease;
        }

        .brand-logo img {
            max-width: 200px;
            filter: drop-shadow(0 15px 30px rgba(255, 215, 0, 0.5));
            border-radius: 10px;
            background: white;
            padding: 15px;
        }

        .brand-info {
            position: relative;
            z-index: 2;
        }

        .brand-info h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
            color: #FFFFFF;
        }

        .kecap-highlight {
            font-size: 48px;
            font-weight: 800;
            margin: 25px 0;
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.6);
            letter-spacing: 2px;
            background: linear-gradient(to right, #ffd700, #ffed4e, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shine 3s infinite;
        }

        @keyframes shine {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .product-badge {
            display: inline-block;
            background: rgba(255, 215, 0, 0.2);
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            margin-top: 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 215, 0, 0.5);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            color: #ffd700;
        }

        .brand-info .description {
            font-size: 15px;
            opacity: 0.9;
            line-height: 1.7;
            margin-top: 30px;
            font-weight: 400;
            color: #E5E5E5;
        }

        /* Right Side - Form */
        .form-side {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(to bottom, #FFFFFF 0%, #F8F8F8 100%);
        }

        .form-header {
            margin-bottom: 40px;
            animation: fadeInUp 1s ease;
        }

        .form-header h2 {
            font-size: 30px;
            font-weight: 700;
            color: #1a1a3e;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
            animation: fadeInUp 1s ease;
            animation-delay: 0.2s;
        }

        .form-label {
            font-weight: 600;
            color: #1a1a3e;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-control {
            height: 55px;
            border-radius: 12px;
            border: 2px solid #D0D0D0;
            padding: 0 20px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #FFF;
        }

        .form-control:focus {
            border-color: #1a1a3e;
            box-shadow: 0 0 0 0.25rem rgba(26, 26, 62, 0.15);
            background: #FFFEF8;
        }

        .password-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #1a1a3e;
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #ffd700;
        }

        .btn-login {
            height: 55px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            background: linear-gradient(135deg, #1a1a3e 0%, #2d2d5a 50%, #232347 100%);
            border: 2px solid #ffd700;
            color: white;
            transition: all 0.3s ease;
            margin-top: 15px;
            box-shadow: 0 6px 20px rgba(26, 26, 62, 0.4);
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.5);
            background: linear-gradient(135deg, #232347 0%, #3a3a6f 50%, #2d2d5a 100%);
            border-color: #ffed4e;
        }

        .system-info {
            text-align: center;
            margin-top: 35px;
            padding-top: 30px;
            border-top: 2px solid #E0E0E0;
            animation: fadeInUp 1s ease;
            animation-delay: 0.4s;
        }

        .system-info p {
            font-size: 13px;
            color: #666;
            margin: 5px 0;
        }

        .system-info strong {
            color: #1a1a3e;
            font-size: 14px;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-content {
                grid-template-columns: 1fr;
            }

            .brand-side {
                padding: 40px 25px;
                min-height: 350px;
            }

            .brand-info h1 {
                font-size: 28px;
            }

            .kecap-highlight {
                font-size: 36px;
            }

            .form-side {
                padding: 40px 30px;
            }

            .form-header h2 {
                font-size: 24px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #F0F0F0;
        }

        ::-webkit-scrollbar-thumb {
            background: #1a1a3e;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #232347;
        }
    </style>
</head>

<body>
    <div class="auth-page-wrapper">
        <!-- Animated Background with Soybean Pattern -->
        <div class="animated-bg">
            <div class="soybean-pattern">
                <div class="soybean"></div>
                <div class="soybean"></div>
                <div class="soybean"></div>
                <div class="soybean"></div>
                <div class="soybean"></div>
                <div class="soybean"></div>
                <div class="soybean"></div>
                <div class="soybean"></div>
            </div>
        </div>

        <!-- Login Container -->
        <div class="login-container">
            <div class="login-card">
                <div class="login-content">
                    <!-- Brand Side - Navy Blue Theme -->
                    <div class="brand-side">
                        <div class="soybean-icon">🫘</div>
                        <div class="soybean-icon">🫘</div>
                        <div class="soybean-icon">🫘</div>

                        <div class="brand-logo">
                            <img src="{{ asset('assets/images/logo/bas.png') }}" alt="PT. Bumi Alam Segar">
                        </div>
                        <div class="brand-info">
                            <h1>PT. BUMI ALAM SEGAR</h1>

                            <div class="kecap-highlight">
                                KECAP SEDAAP
                            </div>

                            <div class="product-badge">
                                Menjadi Perusahaan Makanan Kelas Dunia
                            </div>

                            <p class="description">
                                Berkomitmen meningkatkan bisnis perusahaan dengan menyediakan produk yang berkualitas untuk semua lapisan masyarakat dengan terus berinovasi dan mengembangkan SDM
                            </p>
                        </div>
                    </div>

                    <!-- Form Side -->
                    <div class="form-side">
                        <div class="form-header">
                            <h2>Selamat Datang Kembali! 👋</h2>
                            <p>Silakan masuk ke akun Anda untuk melanjutkan</p>
                        </div>

                        <form id="loginForm">
                            <div class="form-group">
                                <label for="username" class="form-label">Username/NIK</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username/nik Anda" required>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="password-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password Anda" required>
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-login w-100">
                                Masuk ke Sistem
                            </button>
                        </form>

                        <div class="system-info">
                            <p><strong>MAIN-BAS v1.0</strong></p>
                            <p>Management & Integrated System</p>
                            <p style="margin-top: 10px; color: #1a1a3e; font-weight: 600;">🫘 Bumi Alam Segar - Kecap Sedaap 🫘</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('material/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('material/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('material/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('material/assets/js/plugins.js') }}"></script>

    <script>
        // Password Toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
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