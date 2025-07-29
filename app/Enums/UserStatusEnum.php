<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    case Active = 'active';
    case Pending = 'pending';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Hoạt động',
            self::Pending => 'Chờ duyệt',
            self::Inactive => 'Vô hiệu hóa',
        };
    }
}
