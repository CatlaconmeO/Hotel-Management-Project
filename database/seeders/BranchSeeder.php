<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'team_id' => 1,
            'name' => 'Chi nhánh Hà Nội',
            'address' => 'Số 1 Tràng Tiền, Hà Nội',
            'phone' => '0243 888 8888',
            'email' => 'hanoi@moonlit.com',
            'description' => 'Chi nhánh trung tâm thủ đô.',
        ]);

        Branch::create([
            'team_id' => 1,
            'name' => 'Chi nhánh TP.HCM',
            'address' => '456 Lê Lợi, Quận 1, TP.HCM',
            'phone' => '0283 777 7777',
            'email' => 'hcm@moonlit.com',
            'description' => 'Chi nhánh khu trung tâm Sài Gòn.',
        ]);
    }

}
