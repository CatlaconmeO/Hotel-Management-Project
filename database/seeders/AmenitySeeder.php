<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::first() ?? Team::factory()->create();

        $amenities = [
            ['name' => 'Wi-Fi miễn phí', 'icon' => 'heroicon-o-wifi', 'description' => 'Kết nối internet tốc độ cao miễn phí.'],
            ['name' => 'Máy lạnh', 'icon' => 'heroicon-o-sparkles', 'description' => 'Phòng được trang bị máy điều hòa nhiệt độ.'],
            ['name' => 'Bể bơi', 'icon' => 'heroicon-o-droplet', 'description' => 'Hồ bơi ngoài trời sạch sẽ và hiện đại.'],
            ['name' => 'Phòng Gym', 'icon' => 'heroicon-o-bolt', 'description' => 'Phòng tập thể dục với đầy đủ thiết bị.'],
            ['name' => 'Đỗ xe miễn phí', 'icon' => 'heroicon-o-truck', 'description' => 'Chỗ đỗ xe rộng rãi, miễn phí cho khách.'],
            ['name' => 'Dịch vụ giặt là', 'icon' => 'heroicon-o-swatch', 'description' => 'Giặt ủi nhanh chóng và tiện lợi.'],
            ['name' => 'Lễ tân 24/7', 'icon' => 'heroicon-o-clock', 'description' => 'Lễ tân luôn sẵn sàng phục vụ mọi lúc.'],
            ['name' => 'Nhà hàng', 'icon' => 'heroicon-o-fire', 'description' => 'Nhà hàng với thực đơn phong phú và ngon miệng.'],
            ['name' => 'Quầy bar', 'icon' => 'heroicon-o-cocktail', 'description' => 'Quầy bar phục vụ đồ uống đa dạng.'],
            ['name' => 'Dịch vụ spa', 'icon' => 'heroicon-o-heart', 'description' => 'Spa thư giãn với liệu pháp chuyên nghiệp.'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create(array_merge($amenity, ['team_id' => $team->id]));
        }
    }
}
