<?php
namespace App\Enums;

enum RoomStatusEnum: string
{
    case Available = 'available';
    case Booked = 'booked';
    case Cleaning = 'cleaning';
    case Pending = 'pending';
}
