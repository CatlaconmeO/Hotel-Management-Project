<?php

namespace App\Models;

use App\Models\Team;
use App\Enums\RoomStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{

    protected $fillable = [
        'branch_id',
        'room_type_id',
        'room_number',
        'status',
        'description',
        'image',
        'team_id',
    ];

    protected $casts = [
        'status' => RoomStatusEnum::class,
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }


    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(
            Booking::class,
            BookingDetail::class,
            'room_id',
            'id',
            'id',
            'booking_id'
        );
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function averageRating() {
        $average = $this->reviews()->avg('rating');
        return $average ? round($average, 1) : 0;
    }

    public function isAvailable(string $checkIn, string $checkOut): bool
    {
        if ($this->status === RoomStatusEnum::Booked) {
            return false;
        }

        $in  = Carbon::parse($checkIn);
        $out = Carbon::parse($checkOut);

        $innerStart = $in->copy()->addDay()->toDateString();
        $innerEnd   = $out->copy()->subDay()->toDateString();

        return ! $this->bookings()
            ->where(function($q) use ($in, $out, $innerStart, $innerEnd) {
                $q->whereBetween('check_in_date', [
                    $in->toDateString(),
                    $innerEnd
                ])
                    ->orWhereBetween('check_out_date', [
                        $innerStart,
                        $out->toDateString()
                    ]);
            })
            ->exists();
    }

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
