<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Specialist;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        // 6 pasien utama sesuai desain
        $pd   = Specialist::where('slug', 'penyakit-dalam')->first()->id;
        $kard = Specialist::where('slug', 'kardiologi')->first()->id;
        $derm = Specialist::where('slug', 'dermatologi')->first()->id;
        $bedah= Specialist::where('slug', 'bedah-umum')->first()->id;

        $mainPatients = [
            ['patient_code'=>'P-001234','name'=>'Budi Santoso',  'email'=>'budi@gmail.com',  'phone'=>'0812-3456-7890','gender'=>'Laki-laki', 'age'=>42,'specialist_id'=>$pd,   'last_visit'=>'2026-04-26','status'=>'aktif'],
            ['patient_code'=>'P-001235','name'=>'Siti Rahayu',   'email'=>'siti@gmail.com',  'phone'=>'0878-9012-3456','gender'=>'Perempuan', 'age'=>35,'specialist_id'=>$kard, 'last_visit'=>'2026-04-26','status'=>'aktif'],
            ['patient_code'=>'P-001236','name'=>'Ahmad Pratama', 'email'=>'ahmad@gmail.com', 'phone'=>'0856-7890-1234','gender'=>'Laki-laki', 'age'=>28,'specialist_id'=>$derm, 'last_visit'=>'2026-04-26','status'=>'aktif'],
            ['patient_code'=>'P-001237','name'=>'Lisa Nuraini',  'email'=>'lisa@gmail.com',  'phone'=>'0821-4567-8901','gender'=>'Perempuan', 'age'=>51,'specialist_id'=>$bedah,'last_visit'=>'2026-03-30','status'=>'rawat_inap'],
            ['patient_code'=>'P-001238','name'=>'Rizky Maulana', 'email'=>'rizky@gmail.com', 'phone'=>'0895-6789-0123','gender'=>'Laki-laki', 'age'=>24,'specialist_id'=>$pd,   'last_visit'=>'2026-04-15','status'=>'aktif'],
            ['patient_code'=>'P-001239','name'=>'Maya Kusuma',   'email'=>'maya@gmail.com',  'phone'=>'0813-2345-6789','gender'=>'Perempuan', 'age'=>38,'specialist_id'=>$bedah,'last_visit'=>'2026-04-26','status'=>'aktif'],
        ];

        foreach ($mainPatients as $patient) {
            Patient::create($patient);
        }

        // Generate 1278 pasien tambahan untuk total 1284
        $specialists = Specialist::pluck('id')->toArray();
        $genders = ['Laki-laki', 'Perempuan'];
        $statuses = ['aktif', 'aktif', 'aktif', 'aktif', 'rawat_inap'];
        $firstNames = ['Andi','Budi','Citra','Dian','Eka','Fajar','Gita','Hadi','Indah','Joko',
                       'Karin','Lina','Mira','Nanda','Oka','Putri','Qori','Rini','Sari','Tono',
                       'Umar','Vina','Wati','Xena','Yanti','Zahra'];
        $lastNames = ['Santoso','Wijaya','Prasetyo','Kusuma','Hartono','Rahayu','Setiawan',
                      'Nugroho','Hidayat','Lestari','Saputra','Wahyu','Purnama','Dewi','Sari'];

        for ($i = 7; $i <= 1284; $i++) {
            $code = 'P-' . str_pad($i + 1000, 6, '0', STR_PAD_LEFT);
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName  = $lastNames[array_rand($lastNames)];
            $gender    = $genders[array_rand($genders)];
            $age       = rand(5, 75);
            $specId    = $specialists[array_rand($specialists)];
            $status    = $statuses[array_rand($statuses)];
            $lastVisit = now()->subDays(rand(1, 120))->format('Y-m-d');

            Patient::create([
                'patient_code' => $code,
                'name'         => $firstName . ' ' . $lastName,
                'email'        => strtolower($firstName) . $i . '@gmail.com',
                'phone'        => '08' . rand(10, 99) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                'gender'       => $gender,
                'age'          => $age,
                'specialist_id'=> $specId,
                'last_visit'   => $lastVisit,
                'status'       => $status,
                'created_at'   => now()->subDays(rand(1, 365)),
            ]);
        }
    }
}