<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\Booking;

class VoucherService
{
    public function validateVoucher(string $code, Booking $booking)
    {
        if ($booking->voucher_id) {
            return ['valid' => false, 'message' => 'This booking already has a voucher applied'];
        }

        $voucher = Voucher::where('code', $code)
            ->where('team_id', $booking->team_id)
            ->first();

        if (!$voucher) {
            return ['valid' => false, 'message' => 'Voucher is expired or unavailable'];
        }

        $totalAmount = $booking->bookingDetail->price;

        if ($voucher->min_order_value && $totalAmount < $voucher->min_order_value) {
            return ['valid' => false, 'message' => "Minimum price is " . number_format($voucher->min_order_value) . " VND"];
        }

        return ['valid' => true, 'voucher' => $voucher];
    }

    public function calculateDiscount(Voucher $voucher, int $totalAmount)
    {
        if ($voucher->type->value === 'fixed') {
            return min($voucher->amount, $totalAmount);
        }

        return round($totalAmount * ($voucher->amount / 100), 0);
    }

    public function applyVoucher(Booking $booking, Voucher $voucher): void
    {
        $discountAmount = $this->calculateDiscount($voucher, $booking->bookingDetail->price);

        $booking->update([
            'voucher_id' => $voucher->id,
        ]);

        $voucher->increment('used_count');
    }
}
