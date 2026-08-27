<nav
    class="fixed top-0 w-full z-50 border-b bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-gray-200 dark:border-gray-800 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard.index') }}"
                class="flex items-center gap-2 text-xl font-bold tracking-tighter text-on-surface italic">
                <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="BAS Logo" class="w-8 h-8 object-contain">
                PT. BAS
            </a>


        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <!-- Main Navigation -->
                @auth
                    <div class="hidden md:flex items-center gap-1">
                        {{-- <a href="{{ route('dashboard.index') }}" 
                        class="px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('dashboard.*') ? 'bg-primary-container text-on-primary-container' : 'text-secondary hover:bg-gray-100' }} transition-all flex items-center gap-2">
                        <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                        Dashboard
                    </a> --}}

                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('users.index') }}"
                                class="px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('users.*') ? 'bg-primary-container text-on-primary-container' : 'text-secondary hover:bg-gray-100' }} transition-all flex items-center gap-2">
                                <x-heroicon-o-users class="w-5 h-5" />
                                User Management
                            </a>
                        @endif
                        
                        <!-- IMS Menus -->
                        @if (strtoupper(Auth::user()->departemen) === 'IMS')
                            <a href="{{ route('ims.dashboard') }}"
                                class="px-4 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('ims.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-secondary hover:bg-gray-100' }} transition-all flex items-center gap-2">
                                <x-heroicon-o-chart-bar class="w-5 h-5" />
                                IMS Dashboard
                            </a>
                        @endif
                       
                    </div>
                @endauth
                <div class="relative" id="notifContainer">
                    <button id="notifBtn"
                        class="p-2 text-secondary hover:bg-gray-100 rounded-full transition-colors cursor-pointer active:opacity-70 relative">
                        <x-heroicon-o-bell class="w-6 h-6" />
                        <span id="notifBadge"
                            class="absolute top-1.5 right-1.5 w-2 h-2 bg-primary-container rounded-full hidden"></span>
                    </button>
                    <div id="notifDropdown"
                        class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-2xl hidden border border-gray-100 z-50 overflow-hidden transform origin-top-right transition-all duration-200">
                        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-white">
                            <h6 class="text-sm font-bold text-on-surface">Notifications</h6>
                            <span id="notifCount"
                                class="text-[10px] bg-primary-container text-on-primary-container px-2 py-0.5 rounded-full font-bold hidden">0
                                New</span>
                        </div>
                        <div id="notifList" class="max-h-[350px] overflow-y-auto divide-y divide-gray-50">
                            <!-- Items auto-generated -->
                            <div class="py-12 px-4 text-center">
                                <div
                                    class="w-12 h-12 bg-surface-container rounded-full flex items-center justify-center mx-auto mb-3">
                                    <x-heroicon-o-bell-slash class="w-6 h-6 text-outline" />
                                </div>
                                <p class="text-xs text-secondary">No new notifications</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative" id="userMenuContainer">
                    <button id="userMenuBtn"
                        class="flex items-center gap-2 p-1.5 pr-3 text-secondary hover:bg-gray-100 rounded-full transition-colors cursor-pointer active:opacity-70 border border-gray-100">
                        @if (Auth::user()?->image)
                            <img src="{{ asset('uploads/users/' . Auth::user()->image) }}"
                                class="w-8 h-8 rounded-full object-cover">
                        @else
                            <x-heroicon-o-user-circle class="w-8 h-8" />
                        @endif
                        <span class="text-sm font-bold hidden sm:block">{{ Auth::user()?->username }}</span>
                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                    </button>
                    <div id="userMenuDropdown"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 hidden border border-gray-100 z-50 transform origin-top-right transition-all">
                        <div class="px-4 py-3 text-sm border-b border-gray-100 mb-1">
                            <p class="font-bold text-on-surface">{{ Auth::user()?->username }}</p>
                            <p class="text-xs text-secondary truncate">{{ Auth::user()?->email }}</p>
                            <span
                                class="inline-block mt-2 px-2 py-0.5 bg-primary-fixed text-on-primary-fixed-variant text-[10px] font-bold rounded-full uppercase tracking-wider">
                                {{ Auth::user()?->role }}
                            </span>
                        </div>

                        <a href="{{ route('profile.show') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface hover:bg-primary-container/5 hover:text-primary transition-colors">
                            <x-heroicon-o-user class="w-5 h-5" />
                            My Profile
                        </a>
                        <a href="{{ route('profile.change-password') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-on-surface hover:bg-primary-container/5 hover:text-primary transition-colors">
                            <x-heroicon-o-lock-closed class="w-5 h-5" />
                            Change Password
                        </a>

                        <div class="h-px bg-gray-100 my-1 mx-2"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-error hover:bg-error-container/20 transition-colors cursor-pointer">
                                <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
