<!-- profile/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Background Banner -->
        <div class="profile-foreground position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg">
                <img src="https://via.placeholder.com/1200x300/667eea/667eea" alt="profile-bg" class="profile-wid-img" />
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="border-radius: 8px; border: none;">
            <i class="bi bi-check-circle me-2"></i>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
            <div class="row g-4">
                <!-- Profile Image -->
                <div class="col-auto">
                    <div class="avatar-lg">
                        @if ($user->image)
                        <img src="{{ asset('storage/profiles/' . $user->image) }}" alt="user-img" class="img-thumbnail rounded-circle" style="width: 150px; height: 100px; object-fit: cover;" />
                        @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 8px 16px rgba(0,0,0,0.15);">
                            <i class="bi bi-person-fill" style="font-size: 60px; color: white;"></i>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="col">
                    <div class="p-2">
                        <h3 class="text-white mb-1" style="font-weight: 700;">{{ $user->username }}</h3>
                        <p class="text-white-75 mb-3" style="font-weight: 500;">{{ $user->departemen }}</p>
                        <div class="hstack text-white-50 gap-3">
                            <div>
                                <i class="bi bi-building me-2" style="color: rgba(255,255,255,0.8); font-size: 16px;"></i>
                                <span>{{ $user->bagian }}</span>
                            </div>
                            <div>
                                <i class="bi bi-person-badge me-2" style="color: rgba(255,255,255,0.8); font-size: 16px;"></i>
                                <span>{{ $user->nik }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="col-12 col-lg-auto order-last order-lg-0">
                    <div class="text-center text-lg-end">
                        <a href="{{ route('profile.edit') }}" class="btn btn-success btn-lg" style="border-radius: 8px; padding: 10px 28px; font-weight: 600;">
                            <i class="bi bi-pencil-square me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist" style="border-bottom: 2px solid #e0e0e0; padding-bottom: 0;">
                        <li class="nav-item">
                            <a class="nav-link active fs-14" data-bs-toggle="tab" href="#overview-tab" role="tab" style="border-radius: 0; border-bottom: 3px solid #667eea; padding-bottom: 12px; font-weight: 600;">
                                <i class="bi bi-info-circle d-inline-block d-md-none me-2"></i><span class="d-none d-md-inline-block">Informasi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-14" data-bs-toggle="tab" href="#security-tab" role="tab" style="border-radius: 0; padding-bottom: 12px; font-weight: 600;">
                                <i class="bi bi-shield-lock d-inline-block d-md-none me-2"></i><span class="d-none d-md-inline-block">Keamanan</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content pt-4">
                    <!-- Overview Tab -->
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <!-- Info Sidebar -->
                            <div class="col-xxl-3">
                                <!-- Personal Information Card -->
                                <div class="card mb-4" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.07); border-radius: 12px;">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4" style="font-weight: 700;">Informasi Pribadi</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="ps-0" scope="row" style="font-weight: 600; font-size: 0.875rem;">Username :</th>
                                                        <td class="text-muted" style="color: #333; font-weight: 500;">{{ $user->username }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row" style="font-weight: 600; font-size: 0.875rem;">Email :</th>
                                                        <td class="text-muted" style="color: #333; font-weight: 500;">{{ $user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row" style="font-weight: 600; font-size: 0.875rem;">NIK :</th>
                                                        <td class="text-muted" style="color: #333; font-weight: 500;">{{ $user->nik }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row" style="font-weight: 600; font-size: 0.875rem;">Departemen :</th>
                                                        <td class="text-muted" style="color: #333; font-weight: 500;">{{ $user->departemen }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="ps-0" scope="row" style="font-weight: 600; font-size: 0.875rem;">Bagian :</th>
                                                        <td class="text-muted" style="color: #333; font-weight: 500;">{{ $user->bagian }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions Card -->
                                <div class="card" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.07); border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <div class="card-body p-4">
                                        <h5 class="card-title mb-3" style="font-weight: 700;color:white;">Akses Cepat</h5>
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm" style="border-radius: 6px; font-weight: 600;">
                                                <i class="bi bi-pencil me-2"></i>Edit Data
                                            </a>
                                            <a href="{{ route('profile.change-password') }}" class="btn btn-light btn-sm" style="border-radius: 6px; font-weight: 600;">
                                                <i class="bi bi-key me-2"></i>Ubah Password
                                            </a>
                                            <form action="{{ route('logout') }}" method="POST" class="d-grid">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-light btn-sm" style="border-radius: 6px; font-weight: 600;">
                                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Content -->
                            <div class="col-xxl-9">
                                <!-- About Card -->
                                <div class="card mb-4" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.07); border-radius: 12px;">
                                    <div class="card-body p-4">
                                        <h5 class="card-title mb-3" style="font-weight: 700; ">Tentang Profil</h5>
                                        <p class="text-muted mb-4" style="line-height: 1.6;">
                                            Ini adalah profil akun Anda di sistem. Anda dapat memperbarui informasi pribadi, departemen, dan keamanan akun melalui halaman ini.
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex" style="padding: 16px;  border-radius: 8px; border-left: 4px solid #667eea; margin-bottom: 16px;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-title rounded-circle" style="width: 50px; height: 50px; background-color: #667eea; color: white; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                                            <i class="bi bi-person-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p >Status Akun</p>
                                                        <h6 >Aktif</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex" style="padding: 16px;  border-radius: 8px; border-left: 4px solid #764ba2; margin-bottom: 16px;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-title rounded-circle" style="width: 50px; height: 50px; background-color: #764ba2; color: white; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                                            <i class="bi bi-calendar-event"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-1" style="font-weight: 600;  font-size: 0.875rem;">Bergabung Sejak</p>
                                                        <h6 class="mb-0" style="color: #764ba2; font-weight: 700;">{{ $user->created_at->format('d M Y') }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Verification Status -->
                                <div class="card" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.07); border-radius: 12px; border-left: 4px solid #667eea;">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-title rounded-circle" style="width: 50px; height: 50px; background-color: #667eea;  display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                                    <i class="bi bi-shield-check"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1" style="font-weight: 700; ">Keamanan Akun Terjaga</h6>
                                                <p class="text-muted mb-0" style="font-size: 0.875rem;">Profil Anda dilindungi dengan enkripsi password yang aman.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.07); border-radius: 12px;">
                                    <div class="card-body p-4">
                                        <h5 class="card-title mb-4" style="font-weight: 700; ">Pengaturan Keamanan</h5>

                                        <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                            <div>
                                                <h6 class="mb-1" style="font-weight: 600; ">Password</h6>
                                                <p class="text-muted mb-0" style="font-size: 0.875rem;">Ubah password akun Anda secara berkala untuk keamanan maksimal</p>
                                            </div>
                                            <a href="{{ route('profile.change-password') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 6px;">
                                                <i class="bi bi-pencil me-2"></i>Ubah
                                            </a>
                                        </div>

                                        <div class="py-3 border-bottom">
                                            <h6 class="mb-3" style="font-weight: 600; ">Status Verifikasi</h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-success">Terverifikasi</span>
                                                <small class="text-muted">Email Anda telah terverifikasi</small>
                                            </div>
                                        </div>

                                        <div class="py-3">
                                            <h6 class="mb-3" style="font-weight: 600; ">Sesi Aktif</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.875rem;">Anda saat ini login dan dapat mengakses semua fitur aplikasi.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection