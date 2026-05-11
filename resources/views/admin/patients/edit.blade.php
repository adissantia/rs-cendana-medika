@extends('layouts.admin')

@section('title', 'Edit Pasien')
@section('page-title', 'Edit Data Pasien')

@section('breadcrumb')
<span class="text-gray-600">Edit Pasien</span>
@endsection

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">
                Edit Data Pasien
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Perbarui informasi pasien RS Cendana Medika.
            </p>
        </div>

        {{-- Form --}}
        <form method="POST"
              action="{{ route('admin.patients.update', $patient) }}"
              class="p-6">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nama --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $patient->name) }}"
                           class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', $patient->email) }}"
                           class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor HP
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $patient->phone) }}"
                           class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                    @error('phone')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>

                    <select name="gender"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        <option value="Laki-laki"
                            {{ $patient->gender == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ $patient->gender == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>
                </div>

                {{-- Umur --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Umur
                    </label>

                    <input type="number"
                           name="age"
                           value="{{ old('age', $patient->age) }}"
                           class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Birth Date --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Lahir
                    </label>

                    <input type="date"
                           name="birth_date"
                           value="{{ old('birth_date', $patient->birth_date) }}"
                           class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Status
                    </label>

                    <select name="status"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                        <option value="aktif"
                            {{ $patient->status == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="nonaktif"
                            {{ $patient->status == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat
                    </label>

                    <textarea name="address"
                              rows="4"
                              class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('address', $patient->address) }}</textarea>
                </div>

            </div>

            {{-- Button --}}
            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('admin.patients.index') }}"
                   class="px-5 py-3 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition shadow-lg shadow-blue-100">
                    Simpan Perubahan
                </button>

            </div>
        </form>

    </div>

</div>

@endsection