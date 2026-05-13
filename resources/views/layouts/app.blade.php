<!DOCTYPE html>
<html class="light" lang="en">

    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Main - BAS</title>
        <link rel="icon" href="{{ asset('assets/images/logo/kecap.png') }}" type="image/png">

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
            rel="stylesheet" />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />

        {{-- SweetAlert2 CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"
            type="text/css" />

        <!-- jQuery should be included before DataTables -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('styles')
    </head>

    <body class="bg-[#F5F7F9] font-body-md text-on-surface flex flex-col min-h-screen">
        <!-- TopNavBar -->
        @include('layouts.topbar')

        <main class="pt-16 flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // User Menu Toggle
                const userBtn = document.getElementById('userMenuBtn');
                const userMenu = document.getElementById('userMenuDropdown');

                if (userBtn && userMenu) {
                    userBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        userMenu.classList.toggle('hidden');
                        if (notifMenu) notifMenu.classList.add('hidden');
                    });
                }

                // Notifications Toggle
                const notifBtn = document.getElementById('notifBtn');
                const notifMenu = document.getElementById('notifDropdown');

                if (notifBtn && notifMenu) {
                    notifBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        notifMenu.classList.toggle('hidden');
                        if (userMenu) userMenu.classList.add('hidden');
                        if (!notifMenu.classList.contains('hidden')) {
                            fetchNotifications();
                        }
                    });
                }

                document.addEventListener('click', (e) => {
                    if (userMenu && !userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                        userMenu.classList.add('hidden');
                    }
                    if (notifMenu && !notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                        notifMenu.classList.add('hidden');
                    }
                });

                // Fetch Notifications Logic
                function fetchNotifications() {
                    $.ajax({
                        url: "{{ route('notifications.warehouse') }}",
                        method: 'GET',
                        success: function(res) {
                            if (res.success && res.data) {
                                renderNotifications(res.data);
                            }
                        },
                        error: function(err) {
                            console.error('Failed to fetch warehouse notifications', err);
                        }
                    });
                }

                function renderNotifications(data) {
                    const list = document.getElementById('notifList');
                    const badge = document.getElementById('notifBadge');
                    const countSpan = document.getElementById('notifCount');
                    
                    const unread = data.filter(n => !n.is_read);
                    
                    if (unread.length > 0) {
                        badge.classList.remove('hidden');
                        countSpan.textContent = `${unread.length} New`;
                        countSpan.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                        countSpan.classList.add('hidden');
                    }

                    if (data.length === 0) {
                        list.innerHTML = `
                            <div class="py-12 px-4 text-center">
                                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <span class="material-symbols-outlined text-gray-300" style="font-size: 24px;">notifications_none</span>
                                </div>
                                <p class="text-xs text-gray-400">No notifications found</p>
                            </div>
                        `;
                        return;
                    }

                    let html = '';
                    data.forEach(n => {
                        // Gunakan bridge SSO agar user otomatis login ke warehouse
                        const redirectBaseUrl = "{{ route('portal.redirect.get', 'warehouse') }}";
                        const fullUrl = `${redirectBaseUrl}?redirect=${encodeURIComponent(n.url)}`;
                        
                        const icon = n.type === 'barang_baru' ? 'inventory_2' : 'notifications';
                        const iconColor = n.type === 'barang_baru' ? 'text-orange-500' : 'text-blue-500';
                        const bgColor = n.type === 'barang_baru' ? 'bg-orange-50' : 'bg-blue-50';

                        html += `
                            <a href="${fullUrl}" target="_blank" class="flex gap-3 px-4 py-4 hover:bg-gray-50/80 transition-all ${!n.is_read ? 'bg-blue-50/20' : ''}">
                                <div class="flex-shrink-0 relative">
                                    <div class="w-9 h-9 rounded-xl ${bgColor} flex items-center justify-center">
                                        <span class="material-symbols-outlined ${iconColor} text-xl">${icon}</span>
                                    </div>
                                    ${!n.is_read ? '<span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-blue-500 rounded-full border-2 border-white"></span>' : ''}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <div class="flex justify-between items-start mb-0.5">
                                        <p class="text-[12px] font-bold text-gray-900 truncate pr-2">${n.title}</p>
                                        <span class="text-[10px] text-gray-400 whitespace-nowrap">${n.created_at_human}</span>
                                    </div>
                                    <p class="text-[11px] text-gray-600 leading-snug line-clamp-2">${n.message}</p>
                                </div>
                            </a>
                        `;
                    });
                    list.innerHTML = html;
                }

                // Initial fetch and interval
                fetchNotifications();
                setInterval(fetchNotifications, 60000); // Every 1 minute
            });
        </script>
        @yield('scripts')
    </body>

</html>
