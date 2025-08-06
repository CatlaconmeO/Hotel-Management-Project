<?php

namespace Database\Seeders;

use App\Models\RoomType;
use App\Models\Amenity;
use App\Models\Team;
use Illuminate\Database\Seeder;

class RoomTypeAmenitySeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::first();

        if (!$team) {
            $this->command->error('No teams found. Please create a team first.');
            return;
        }

        $amenities = Amenity::where('team_id', $team->id)->get();

        if ($amenities->isEmpty()) {
            $this->command->error('No amenities found. Please run AmenitySeeder first.');
            return;
        }

        $roomTypes = [
            [
                'name' => 'Standard Room',
                'description' => 'Comfortable standard room with essential amenities',
                'price' => 500000,
                'bed_count' => 1,
                'image' => 'standard-room.jpg',
                'amenities' => ['Wi-Fi', 'Air Conditioning', 'TV']
            ],
            [
                'name' => 'Deluxe Room',
                'description' => 'Spacious deluxe room with premium amenities',
                'price' => 800000,
                'bed_count' => 1,
                'image' => 'deluxe-room.jpg',
                'amenities' => ['Wi-Fi', 'Air Conditioning', 'TV', 'Mini Bar', 'Safe', 'Room Service']
            ],
            [
                'name' => 'Suite',
                'description' => 'Luxurious suite with all premium amenities',
                'price' => 1500000,
                'bed_count' => 2,
                'image' => 'suite.jpg',
                'amenities' => ['Wi-Fi', 'Air Conditioning', 'TV', 'Mini Bar', 'Safe', 'Balcony', 'Room Service', 'Breakfast']
            ],
            [
                'name' => 'Presidential Suite',
                'description' => 'Ultimate luxury with exclusive amenities',
                'price' => 3000000,
                'bed_count' => 3,
                'image' => 'presidential-suite.jpg',
                'amenities' => ['Wi-Fi', 'Air Conditioning', 'TV', 'Mini Bar', 'Safe', 'Balcony', 'Jacuzzi', 'Room Service', 'Breakfast', 'Parking', 'Gym Access', 'Pool Access']
            ]
        ];

        foreach ($roomTypes as $roomTypeData) {
            // Tạo hoặc tìm RoomType
            $roomType = RoomType::firstOrCreate(
                ['name' => $roomTypeData['name'], 'team_id' => $team->id],
                [
                    'description' => $roomTypeData['description'],
                    'price' => $roomTypeData['price'],
                    'bed_count' => $roomTypeData['bed_count'],
                    'image' => $roomTypeData['image'],
                ]
            );

            // Attach amenities nếu RoomType vừa được tạo
            if ($roomType->wasRecentlyCreated || $roomType->amenities()->count() === 0) {
                $amenityIds = $amenities->whereIn('name', $roomTypeData['amenities'])->pluck('id');
                if ($amenityIds->isNotEmpty()) {
                    $roomType->amenities()->sync($amenityIds);
                }
            }
        }

        $this->command->info('RoomTypes with amenities seeded successfully!');
    }
}
