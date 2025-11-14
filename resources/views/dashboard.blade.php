@extends('layouts.app')

@section('styles')
<style>
    @keyframes gradientShift {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }

    /* Header Section */
    .header-section {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }

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

    .robot-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1.5rem;
        animation: floatRobot 3s ease-in-out infinite;
    }

    @keyframes floatRobot {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-15px);
        }
    }

    .lottie-robot {
        filter: drop-shadow(0 15px 35px rgba(102, 126, 234, 0.4));
    }

    .welcome-title {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.4rem;
        color: #555;
        font-weight: 400;
    }

    .welcome-subtitle strong {
        color: #667eea;
        font-weight: 600;
    }

    /* Portal Cards */
    .portals-section {
        position: relative;
        z-index: 1;
    }

    .portal-card {
        /* background: rgba(255, 255, 255, 0.98); */
        border-radius: 24px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .portal-card.disabled {
        opacity: 0.6;
        background: rgba(255, 255, 255, 0.7);
    }

    .portal-card.disabled::after {
        content: '🔒 Akses Terbatas';
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(220, 38, 38, 0.9);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .portal-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .portal-card:not(.disabled):hover::before {
        transform: scaleX(1);
    }

    .portal-card:not(.disabled):hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.3);
    }

    .portal-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        transition: all 0.3s ease;
    }

    .portal-card.disabled .portal-icon {
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    }

    .portal-card:not(.disabled):hover .portal-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    .portal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1rem;
        text-transform: capitalize;
    }

    .portal-description {
        color: #718096;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .portal-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.9rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        width: 100%;
    }

    .portal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    .portal-btn:disabled {
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
        cursor: not-allowed;
        box-shadow: none;
    }

    .portal-btn:disabled:hover {
        transform: none;
    }

    /* Decorative Elements */
    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
    }

    .shape {
        position: absolute;
        opacity: 0.1;
        animation: float 20s infinite ease-in-out;
    }

    .shape:nth-child(1) {
        top: 10%;
        left: 10%;
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        top: 60%;
        right: 10%;
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 30%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        bottom: 10%;
        left: 20%;
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 20%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-30px) rotate(180deg);
        }
    }

    /* Alert Notification */
    .alert-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-left: 4px solid #dc2626;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        display: none;
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .alert-notification.show {
        display: block;
    }

    .alert-notification .alert-icon {
        color: #dc2626;
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .alert-notification .alert-content {
        display: flex;
        align-items: center;
    }

    .alert-notification .alert-text {
        flex: 1;
    }

    .alert-notification .alert-title {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .alert-notification .alert-message {
        color: #6b7280;
        font-size: 0.9rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-title {
            font-size: 2rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
        }

        .portal-card {
            padding: 2rem;
        }

        .lottie-robot {
            width: 250px !important;
            height: 250px !important;
        }

        .alert-notification {
            top: 10px;
            right: 10px;
            left: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="dashboard-container">
            <!-- Welcome Card -->
            <div class="welcome-card text-center" data-aos="fade-up">
                <div class="robot-container">
                    <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js" type="module"></script>
                    <dotlottie-wc src="https://lottie.host/3ffaa88c-e8ac-4b0e-9fcc-0029b59d764a/CXHALuTfPV.lottie" class="lottie-robot" style="width: 350px; height: 350px;" autoplay loop>
                    </dotlottie-wc>
                </div>

                <h1 class="welcome-title">Welcome Back!</h1>
                <p class="welcome-subtitle">Hi, <strong>{{ Auth::user()->username ?? 'User' }}</strong> 👋</p>
            </div>

            <!-- Portal Cards -->
            <div class="portals-section">
                <div class="row justify-content-center g-4">
                    @foreach ($portals as $key => $url)
                    @php
                    $jabatan = strtolower(Auth::user()->jabatan ?? '');
                    $departemen = strtoupper(Auth::user()->departemen ?? '');
                    $canAccess = false;

                    // RULE 1: Semua Dept Head dari departemen apapun bisa akses semua portal
                    if ($jabatan === 'dept_head') {
                    $canAccess = true;
                    }
                    // RULE 2: Semua user dari Departemen IT bisa akses semua portal
                    elseif ($departemen === 'IT') {
                    $canAccess = true;
                    }
                    // RULE 3: User lain hanya bisa akses portal sesuai departemen mereka
                    else {
                    $jabatanUpper = strtoupper($jabatan);

                    $portalAccess = [
                    'engineering' => ['ENGINEERING', 'ENG'],
                    'warehouse' => ['WAREHOUSE', 'WH'],
                    'production' => ['PRODUCTION', 'PROD'],
                    'qc' => ['QC', 'QUALITY CONTROL'],
                    ];

                    if (isset($portalAccess[$key])) {
                    foreach ($portalAccess[$key] as $allowedRole) {
                    if (str_contains($jabatanUpper, $allowedRole) || str_contains($departemen, $allowedRole)) {
                    $canAccess = true;
                    break;
                    }
                    }
                    }
                    }
                    @endphp

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="portal-card {{ !$canAccess ? 'disabled' : '' }}">
                            <div class="portal-icon">
                                @if($key === 'engineering')
                                <i class="ri-tools-line"></i>
                                @elseif($key === 'warehouse')
                                <i class="ri-archive-line"></i>
                                @elseif($key === 'production')
                                <i class="ri-settings-3-line"></i>
                                @elseif($key === 'qc')
                                <i class="ri-checkbox-circle-line"></i>
                                @else
                                <i class="ri-dashboard-line"></i>
                                @endif
                            </div>

                            <h5 class="portal-title">{{ ucfirst($key) }}</h5>
                            <p class="portal-description">
                                Akses portal {{ $key }} untuk melihat data dan aktivitas departemen secara lengkap dan terperinci.
                            </p>

                            @if($canAccess)
                            <form method="POST" action="{{ route('portal.redirect', $key) }}" class="portal-form" data-target="{{ $key }}">
                                @csrf
                                <button type="submit" class="portal-btn">
                                    <i class="ri-login-circle-line me-2"></i>
                                    Masuk ke {{ ucfirst($key) }}
                                </button>
                            </form>
                            @else
                            <button type="button" class="portal-btn" disabled onclick="showAccessDenied('{{ ucfirst($key) }}')">
                                <i class="ri-lock-line me-2"></i>
                                Akses Terbatas
                            </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alert Notification -->
<div id="alertNotification" class="alert-notification">
    <div class="alert-content">
        <i class="ri-error-warning-line alert-icon"></i>
        <div class="alert-text">
            <div class="alert-title">Akses Ditolak</div>
            <div class="alert-message" id="alertMessage"></div>
        </div>
    </div>
</div>

<!-- AOS JS -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-out-cubic'
    });

    // Show access denied notification
    function showAccessDenied(portalName) {
        const alertBox = document.getElementById('alertNotification');
        const alertMessage = document.getElementById('alertMessage');

        alertMessage.textContent = `Anda tidak memiliki akses ke portal ${portalName}. Hanya FM dan IT yang dapat mengakses semua portal.`;

        alertBox.classList.add('show');

        setTimeout(() => {
            alertBox.classList.remove('show');
        }, 5000);
    }

    // Portal form handler
    document.querySelectorAll('.portal-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const newForm = document.createElement('form');
            newForm.method = this.method;
            newForm.action = this.action;
            newForm.target = '_blank';

            this.querySelectorAll('input, hidden, [name]').forEach(input => {
                const clone = input.cloneNode(true);
                newForm.appendChild(clone);
            });

            document.body.appendChild(newForm);
            newForm.submit();
            document.body.removeChild(newForm);
        });
    });
</script>
@endsection