@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Change Password</h1>
        <p class="text-sm text-gray-500">Ensure your account is using a long, random password to stay secure.</p>
    </div>

    @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-3">
        <x-heroicon-o-check-circle class="w-5 h-5 text-green-500" />
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('profile.update-password') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        @csrf

        <div class="space-y-6 mb-8">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Current Password</label>
                <div class="relative">
                    <x-heroicon-o-lock-closed class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                    <input type="password" name="current_password" class="w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">New Password</label>
                <div class="relative">
                    <x-heroicon-o-key class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                    <input type="password" name="new_password" class="w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Confirm New Password</label>
                <div class="relative">
                    <x-heroicon-o-check-badge class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" />
                    <input type="password" name="new_password_confirmation" class="w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-gray-50">
            <a href="{{ route('profile.show') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all">Cancel</a>
            <button type="submit" class="bg-primary hover:bg-primary-container text-white px-8 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all">Update Password</button>
        </div>
    </form>
</div>
@endsection
