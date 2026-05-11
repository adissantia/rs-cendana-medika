@extends('layouts.admin')

@section('title', 'Tambah Dokter')
@section('page-title', 'Tambah Dokter')

@section('breadcrumb')
    <span class="text-gray-400">Dokter</span>
    <span class="mx-2">/</span>
    <span class="text-gray-600">Tambah</span>
@endsection

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-3xl shadow-sm border p-6">
        <h2 class="text-xl font-bold text-slate-800">
            Tambah Data Dokter
        </h2>
        <p class="text-sm text-slate-500 mt-1">
            Kode dokter akan dibuat otomatis oleh sistem
        </p>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-3xl shadow-sm border p-8">

        <form action="{{ route('admin.doctors.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            {{-- INFO KODE --}}
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>

                <p class="text-sm text-blue-700">
                    <span class="font-semibold">Info:</span>
                    Kode dokter akan dibuat otomatis oleh sistem setelah data disimpan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- NAMA --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Nama Dokter
                    </label>
                    <input type="text"
                           name="name"
                           required
                           placeholder="Contoh: Andi Pratama"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- SPESIALIS --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Spesialis
                    </label>
                    <select name="specialist_id"
                            required
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">-- Pilih Spesialis --</option>
                        @foreach($specialists as $specialist)
                            <option value="{{ $specialist->id }}">
                                {{ $specialist->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Status
                    </label>
                    <select name="status"
                            required
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                        <option value="cuti">Cuti</option>
                    </select>
                </div>

                {{-- NO HP --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        No HP
                    </label>
                    <input type="text"
                           name="phone"
                           placeholder="08xxxxxxxxxx"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- AVATAR --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Foto Dokter
                    </label>
                    <input type="file"
                           name="avatar"
                           class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-600
                                  hover:file:bg-blue-100">
                </div>

            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 pt-6 border-t">

                <a href="{{ route('admin.doctors.index') }}"
                   class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-semibold text-slate-700 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    Simpan Dokter
                </button>

            </div>

        </form>

    </div>

</div>

@endsection