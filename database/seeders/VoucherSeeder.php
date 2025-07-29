<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::first() ?? Team::factory()->create();

        $vouchers = [
            [
                'code' => 'WELCOME100',
                'type' => 'fixed',
                'amount' => 100000, // giảm 100k
                'min_order_value' => 500000,
                'max_uses' => 50,
                'used_count' => 0,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(30),
                'status' => 'active',
            ],
            [
                'code' => 'SUMMER20',
                'type' => 'percent',
                'amount' => 20, // giảm 20%
                'min_order_value' => 300000,
                'max_uses' => 100,
                'used_count' => 0,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(45),
                'status' => 'active',
            ],
            [
                'code' => 'VIP500',
                'type' => 'fixed',
                'amount' => 500000, // giảm 500k
                'min_order_value' => 2000000,
                'max_uses' => 10,
                'used_count' => 0,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(60),
                'status' => 'active',
            ],
            [
                'code' => 'FLASH10',
                'type' => 'percent',
                'amount' => 10, // giảm 10%
                'min_order_value' => 0,
                'max_uses' => 200,
                'used_count' => 0,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(7),
                'status' => 'active',
            ],
            [
                'code' => 'WINTER300',
                'type' => 'fixed',
                'amount' => 300000, // giảm 300k
                'min_order_value' => 1000000,
                'max_uses' => 30,
                'used_count' => 0,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(90),
                'status' => 'active',
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::create(array_merge($voucher, [
                'team_id' => $team->id,
            ]));
        }
    }
}
