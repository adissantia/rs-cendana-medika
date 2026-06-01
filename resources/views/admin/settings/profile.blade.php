@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('breadcrumb')<span class="text-gray-600">Pengaturan</span>@endsection

@section('content')
<div class="flex gap-6">

    {{-- Sidebar Pengaturan --}}
    <div class="w-56 flex-shrink-0">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <a href="{{ route('admin.settings.profile') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
               {{ request()->routeIs('admin.settings.profile') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil Saya
            </a>
            <a href="#"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Kelola Pengguna
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-500 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar / Logout
                </button>
            </form>
        </div>
    </div>

    {{-- Form Profil --}}
    <div class="flex-1">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">

            {{-- Header Profil --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Informasi Profil</h3>
            </div>

            {{-- Avatar section --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xl font-bold">{{ $user->initials }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->position }}</p>
                        <div class="flex items-center gap-3 mt-1 text-xs text-gray-400">
                            <span>📧 {{ $user->email }}</span>
                            <span>📅 Bergabung {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
                <label for="avatar-upload" class="text-sm text-blue-600 hover:text-blue-700 cursor-pointer font-medium border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition-colors">
                    ✏️ Edit Foto
                </label>
            </div>

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf @method('PATCH')

                <input type="file" id="avatar-upload" name="avatar" class="hidden" accept="image/*">

                {{-- Data Pribadi --}}
                <div class="px-6 py-5 border-b border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4">Data Pribadi</h4>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none @error('name') border-red-300 @enderror">
                            @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                   class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none @error('username') border-red-300 @enderror">
                            @error('username')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                   class="w-full border border-gray-100 bg-gray-50 rounded-lg text-sm px-3 py-2.5 text-gray-400 cursor-not-allowed">
                            <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Jabatan / Posisi</label>
                            <input type="text" value="{{ $user->position }}" disabled
                                   class="w-full border border-gray-100 bg-gray-50 rounded-lg text-sm px-3 py-2.5 text-gray-400 cursor-not-allowed">
                            <p class="text-xs text-gray-400 mt-1">Jabatan yang ditetapkan oleh sistem</p>
                        </div>
                    </div>
                </div>

                {{-- Ganti Password --}}
                <div class="px-6 py-5 border-b border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4">Ganti Password</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                   placeholder="Masukkan password lama"
                                   class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none @error('current_password') border-red-300 @enderror">
                            @error('current_password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">Password Baru</label>
                                <input type="password" name="password"
                                       placeholder="Minimal 8 karakter"
                                       class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none @error('password') border-red-300 @enderror">
                                @error('password')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1.5">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation"
                                       placeholder="Ulangi password baru"
                                       class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="px-6 py-4 flex justify-end gap-3">
                    <button type="reset" class="px-4 py-2 text-sm text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Reset</button>
                    <button type="submit" class="px-5 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection