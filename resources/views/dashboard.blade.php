@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[480px] lg:min-h-[400px] flex items-center overflow-hidden py-20 lg:py-0">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover opacity-10 brightness-50" alt="corporate background"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCj3-I0iwUPe8-YZVZ_aLZdwjTPhYQCK4VojWMQiOuwfmU66K0MecvAFulu1xII21A2d1OY8zBZqY1daGyM7STMeKGqz74XghAqg0UxTE48TyYH4hbhu5b-WjYqLv2jTAyCfDP2JM_C8eC2WGyYlpoz2YDgKnRkU1F4rCBdzpwWua5Q1B34P1PnOpegJfwwOmCo2O7TFlAZM694N3GQuSL9yn_Tn3u1NWuh00lng_nJV3ghssKccv8kPcBA_apUA9ZVB7DL878Ue18" />
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-transparent"></div>
        </div>
        <div class="max-w-[1440px] mx-auto px-6 w-full relative z-10">
            <div class="max-w-2xl">
                <h1 class="font-h1 text-h1 text-on-surface mb-4">PT. Bumi Alam Segar</h1>
                <p class="font-body-lg text-body-lg text-secondary mb-8">
                    Selamat datang di portal BAS, anda dapat mengakses portal <span
                        class="text-primary font-bold">Engineering, Quality Control,
                        Production, and Warehouse</span>
                </p>
                <p class="font-body-md text-secondary mb-8">Selamat Datang Kembali, <strong
                        class="text-primary">{{ Auth::user()?->username ?? 'User' }}</strong>!</p>
            </div>
        </div>
    </section>

    <!-- Main Grid Section -->
    <section id="portals" class="max-w-[1440px] mx-auto px-6 py-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-h2 text-h2">Operational Departments</h2>
            <div class="flex gap-2 items-center text-accent-success font-label-bold">
                <span class="w-2 h-2 rounded-full bg-accent-success animate-pulse"></span>
                System Online
            </div>
        </div>

        <!-- Alert Message Container -->
        <div id="alertMessageContainer"
            class="hidden mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
            <div class="flex items-center">
                <x-heroicon-o-exclamation-circle class="w-5 h-5 mr-2" />
                <p id="alertMessageText" class="font-medium"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
            <!-- IMS Portal Card (Internal to Main-BAS) -->
            <div class="bg-white p-md rounded-[12px] border border-gray-200 shadow-sm hover:shadow-md transition-shadow flex flex-col h-full group relative">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-700">
                        <x-heroicon-o-document-text class="w-7 h-7" />
                    </div>
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider">Internal</span>
                </div>
                <h3 class="font-h3 text-h3 mb-2">IMS Document Control</h3>
                <p class="text-secondary font-body-md mb-8 flex-grow">Manage standard operating procedures, forms, and official company document requests globally.</p>
                
                @if (strtoupper(Auth::user()->departemen) === 'IMS')
                    <a href="{{ route('ims.dashboard') }}" class="w-full py-3 mb-2 rounded-lg border-2 border-blue-600 text-blue-600 font-label-bold hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center gap-2 group-hover:scale-[1.01]">
                        Open IMS Dashboard
                        <x-heroicon-o-chart-bar class="w-5 h-5" />
                    </a>
                @endif
                <a href="{{ route('ims.document_requests.index') }}" class="w-full py-3 rounded-lg bg-blue-50 text-blue-700 font-label-bold hover:bg-blue-100 transition-all flex items-center justify-center gap-2 mt-auto">
                    Document Requests Log
                    <x-heroicon-o-arrow-right class="w-5 h-5" />
                </a>
            </div>

            @foreach ($portals as $key => $url)
                @php
                    $jabatan = strtolower(Auth::user()?->jabatan ?? '');
                    $departemen = strtoupper(Auth::user()?->departemen ?? '');
                    $canAccess = false;

                    if ($jabatan === 'dept_head' || $jabatan === 'fm') {
                        $canAccess = true;
                    }
                    elseif ($departemen === 'IT') {
                        $canAccess = true;
                    }
                    else {
                        $jabatanUpper = strtoupper($jabatan);
                        $portalAccess = [
                            'engineering' => ['ENGINEERING', 'ENG'],
                            'warehouse' => ['WAREHOUSE', 'WH'],
                            'production' => ['PRODUCTION', 'PROD'],
                            'qc' => ['QUALITY CONTROL', 'QC'],
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

                    $portalStatusText = 'Online';
                    $portalStatusClass = 'bg-green-100 text-accent-success';
                    $portalDesc = 'Akses portal ' . ucfirst($key) . ' untuk melihat data dan aktivitas departemen secara lengkap dan terperinci.';
                    $iconComponent = 'heroicon-o-squares-2x2';

                    if ($key === 'engineering') {
                        $iconComponent = 'heroicon-o-beaker';
                        $portalStatusText = 'Active';
                        $portalDesc = 'R&D lifecycle management, technical schematics repository, and prototype performance monitoring.';
                    } elseif ($key === 'warehouse') {
                        $iconComponent = 'heroicon-o-archive-box';
                        $portalStatusText = 'Active';
                        $portalDesc = 'Automated inventory tracking, logistics coordination, and storage optimization for high-volume output.';
                    } elseif ($key === 'production') {
                        $iconComponent = 'heroicon-o-cpu-chip';
                        $portalStatusText = 'Active';
                        $portalDesc = 'Live assembly line telemetry, output forecasting, and personnel shift scheduling systems.';
                    } elseif ($key === 'qc') {
                        $iconComponent = 'heroicon-o-check-badge';
                        $portalStatusText = 'Active';
                        $portalDesc = 'Strict adherence to ISO standards, batch testing analytics, and defect tracking reports.';
                    }
                @endphp

                <!-- Card -->
                <div
                    class="bg-white p-md rounded-[12px] border {{ $canAccess ? 'border-gray-200 shadow-sm hover:shadow-md' : 'border-gray-300 shadow-none opacity-75 grayscale-[50%]' }} transition-shadow flex flex-col h-full group relative">
                    @if (!$canAccess)
                        <div
                            class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full z-10 flex items-center gap-1 shadow-sm">
                            <x-heroicon-o-lock-closed class="w-3.5 h-3.5" />
                            Restricted Access
                        </div>
                    @endif
                    <div class="flex justify-between items-start mb-6">
                        <div
                            class="w-12 h-12 bg-primary-fixed rounded-xl flex items-center justify-center text-primary-container">
                            <x-dynamic-component :component="$iconComponent" class="w-7 h-7" />
                        </div>
                        @if ($canAccess)
                            <span
                                class="px-3 py-1 rounded-full {{ $portalStatusClass }} text-[10px] font-bold uppercase tracking-wider">{{ $portalStatusText }}</span>
                        @endif
                    </div>
                    <h3 class="font-h3 text-h3 mb-2">
                        {{ is_array($url) && isset($url['label']) ? $url['label'] : ucfirst($key) }}</h3>
                    <p class="text-secondary font-body-md mb-8 flex-grow">{{ $portalDesc }}</p>

                    @if ($canAccess)
                        <form method="POST" action="{{ route('portal.redirect', $key) }}" class="portal-form mt-auto">
                            @csrf
                            <button type="submit"
                                class="w-full py-3 rounded-lg border-2 border-primary-container text-primary-container font-label-bold hover:bg-primary-container hover:text-white transition-all flex items-center justify-center gap-2 group-hover:scale-[1.01] cursor-pointer">
                                Enter Portal
                                <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />
                            </button>
                        </form>
                    @else
                        <button type="button" onclick="showAccessDenied('{{ ucfirst($key) }}')"
                            class="w-full py-3 rounded-lg border-2 border-gray-400 text-gray-500 font-label-bold hover:bg-gray-100 transition-all flex items-center justify-center gap-2 mt-auto">
                            Access Denied
                            <x-heroicon-o-lock-closed class="w-5 h-5" />
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function showAccessDenied(portalName) {
            const alertContainer = document.getElementById('alertMessageContainer');
            const alertText = document.getElementById('alertMessageText');

            alertText.textContent =
                `You don't have access to the ${portalName} portal. Only FM, Dept Head, and IT can access all portals.`;
            alertContainer.classList.remove('hidden');
            alertContainer.classList.add('flex');

            // Auto hide after 5 seconds
            setTimeout(() => {
                alertContainer.classList.add('hidden');
                alertContainer.classList.remove('flex');
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
