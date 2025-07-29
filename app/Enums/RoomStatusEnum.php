<?php

namespace App\Enums;

enum RoomStatusEnum: string
{
    case Available = 'available';
    case Booked = 'booked';
    case Occupied = 'occupied';
    case Cleaning = 'cleaning';
    case Maintenance = 'maintenance';

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Sẵn sàng',
            self::Booked => 'Đã đặt',
            self::Occupied => 'Đang sử dụng',
            self::Cleaning => 'Đang dọn',
            self::Maintenance => 'Bảo trì',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->label()];
        })->toArray();
    }
}
