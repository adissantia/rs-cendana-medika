@extends('layouts.user')

@section('title', 'Buat Janji')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Buat Janji Temu
        </h1>

        <p class="text-slate-500 mt-1">
            Pilih dokter dan jadwal konsultasi
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <form action="{{ route('user.queue.store') }}"
              method="POST"
              class="space-y-5">

            @csrf

            {{-- Dokter --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Pilih Dokter
                </label>

                <select name="doctor_id"
                        required
                        class="w-full border rounded-xl px-4 py-3">

                    <option value="">-- Pilih Dokter --</option>

                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->name }}
                            -
                            {{ $doctor->specialist?->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Tanggal Konsultasi
                </label>

                <input type="date"
                       name="appointment_date"
                       required
                       class="w-full border rounded-xl px-4 py-3">
            </div>

            {{-- Jam --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Jam Konsultasi
                </label>

                <select name="appointment_time"
                        required
                        class="w-full border rounded-xl px-4 py-3">

                    <option value="">-- Pilih Jam --</option>

                    <option value="08:00">08:00</option>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                </select>
            </div>

            {{-- Keluhan --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Keluhan
                </label>

                <textarea name="notes"
                          rows="4"
                          class="w-full border rounded-xl px-4 py-3"
                          placeholder="Masukkan keluhan anda..."></textarea>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium">
                    Buat Janji
                </button>

            </div>

        </form>

    </div>

</div>

@endsection