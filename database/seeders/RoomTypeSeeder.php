<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomType;
class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        RoomType::insert([
            [
                'name' => 'Executive Room',
                'description' => 'Phòng cao cấp với tiện nghi hiện đại.',
                'price' => 122,
                'bed_count' => 1,
            ],
            [
                'name' => 'Single Room',
                'description' => 'Phòng đơn tiết kiệm cho 1 người.',
                'price' => 85,
                'bed_count' => 1,
            ],
            [
                'name' => 'Double Room',
                'description' => 'Phòng đôi phù hợp cặp đôi hoặc bạn bè.',
                'price' => 130,
                'bed_count' => 2,
            ],
            [
                'name' => 'Triple Room',
                'description' => 'Phòng cho gia đình nhỏ hoặc nhóm bạn.',
                'price' => 140,
                'bed_count' => 3,
            ],
        ]);
    }
}
