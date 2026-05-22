<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reset Password | Corporate Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/kecap.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F5F7F9] font-body-md text-on-surface flex flex-col min-h-screen relative">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-white/90 via-white/70 to-transparent"></div>
    </div>

    <div class="relative z-10 flex flex-col items-center justify-center flex-grow px-6 py-12">
        <div class="glass-card rounded-[24px] shadow-2xl p-10 w-full max-w-[480px] border border-white/50 relative overflow-hidden">
            <div class="text-center mb-8">
                <h1 class="font-h2 text-h2 text-on-surface mb-2">Reset Password</h1>
                <p class="text-secondary font-body-md">Enter your email to receive a password reset link.</p>
            </div>

            @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
                {{ session('status') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
                @csrf
                <div>
                    <label for="email" class="block font-label-bold text-on-surface mb-2">Email Address</label>
                    <div class="relative">
                        <x-heroicon-o-envelope class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 outline-none transition-all bg-white/80 backdrop-blur-sm shadow-inner" placeholder="Enter your email" required autofocus>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary-container text-on-primary-container px-8 py-4 rounded-xl font-label-bold text-label-bold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all active:scale-95 mt-4 group cursor-pointer">
                    Send Reset Link
                    <x-heroicon-o-paper-airplane class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-primary-container hover:underline flex items-center justify-center gap-2">
                    <x-heroicon-o-arrow-left class="w-4 h-4" />
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
