@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-8">

    {{-- HERO --}}
    <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-[32px] p-8 text-white">

        <div class="grid lg:grid-cols-2 gap-8 items-center">

            <div>

                <h1 class="text-4xl font-bold leading-tight">
                    Find Your Doctor
                    & Book Appointment
                </h1>

                <p class="mt-4 text-blue-100 text-lg">
                    Konsultasi kesehatan lebih mudah,
                    cepat, dan nyaman.
                </p>

                {{-- BUTTON HERO --}}
                <a href="{{ route('user.queue.create') }}"
                    class="inline-block mt-6 bg-white text-blue-600 px-6 py-3 rounded-2xl font-semibold hover:bg-blue-50 transition">
                    Buat Janji
                </a>

            </div>

            <div class="hidden lg:flex justify-end">

                <img
                    src="https://cdn-icons-png.flaticon.com/512/2785/2785482.png"
                    class="w-72"
                >

            </div>

        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl p-6 shadow-sm">
            <p class="text-slate-500 text-sm">
                Total Dokter
            </p>

            <h2 class="text-4xl font-bold mt-2">
                {{ $doctors->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm">
            <p class="text-slate-500 text-sm">
                Appointment
            </p>

            <h2 class="text-4xl font-bold mt-2">
                {{ $myQueues->count() }}
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm">
            <p class="text-slate-500 text-sm">
                Status Aktif
            </p>

            <h2 class="text-2xl font-bold mt-2 text-green-600">
                Online
            </h2>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm">
            <p class="text-slate-500 text-sm">
                Layanan
            </p>

            <h2 class="text-4xl font-bold mt-2">
                24 Jam
            </h2>
        </div>

    </div>

    {{-- DOKTER --}}
    <div>

        <div class="flex items-center justify-between mb-6">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Dokter Tersedia
                </h2>

                <p class="text-slate-500">
                    Pilih dokter terbaik anda
                </p>

            </div>

        </div>

        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">

            @foreach($doctors as $doctor)

            <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-lg transition">

                {{-- HEADER --}}
                <div class="flex items-center gap-4">

                    @if($doctor->avatar)

                        <img
                            src="{{ asset('storage/' . $doctor->avatar) }}"
                            class="w-20 h-20 rounded-2xl object-cover"
                        >

                    @else

                        <div class="w-20 h-20 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl">
                            DR
                        </div>

                    @endif

                    <div>

                        <h3 class="font-bold text-lg text-slate-800">
                            {{ $doctor->name }}
                        </h3>

                        <p class="text-slate-500 text-sm">
                            {{ $doctor->specialist?->name }}
                        </p>

                        {{-- STATUS --}}
                        <span class="inline-block mt-2 bg-green-100 text-green-600 text-xs px-3 py-1 rounded-xl">
                            Available
                        </span>

                    </div>

                </div>

                {{-- RATING --}}
                <div class="mt-5 flex items-center justify-between">

                    <div>
                        <p class="text-sm text-slate-500">
                            Rating
                        </p>

                        <p class="font-semibold text-yellow-500">
                            ⭐ {{ number_format($doctor->average_rating ?? 0, 1) }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-slate-500">
                            Review
                        </p>

                        <p class="font-semibold text-slate-700">
                            {{ $doctor->ratings->count() }}
                        </p>
                    </div>

                </div>

                {{-- BUTTON DETAIL --}}
                <a href="{{ route('user.doctors.show', $doctor) }}"
                    class="block text-center mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-2xl font-semibold transition">

                    Lihat Detail

                </a>

            </div>

            @endforeach

        </div>

    </div>

</div>

@endsection