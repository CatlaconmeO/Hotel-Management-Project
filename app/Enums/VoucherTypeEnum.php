<?php

namespace App\Enums;

enum VoucherTypeEnum: string
{
    case Fixed = 'fixed';
    case Percentage = 'percent';

    public function label(): string
    {
        return match ($this) {
            self::Fixed => 'Số tiền cố định',
            self::Percentage => 'Phần trăm',
        };
    }
}
