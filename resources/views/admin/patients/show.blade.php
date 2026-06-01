@extends('layouts.admin')

@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')

@section('breadcrumb')
<span class="text-gray-600">Detail Pasien</span>
@endsection

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- HEADER CARD --}}
    <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-3xl overflow-hidden shadow-xl">

        <div class="p-8 flex items-center justify-between flex-wrap gap-6">

            <div class="flex items-center gap-5">

                {{-- Avatar --}}
                <div class="w-24 h-24 rounded-3xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                </div>

                <div class="text-white">

                    <p class="text-sm uppercase tracking-widest text-blue-100">
                        Data Pasien
                    </p>

                    <h1 class="text-3xl font-bold mt-1">
                        {{ $patient->name }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-3 mt-4">

                        <span class="bg-white/20 px-4 py-1 rounded-full text-sm backdrop-blur-md">
                            ID: {{ $patient->patient_code }}
                        </span>

                        <span class="bg-white/20 px-4 py-1 rounded-full text-sm backdrop-blur-md">
                            {{ $patient->gender }}
                        </span>

                        <span class="bg-white/20 px-4 py-1 rounded-full text-sm backdrop-blur-md">
                            {{ $patient->age }} Tahun
                        </span>

                    </div>
                </div>

            </div>

            {{-- Status --}}
            <div>

                @if($patient->status == 'aktif')
                    <span class="bg-green-400 text-white px-5 py-2 rounded-2xl text-sm font-semibold shadow-lg">
                        Pasien Aktif
                    </span>
                @else
                    <span class="bg-red-500 text-white px-5 py-2 rounded-2xl text-sm font-semibold shadow-lg">
                        Nonaktif
                    </span>
                @endif

            </div>

        </div>

    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Utama --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800">
                        Informasi Pasien
                    </h2>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nama --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">
                            Nama Lengkap
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $patient->name }}
                        </p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">
                            Email
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $patient->email ?? '-' }}
                        </p>
                    </div>

                    {{-- Phone --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">
                            Nomor HP
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $patient->phone ?? '-' }}
                        </p>
                    </div>

                    {{-- Gender --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">
                            Jenis Kelamin
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $patient->gender }}
                        </p>
                    </div>

                    {{-- Umur --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">
                            Umur
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ $patient->age }} Tahun
                        </p>
                    </div>

                    {{-- Birth Date --}}
                    <div>
                        <p class="text-sm text-gray-400 mb-1">
                            Tanggal Lahir
                        </p>

                        <p class="font-semibold text-gray-800">
                           {{ \Carbon\Carbon::parse($patient->birth_date)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Address --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800">
                        Alamat Pasien
                    </h2>
                </div>

                <div class="p-6">

                    <p class="text-gray-700 leading-relaxed">
                        {{ $patient->address ?? 'Alamat belum tersedia.' }}
                    </p>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- Statistik --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800">
                        Statistik
                    </h2>
                </div>

                <div class="p-6 space-y-5">

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">
                            Last Visit
                        </span>

                        <span class="font-semibold text-gray-800">
                            {{ $patient->last_visit ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">
                            Status
                        </span>

                        <span class="font-semibold text-blue-600">
                            {{ ucfirst($patient->status) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">
                            Terdaftar
                        </span>

                        <span class="font-semibold text-gray-800">
                            {{ $patient->created_at->format('d M Y') }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800">
                        Aksi
                    </h2>
                </div>

                <div class="p-6 space-y-3">

                    {{-- Edit --}}
                    <a href="{{ route('admin.patients.edit', $patient) }}"
                       class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white py-3 rounded-2xl font-semibold shadow-lg shadow-blue-100">

                        Edit Pasien
                    </a>

                    {{-- Back --}}
                    <a href="{{ route('admin.patients.index') }}"
                       class="w-full flex items-center justify-center gap-2 border border-gray-300 hover:bg-gray-50 transition text-gray-700 py-3 rounded-2xl font-semibold">

                        Kembali
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection