<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use App\Models\Branch;
use App\Models\Amenity;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'description',
        'image',
        'user_id',
        'status',
    ];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /** @return HasMany<\App\Models\Role, self> */
    public function roles(): HasMany
    {
        return $this->hasMany(\App\Models\Role::class);
    }


    /** @return HasMany<\App\Models\Amenity, self> */
    public function amenities(): HasMany
    {
        return $this->hasMany(\App\Models\Amenity::class);
    }


    /** @return HasMany<\App\Models\Branch, self> */
    public function branches(): HasMany
    {
        return $this->hasMany(\App\Models\Branch::class);
    }


    /** @return HasMany<\App\Models\Room, self> */
    public function rooms(): HasMany
    {
        return $this->hasMany(\App\Models\Room::class);
    }


    /** @return HasMany<\App\Models\RoomType, self> */
    public function roomTypes(): HasMany
    {
        return $this->hasMany(\App\Models\RoomType::class);
    }


    /** @return HasMany<\App\Models\Booking, self> */
    public function bookings(): HasMany
    {
        return $this->hasMany(\App\Models\Booking::class);
    }


    /** @return HasMany<\App\Models\Customer, self> */
    public function customers(): HasMany
    {
        return $this->hasMany(\App\Models\Customer::class);
    }


    /** @return HasMany<\App\Models\Voucher, self> */
    public function vouchers(): HasMany
    {
        return $this->hasMany(\App\Models\Voucher::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

}
