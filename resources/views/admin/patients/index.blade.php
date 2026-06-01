@extends('layouts.admin')

@section('title', 'Data Pasien')
@section('page-title', 'Data Pasien')
@section('breadcrumb')
<span class="text-gray-600">Pasien</span>
@endsection

@section('content')
<div class="space-y-6" x-data="{ showModal: false }">

    {{-- ================= STATISTIC CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Total Pasien --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pasien</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ number_format($totalPatients) }}
                    </h2>
                </div>

                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pasien Baru --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pasien Baru</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $newThisMonth }}
                    </h2>
                </div>

                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Kunjungan Hari Ini --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Kunjungan Hari Ini</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $todayVisits }}
                    </h2>
                </div>

                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Kepuasan --}}
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Kepuasan</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $satisfactionRate }}%
                    </h2>
                </div>

                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-6 py-5 border-b border-gray-100">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Data Pasien
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola seluruh data pasien rumah sakit
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">

                {{-- Search --}}
                <form method="GET" class="flex items-center gap-3 flex-wrap">

                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari pasien..."
                            class="w-64 border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                        >

                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <select
                        name="gender"
                        class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                    >
                        <option value="">Semua Gender</option>

                        <option value="Laki-laki"
                            {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors"
                    >
                        Filter
                    </button>
                </form>

                {{-- Button --}}
                <a
    href="{{ route('admin.patients.create') }}"
    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-xl flex items-center gap-2 transition-colors"
>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>

                    Tambah Pasien
                </a>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Pasien
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            ID
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Umur
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Gender
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Telepon
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Tanggal Lahir
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Status
                        </th>

                        <th class="px-4 py-4 text-left text-xs font-semibold text-gray-400 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($patients as $patient)

                    <tr class="hover:bg-gray-50 transition-colors">

                        {{-- PASIEN --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">
                                        {{ $patient->initials }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $patient->name }}
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        {{ $patient->email ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- CODE --}}
                        <td class="px-4 py-4">
                            <span class="font-mono text-sm text-blue-600">
                                {{ $patient->patient_code }}
                            </span>
                        </td>

                        {{-- AGE --}}
                        <td class="px-4 py-4 text-sm text-gray-600">
                            {{ $patient->calculated_age }} thn
                        </td>

                        {{-- GENDER --}}
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $patient->gender == 'Laki-laki'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-pink-100 text-pink-700' }}">
                                {{ $patient->gender }}
                            </span>
                        </td>

                        {{-- PHONE --}}
                        <td class="px-4 py-4 text-sm text-gray-600">
                            {{ $patient->phone ?? '-' }}
                        </td>

                        {{-- BIRTH --}}
                        <td class="px-4 py-4 text-sm text-gray-600">
                            {{ $patient->birth_date
                                ? \Carbon\Carbon::parse($patient->birth_date)->format('d M Y')
                                : '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $patient->status == 'aktif'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($patient->status) }}
                            </span>
                        </td>

                        {{-- ACTION --}}
                        <td class="px-4 py-4">

                            <div class="flex items-center gap-2">

                                {{-- SHOW --}}
                                <a
                                    href="{{ route('admin.patients.show', $patient) }}"
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-blue-100 text-gray-500 hover:text-blue-600 flex items-center justify-center transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                {{-- EDIT --}}
                                <a
                                    href="{{ route('admin.patients.edit', $patient) }}"
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-yellow-100 text-gray-500 hover:text-yellow-600 flex items-center justify-center transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>

                                {{-- DELETE --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.patients.destroy', $patient) }}"
                                    onsubmit="return confirm('Hapus pasien ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 flex items-center justify-center transition-colors"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6"/>
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-14 text-gray-400 text-sm">
                            Tidak ada data pasien
                        </td>
                    </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $patients->links() }}
        </div>
    </div>

</div>
@endsection