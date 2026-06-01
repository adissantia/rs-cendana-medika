@extends('layouts.user')

@section('title', 'Pembayaran')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Pembayaran
        </h1>

        <p class="text-slate-500 mt-1">
            Riwayat pembayaran appointment anda
        </p>
    </div>

    <div class="grid gap-5">

        @forelse($appointments as $appointment)

            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-xl font-bold text-slate-800">
                            {{ $appointment->doctor->name }}
                        </h2>

                        <p class="text-slate-500 mt-1">
                            {{ $appointment->appointment_date->format('d M Y') }}
                            •
                            {{ $appointment->appointment_time }}
                        </p>

                    </div>

                    <div class="text-right">

                        <p class="text-sm text-slate-500">
                            Total
                        </p>

                        <h3 class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($appointment->fee, 0, ',', '.') }}
                        </h3>

                    </div>

                </div>

                <div class="mt-5 flex items-center justify-between">

                    <div class="flex items-center justify-end w-full">

    <span class="px-5 py-2 rounded-xl bg-green-100 text-green-700 text-sm font-semibold">
        Selesai
    </span>

</div>

                   

                </div>

            </div>

        @empty

            <div class="bg-white rounded-3xl p-10 text-center shadow-sm">

                <p class="text-slate-400">
                    Belum ada pembayaran.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection