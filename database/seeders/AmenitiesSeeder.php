<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AmenitiesSeeder extends Seeder
{
    public function run()
    {
        $amenities = [
            [
                'name'        => 'Free Wifi',
                'icon'        => 'flaticon-wifi',
                'description' => 'Miễn phí wifi tốc độ cao khắp khách sạn.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Shower',
                'icon'        => 'flaticon-shower',
                'description' => 'Phòng tắm vòi sen hiện đại.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Airport transport',
                'icon'        => 'flaticon-airport',
                'description' => 'Dịch vụ đưa đón sân bay 24/7.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Balcony',
                'icon'        => 'flaticon-balcony',
                'description' => 'Ban công riêng nhìn ra thành phố hoặc vườn.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Refrigerator',
                'icon'        => 'flaticon-fridge',
                'description' => 'Tủ lạnh mini trong phòng.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => '24/7 Support',
                'icon'        => 'flaticon-support',
                'description' => 'Hỗ trợ khách hàng 24/7.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Work Desk',
                'icon'        => 'flaticon-desk',
                'description' => 'Bàn làm việc tiện nghi.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Fitness Center',
                'icon'        => 'flaticon-fitness',
                'description' => 'Phòng tập gym đầy đủ thiết bị.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Swimming Pool',
                'icon'        => 'flaticon-pool',
                'description' => 'Hồ bơi ngoài trời.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        foreach ($amenities as $amenity) {
            // updateOrInsert để tránh duplicate khi chạy lại seeder
            DB::table('amenities')->updateOrInsert(
                ['name' => $amenity['name']],
                $amenity
            );
        }
    }
}
