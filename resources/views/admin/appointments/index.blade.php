@extends('layouts.admin')

@section('title', 'Jadwal Temu')
@section('page-title', 'Jadwal Temu')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Jadwal Temu
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kelola seluruh jadwal konsultasi pasien
            </p>
        </div>
    </div>


    {{-- STAT CARD --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Hari Ini</p>

            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $totalToday }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Terkonfirmasi</p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $confirmed }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Menunggu</p>

            <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                {{ $waiting }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Dibatalkan</p>

            <h2 class="text-3xl font-bold text-red-500 mt-2">
                {{ $cancelled }}
            </h2>
        </div>

        

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- FILTER --}}
<div class="p-5 border-b border-gray-100">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        {{-- FORM FILTER --}}
        <form
            method="GET"
            action="{{ route('admin.appointments.index') }}"
            class="flex flex-col lg:flex-row gap-3 flex-wrap">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pasien..."
                class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm w-full lg:w-72 focus:ring-2 focus:ring-blue-500 outline-none">

            <select
                name="status"
                class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="terkonfirmasi" {{ request('status')=='terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                <option value="proses" {{ request('status')=='proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status')=='dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <select
                name="doctor_id"
                class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">Semua Dokter</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}"
                        {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }}
                    </option>
                @endforeach
            </select>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-2.5 text-sm font-medium transition">
                Filter
            </button>

        </form>

        {{-- BUTTON TAMBAH --}}
        <a href="{{ route('admin.appointments.create') }}"
           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Tambah Janji Temu
        </a>

    </div>

</div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-gray-50 border-b border-gray-100">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Pasien
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Dokter
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Jam
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($appointments as $appointment)

                    <tr class="hover:bg-gray-50 transition">

                        {{-- PASIEN --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-sm">

                                    {{ $appointment->patient?->initials ?? 'P' }}

                                </div>

                                <div>

                                    <p class="font-semibold text-gray-800 text-sm">
                                        {{ $appointment->patient?->name ?? '-' }}
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        {{ $appointment->patient?->patient_code ?? '-' }}
                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- DOKTER --}}
                        <td class="px-6 py-4">

                            <div>

                                <p class="font-medium text-sm text-gray-700">
                                    {{ $appointment->doctor?->name ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $appointment->doctor?->specialist?->name ?? '-' }}
                                </p>

                            </div>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-6 py-4 text-sm text-gray-600">

                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}

                        </td>

                        {{-- JAM --}}
                        <td class="px-6 py-4">

                            <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-sm font-semibold">

                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}

                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">

                            @php

                                $statusColor = match($appointment->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-700',
                                    'terkonfirmasi' => 'bg-green-100 text-green-700',
                                    'proses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-gray-100 text-gray-700',
                                    'dibatalkan' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };

                            @endphp

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">

                                {{ ucfirst($appointment->status) }}

                            </span>

                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-end gap-1">

                               {{-- KONFIRMASI --}}
@if($appointment->status == 'menunggu')

<form method="POST"
      action="{{ route('admin.appointments.update', $appointment) }}">

    @csrf
    @method('PUT')

    <input type="hidden"
           name="status"
           value="terkonfirmasi">

    <button type="submit"
            title="Konfirmasi"
            class="w-7 h-7 bg-gray-100 hover:bg-green-100 text-gray-500 hover:text-green-600 rounded-lg flex items-center justify-center transition-colors">

        <svg class="w-3.5 h-3.5"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 13l4 4L19 7"/>

        </svg>

    </button>

</form>

@endif

                                {{-- DETAIL --}}
                                <a href="{{ route('admin.appointments.show', $appointment) }}"
                                   title="Detail"
                                   class="w-7 h-7 bg-gray-100 hover:bg-blue-100 text-gray-500 hover:text-blue-600 rounded-lg flex items-center justify-center transition-colors">

                                    <svg class="w-3.5 h-3.5"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                 c4.478 0 8.268 2.943 9.542 7
                                                 -1.274 4.057-5.064 7-9.542 7
                                                 -4.477 0-8.268-2.943-9.542-7z"/>

                                    </svg>

                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('admin.appointments.edit', $appointment) }}"
                                   title="Edit"
                                   class="w-7 h-7 bg-gray-100 hover:bg-yellow-100 text-gray-500 hover:text-yellow-600 rounded-lg flex items-center justify-center transition-colors">

                                    <svg class="w-3.5 h-3.5"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11
                                                 a2 2 0 002 2h11a2 2 0 002-2v-5
                                                 m-1.414-9.414a2 2 0 112.828 2.828
                                                 L11.828 15H9v-2.828l8.586-8.586z"/>

                                    </svg>

                                </a>

                                {{-- HAPUS --}}
                                <form method="POST"
                                      action="{{ route('admin.appointments.destroy', $appointment) }}"
                                      onsubmit="return confirm('Hapus jadwal ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            title="Hapus"
                                            class="w-7 h-7 bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 rounded-lg flex items-center justify-center transition-colors">

                                        <svg class="w-3.5 h-3.5"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                     a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                     m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>

                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-14 text-gray-400 text-sm">

                            Belum ada jadwal temu

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-gray-100">

            {{ $appointments->links() }}

        </div>

    </div>

</div>

@endsection