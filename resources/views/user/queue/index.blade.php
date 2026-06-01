@extends('layouts.user')

@section('title', 'Janji Temu')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Janji Temu Saya
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Riwayat pemeriksaan dan tiket rumah sakit
            </p>
        </div>

        <a href="{{ route('user.queue.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-medium transition shadow-sm">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>

            Buat Janji

        </a>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">

            {{ session('success') }}

        </div>

    @endif

    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">

            {{ session('error') }}

        </div>

    @endif

    {{-- LIST APPOINTMENT --}}
    <div class="space-y-4">

        @forelse($appointments as $appointment)

            @php

                /*
                |--------------------------------------------------------------------------
                | STATUS DISPLAY
                |--------------------------------------------------------------------------
                */

                $displayStatus = $appointment->status;

                // kalau status proses tapi belum rating
                if($appointment->status == 'proses' && !$appointment->rating){

                    $displayStatus = 'menunggu_rating';
                }

                // kalau status proses tapi SUDAH rating
                if($appointment->status == 'proses' && $appointment->rating){

                    $displayStatus = 'selesai';
                }

                /*
                |--------------------------------------------------------------------------
                | STATUS COLOR
                |--------------------------------------------------------------------------
                */

                $statusClass = match($displayStatus) {

                    'terkonfirmasi' => 'bg-green-100 text-green-700',

                    'menunggu' => 'bg-yellow-100 text-yellow-700',

                    'dibatalkan' => 'bg-red-100 text-red-700',

                    'menunggu_rating' => 'bg-orange-100 text-orange-700',

                    'selesai' => 'bg-gray-100 text-gray-700',

                    default => 'bg-gray-100 text-gray-700'
                };

                /*
                |--------------------------------------------------------------------------
                | STATUS TEXT
                |--------------------------------------------------------------------------
                */

                $statusText = match($displayStatus) {

                    'terkonfirmasi' => 'Terkonfirmasi',

                    'menunggu' => 'Menunggu',

                    'dibatalkan' => 'Dibatalkan',

                    'menunggu_rating' => 'Menunggu Rating',

                    'selesai' => 'Selesai',

                    default => ucfirst($displayStatus)
                };

            @endphp

            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">

                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                    {{-- LEFT --}}
                    <div class="flex items-start gap-4">

                        {{-- AVATAR --}}
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center flex-shrink-0">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-7 h-7 text-blue-600"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M8 9a3 3 0 106 0 3 3 0 00-6 0zm-3 8a6 6 0 1112 0H5z" />

                            </svg>

                        </div>

                        {{-- INFO --}}
                        <div>

                            <h2 class="text-lg font-bold text-gray-800">
                                {{ $appointment->doctor?->name ?? '-' }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-1">
                                {{ $appointment->doctor?->specialist?->name ?? 'Dokter Umum' }}
                            </p>

                            {{-- DATE & TIME --}}
                            <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-gray-600">

                                {{-- TANGGAL --}}
                                <div class="flex items-center gap-2">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4 text-blue-500"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                    </svg>

                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}

                                </div>

                                {{-- JAM --}}
                                <div class="flex items-center gap-2">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4 text-blue-500"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 8v4l3 3" />

                                    </svg>

                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}

                                </div>

                            </div>

                            {{-- BOOKING CODE --}}
                            <div class="mt-4">

                                <span class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 text-xs font-semibold px-4 py-2 rounded-xl">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 12h6m2 5H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2z" />

                                    </svg>

                                    {{ $appointment->booking_code ?? '-' }}

                                </span>

                            </div>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="flex flex-col items-start xl:items-end gap-3">

                        {{-- STATUS --}}
                        <span class="px-4 py-2 rounded-full text-xs font-semibold {{ $statusClass }}">

                            {{ $statusText }}

                        </span>

                        {{-- ACTION --}}
                        <div class="flex flex-wrap items-center gap-2">

                            {{-- TIKET --}}
                            @if($appointment->status == 'terkonfirmasi')

                                <a href="{{ route('user.queue.ticket', $appointment) }}"
                                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-2xl transition">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                    </svg>

                                    Lihat Tiket

                                </a>

                            @endif

                            {{-- RATING --}}
                            @if($appointment->status == 'proses' && !$appointment->rating)

                                <a href="{{ route('user.ratings.create', $appointment) }}"
                                   class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2.5 rounded-2xl transition">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.98 10.1c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.616-4.853z" />

                                    </svg>

                                    Beri Rating

                                </a>

                            @endif

                            {{-- SELESAI --}}
                            @if($appointment->status == 'proses' && $appointment->rating)

                                <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 text-sm font-semibold px-4 py-2.5 rounded-2xl">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-5 h-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M5 13l4 4L19 7" />

                                    </svg>

                                    Pemeriksaan Selesai

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-3xl border border-dashed border-gray-200 p-14 text-center">

                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-10 h-10 text-blue-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                    </svg>

                </div>

                <h3 class="text-lg font-bold text-gray-700 mt-5">
                    Belum Ada Janji Temu
                </h3>

                <p class="text-gray-400 text-sm mt-2">
                    Silakan buat janji dengan dokter terlebih dahulu
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection