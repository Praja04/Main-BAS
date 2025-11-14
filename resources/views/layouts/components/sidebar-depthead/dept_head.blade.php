@php
$jabatan = Auth::user()->jabatan;
$departemen = Auth::user()->departemen;
@endphp

@if (
($jabatan === 'dept_head') || $departemen === 'Engineering'
)
<li class="nav-item">
    <a href="{{ route('master.alat') }}" class="nav-link menu-link {{ request()->routeIs('master.alat') ? 'active' : '' }}">
        <i class="mdi mdi-book-cog"></i> <span data-key="t-albras">Alat Kalibrasi</span>
    </a>
</li>
@elseif (
($jabatan === 'dept_head') ||
( $departemen === 'Quality Control')
)


@elseif (
($jabatan === 'dept_head') ||
( $departemen === 'Produksi')
)

@elseif (
($jabatan === 'dept_head') ||
( $departemen === 'Warehouse')
)

@elseif (
($jabatan === 'dept_head') ||
( $departemen === 'Factory')
)

@endif