<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Team;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $team = Team::first();

        if (!$team) {
            $this->command->error('No teams found. Please create a team first.');
            return;
        }

        $amenities = [
            ['name' => 'Wi-Fi', 'icon' => 'wifi.png', 'description' => 'Free wireless internet'],
            ['name' => 'Air Conditioning', 'icon' => 'ac.png', 'description' => 'Climate control'],
            ['name' => 'TV', 'icon' => 'tv.png', 'description' => 'Flat screen television'],
            ['name' => 'Mini Bar', 'icon' => 'minibar.png', 'description' => 'Refrigerated mini bar'],
            ['name' => 'Safe', 'icon' => 'safe.png', 'description' => 'In-room safety deposit box'],
            ['name' => 'Balcony', 'icon' => 'balcony.png', 'description' => 'Private balcony'],
            ['name' => 'Jacuzzi', 'icon' => 'jacuzzi.png', 'description' => 'Private jacuzzi'],
            ['name' => 'Room Service', 'icon' => 'room-service.png', 'description' => '24/7 room service'],
            ['name' => 'Breakfast', 'icon' => 'breakfast.png', 'description' => 'Complimentary breakfast'],
            ['name' => 'Parking', 'icon' => 'parking.png', 'description' => 'Free parking'],
            ['name' => 'Gym Access', 'icon' => 'gym.png', 'description' => 'Fitness center access'],
            ['name' => 'Pool Access', 'icon' => 'pool.png', 'description' => 'Swimming pool access'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(
                ['name' => $amenity['name'], 'team_id' => $team->id],
                [
                    'icon' => $amenity['icon'],
                    'description' => $amenity['description'],
                ]
            );
        }

        $this->command->info('Amenities seeded successfully!');
    }
}
