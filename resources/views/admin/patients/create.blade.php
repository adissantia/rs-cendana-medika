@extends('layouts.admin')

@section('title', 'Tambah Pasien')
@section('page-title', 'Tambah Pasien')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        {{-- HEADER --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Pasien
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Tambahkan data pasien baru rumah sakit
            </p>

        </div>

        {{-- ERROR --}}
        @if ($errors->any())

            <div class="mb-5 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">

                <ul class="list-disc pl-5 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- FORM --}}
        <form
            action="{{ route('admin.patients.store') }}"
            method="POST"
            class="space-y-5">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- NAMA --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pasien
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Masukkan nama pasien">

                </div>

                {{-- EMAIL --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="Masukkan email">

                </div>

                {{-- TELEPON --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"
                        placeholder="08xxxxxxxxxx">

                </div>

                {{-- GENDER --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gender
                    </label>

                    <select
                        name="gender"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

                        <option value="">Pilih Gender</option>

                        <option value="Laki-laki"
                            {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>

                </div>

                {{-- TANGGAL LAHIR --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        name="birth_date"
                        value="{{ old('birth_date') }}"
                        required
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

                </div>

                {{-- SPESIALIS --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Poli / Spesialis
                    </label>

                    

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex items-center justify-end gap-3 pt-4">

                <a href="{{ route('admin.patients.index') }}"
                   class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-sm font-medium text-gray-700 transition">

                    Batal

                </a>

                <button
                    type="submit"
                    class="px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">

                    Simpan Pasien

                </button>

            </div>

        </form>

    </div>

</div>

@endsection