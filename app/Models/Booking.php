<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Team;
use App\Models\Branch;
use App\Models\Customer;
use App\Enums\BookingStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'branch_id',
        'check_in_date',
        'check_out_date',
        'status',
        'team_id',
    ];

    protected $casts = [
        'status' => BookingStatusEnum::class,
    ];

    // Booking belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Booking belongs to a room
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Booking belongs to a branch
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // Booking belongs to a customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Booking belongs to a hotel/team
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function getNightsAttribute()
    {
        return Carbon::parse($this->check_in_date)
            ->diffInDays(Carbon::parse($this->check_out_date));
    }

    public function bookingDetail()
    {
        return $this->hasOne(BookingDetail::class, 'booking_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }
}
