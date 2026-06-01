@extends('layouts.admin')

@section('title', 'Detail Jadwal')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Detail Jadwal Temu
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap appointment pasien
            </p>
        </div>

        <a href="{{ route('admin.appointments.index') }}"
           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium text-gray-700 transition">

            Kembali

        </a>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- PASIEN --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Nama Pasien
                </label>

                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ $appointment->patient->name }}
                </p>
            </div>

            {{-- KODE PASIEN --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Kode Pasien
                </label>

                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ $appointment->patient->patient_code }}
                </p>
            </div>

            {{-- DOKTER --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Dokter
                </label>

                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ $appointment->doctor->name }}
                </p>
            </div>

            {{-- SPESIALIS --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Spesialis
                </label>

                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ $appointment->doctor->specialist->name ?? '-' }}
                </p>
            </div>

            {{-- TANGGAL --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Tanggal Appointment
                </label>

                <p class="mt-2 text-base font-semibold text-gray-800">
                    {{ $appointment->appointment_date->format('d F Y') }}
                </p>
            </div>

            {{-- JAM --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Jam Appointment
                </label>

                <p class="mt-2 text-base font-semibold text-blue-600">
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                </p>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Status
                </label>

                <div class="mt-2">

                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium {{ $appointment->status_class }}">

                        <span class="w-2 h-2 rounded-full {{ $appointment->status_dot }}"></span>

                        {{ $appointment->status_label }}

                    </span>

                </div>
            </div>

            {{-- BIAYA --}}
            <div>
                <label class="text-xs text-gray-400 uppercase">
                    Biaya
                </label>

                <p class="mt-2 text-base font-semibold text-gray-800">
                    Rp {{ number_format($appointment->fee, 0, ',', '.') }}
                </p>
            </div>

        </div>

        {{-- CATATAN --}}
        <div class="mt-8">

            <label class="text-xs text-gray-400 uppercase">
                Catatan / Keluhan
            </label>

            <div class="mt-2 bg-gray-50 rounded-xl p-4 text-sm text-gray-700">

                {{ $appointment->notes ?? 'Tidak ada catatan' }}

            </div>

        </div>

    </div>

</div>

@endsection