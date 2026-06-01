@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 via-cyan-500 to-sky-500 rounded-[32px] p-8 shadow-xl mb-6">

        <div class="flex items-center gap-5">

            <div class="w-24 h-24 rounded-3xl bg-white/20 flex items-center justify-center text-4xl font-bold text-white border border-white/20">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>

                <h1 class="text-3xl font-bold text-white">
                    Edit Profil
                </h1>

                <p class="text-blue-100 mt-1">
                    Perbarui informasi akun dan data pasien
                </p>

            </div>

        </div>

    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">

        @if(session('success'))
            <div class="mb-6 bg-green-100 text-green-700 px-4 py-3 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.account.update') }}">

            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">

                {{-- NAME --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Nama Lengkap
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- PHONE --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Nomor Telepon
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $patient->phone ?? '') }}"
                           class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- GENDER --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Jenis Kelamin
                    </label>

                    <select name="gender"
                            class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

                        <option value="">Pilih Gender</option>

                        <option value="Laki-laki"
                            {{ ($patient->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ ($patient->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>
                </div>

                {{-- AGE --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Umur
                    </label>

                    <input type="number"
                           name="age"
                           value="{{ old('age', $patient->age ?? '') }}"
                           class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- BIRTH DATE --}}
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Tanggal Lahir
                    </label>

                    <input type="date"
                           name="birth_date"
                           value="{{ old('birth_date', $patient->birth_date ?? '') }}"
                           class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                {{-- ADDRESS --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-600 mb-2">
                        Alamat
                    </label>

                    <textarea name="address"
                              rows="4"
                              class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('address', $patient->address ?? '') }}</textarea>
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 mt-8">

                <a href="{{ route('user.account.index') }}"
                   class="px-6 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition shadow-lg">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection