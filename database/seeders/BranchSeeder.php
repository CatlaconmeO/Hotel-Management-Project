<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy team đầu tiên (hoặc tạo mới nếu chưa có)
        $team = Team::first() ?? Team::factory()->create();

        Branch::create([
            'name' => 'Chi nhánh Hà Nội',
            'address' => '123 Đường Hoàn Kiếm, Hà Nội',
            'phone' => '0123456789',
            'email' => 'hanoi@hotel.com',
            'description' => 'Chi nhánh chính đặt tại Hà Nội',
            'team_id' => $team->id,
        ]);

        Branch::create([
            'name' => 'Chi nhánh TP.HCM',
            'address' => '456 Đường Quận 1, TP.HCM',
            'phone' => '0987654321',
            'email' => 'hcm@hotel.com',
            'description' => 'Chi nhánh đặt tại trung tâm TP.HCM',
            'team_id' => $team->id,
        ]);
    }
}
