@extends('layouts.user')

@section('title', 'Detail Dokter')

@section('content')

<div class="space-y-8">

    {{-- BUTTON KEMBALI --}}
    <div>
        <a href="{{ route('user.dashboard') }}"
            class="inline-flex items-center gap-2 bg-white hover:bg-slate-100 text-slate-700 px-5 py-3 rounded-2xl shadow-sm transition">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 19l-7-7 7-7"/>
            </svg>

            Kembali ke Dashboard
        </a>
    </div>

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-[32px] p-8 text-white">

        <div class="flex flex-col lg:flex-row items-center gap-8">

            {{-- AVATAR --}}
            <div>

                @if($doctor->avatar)
                    <img
                        src="{{ asset('storage/' . $doctor->avatar) }}"
                        class="w-40 h-40 rounded-3xl object-cover border-4 border-white/30"
                    >
                @else
                    <div class="w-40 h-40 rounded-3xl bg-white/20 flex items-center justify-center text-5xl font-bold">
                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                    </div>
                @endif

            </div>

            {{-- INFO --}}
            <div class="flex-1">

                <h1 class="text-4xl font-bold">
                    {{ $doctor->name }}
                </h1>

                <p class="mt-2 text-blue-100 text-lg">
                    {{ $doctor->specialist?->name ?? '-' }}
                </p>

                <div class="mt-5 flex flex-wrap gap-3">

                    <span class="bg-white/20 px-4 py-2 rounded-2xl text-sm">
                        ⭐ {{ number_format($doctor->average_rating ?? 0, 1) }} Rating
                    </span>

                    <span class="bg-green-500/20 text-green-100 px-4 py-2 rounded-2xl text-sm">
                        {{ ucfirst($doctor->status) }}
                    </span>

                </div>

                <a href="{{ route('user.queue.create') }}"
                    class="inline-block mt-6 bg-white text-blue-600 px-6 py-3 rounded-2xl font-semibold hover:bg-blue-50 transition">
                    Book Appointment
                </a>

            </div>

        </div>

    </div>

    {{-- INFORMASI --}}
    <div class="grid lg:grid-cols-3 gap-6">

        {{-- DETAIL --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-8 shadow-sm">

            <h2 class="text-2xl font-bold text-slate-800 mb-6">
                Informasi Dokter
            </h2>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <p class="text-sm text-slate-500 mb-1">
                        Kode Dokter
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $doctor->doctor_code }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500 mb-1">
                        Nomor Telepon
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $doctor->phone ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500 mb-1">
                        Spesialis
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $doctor->specialist?->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500 mb-1">
                        Status
                    </p>

                    <p class="font-semibold text-green-600">
                        {{ ucfirst($doctor->status) }}
                    </p>
                </div>

            </div>

        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-6">

            {{-- CARD --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <h3 class="font-bold text-slate-800 mb-5">
                    Statistik Dokter
                </h3>

                <div class="space-y-4">

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-sm">
                            Rating
                        </span>

                        <span class="font-bold text-yellow-500">
                            ⭐ {{ number_format($doctor->average_rating ?? 0, 1) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-sm">
                            Total Review
                        </span>

                        <span class="font-bold text-slate-800">
                            {{ $doctor->ratings->count() }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-sm">
                            Status
                        </span>

                        <span class="font-bold text-green-600">
                            {{ ucfirst($doctor->status) }}
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- REVIEW --}}
    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <div class="mb-8">

            <h2 class="text-2xl font-bold text-slate-800">
                Review Pasien
            </h2>

            <p class="text-slate-500">
                Ulasan pasien terhadap dokter
            </p>

        </div>

        <div class="space-y-6">

            @forelse($doctor->ratings as $rating)

                <div class="border border-slate-100 rounded-2xl p-5">

                    <div>

                        <h4 class="font-semibold text-slate-800">
                            {{ $rating->patient->name ?? 'Pasien' }}
                        </h4>

                        <div class="flex items-center gap-1 mt-2">

                            @for($i = 1; $i <= 5; $i++)

                                <svg
                                    class="w-4 h-4 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-slate-300' }}"
                                    fill="currentColor"
                                    viewBox="0 0 20 20">

                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"/>

                                </svg>

                            @endfor

                        </div>

                    </div>

                    <p class="mt-4 text-slate-600 leading-relaxed">
                        {{ $rating->review ?: 'Tidak ada review.' }}
                    </p>

                </div>

            @empty

                <div class="text-center py-12">

                    <p class="text-slate-400">
                        Belum ada review untuk dokter ini.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection