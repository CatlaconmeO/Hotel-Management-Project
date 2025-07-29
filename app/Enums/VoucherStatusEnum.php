<?php

namespace App\Enums;

enum VoucherStatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Đang hoạt động',
            self::Inactive => 'Không hoạt động',
            self::Expired => 'Hết hạn',
        };
    }
}
