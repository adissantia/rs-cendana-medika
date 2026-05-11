@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('breadcrumb')
    <span class="text-gray-600">Laporan</span>
@endsection

@section('content')
<div class="space-y-5">

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl p-5 border shadow-sm">
            <p class="text-2xl font-bold text-gray-800">
                {{ number_format($totalAppointments) }}
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Total Janji Temu
            </p>
        </div>

        <div class="bg-white rounded-xl p-5 border shadow-sm">
            <p class="text-2xl font-bold text-green-600">
                {{ number_format($completedAppointments) }}
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Janji Selesai
            </p>
        </div>

        <div class="bg-white rounded-xl p-5 border shadow-sm">
            <p class="text-2xl font-bold text-red-600">
                {{ number_format($cancelledAppointments) }}
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Dibatalkan
            </p>
        </div>

        <div class="bg-white rounded-xl p-5 border shadow-sm">
            <p class="text-2xl font-bold text-blue-600">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Total Pendapatan
            </p>
        </div>

    </div>

    {{-- ===== CHART ===== --}}
    <div class="bg-white rounded-xl border shadow-sm p-5">

        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-semibold text-gray-800">
                Statistik Janji Temu
            </h3>
            <p class="text-sm text-gray-500">
                Ringkasan status appointment rumah sakit
            </p>
            <a href="{{ route('admin.reports.pdf') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
            Cetak PDF
            </a>

        </div>

        <div class="h-[350px]">
            <canvas id="appointmentChart"></canvas>
        </div>

    </div>

    {{-- ===== REVENUE BY SPECIALIST ===== --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b">
            <h3 class="text-base font-semibold text-gray-800">
                Pendapatan per Spesialis
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">

                <thead class="bg-gray-50">
                    <tr class="text-xs text-gray-500 uppercase">
                        <th class="px-5 py-3 text-left">Spesialis</th>
                        <th class="px-4 py-3 text-center">Janji Temu</th>
                        <th class="px-4 py-3 text-right">Pendapatan</th>
                        <th class="px-4 py-3 text-center">Persentase</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($revenueBySpecialist as $row)
                        <tr>
                            <td class="px-5 py-4 font-medium text-gray-700">
                                {{ $row->name }}
                            </td>

                            <td class="px-4 py-4 text-center text-gray-600">
                                {{ $row->appointment_count }}
                            </td>

                            <td class="px-4 py-4 text-right font-medium text-gray-700">
                                Rp {{ number_format($row->total_revenue, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="bg-blue-50 text-blue-600 text-xs px-2 py-1 rounded-full">
                                    {{ $row->percentage }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-400">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

    {{-- ===== TOP DOCTORS ===== --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b">
            <h3 class="text-base font-semibold text-gray-800">
                Top Dokter
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">

                <thead class="bg-gray-50">
                    <tr class="text-xs text-gray-500 uppercase">
                        <th class="px-5 py-3 text-left">Dokter</th>
                        <th class="px-4 py-3 text-left">Spesialis</th>
                        <th class="px-4 py-3 text-center">Pasien</th>
                        <th class="px-4 py-3 text-right">Pendapatan</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($topDoctors as $doc)
                        <tr>
                            <td class="px-5 py-4 font-medium text-gray-700">
                                {{ $doc->name }}
                            </td>

                            <td class="px-4 py-4 text-gray-600">
                                {{ $doc->specialist->name ?? '-' }}
                            </td>

                            <td class="px-4 py-4 text-center text-gray-600">
                                {{ $doc->total_patients }}
                            </td>

                            <td class="px-4 py-4 text-right font-medium text-gray-700">
                                Rp {{ number_format($doc->total_revenue, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-400">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

{{-- ===== CHART JS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('appointmentChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Appointment',
                data: {!! json_encode($chartData) !!},
                backgroundColor: [
                    '#facc15',
                    '#22c55e',
                    '#3b82f6',
                    '#6b7280',
                    '#ef4444'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

});
</script>

@endsection