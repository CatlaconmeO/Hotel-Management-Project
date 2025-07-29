<?php

namespace App\Enums;

enum CustomerTypeEnum: string
{
    case Casual = 'casual';
    case VIP = 'vip';

    public function label(): string
    {
        return match ($this) {
            self::Casual => 'Khách thường',
            self::VIP => 'Khách VIP',
        };
    }
}
