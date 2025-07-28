<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomNumber = 101;

        foreach (range(1, 2) as $branchId) {
            foreach (range(1, 4) as $roomTypeId) {
                for ($i = 0; $i < 3; $i++) {
                    Room::create([
                        'branch_id' => $branchId,
                        'room_type_id' => $roomTypeId,
                        'room_number' => 'P' . $roomNumber++,
                        'note' => 'Phòng sạch sẽ, đầy đủ tiện nghi.',
                    ]);
                }
            }
        }
    }
}
