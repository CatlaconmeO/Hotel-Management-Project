<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'branch_id',
        'check_in_date',
        'check_out_date',
        'status',
        'total_price'
    ];
    public function getNightsAttribute()
    {
        return Carbon::parse($this->check_in_date)
            ->diffInDays(Carbon::parse($this->check_out_date));
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function bookingDetail()
    {
        return $this->hasOne(BookingDetail::class, 'booking_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }
}
