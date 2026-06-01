<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $today = '2026-04-26';

        // Appointments hari ini sesuai desain
        $todayData = [
            ['patient'=>'Budi Santoso',  'doctor'=>'Rina Wati',   'time'=>'08:00','room'=>'R.102','status'=>'terkonfirmasi'],
            ['patient'=>'Siti Rahayu',   'doctor'=>'Ahmad Yusuf', 'time'=>'08:30','room'=>'R.205','status'=>'menunggu'],
            ['patient'=>'Ahmad Pratama', 'doctor'=>'Dewi Lestari','time'=>'09:00','room'=>'R.308','status'=>'terkonfirmasi'],
            ['patient'=>'Lisa Nuraini',  'doctor'=>'Budi Hartono','time'=>'09:30','room'=>'R.401','status'=>'dibatalkan'],
            ['patient'=>'Rizky Maulana', 'doctor'=>'Rina Wati',   'time'=>'10:00','room'=>'R.102','status'=>'proses'],
            ['patient'=>'Maya Kusuma',   'doctor'=>'Budi Hartono','time'=>'10:30','room'=>'R.401','status'=>'terkonfirmasi'],
        ];

        foreach ($todayData as $data) {
            $patient = Patient::where('name', $data['patient'])->first();
            $doctor  = Doctor::where('name', $data['doctor'])->first();
            $room    = Room::where('room_number', $data['room'])->first();

            if ($patient && $doctor) {
                Appointment::create([
                    'patient_id'       => $patient->id,
                    'doctor_id'        => $doctor->id,
                    'room_id'          => $room?->id,
                    'appointment_date' => $today,
                    'appointment_time' => $data['time'],
                    'status'           => $data['status'],
                    'fee'              => 150000,
                ]);
            }
        }

        // Generate jadwal historis (beberapa bulan ke belakang) untuk grafik
        $patients = Patient::take(100)->get();
        $doctors  = Doctor::all();
        $rooms    = Room::all();
        $statuses = ['terkonfirmasi','terkonfirmasi','terkonfirmasi','selesai','selesai','dibatalkan'];

        // Buat data per bulan Nov-Apr
        $monthlyData = [
            ['month' => '2025-11', 'count' => 980],
            ['month' => '2025-12', 'count' => 1050],
            ['month' => '2026-01', 'count' => 980],
            ['month' => '2026-02', 'count' => 1045],
            ['month' => '2026-03', 'count' => 1145],
        ];

        foreach ($monthlyData as $monthData) {
            [$year, $month] = explode('-', $monthData['month']);
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
            $perDay = (int)($monthData['count'] / $daysInMonth);

            for ($day = 1; $day <= min($daysInMonth, 28); $day++) {
                $date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                $count = rand($perDay - 5, $perDay + 5);

                for ($j = 0; $j < $count; $j++) {
                    $patient = $patients->random();
                    $doctor  = $doctors->random();
                    $room    = $rooms->random();

                    Appointment::create([
                        'patient_id'       => $patient->id,
                        'doctor_id'        => $doctor->id,
                        'room_id'          => $room->id,
                        'appointment_date' => $date,
                        'appointment_time' => sprintf('%02d:00', rand(8, 16)),
                        'status'           => $statuses[array_rand($statuses)],
                        'fee'              => rand(100000, 300000),
                        'created_at'       => $date,
                        'updated_at'       => $date,
                    ]);
                }
            }
        }
    }
}