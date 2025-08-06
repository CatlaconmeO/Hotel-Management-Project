<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\AmenitySeeder;
use Database\Seeders\VoucherSeeder;
use Database\Seeders\RoomTypeSeeder;
use Database\Seeders\RoomTypeAmenitySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BranchSeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(RoomTypeSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(VoucherSeeder::class);
        $this->call(RoomTypeAmenitySeeder::class);
    }
}
