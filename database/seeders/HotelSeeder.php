<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name' => 'Moonlit Hotel Group',
            'email' => 'info@moonlit.com',
            'phone' => '+123456789',
            'address' => '123 Main Street, Cityville',
            'description' => 'Chuỗi khách sạn cao cấp toàn quốc.',
            'logo' => 'images/logo.png',
        ]);
    }
}
