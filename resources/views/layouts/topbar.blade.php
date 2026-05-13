<nav
    class="fixed top-0 w-full z-50 border-b bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-gray-200 dark:border-gray-800 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard.index') }}"
                class="flex items-center gap-2 text-xl font-bold tracking-tighter text-gray-900 dark:text-white italic">
                <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="BAS Logo" class="w-8 h-8 object-contain">
                PT. BAS
            </a>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="relative" id="notifContainer">
                    <button id="notifBtn"
                        class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors cursor-pointer active:opacity-70 relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span id="notifBadge"
                            class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full hidden"></span>
                    </button>
                    <div id="notifDropdown"
                        class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-2xl hidden border border-gray-100 z-50 overflow-hidden transform origin-top-right transition-all duration-200">
                        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-white">
                            <h6 class="text-sm font-bold text-gray-900">Notifications</h6>
                            <span id="notifCount"
                                class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full font-bold hidden">0
                                New</span>
                        </div>
                        <div id="notifList" class="max-h-[350px] overflow-y-auto divide-y divide-gray-50">
                            <!-- Items auto-generated -->
                            <div class="py-12 px-4 text-center">
                                <div
                                    class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <span class="material-symbols-outlined text-gray-300" style="font-size: 24px;">notifications_none</span>
                                </div>
                                <p class="text-xs text-gray-400">No new notifications</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative" id="userMenuContainer">
                    <button id="userMenuBtn"
                        class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors cursor-pointer active:opacity-70">
                        <span class="material-symbols-outlined">account_circle</span>
                    </button>
                    <div id="userMenuDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden border border-gray-200 z-50">
                        <div class="px-4 py-3 text-sm text-gray-700 border-b border-gray-200">
                            <p class="font-bold">{{ Auth::user()?->username ?? 'User' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()?->jabatan ?? '' }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors cursor-pointer">Sign
                                out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
