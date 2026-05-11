<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    public function run(): void
    {
        $specialists = [
            ['name' => 'Penyakit Dalam',  'slug' => 'penyakit-dalam',  'color' => '#3b82f6'],
            ['name' => 'Kardiologi',       'slug' => 'kardiologi',       'color' => '#ef4444'],
            ['name' => 'Dermatologi',      'slug' => 'dermatologi',      'color' => '#8b5cf6'],
            ['name' => 'Bedah Umum',       'slug' => 'bedah-umum',       'color' => '#f59e0b'],
            ['name' => 'Neurologi',        'slug' => 'neurologi',        'color' => '#10b981'],
            ['name' => 'Ortopedi',         'slug' => 'ortopedi',         'color' => '#06b6d4'],
        ];

        foreach ($specialists as $spec) {
            Specialist::create($spec);
        }
    }
}