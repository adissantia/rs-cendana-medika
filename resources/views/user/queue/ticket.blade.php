@extends('layouts.user')

@section('content')

<div class="max-w-xl mx-auto py-10">

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">

        <div class="text-center">

            <h1 class="text-2xl font-bold text-gray-800">
                Tiket Appointment
            </h1>

            <p class="text-gray-500 mt-2">
                Tunjukkan barcode ini ke resepsionis
            </p>

        </div>

        <div class="mt-8 text-center">

            <div class="text-5xl font-bold text-blue-600">
                {{ $appointment->queue_number }}
            </div>

            <p class="text-sm text-gray-500 mt-2">
                Nomor Antrian
            </p>

        </div>

        <div class="mt-8 space-y-4">

            <div class="flex justify-between">
                <span>Pasien</span>
                <span class="font-semibold">
                    {{ $appointment->patient->name }}
                </span>
            </div>

            <div class="flex justify-between">
                <span>Dokter</span>
                <span class="font-semibold">
                    {{ $appointment->doctor->name }}
                </span>
            </div>

            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>
                    {{ $appointment->appointment_date->format('d M Y') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span>Jam</span>
                <span>
                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                </span>
            </div>

        </div>

        {{-- BARCODE --}}
        <div class="mt-10 flex justify-center">

            <img
                src="https://barcode.tec-it.com/barcode.ashx?data={{ $appointment->booking_code }}&code=Code128"
                alt="barcode">

        </div>

        <div class="text-center mt-4 font-semibold text-gray-700">
            {{ $appointment->booking_code }}
        </div>

    </div>

</div>

@endsection