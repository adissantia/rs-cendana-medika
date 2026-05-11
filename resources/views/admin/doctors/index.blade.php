@extends('layouts.admin')

@section('title', 'Data Dokter')
@section('page-title', 'Data Dokter')

@section('breadcrumb')
    <span class="text-gray-600">Dokter</span>
@endsection

@section('content')

<div class="space-y-8">

    {{-- ================= STAT CARD ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- TOTAL DOKTER --}}
        <div class="bg-white rounded-3xl p-6 border shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-slate-800">
                        {{ number_format($totalDoctors) }}
                    </p>
                    <p class="text-sm text-slate-500 mt-1">Total Dokter</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                              d="M8 9a3 3 0 100 6m8-6a3 3 0 100 6M3 20a5 5 0 0110 0m1 0a5 5 0 0110 0"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- DOKTER AKTIF --}}
        <div class="bg-white rounded-3xl p-6 border shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-green-600">{{ $activeDoctors }}</p>
                    <p class="text-sm text-slate-500 mt-1">Dokter Aktif</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- SPESIALIS --}}
        <div class="bg-white rounded-3xl p-6 border shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-cyan-600">{{ $specialistsCount }}</p>
                    <p class="text-sm text-slate-500 mt-1">Spesialis</p>
                </div>
                <div class="w-14 h-14 bg-cyan-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- RATING --}}
        <div class="bg-white rounded-3xl p-6 border shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold text-yellow-500">
                        {{ number_format($avgRating ?? 0, 1) }}
                    </p>
                    <p class="text-sm text-slate-500 mt-1">Rating</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.962a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.287 3.962c.3.922-.755 1.688-1.539 1.118L10 15.347l-3.353 2.437c-.783.57-1.838-.196-1.539-1.118l1.287-3.962a1 1 0 00-.364-1.118L2.663 9.39c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.962z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= FILTER & ACTION ================= --}}
    <div class="bg-white rounded-3xl border shadow-sm p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <form method="GET" class="flex flex-col md:flex-row gap-3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari dokter..."
                class="border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
            >

            <select
                name="specialist_id"
                class="border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
            >
                <option value="">Semua Spesialis</option>
                @foreach($specialists as $spec)
                    <option value="{{ $spec->id }}" {{ request('specialist_id') == $spec->id ? 'selected' : '' }}>
                        {{ $spec->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl text-sm font-semibold transition">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.doctors.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl text-sm font-semibold transition">
            + Tambah Dokter
        </a>

    </div>

    {{-- ================= CARD DOCTERS ================= --}}
    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($doctors as $doctor)

        <div class="bg-white rounded-3xl border shadow-sm p-6 hover:shadow-lg transition">

            <div class="flex items-start gap-4">
                @if($doctor->avatar)
                    <img src="{{ asset('storage/'.$doctor->avatar) }}" class="w-20 h-20 rounded-2xl object-cover">
                @else
                    <div class="w-20 h-20 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-bold">
                        {{ strtoupper(substr($doctor->name,0,1)) }}
                    </div>
                @endif

                <div class="flex-1">
                    <h3 class="font-bold text-lg text-slate-800">{{ $doctor->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $doctor->specialist?->name ?? '-' }}</p>
                    <p class="text-xs text-slate-400">{{ $doctor->doctor_code }}</p>

                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-yellow-400">★★★★★</span>
                        <span class="text-sm font-semibold">
                            {{ number_format($doctor->average_rating ?? 4.5,1) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-6">
                <a href="{{ route('admin.doctors.show', $doctor) }}"
                   class="border border-gray-200 hover:bg-gray-50 text-slate-700 py-3 rounded-2xl text-center text-sm font-semibold">
                    Detail
                </a>
                <a href="{{ route('admin.doctors.edit', $doctor) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-2xl text-center text-sm font-semibold">
                    Edit
                </a>
            </div>

        </div>

        @empty
            <div class="col-span-full text-center text-slate-400 py-16">
                Tidak ada data dokter
            </div>
        @endforelse

    </div>

    {{ $doctors->links() }}

</div>

@endsection