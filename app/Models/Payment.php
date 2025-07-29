<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'response_data',
        'team_id'
    ];

    protected $casts = [
        'response_data' => 'array',
        'status' => PaymentStatusEnum::class,
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
