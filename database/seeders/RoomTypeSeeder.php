<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::first() ?? Team::factory()->create();

        $roomTypes = [
            [
                'name' => 'Phòng đơn tiêu chuẩn',
                'description' => 'Phòng nhỏ gọn, 1 giường đơn, phù hợp cho khách đi công tác.',
                'price' => 500000,
                'bed_count' => 1,
                'amenity_id' => 1,
            ],
            [
                'name' => 'Phòng đôi tiêu chuẩn',
                'description' => 'Phòng có 2 giường đơn hoặc 1 giường đôi, tiện nghi cơ bản.',
                'price' => 800000,
                'bed_count' => 2,
                'amenity_id' => 1,
            ],
            [
                'name' => 'Phòng Superior',
                'description' => 'Phòng rộng rãi với view đẹp và đầy đủ tiện ích cao cấp.',
                'price' => 1200000,
                'bed_count' => 2,
                'amenity_id' => 1,
            ],
            [
                'name' => 'Phòng Deluxe',
                'description' => 'Phòng sang trọng, giường king size và dịch vụ cao cấp.',
                'price' => 1800000,
                'bed_count' => 1,
                'amenity_id' => 1,
            ],
            [
                'name' => 'Phòng Gia đình',
                'description' => 'Phòng lớn với 2 giường đôi, phù hợp cho gia đình hoặc nhóm bạn.',
                'price' => 2000000,
                'bed_count' => 2,
                'amenity_id' => 1,
            ],
            [
                'name' => 'Suite Junior',
                'description' => 'Phòng suite với phòng khách riêng và tiện nghi hiện đại.',
                'price' => 2500000,
                'bed_count' => 1,
                'amenity_id' => 1,
            ],
            [
                'name' => 'Suite Executive',
                'description' => 'Phòng suite cao cấp, view toàn cảnh, dịch vụ VIP.',
                'price' => 3500000,
                'bed_count' => 1,
                'amenity_id' => 1,
            ],
        ];

        foreach ($roomTypes as $type) {
            RoomType::create(array_merge($type, [
                'team_id' => $team->id,
            ]));
        }
    }
}
