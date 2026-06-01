<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================================
        // STATISTIK DASHBOARD
        // =====================================

        $totalPatients = Patient::count();

        $todayAppointments = Appointment::whereDate(
            'appointment_date',
            today()
        )->count();

        $activeDoctors = Doctor::where(
            'status',
            'online'
        )->count();

        $pendingApprovals = Appointment::where(
            'status',
            'menunggu'
        )->count();

        // =====================================
        // PERSENTASE / INFO TAMBAHAN
        // =====================================

        $patientGrowth = '+12%';
        $appointGrowth = '+5%';
        $doctorChange  = '+2';
        $pendingChange = '+1';

        // =====================================
        // JADWAL TEMU HARI INI
        // =====================================

        $todaySchedule = Appointment::with([
                'patient',
                'doctor',
                'room'
            ])
            ->whereDate(
                'appointment_date',
                today()
            )
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // =====================================
        // SIDEBAR KANAN
        // =====================================

        $sidebarSchedule = Appointment::with([
                'patient',
                'doctor'
            ])
            ->whereDate(
                'appointment_date',
                today()
            )
            ->whereIn('status', [
                'terkonfirmasi',
                'menunggu',
                'proses'
            ])
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // =====================================
        // CHART
        // =====================================

        $chartData = $this->getChartData();

        // =====================================
        // AKTIVITAS TERBARU
        // =====================================

        $activities = $this->getRecentActivities();

        // =====================================
        // PENDAPATAN HARI INI
        // =====================================

        $todayRevenue = Appointment::whereDate(
                'created_at',
                today()
            )
            ->whereIn('status', [
                'selesai',
                'terkonfirmasi',
                'proses'
            ])
            ->sum('fee');

        // =====================================
        // RETURN VIEW
        // =====================================

        return view('admin.dashboard', compact(
            'totalPatients',
            'todayAppointments',
            'activeDoctors',
            'pendingApprovals',
            'patientGrowth',
            'appointGrowth',
            'doctorChange',
            'pendingChange',
            'todaySchedule',
            'sidebarSchedule',
            'chartData',
            'activities',
            'todayRevenue'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CHART DATA
    |--------------------------------------------------------------------------
    */

    private function getChartData(): array
    {
        $months = [];
        $visits = [];
        $done   = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = now()->subMonths($i);

            $months[] = $date->format('M');

            $monthVisits = Appointment::whereYear(
                    'appointment_date',
                    $date->year
                )
                ->whereMonth(
                    'appointment_date',
                    $date->month
                )
                ->count();

            $monthDone = Appointment::whereYear(
                    'appointment_date',
                    $date->year
                )
                ->whereMonth(
                    'appointment_date',
                    $date->month
                )
                ->where('status', 'selesai')
                ->count();

            $visits[] = $monthVisits;
            $done[]   = $monthDone;
        }

        return [
            'labels' => $months,
            'visits' => $visits,
            'done'   => $done,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RECENT ACTIVITIES
    |--------------------------------------------------------------------------
    */

    private function getRecentActivities(): array
    {
        $appointments = Appointment::with([
                'patient',
                'doctor'
            ])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $activities = [];

        foreach ($appointments as $apt) {

            $activities[] = [

                'name' => $apt->patient->name ?? 'Pasien',

                'action' => $this->getActivityText(
                    $apt->status
                ),

                'time' => $apt->updated_at
                    ->diffForHumans(),

                'dot' => match($apt->status) {

                    'menunggu' => 'yellow',
                    'terkonfirmasi' => 'blue',
                    'proses' => 'purple',
                    'selesai' => 'green',
                    'dibatalkan' => 'red',

                    default => 'gray',
                }

            ];
        }

        return $activities;
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVITY TEXT
    |--------------------------------------------------------------------------
    */

    private function getActivityText(string $status): string
    {
        return match($status) {

            'terkonfirmasi'
                => 'telah check-in untuk janji temu',

            'menunggu'
                => 'mendaftar untuk janji temu',

            'proses'
                => 'sedang dalam proses pemeriksaan',

            'selesai'
                => 'telah selesai diperiksa',

            'dibatalkan'
                => 'membatalkan janji temu',

            default
                => 'melakukan aktivitas',
        };
    }
}