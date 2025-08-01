<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Team;
use App\Models\Branch;
use App\Models\Amenity;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::first() ?? Team::factory()->create();

        $branches = Branch::all();
        $roomTypes = RoomType::all();
        $amenities = Amenity::all();

        if ($branches->isEmpty() || $roomTypes->isEmpty()) {
            $this->command->warn('Hãy seed Branch và RoomType trước khi seed Room.');
            return;
        }

        // Tạo 20 phòng ngẫu nhiên
        for ($i = 1; $i <= 20; $i++) {
            Room::create([
                'branch_id' => $branches->random()->id,
                'room_type_id' => $roomTypes->random()->id,
                'room_number' => 'R' . str_pad($i, 3, '0', STR_PAD_LEFT), // VD: R001, R002
                'status' => collect(['available', 'booked', 'occupied', 'cleaning'])->random(),
                'team_id' => $team->id,
                'description' => fake()->sentence(6),
            ]);
        }
    }
}
