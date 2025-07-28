<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; //
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'address',
        'identity_number',
        'customer_type',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id', 'id');
    }

}
