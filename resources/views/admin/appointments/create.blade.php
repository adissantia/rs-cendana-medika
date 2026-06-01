@extends('layouts.admin')

@section('title', 'Tambah Janji Temu')
@section('page-title', 'Tambah Janji Temu')

@section('content')
<div class="bg-white rounded-xl shadow p-6 max-w-4xl">

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            {{-- PASIEN --}}
            <div>
                <label class="text-sm font-medium">Pasien</label>
                <select name="patient_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DOKTER --}}
            <div>
                <label class="text-sm font-medium">Dokter</label>
                <select name="doctor_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Pilih Dokter</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TANGGAL --}}
            <div>
                <label class="text-sm font-medium">Tanggal</label>
                <input type="date"
                    name="appointment_date"
                    min="{{ date('Y-m-d') }}"
                    class="w-full border rounded-xl px-4 py-3"
                    required>
            </div>

            {{-- JAM --}}
            <div>
                <label class="text-sm font-medium">Jam</label>
               <input type="time"
                name="appointment_time"
                min="08:00"
                max="16:00"
                class="w-full border rounded-xl px-4 py-3"
                required>
            </div>

            {{-- BIAYA --}}
            <div>
                <label class="text-sm font-medium">Biaya Konsultasi</label>
                <input
                    type="number"
                    name="fee"
                    value="{{ old('fee') }}"
                    class="w-full border rounded-lg px-3 py-2"
                    min="0"
                    required
                >
            </div>

            {{-- STATUS PEMBAYARAN --}}
            <div>
                <label class="text-sm font-medium">Status Pembayaran</label>
                <select name="payment_status" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>
                        Belum Dibayar
                    </option>
                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>
                        Sudah Dibayar
                    </option>
                </select>
            </div>

            {{-- CATATAN --}}
            <div class="col-span-2">
                <label class="text-sm font-medium">Catatan</label>
                <textarea
                    name="notes"
                    class="w-full border rounded-lg px-3 py-2"
                    rows="3"
                >{{ old('notes') }}</textarea>
            </div>

        </div>

        {{-- ACTION --}}
        <div class="mt-6 flex gap-3">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg"
            >
                Simpan Janji Temu
            </button>

            <a
                href="{{ route('admin.appointments.index') }}"
                class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg"
            >
                Batal
            </a>
        </div>

    </form>

</div>
@endsection