@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Profile</h1>
        <p class="text-sm text-gray-500">Update your personal information and profile picture</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="md:col-span-2 flex items-center gap-6 mb-4">
                <div class="relative">
                    @if ($user->image)
                    <img src="{{ asset('uploads/users/' . $user->image) }}" id="preview" class="w-20 h-20 rounded-2xl object-cover border-2 border-gray-100 shadow-sm bg-gray-50">
                    @else
                    <div id="preview-placeholder" class="w-20 h-20 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center">
                        <x-heroicon-o-camera class="w-8 h-8 text-gray-400" />
                    </div>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Profile Image</label>
                    <input type="file" name="image" onchange="previewImage(this)" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Department</label>
                <input type="text" name="departemen" value="{{ old('departemen', $user->departemen) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Section (Bagian)</label>
                <input type="text" name="bagian" value="{{ old('bagian', $user->bagian) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" required>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-gray-50">
            <a href="{{ route('profile.show') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all">Cancel</a>
            <button type="submit" class="bg-primary hover:bg-primary-container text-white px-8 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all">Save Changes</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('preview');
                if (!preview) {
                    const placeholder = document.getElementById('preview-placeholder');
                    preview = document.createElement('img');
                    preview.id = 'preview';
                    preview.className = 'w-20 h-20 rounded-2xl object-cover border-2 border-gray-100 shadow-sm bg-gray-50';
                    placeholder.parentNode.replaceChild(preview, placeholder);
                }
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
