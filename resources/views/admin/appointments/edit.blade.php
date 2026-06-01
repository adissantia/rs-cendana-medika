@extends('layouts.admin')

@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Jadwal Temu</h1>
            <p class="text-sm text-gray-500 mt-1">
                Update data appointment pasien
            </p>
        </div>

        <a href="{{ route('admin.appointments.index') }}"
           class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium text-gray-700">
            Kembali
        </a>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <form method="POST"
              action="{{ route('admin.appointments.update', $appointment->id) }}"
              class="space-y-5">

            @csrf
            @method('PUT')

            {{-- PASIEN --}}
            <div>
                <label class="block text-sm font-medium mb-2">Pasien</label>
                <input type="text"
                       value="{{ $appointment->patient->name }}"
                       disabled
                       class="w-full border rounded-xl px-4 py-3 bg-gray-100">
            </div>

            {{-- DOKTER --}}
            <div>
                <label class="block text-sm font-medium mb-2">Dokter</label>
                <select name="doctor_id"
                        class="w-full border rounded-xl px-4 py-3" required>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TANGGAL --}}
            <div>
                <label class="block text-sm font-medium mb-2">Tanggal</label>
                <input type="date"
                       name="appointment_date"
                       value="{{ $appointment->appointment_date->format('Y-m-d') }}"
                       class="w-full border rounded-xl px-4 py-3" required>
            </div>

            {{-- JAM --}}
            <div>
                <label class="block text-sm font-medium mb-2">Jam</label>
                <input type="time"
                       name="appointment_time"
                       value="{{ $appointment->appointment_time }}"
                       class="w-full border rounded-xl px-4 py-3" required>
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block text-sm font-medium mb-2">Status Janji Temu</label>
                <select name="status"
                        class="w-full border rounded-xl px-4 py-3" required>

                    @foreach(['menunggu','terkonfirmasi','proses','selesai','dibatalkan'] as $status)
                        <option value="{{ $status }}"
                            {{ $appointment->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- PEMBAYARAN --}}
            <div>
                <label class="block text-sm font-medium mb-2">Status Pembayaran</label>
                <select name="payment_status"
                        class="w-full border rounded-xl px-4 py-3" required>
                    <option value="pending"
                        {{ $appointment->payment_status == 'pending' ? 'selected' : '' }}>
                        Belum Dibayar
                    </option>
                    <option value="paid"
                        {{ $appointment->payment_status == 'paid' ? 'selected' : '' }}>
                        Sudah Dibayar
                    </option>
                </select>
            </div>

            {{-- BIAYA --}}
            <div>
                <label class="block text-sm font-medium mb-2">Biaya Konsultasi</label>
                <input type="number"
                       name="fee"
                       value="{{ $appointment->fee }}"
                       class="w-full border rounded-xl px-4 py-3" required>
            </div>

            {{-- CATATAN --}}
            <div>
                <label class="block text-sm font-medium mb-2">Catatan</label>
                <textarea name="notes"
                          rows="3"
                          class="w-full border rounded-xl px-4 py-3">{{ $appointment->notes }}</textarea>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.appointments.index') }}"
                   class="px-5 py-3 bg-gray-100 rounded-xl">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-3 bg-blue-600 text-white rounded-xl">
                    Update Jadwal
                </button>
            </div>

        </form>
    </div>

</div>
@endsection