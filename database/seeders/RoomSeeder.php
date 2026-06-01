<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['room_number' => 'R.102', 'name' => 'Poli Penyakit Dalam', 'type' => 'Poli'],
            ['room_number' => 'R.205', 'name' => 'Poli Kardiologi',      'type' => 'Poli'],
            ['room_number' => 'R.308', 'name' => 'Poli Dermatologi',     'type' => 'Poli'],
            ['room_number' => 'R.401', 'name' => 'Poli Bedah Umum',      'type' => 'Poli'],
            ['room_number' => 'R.312', 'name' => 'Poli Neurologi',       'type' => 'Poli'],
            ['room_number' => 'R.215', 'name' => 'Poli Ortopedi',        'type' => 'Poli'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}