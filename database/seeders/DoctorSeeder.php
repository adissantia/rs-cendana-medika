<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialist;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $pd   = Specialist::where('slug', 'penyakit-dalam')->first()->id;
        $kard = Specialist::where('slug', 'kardiologi')->first()->id;
        $derm = Specialist::where('slug', 'dermatologi')->first()->id;
        $bedah= Specialist::where('slug', 'bedah-umum')->first()->id;
        $neuro= Specialist::where('slug', 'neurologi')->first()->id;
        $orto = Specialist::where('slug', 'ortopedi')->first()->id;

        $doctors = [
            [
                'doctor_code'   => 'DOK-0001',
                'name'          => 'Rina Wati',
                'title'         => 'Sp.PD',
                'specialist_id' => $pd,
                'str_number'    => 'STR-0321-STR-0123456789',
                'schedule_days' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
                'schedule_start'=> '08:00',
                'schedule_end'  => '14:00',
                'rating'        => 4.9,
                'total_reviews' => 750,
                'status'        => 'online',
            ],
            [
                'doctor_code'   => 'DOK-0002',
                'name'          => 'Ahmad Yusuf',
                'title'         => 'Sp.JP',
                'specialist_id' => $kard,
                'str_number'    => 'STR-0321-STR-0987654321',
                'schedule_days' => ['Sen', 'Rab', 'Jum'],
                'schedule_start'=> '09:00',
                'schedule_end'  => '15:00',
                'rating'        => 4.8,
                'total_reviews' => 412,
                'status'        => 'online',
            ],
            [
                'doctor_code'   => 'DOK-0003',
                'name'          => 'Dewi Lestari',
                'title'         => 'Sp.KK',
                'specialist_id' => $derm,
                'str_number'    => 'STR-0018-STR-4567891230',
                'schedule_days' => ['Sel', 'Sab'],
                'schedule_start'=> '10:00',
                'schedule_end'  => '16:00',
                'rating'        => 4.6,
                'total_reviews' => 103,
                'status'        => 'online',
            ],
            [
                'doctor_code'   => 'DOK-0004',
                'name'          => 'Budi Hartono',
                'title'         => 'Sp.B',
                'specialist_id' => $bedah,
                'str_number'    => 'STR-0009-STR-3206489747',
                'schedule_days' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
                'schedule_start'=> '07:00',
                'schedule_end'  => '13:00',
                'rating'        => 4.9,
                'total_reviews' => 327,
                'status'        => 'online',
            ],
            [
                'doctor_code'   => 'DOK-0005',
                'name'          => 'Farhan Ramadhan',
                'title'         => 'Sp.S',
                'specialist_id' => $neuro,
                'str_number'    => 'STR-0032-STR-7682345678',
                'schedule_days' => ['Sen', 'Sel', 'Kam'],
                'schedule_start'=> '13:00',
                'schedule_end'  => '18:00',
                'rating'        => 4.5,
                'total_reviews' => 277,
                'status'        => 'online',
            ],
            [
                'doctor_code'   => 'DOK-0006',
                'name'          => 'Hendra Saputra',
                'title'         => 'Sp.OT',
                'specialist_id' => $orto,
                'str_number'    => 'STR-0001-STR-6432198765',
                'schedule_days' => ['Sel', 'Kam', 'Sab'],
                'schedule_start'=> '10:00',
                'schedule_end'  => '16:00',
                'rating'        => 4.3,
                'total_reviews' => 74,
                'status'        => 'cuti',
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}