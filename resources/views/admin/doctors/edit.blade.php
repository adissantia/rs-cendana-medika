@extends('layouts.admin')

@section('title', 'Edit Dokter')
@section('page-title', 'Edit Dokter')

@section('breadcrumb')
    <span class="text-gray-400">Dokter</span>
    <span class="mx-2">/</span>
    <span class="text-gray-600">Edit</span>
@endsection

@section('content')

<div class="max-w-3xl">

    <div class="bg-white rounded-2xl border shadow-sm p-6">

        <form
            method="POST"
            action="{{ route('admin.doctors.update', $doctor) }}"
            enctype="multipart/form-data"
            class="space-y-5"
        >
            @csrf
            @method('PUT')

            {{-- FOTO --}}
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Dokter
                </label>

                @if($doctor->avatar)
                    <img
                        src="{{ asset('storage/' . $doctor->avatar) }}"
                        class="w-24 h-24 rounded-full object-cover mb-3 border"
                    >
                @endif

                <input
                    type="file"
                    name="avatar"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2"
                >

            </div>

            {{-- NAMA --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Dokter
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $doctor->name) }}"
                    required
                    class="w-full border border-gray-300 rounded-xl px-3 py-2"
                >
            </div>

            {{-- PHONE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    No HP
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $doctor->phone) }}"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2"
                >
            </div>

            {{-- SPESIALIS --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Spesialis
                </label>

                <select
                    name="specialist_id"
                    required
                    class="w-full border border-gray-300 rounded-xl px-3 py-2"
                >
                    @foreach($specialists as $spec)
                        <option
                            value="{{ $spec->id }}"
                            {{ $doctor->specialist_id == $spec->id ? 'selected' : '' }}
                        >
                            {{ $spec->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full border border-gray-300 rounded-xl px-3 py-2"
                >
                    <option value="online" {{ $doctor->status == 'online' ? 'selected' : '' }}>
                        Online
                    </option>

                    <option value="offline" {{ $doctor->status == 'offline' ? 'selected' : '' }}>
                        Offline
                    </option>

                    <option value="cuti" {{ $doctor->status == 'cuti' ? 'selected' : '' }}>
                        Cuti
                    </option>
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3 pt-4">

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl"
                >
                    Simpan Perubahan
                </button>

                <a href="{{ route('admin.doctors.index') }}"
                    class="border border-gray-300 hover:bg-gray-100 px-5 py-2 rounded-xl">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection