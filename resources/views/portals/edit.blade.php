<!-- FILE: resources/views/portals/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Edit Kredensial Portal</h1>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('portals.update', $portalCredential->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Info Portal (Read Only) -->
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                    <p class="text-gray-700"><strong>Portal:</strong> {{ $portalCredential->portal_name }}</p>
                    <p class="text-gray-600 text-sm">{{ $portalCredential->portal_url }}</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Username *</label>
                    <input type="text" name="username" value="{{ old('username', $portalCredential->username) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('username') border-red-500 @enderror" required>
                    @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Password *</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" value="{{ old('password', $portalCredential->password) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" required>
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-gray-600 hover:text-gray-800">
                            👁️
                        </button>
                    </div>
                    @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">{{ old('description', $portalCredential->description) }}</textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        💾 Perbarui
                    </button>
                    <a href="{{ route('portals.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition text-center">
                        ✖️ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection