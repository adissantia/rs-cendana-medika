@extends('layouts.admin')

@section('title', 'Detail Dokter')
@section('page-title', 'Detail Dokter')

@section('breadcrumb')
    <span class="text-gray-400">Dokter</span>
    <span class="mx-2">/</span>
    <span class="text-gray-600">{{ $doctor->name }}</span>
@endsection

@section('content')

<div class="grid grid-cols-3 gap-6">

    {{-- PROFILE --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">

        <div class="flex flex-col items-center">

            @if($doctor->avatar)
                <img
                    src="{{ asset('storage/' . $doctor->avatar) }}"
                    class="w-32 h-32 rounded-full object-cover border-4 border-blue-100"
                >
            @else
                <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center text-4xl font-bold text-blue-600">
                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                </div>
            @endif

            <h2 class="mt-4 text-xl font-bold text-gray-800">
                {{ $doctor->name }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ $doctor->specialist?->name ?? '-' }}
            </p>

            <span class="mt-3 px-3 py-1 text-xs rounded-full
                {{ $doctor->status === 'online'
                    ? 'bg-green-100 text-green-700'
                    : ($doctor->status === 'cuti'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-gray-100 text-gray-700') }}">
                {{ ucfirst($doctor->status) }}
            </span>

        </div>

    </div>

    {{-- DETAIL --}}
    <div class="col-span-2 bg-white rounded-2xl border shadow-sm p-6">

        <h3 class="text-lg font-semibold text-gray-800 mb-5">
            Informasi Dokter
        </h3>

        <div class="grid grid-cols-2 gap-5">

            <div>
                <p class="text-sm text-gray-500 mb-1">Kode Dokter</p>
                <p class="font-medium text-gray-800">
                    {{ $doctor->doctor_code }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">No HP</p>
                <p class="font-medium text-gray-800">
                    {{ $doctor->phone ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">Spesialis</p>
                <p class="font-medium text-gray-800">
                    {{ $doctor->specialist?->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">Rating</p>
                <p class="font-medium text-gray-800">
                    ⭐ {{ number_format($doctor->average_rating ?? 0, 1) }}
                </p>
            </div>

        </div>

        <div class="mt-8 flex gap-3">

            <a href="{{ route('admin.doctors.edit', $doctor) }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl text-sm">
                Edit Dokter
            </a>

            <a href="{{ route('admin.doctors.index') }}"
                class="border border-gray-300 hover:bg-gray-100 px-5 py-2 rounded-xl text-sm">
                Kembali
            </a>

        </div>

    </div>

</div>

@endsection