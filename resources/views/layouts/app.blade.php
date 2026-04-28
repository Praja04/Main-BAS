<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Main - BAS</title>
    <link rel="icon" href="{{ asset('assets/images/logo/kecap.png') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    {{-- SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />

    <!-- jQuery should be included before DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>

<body class="bg-[#F5F7F9] font-body-md text-on-surface flex flex-col min-h-screen">
    <!-- TopNavBar -->
    <nav class="fixed top-0 w-full z-50 border-b bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-gray-200 dark:border-gray-800 shadow-sm">
        <div class="max-w-[1440px] mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2 text-xl font-bold tracking-tighter text-gray-900 dark:text-white italic">
                    <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="BAS Logo" class="w-8 h-8 object-contain">
                    PT. BAS
                </a>
                <!-- <div class="hidden md:flex gap-6 items-center font-sans antialiased font-medium text-sm tracking-tight">
                    <a class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-200 cursor-pointer active:opacity-70" href="{{ route('dashboard.index') }}">Dashboard</a>
                </div> -->
            </div>
            <div class="flex items-center gap-4">
                <div class="relative hidden lg:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input class="pl-10 pr-4 py-1.5 rounded-full border-none bg-secondary-container/50 text-sm focus:ring-2 focus:ring-primary-container w-64 outline-none" placeholder="Search portal..." type="text" />
                </div>
                <div class="flex items-center gap-2">
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors cursor-pointer active:opacity-70">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors cursor-pointer active:opacity-70">
                        <span class="material-symbols-outlined">help</span>
                    </button>
                    <div class="relative" id="userMenuContainer">
                        <button id="userMenuBtn" class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors cursor-pointer active:opacity-70">
                            <span class="material-symbols-outlined">account_circle</span>
                        </button>
                        <div id="userMenuDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden border border-gray-200 z-50">
                            <div class="px-4 py-3 text-sm text-gray-700 border-b border-gray-200">
                                <p class="font-bold">{{ Auth::user()?->username ?? 'User' }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()?->jabatan ?? '' }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors cursor-pointer">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main class="pt-16 flex-grow">
        @yield('content')
    </main>
    <!-- Footer -->
    <footer class="bg-gray-50 dark:bg-gray-950 w-full py-12 border-t mt-auto border-gray-200 dark:border-gray-800">
        <div class="max-w-[1440px] mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-col md:items-start items-center">
                <span class="text-sm font-black text-gray-400 uppercase tracking-tighter mb-2">PT. BAS</span>
                <p class="font-sans text-xs font-normal text-gray-500 dark:text-gray-400">© {{ date('Y') }} PT. BAS. All rights reserved.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8 font-sans text-xs font-normal">
                <a class="text-gray-500 dark:text-gray-400 hover:underline hover:text-red-600 transition-all ease-in-out" href="#">Privacy Policy</a>
                <a class="text-gray-500 dark:text-gray-400 hover:underline hover:text-red-600 transition-all ease-in-out" href="#">Terms of Service</a>
                <a class="text-gray-500 dark:text-gray-400 hover:underline hover:text-red-600 transition-all ease-in-out" href="#">Internal Directory</a>
                <a class="text-gray-500 dark:text-gray-400 hover:underline hover:text-red-600 transition-all ease-in-out" href="#">Support</a>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('userMenuBtn');
            const menu = document.getElementById('userMenuDropdown');

            if (btn && menu) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!menu.contains(e.target) && !btn.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    @yield('scripts')
</body>

</html>