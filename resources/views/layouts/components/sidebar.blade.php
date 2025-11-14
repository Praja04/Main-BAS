<div class="app-menu navbar-menu">
    @php
    $jabatan = Auth::user()->jabatan;
    $departemen = Auth::user()->departemen;

    // Definisi menu berdasarkan departemen
    $menuConfig = [
    'engineering' => [
    ['route' => 'dashboard.boiler', 'icon' => 'ri-fire-line', 'label' => 'Boiler'],
    ['route' => 'dashboard.utility', 'icon' => 'ri-tools-line', 'label' => 'Utility'],
    ['route' => 'dashboard.scoring', 'icon' => 'ri-bar-chart-line', 'label' => 'Scoring'],
    ],
    'qc' => [
    ['route' => 'dashboard.blending', 'icon' => 'ri-flask-line', 'label' => 'Blending'],
    ['route' => 'dashboard.disolver', 'icon' => 'ri-contrast-drop-line', 'label' => 'Disolver'],
    ['route' => 'dashboard.monitoring_turun', 'icon' => 'ri-arrow-down-line', 'label' => 'Monitoring Turun'],
    ['route' => 'dashboard.pasteurisasi', 'icon' => 'ri-temp-hot-line', 'label' => 'Pasteurisasi'],
    ['route' => 'dashboard.monitoring_storage', 'icon' => 'ri-database-2-line', 'label' => 'Monitoring Storage'],
    ['route' => 'dashboard.rm', 'icon' => 'ri-list-check', 'label' => 'Raw Material'],
    ],
    'produksi' => [
    ['route' => 'dashboard.pasteurisasi1', 'icon' => 'ri-temp-hot-line', 'label' => 'Pasteurisasi 1'],
    ['route' => 'dashboard.pasteurisasi2', 'icon' => 'ri-temp-hot-line', 'label' => 'Pasteurisasi 2'],
    ['route' => 'dashboard.retail', 'icon' => 'ri-store-2-line', 'label' => 'Retail'],
    ['route' => 'dashboard.downtime_retail', 'icon' => 'ri-time-line', 'label' => 'Downtime Retail'],
    ],
    'warehouse' => [
    ['route' => 'dashboard.p2h', 'icon' => 'ri-checkbox-multiple-line', 'label' => 'P2H'],
    ['route' => 'dashboard.tkbm', 'icon' => 'ri-truck-line', 'label' => 'TKBM'],
    ['route' => 'dashboard.soh', 'icon' => 'ri-stack-line', 'label' => 'SOH'],
    ],
    ];

    // Icon untuk setiap departemen
    $deptIcons = [
    'engineering' => 'ri-settings-3-line',
    'qc' => 'ri-flask-line',
    'produksi' => 'ri-building-line',
    'warehouse' => 'ri-archive-line',
    ];

    // Filter menu berdasarkan role
    $allowedDepartments = [];
    if ($jabatan === 'dept_head') {
    // Dept Head bisa lihat semua dengan dropdown
    $allowedDepartments = array_keys($menuConfig);
    } else {
    // Supervisor dan Foreman hanya bisa lihat departemennya
    $allowedDepartments = [$departemen];
    }
    @endphp

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="" height="100">
            </span>
        </a>
        <a href="{{ route('dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo/kecap.png') }}" alt="" height="100">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar" class="p-3">
        <div class="container-fluid">
            <div id="two-column-menu"></div>

            <ul class="navbar-nav" id="navbar-nav">
                <!-- Dashboard Utama -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <!-- Menu Title -->
                <li class="menu-title">
                    <span data-key="t-menu">Menu Departemen</span>
                </li>

                <!-- Menu Berdasarkan Departemen -->
                @if($jabatan === 'dept_head')
                <!-- Dropdown untuk Dept Head -->
                @foreach($allowedDepartments as $dept)
                @if(isset($menuConfig[$dept]))
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebar{{ ucfirst($dept) }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar{{ ucfirst($dept) }}">
                        <i class="{{ $deptIcons[$dept] ?? 'ri-folder-line' }}"></i>
                        <span data-key="t-{{ $dept }}">{{ ucfirst($dept) }}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar{{ ucfirst($dept) }}">
                        <ul class="nav nav-sm flex-column">
                            @foreach($menuConfig[$dept] as $menu)
                            <li class="nav-item">
                                <a href="{{ route($menu['route']) }}" class="nav-link {{ request()->routeIs($menu['route']) ? 'active' : '' }}" data-key="t-{{ Str::slug($menu['label']) }}">
                                    <i class="{{ $menu['icon'] }} me-2"></i>{{ $menu['label'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endif
                @endforeach
                @else
                <!-- Menu biasa untuk Supervisor/Foreman -->
                @foreach($allowedDepartments as $dept)
                @if(isset($menuConfig[$dept]))
                @foreach($menuConfig[$dept] as $menu)
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs($menu['route']) ? 'active' : '' }}" href="{{ route($menu['route']) }}">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span data-key="t-{{ Str::slug($menu['label']) }}">{{ $menu['label'] }}</span>
                    </a>
                </li>
                @endforeach
                @endif
                @endforeach
                @endif

                <!-- Menu Data Mesin (khusus Engineering & Produksi) -->
                @if(($jabatan === 'dept_head') || ($jabatan === 'supervisor' && in_array($departemen, ['engineering', 'produksi'])))
                <li class="menu-title mt-3">
                    <span data-key="t-data-mesin">Data Mesin</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDataMesin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDataMesin">
                        <i class="ri-cpu-line"></i>
                        <span data-key="t-data-mesin">Data Mesin</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDataMesin">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('mesin.daily-tank') }}" class="nav-link {{ request()->routeIs('mesin.daily-tank') ? 'active' : '' }}" data-key="t-daily-tank">
                                    <i class="ri-database-line me-2"></i>Mesin Daily Tank
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mesin.pasteur1') }}" class="nav-link {{ request()->routeIs('mesin.pasteur1') ? 'active' : '' }}" data-key="t-pasteur1">
                                    <i class="ri-temp-hot-line me-2"></i>Mesin Pasteur 1
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mesin.pasteur2') }}" class="nav-link {{ request()->routeIs('mesin.pasteur2') ? 'active' : '' }}" data-key="t-pasteur2">
                                    <i class="ri-temp-hot-line me-2"></i>Mesin Pasteur 2
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mesin.disolver') }}" class="nav-link {{ request()->routeIs('mesin.disolver') ? 'active' : '' }}" data-key="t-disolver">
                                    <i class="ri-contrast-drop-line me-2"></i>Mesin Disolver
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mesin.boiler') }}" class="nav-link {{ request()->routeIs('mesin.boiler') ? 'active' : '' }}" data-key="t-boiler">
                                    <i class="ri-fire-line me-2"></i>Mesin Boiler
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mesin.glucose') }}" class="nav-link {{ request()->routeIs('mesin.glucose') ? 'active' : '' }}" data-key="t-glucose">
                                    <i class="ri-flask-line me-2"></i>Mesin Glucose
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Info User -->
                <li class="menu-title mt-4">
                    <span data-key="t-info">User Info</span>
                </li>
                <li class="nav-item">
                    <div class="px-3 py-2 text-muted small">
                        <div><strong>Jabatan:</strong> {{ ucfirst($jabatan) }}</div>
                        <div><strong>Departemen:</strong> {{ ucfirst($departemen) }}</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>