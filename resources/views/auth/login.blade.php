@extends('layouts.guest')

@section('title', 'Portal Pasien')

@section('content')
<div class="min-h-screen flex bg-gray-100 overflow-hidden">

    {{-- LEFT SIDE --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">

        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500 via-blue-600 to-indigo-700"></div>

        {{-- Blur circles --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col justify-between h-full p-14 text-white">

            {{-- Top --}}
            <div>

                <div class="flex items-center gap-4">

                    <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-lg border border-white/20 flex items-center justify-center shadow-xl">
                        <svg class="w-8 h-8"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold">
                            RS Cendana Medika
                        </h1>

                        <p class="text-cyan-100 text-sm">
                            Smart Hospital System
                        </p>
                    </div>
                </div>

                <div class="mt-20">

                    <h2 class="text-5xl font-black leading-tight">
                        Pelayanan Rumah Sakit Digital Modern
                    </h2>

                    <p class="mt-6 text-lg leading-relaxed text-cyan-100 max-w-xl">
                        Sistem terpadu untuk pendaftaran pasien,
                        antrian online, pembayaran digital,
                        dan monitoring layanan kesehatan secara real-time.
                    </p>
                </div>

                {{-- Feature cards --}}
                <div class="grid grid-cols-2 gap-5 mt-14">

                    <div class="bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-6 shadow-2xl">
                        <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <h3 class="font-semibold text-lg">
                            Booking Online
                        </h3>

                        <p class="text-sm text-cyan-100 mt-2">
                            Daftar pemeriksaan kapan saja tanpa antri manual.
                        </p>
                    </div>

                    <div class="bg-white/10 border border-white/10 backdrop-blur-xl rounded-3xl p-6 shadow-2xl">
                        <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0-5C6.477 3 2 7.477 2 13s4.477 10 10 10 10-4.477 10-10S17.523 3 12 3z"/>
                            </svg>
                        </div>

                        <h3 class="font-semibold text-lg">
                            Monitoring Antrian
                        </h3>

                        <p class="text-sm text-cyan-100 mt-2">
                            Pantau nomor antrian langsung dari smartphone.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Bottom --}}
            <div class="flex items-center justify-between text-sm text-cyan-100">
                <p>© 2026 RS Cendana Medika</p>
                <p>Healthcare Technology Platform</p>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-10 relative">

        <div class="absolute inset-0 bg-gradient-to-br from-white to-blue-50"></div>

        <div class="relative z-10 w-full max-w-md">

            {{-- Card --}}
            <div class="bg-white/90 backdrop-blur-xl rounded-[2rem] shadow-2xl border border-white p-10">

                {{-- Header --}}
                <div class="text-center">

                    <div class="mx-auto w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-xl shadow-blue-200">
                        <svg class="w-10 h-10 text-white"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>

                    <h2 class="mt-6 text-4xl font-black text-gray-800">
                        Portal Pasien
                    </h2>

                    <p class="text-gray-500 mt-3 text-sm">
                        Login untuk mengakses layanan rumah sakit digital
                    </p>
                </div>

                {{-- Form --}}
                <form method="POST"
                      action="{{ route('login') }}"
                      class="mt-10 space-y-6">

                    @csrf

                    {{-- Email --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               placeholder="Masukkan email"
                               class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 h-14 px-5 transition">

                        @error('email')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               required
                               placeholder="Masukkan password"
                               class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 h-14 px-5 transition">

                        @error('password')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center justify-between">

                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox"
                                   name="remember"
                                   class="rounded border-gray-300 text-blue-600">
                            Ingat Saya
                        </label>

                        <a href="#"
                           class="text-sm font-medium text-blue-600 hover:text-blue-700">
                            Lupa Password?
                        </a>
                    </div>

                    {{-- Button --}}
                    <button type="submit"
                            class="w-full h-14 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-bold text-lg shadow-xl shadow-blue-200 hover:scale-[1.02] transition-all duration-300">
                        Login Sekarang
                    </button>

                    {{-- Divider --}}
                    <div class="relative">

                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>

                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-white px-3 text-gray-400">
                                atau
                            </span>
                        </div>
                    </div>

                    {{-- Register --}}
                    <a href="{{ route('register') }}"
                       class="w-full h-14 rounded-2xl border border-gray-200 flex items-center justify-center font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Buat Akun Pasien
                    </a>

                    {{-- Admin --}}
                    <div class="text-center pt-2">
                        <a href="{{ route('admin.login') }}"
                           class="text-sm text-gray-400 hover:text-gray-700 transition">
                            Login sebagai Admin
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection