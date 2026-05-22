@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
            <p class="text-sm text-gray-500">View and manage your account information</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('profile.edit') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all text-sm font-semibold shadow-sm">
                <x-heroicon-o-pencil-square class="w-4 h-4" />
                Edit Profile
            </a>
            <a href="{{ route('profile.change-password') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg flex items-center gap-2 transition-all text-sm font-semibold shadow-sm">
                <x-heroicon-o-lock-closed class="w-4 h-4" />
                Change Password
            </a>
        </div>
    </div>

    @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500" />
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header/Banner -->
        <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-600 relative">
            <div class="absolute -bottom-12 left-8">
                @if ($user->image)
                <img src="{{ asset('uploads/users/' . $user->image) }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-lg bg-white">
                @else
                <div class="w-24 h-24 rounded-2xl bg-gray-100 border-4 border-white shadow-lg flex items-center justify-center text-gray-400">
                    <x-heroicon-o-user class="w-12 h-12" />
                </div>
                @endif
            </div>
        </div>

        <div class="pt-16 pb-8 px-8">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900">{{ $user->username }}</h2>
                <p class="text-gray-500 text-sm capitalize">{{ $user->role }} • {{ $user->jabatan ? str_replace('_', ' ', $user->jabatan) : 'No Position' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Full Name</label>
                        <p class="text-gray-800 font-medium">{{ $user->nama_lengkap ?? 'Not Set' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Email Address</label>
                        <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">NIK</label>
                        <p class="text-gray-800 font-medium">{{ $user->nik }}</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Department</label>
                        <p class="text-gray-800 font-medium">{{ $user->departemen }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Section (Bagian)</label>
                        <p class="text-gray-800 font-medium">{{ $user->bagian }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Member Since</label>
                        <p class="text-gray-800 font-medium">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
