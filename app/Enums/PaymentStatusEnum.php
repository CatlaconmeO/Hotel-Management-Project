<?php

namespace App\Enums;

    enum PaymentStatusEnum: string
    {
        case Pending = 'pending';
        case Completed = 'completed';
        case Failed = 'failed';

        public function label(): string
        {
            return match ($this) {
                self::Pending => 'Chờ xử lý',
                self::Completed => 'Đã hoàn thành',
                self::Failed => 'Thất bại',
            };
        }
    }

    
