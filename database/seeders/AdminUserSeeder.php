<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Rumah Sakit',
            'email'    => 'admin@medicore.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'username' => 'admin_medicore',
            'phone'    => '080-0000-0001',
            'position' => 'Super Administrator',
            'is_active'=> true,
        ]);
    }
}