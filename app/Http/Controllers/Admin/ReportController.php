<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialist;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

public function exportExcel()
{
    $startDate = now()->startOfMonth();
    $endDate   = now()->endOfMonth();

    $appointments = Appointment::with(['doctor', 'patient'])
        ->whereBetween('appointment_date', [$startDate, $endDate])
        ->latest()
        ->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // =========================
    // JUDUL
    // =========================
    $sheet->setCellValue('A1', 'LAPORAN JADWAL JANJI TEMU');
    $sheet->mergeCells('A1:F1');

    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // =========================
    // HEADER
    // =========================
    $headers = ['No', 'Pasien', 'Dokter', 'Tanggal', 'Status', 'Fee'];

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '3', $header);

        $sheet->getStyle($col . '3')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        $col++;
    }

    // =========================
    // DATA
    // =========================
    $row = 4;
    $no = 1;
    $totalRevenue = 0;

    foreach ($appointments as $item) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $item->patient->name ?? '-');
        $sheet->setCellValue('C' . $row, $item->doctor->name ?? '-');
        $sheet->setCellValue('D' . $row, $item->appointment_date);
        $sheet->setCellValue('E' . $row, $item->status);
        $sheet->setCellValue('F' . $row, $item->fee);

        if (in_array($item->status, ['selesai', 'terkonfirmasi', 'proses'])) {
            $totalRevenue += $item->fee;
        }

        $sheet->getStyle("A$row:F$row")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ]);

        $row++;

        $sheet->setCellValue('E' . $row, 'TOTAL PENDAPATAN');
        $sheet->setCellValue('F' . $row, $totalRevenue);

// styling total
$sheet->getStyle("E$row:F$row")->applyFromArray([
    'font' => [
        'bold' => true
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THICK
        ]
    ]
]);

$sheet->getProtection()->setPassword('12345');
$sheet->getProtection()->setSheet(true);

}

    // Auto size kolom
    foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    
    // =========================
    // DOWNLOAD
    // =========================
    
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="laporan-appointment.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

}