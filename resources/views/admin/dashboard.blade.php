@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- ===== BANNER SELAMAT PAGI ===== --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-5 flex items-center justify-between">
        <div>
            <h2 class="text-white font-semibold text-lg">
                Selamat Pagi, Admin! 👋
            </h2>
            <p class="text-blue-100 text-sm mt-1">
                Ada <strong>{{ $todayAppointments }}</strong> janji temu hari ini dan
                <strong>{{ $pendingApprovals }}</strong> permohonan menunggu persetujuan Anda
            </p>
        </div>
        <a href="{{ route('admin.appointments.index') }}"
           class="bg-white text-blue-600 text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors flex-shrink-0">
            Lihat Jadwal →
        </a>
    </div>

    {{-- ===== 4 STAT CARDS ===== --}}
    <div class="grid grid-cols-4 gap-4">

        {{-- Total Pasien --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ $patientGrowth }}</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPatients) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Pasien</p>
        </div>

        {{-- Janji Temu --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">{{ $appointGrowth }}</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $todayAppointments }}</p>
            <p class="text-sm text-gray-500 mt-1">Janji Temu Hari Ini</p>
        </div>

        {{-- Dokter Aktif --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">{{ $doctorChange }}</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $activeDoctors }}</p>
            <p class="text-sm text-gray-500 mt-1">Dokter Aktif</p>
        </div>

        {{-- Pending Approval --}}
        <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">{{ $pendingChange }}</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $pendingApprovals }}</p>
            <p class="text-sm text-gray-500 mt-1">Pending Approval</p>
        </div>
    </div>

    {{-- ===== ROW 2: GRAFIK + KALENDER ===== --}}
    <div class="grid grid-cols-3 gap-6">

        {{-- Grafik Kunjungan (2/3 lebar) --}}
        <div class="col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-gray-800">Kunjungan Pasien</h3>
                    <p class="text-xs text-gray-400">Data kunjungan 6 bulan terakhir</p>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">6 Bulan</span>
            </div>
            <div class="h-48">
                <canvas id="visitChart"></canvas>
            </div>
        </div>

        {{-- Mini Kalender (1/3 lebar) --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h3 class="font-semibold text-gray-800 mb-4">Kalender</h3>
            @php
                $today = now();
                $firstDayOfMonth = $today->copy()->startOfMonth()->dayOfWeek; // 0=Minggu
                $daysInMonth = $today->daysInMonth;
                $dayNames = ['MIN','SEN','SEL','RAB','KAM','JUM','SAB'];
            @endphp
            <div class="text-center mb-3">
                <p class="text-sm font-medium text-gray-700">{{ $today->format('F Y') }}</p>
            </div>
            <div class="grid grid-cols-7 gap-1 text-center">
                @foreach($dayNames as $day)
                    <div class="text-xs font-medium text-gray-400 py-1">{{ $day }}</div>
                @endforeach
                @for($i = 0; $i < $firstDayOfMonth; $i++)
                    <div></div>
                @endfor
                @for($d = 1; $d <= $daysInMonth; $d++)
                    <div class="text-xs py-1 rounded-full w-6 h-6 flex items-center justify-center mx-auto cursor-pointer
                        {{ $d == $today->day ? 'bg-blue-600 text-white font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $d }}
                    </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- ===== ROW 3: JADWAL TEMU + SIDEBAR JADWAL ===== --}}
    <div class="grid grid-cols-3 gap-6">

        {{-- Jadwal Temu Hari Ini (2/3) --}}
        <div class="col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Janji Temu Hari Ini</h3>
                <a href="{{ route('admin.appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Lihat Semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-5 py-3">Pasien</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-4 py-3">Dokter</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-4 py-3">Waktu</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-4 py-3">Status</th>
                            <th class="text-left text-xs font-medium text-gray-400 uppercase px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($todaySchedule as $apt)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full {{ $apt->patient->avatar_color }} flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-xs font-bold">{{ $apt->patient->initials }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $apt->patient->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $apt->patient->patient_code }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $apt->doctor->full_name }}</td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-semibold text-blue-600">
                                    {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $apt->status_class }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $apt->status_dot }}"></span>
                                    {{ $apt->status_label }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.appointments.edit', $apt) }}"
                                   class="text-xs text-blue-600 hover:text-blue-700 font-medium">+ Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">
                                Tidak ada jadwal temu hari ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Jadwal Sidebar Kanan (1/3) --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800 text-sm">Jadwal Hari Ini</h3>
                <a href="{{ route('admin.appointments.index') }}" class="text-xs text-blue-600">Semua</a>
            </div>
            <div class="p-3 space-y-2">
                @forelse($sidebarSchedule as $apt)
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex-shrink-0 text-right">
                        <span class="text-xs font-bold text-blue-600">
                            {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ $apt->patient->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $apt->doctor->full_name }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        @if($apt->status === 'menunggu')
                            <form method="POST" action="{{ route('admin.appointments.update', $apt) }}" class="inline">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="terkonfirmasi">
                                <button type="submit" class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center hover:bg-green-200 transition-colors" title="Konfirmasi">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                        @elseif($apt->status === 'terkonfirmasi')
                            <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-xs text-gray-400 text-center py-4">Tidak ada jadwal</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ===== ROW 4: AKTIVITAS TERBARU + AKSI CEPAT ===== --}}
    <div class="grid grid-cols-2 gap-6">

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Aktivitas Terbaru</h3>
                <span class="text-xs text-gray-400">Hari Ini</span>
            </div>
            <div class="space-y-3">
                @forelse($activities as $activity)
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ $activity['dot'] }}"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-700">
                            <strong>{{ $activity['name'] }}</strong> {{ $activity['action'] }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }} — Hari ini</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400">Belum ada aktivitas hari ini</p>
                @endforelse
            </div>
        </div>

        {{-- Aksi Cepat + Pendapatan --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.appointments.create') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-colors group">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                            <svg class="w-4 h-4 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-600 font-medium group-hover:text-blue-700 text-center">Tambah Jadwal</span>
                    </a>
                    <a href="{{ route('admin.patients.create') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-colors group">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-600 transition-colors">
                            <svg class="w-4 h-4 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-600 font-medium group-hover:text-green-700 text-center">Daftar Pasien</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-colors group">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-600 transition-colors">
                            <svg class="w-4 h-4 text-yellow-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-600 font-medium group-hover:text-yellow-700 text-center">Export Laporan</span>
                    </a>
                    <a href="{{ route('admin.doctors.index') }}"
                       class="flex flex-col items-center gap-2 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition-colors group">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-600 transition-colors">
                            <svg class="w-4 h-4 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="text-xs text-gray-600 font-medium group-hover:text-purple-700 text-center">Data Dokter</span>
                    </a>
                </div>
            </div>

            {{-- Pendapatan Hari Ini --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                <p class="text-sm text-gray-500 mb-1">Pendapatan Hari Ini</p>
                <p class="text-2xl font-bold text-blue-600">
                    Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                </p>
                <p class="text-xs text-green-600 mt-1">+ 8% dari kemarin</p>
                <div class="mt-3">
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: 60%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">60% dari target harian</p>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Chart.js Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('visitChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [
                {
                    label: 'Kunjungan',
                    data: @json($chartData['visits']),
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 4,
                    borderSkipped: false,
                },
                {
                    label: 'Selesai',
                    data: @json($chartData['done']),
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderRadius: 4,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: { boxWidth: 10, font: { size: 11 }, padding: 15 }
                },
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11 } } }
            }
        }
    });
});
</script>
@endsection