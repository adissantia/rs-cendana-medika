@extends('layouts.user')

@section('content')

<div class="max-w-md mx-auto py-10">

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-blue-600 p-6 text-white text-center">

            <h1 class="text-2xl font-bold">
                Pembayaran QRIS
            </h1>

            <p class="text-blue-100 text-sm mt-1">
                Scan QR untuk menyelesaikan pembayaran
            </p>

        </div>

        <div class="p-8">

            {{-- TOTAL --}}
            <div class="text-center">

                <p class="text-gray-500 text-sm">
                    Total Pembayaran
                </p>

                <h2 class="text-4xl font-bold text-gray-800 mt-2">
                    Rp {{ number_format($appointment->fee,0,',','.') }}
                </h2>

            </div>

            {{-- QRIS --}}
            <div class="mt-8 flex justify-center">

                <div class="bg-white border-4 border-gray-200 rounded-3xl p-4 shadow-sm">

                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PAYMENT-{{ $appointment->booking_code }}"
                        class="w-64 h-64">

                </div>

            </div>

            {{-- INFO --}}
            <div class="mt-6 space-y-3 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Kode Booking</span>
                    <span class="font-semibold">
                        {{ $appointment->booking_code }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Dokter</span>
                    <span class="font-semibold">
                        {{ $appointment->doctor->name }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal</span>
                    <span class="font-semibold">
                        {{ $appointment->appointment_date->format('d M Y') }}
                    </span>
                </div>

            </div>

            {{-- STATUS --}}
            <div class="mt-8">

                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 text-center">

                    <p class="text-yellow-700 font-semibold">
                        Menunggu Pembayaran...
                    </p>

                    <p class="text-sm text-yellow-600 mt-1">
                        Simulasi QRIS otomatis berhasil dalam beberapa detik
                    </p>

                </div>

            </div>

            {{-- LOADING --}}
            <div class="mt-8">

                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">

                    <div id="progressBar"
                         class="bg-blue-600 h-3 rounded-full transition-all duration-1000"
                         style="width:0%">
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- AUTO PAYMENT --}}
<script>

    let progress = 0;

    let interval = setInterval(() => {

        progress += 20;

        document.getElementById('progressBar')
            .style.width = progress + '%';

        if(progress >= 100){

            clearInterval(interval);

            window.location.href =
            "{{ route('user.payments.pay', $appointment) }}";

        }

    }, 1000);

</script>

@endsection