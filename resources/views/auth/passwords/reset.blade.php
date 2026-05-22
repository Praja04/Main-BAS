<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Set New Password | Corporate Portal</title>
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
                <h1 class="font-h2 text-h2 text-on-surface mb-2">Set New Password</h1>
                <p class="text-secondary font-body-md">Please enter your new password below.</p>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block font-label-bold text-on-surface mb-2">Email Address</label>
                    <div class="relative">
                        <x-heroicon-o-envelope class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                        <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 outline-none transition-all bg-white/80 backdrop-blur-sm shadow-inner" placeholder="Enter your email" required autofocus>
                    </div>
                </div>

                <div>
                    <label for="password" class="block font-label-bold text-on-surface mb-2">New Password</label>
                    <div class="relative">
                        <x-heroicon-o-lock-closed class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                        <input type="password" id="password" name="password" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 outline-none transition-all bg-white/80 backdrop-blur-sm shadow-inner" placeholder="New password" required>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block font-label-bold text-on-surface mb-2">Confirm New Password</label>
                    <div class="relative">
                        <x-heroicon-o-key class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 outline-none transition-all bg-white/80 backdrop-blur-sm shadow-inner" placeholder="Confirm new password" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary-container text-on-primary-container px-8 py-4 rounded-xl font-label-bold text-label-bold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all active:scale-95 mt-4 group cursor-pointer">
                    Reset Password
                    <x-heroicon-o-lock-open class="w-5 h-5 group-hover:scale-110 transition-transform" />
                </button>
            </form>
        </div>
    </div>
</body>
</html>
