<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialist;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // PERIODE
        // =========================

        $startDate = now()->startOfMonth();
        $endDate   = now()->endOfMonth();

        // =========================
        // BASE QUERY
        // =========================

        $baseQuery = Appointment::whereBetween(
            'appointment_date',
            [$startDate, $endDate]
        );

        // =========================
        // SUMMARY
        // =========================

        $totalAppointments = (clone $baseQuery)->count();

        $completedAppointments = (clone $baseQuery)
            ->where('status', 'selesai')
            ->count();

        $cancelledAppointments = (clone $baseQuery)
            ->where('status', 'dibatalkan')
            ->count();

        $waitingAppointments = (clone $baseQuery)
            ->where('status', 'menunggu')
            ->count();

        $confirmedAppointments = (clone $baseQuery)
            ->where('status', 'terkonfirmasi')
            ->count();

        $processAppointments = (clone $baseQuery)
            ->where('status', 'proses')
            ->count();

        // =========================
        // TOTAL REVENUE
        // =========================

        $totalRevenue = (clone $baseQuery)
            ->whereIn('status', [
                'selesai',
                'terkonfirmasi',
                'proses'
            ])
            ->sum('fee');

        // =========================
        // AVG VISIT
        // =========================

        $totalVisits = $totalAppointments;

        $avgPerVisit = $totalVisits > 0
            ? $totalRevenue / $totalVisits
            : 0;

        // =========================
        // REVENUE BY SPECIALIST
        // =========================

        $revenueBySpecialist = Specialist::query()

            ->select(
                'specialists.id',
                'specialists.name'
            )

            ->leftJoin(
                'doctors',
                'doctors.specialist_id',
                '=',
                'specialists.id'
            )

            ->leftJoin('appointments', function ($join) use ($startDate, $endDate) {

                $join->on(
                    'appointments.doctor_id',
                    '=',
                    'doctors.id'
                )

                ->whereBetween(
                    'appointments.appointment_date',
                    [$startDate, $endDate]
                )

                ->whereIn('appointments.status', [
                    'selesai',
                    'terkonfirmasi',
                    'proses'
                ]);
            })

            ->selectRaw('COUNT(appointments.id) as appointment_count')

            ->selectRaw('COALESCE(SUM(appointments.fee),0) as total_revenue')

            ->groupBy(
                'specialists.id',
                'specialists.name'
            )

            ->orderByDesc('total_revenue')

            ->limit(5)

            ->get()

            ->map(function ($row) use ($totalAppointments) {

                $row->percentage = $totalAppointments > 0
                    ? round(
                        ($row->appointment_count / $totalAppointments) * 100
                    )
                    : 0;

                return $row;
            });

        // =========================
        // TOP DOCTORS
        // =========================

        $topDoctors = Doctor::query()

            ->with('specialist')

            ->leftJoin('appointments', function ($join) use ($startDate, $endDate) {

                $join->on(
                    'appointments.doctor_id',
                    '=',
                    'doctors.id'
                )

                ->whereBetween(
                    'appointments.appointment_date',
                    [$startDate, $endDate]
                )

                ->whereIn('appointments.status', [
                    'selesai',
                    'terkonfirmasi',
                    'proses'
                ]);
            })

            ->select(
                'doctors.id',
                'doctors.name',
                'doctors.specialist_id'
            )

            ->selectRaw('COUNT(appointments.id) as total_patients')

            ->selectRaw('COALESCE(SUM(appointments.fee),0) as total_revenue')

            ->groupBy(
                'doctors.id',
                'doctors.name',
                'doctors.specialist_id'
            )

            ->orderByDesc('total_revenue')

            ->limit(5)

            ->get();

        // =========================
        // CHART DATA
        // =========================

        $chartLabels = [
            'Menunggu',
            'Terkonfirmasi',
            'Proses',
            'Selesai',
            'Dibatalkan',
        ];

        $chartData = [
            $waitingAppointments,
            $confirmedAppointments,
            $processAppointments,
            $completedAppointments,
            $cancelledAppointments,
        ];

        // =========================
        // RETURN VIEW
        // =========================

        return view('admin.reports.index', compact(
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'waitingAppointments',
            'confirmedAppointments',
            'processAppointments',
            'totalRevenue',
            'totalVisits',
            'avgPerVisit',
            'revenueBySpecialist',
            'topDoctors',
            'chartLabels',
            'chartData'
        ));
    }

    public function exportPdf()
{
    $startDate = now()->startOfMonth();
    $endDate   = now()->endOfMonth();

    $appointments = Appointment::with([
        'doctor',
        'patient'
    ])
    ->whereBetween('appointment_date', [
        $startDate,
        $endDate
    ])
    ->latest()
    ->get();

    $totalAppointments = $appointments->count();

    $completedAppointments = $appointments
        ->where('status', 'selesai')
        ->count();

    $cancelledAppointments = $appointments
        ->where('status', 'dibatalkan')
        ->count();

    $totalRevenue = $appointments
        ->whereIn('status', [
            'selesai',
            'terkonfirmasi',
            'proses'
        ])
        ->sum('fee');

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'admin.reports.pdf',
        compact(
            'appointments',
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'totalRevenue'
        )
    );

    return $pdf->download('laporan-rs-cendana.pdf');
}

}