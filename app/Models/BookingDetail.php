<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'room_id',
        'price',
        'name',
        'email',
        'phone',
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
