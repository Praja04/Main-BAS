<!-- FILE: resources/views/portals/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Tambah Kredensial Portal</h1>

        <div class="bg-white rounded-lg shadow-lg p-8">
            <form action="{{ route('portals.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Pilih Portal *</label>
                    <select name="portal_select" id="portalSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Portal Preset --</option>
                        @foreach($defaultPortals as $portal)
                        <option value="{{ json_encode($portal) }}">{{ $portal['portal_name'] }}</option>
                        @endforeach
                        <option value="custom">-- Portal Custom --</option>
                    </select>
                    <p class="text-gray-500 text-sm mt-2">Pilih portal dari daftar atau buat custom</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Nama Portal *</label>
                    <input type="text" name="portal_name" id="portalName" value="{{ old('portal_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('portal_name') border-red-500 @enderror" placeholder="Contoh: Engineering Portal" required>
                    @error('portal_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">URL Portal *</label>
                    <input type="url" name="portal_url" id="portalUrl" value="{{ old('portal_url') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('portal_url') border-red-500 @enderror" placeholder="Contoh: http://10.11.10.130:8090/engineering/public" required>
                    @error('portal_url')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Username *</label>
                    <input type="text" name="username" value="{{ old('username') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('username') border-red-500 @enderror" placeholder="Username Anda" required>
                    @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Password *</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('password') border-red-500 @enderror" placeholder="Masukkan password" required>
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-gray-600 hover:text-gray-800">
                            👁️
                        </button>
                    </div>
                    @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Deskripsi portal ini">{{ old('description') }}</textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        💾 Simpan
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

    document.getElementById('portalSelect').addEventListener('change', function() {
        if (this.value === 'custom') {
            document.getElementById('portalName').value = '';
            document.getElementById('portalUrl').value = '';
        } else if (this.value) {
            const portal = JSON.parse(this.value);
            document.getElementById('portalName').value = portal.portal_name;
            document.getElementById('portalUrl').value = portal.portal_url;
        }
    });
</script>
@endsection
