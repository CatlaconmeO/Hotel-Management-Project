<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; //

class Customer extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'address',
        'identity_number',
        'customer_type',
        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id', 'id');
    }

}
