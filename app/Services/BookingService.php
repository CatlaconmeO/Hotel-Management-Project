<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Room;

class BookingService
{
    /**
     * @param  Room    $room
     * @param  string  $checkIn  Y-m-d
     * @param  string  $checkOut Y-m-d
     */
    public function calculateTotal(Room $room, string $checkIn, string $checkOut): float
    {
        $nights = Carbon::parse($checkOut)->diffInDays(Carbon::parse($checkIn));
        return $nights * $room->roomType->price;
    }
}
