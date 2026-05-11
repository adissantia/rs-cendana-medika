@extends('layouts.user')

@section('title', 'Akun Saya')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- HEADER PROFILE --}}
    <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-r from-blue-600 via-cyan-500 to-sky-500 p-8 shadow-xl">

        {{-- Background blur --}}
        <div class="absolute -top-10 -right-10 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div class="flex items-center gap-5">

                {{-- Avatar --}}
                <div class="w-24 h-24 rounded-3xl bg-white/20 backdrop-blur flex items-center justify-center text-4xl font-bold text-white border border-white/20 shadow-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                {{-- Info --}}
                <div>

                    <h1 class="text-3xl font-bold text-white">
                        {{ $user->name }}
                    </h1>

                    <p class="text-blue-100 mt-1">
                        {{ $user->email }}
                    </p>

                    <div class="flex flex-wrap gap-2 mt-4">

                        <span class="bg-white/20 backdrop-blur px-4 py-2 rounded-2xl text-sm text-white">
                            Pasien Aktif
                        </span>

                        <span class="bg-emerald-400/20 border border-emerald-300/20 px-4 py-2 rounded-2xl text-sm text-white">
                            RS Cendana Medika
                        </span>

                    </div>

                </div>

            </div>

            {{-- Button --}}
            <div class="flex gap-3">

    <a href="{{ route('user.account.edit') }}"
       class="bg-white text-blue-600 font-semibold px-5 py-3 rounded-2xl hover:bg-blue-50 transition inline-flex items-center gap-2 shadow-lg">

        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>

        Edit Profil
    </a>

</div>

        </div>

    </div>

    {{-- GRID --}}
    <div class="grid lg:grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- INFORMASI AKUN --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                <div class="flex items-center justify-between mb-8">

                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">
                            Informasi Akun
                        </h2>

                        <p class="text-slate-500 text-sm mt-1">
                            Informasi pribadi pasien
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                </div>

                <div class="grid md:grid-cols-2 gap-8">

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Nama Lengkap
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Email
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Role
                        </p>

                        <p class="font-semibold text-slate-800 text-lg capitalize">
                            {{ $user->role }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Bergabung
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $user->created_at->format('d F Y') }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- DATA KESEHATAN --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

                <div class="flex items-center justify-between mb-8">

                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">
                            Data Pasien
                        </h2>

                        <p class="text-slate-500 text-sm mt-1">
                            Informasi medis dasar pasien
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-3-3v6m8-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                </div>

                <div class="grid md:grid-cols-2 gap-8">

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Nomor Pasien
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $patient->patient_code ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Nomor Telepon
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $patient->phone ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Jenis Kelamin
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $patient->gender ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Umur
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $patient->age ?? '-' }} Tahun
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Tanggal Lahir
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->format('d F Y') : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500 mb-2">
                            Status
                        </p>

                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-green-100 text-green-700 font-medium">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            {{ ucfirst($patient->status ?? 'aktif') }}
                        </span>
                    </div>

                    <div class="md:col-span-2">
                        <p class="text-sm text-slate-500 mb-2">
                            Alamat
                        </p>

                        <p class="font-semibold text-slate-800 text-lg">
                            {{ $patient->address ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- QUICK STATS --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h3 class="text-lg font-bold text-slate-800 mb-5">
                    Statistik Akun
                </h3>

                <div class="space-y-4">

                    <div class="bg-blue-50 rounded-2xl p-4">
                        <p class="text-sm text-blue-500">
                            Total Kunjungan
                        </p>

                        <p class="text-3xl font-bold text-blue-700 mt-1">
                            12
                        </p>
                    </div>

                    <div class="bg-emerald-50 rounded-2xl p-4">
                        <p class="text-sm text-emerald-500">
                            Status Akun
                        </p>

                        <p class="text-xl font-bold text-emerald-700 mt-1">
                            Aktif
                        </p>
                    </div>

                </div>

            </div>

            {{-- SECURITY --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h3 class="text-lg font-bold text-slate-800 mb-5">
                    Keamanan
                </h3>

                <div class="space-y-3">

                    <button class="w-full bg-slate-100 hover:bg-slate-200 transition rounded-2xl px-4 py-3 text-left font-medium text-slate-700">
                        Ubah Password
                    </button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-2xl font-semibold transition">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection