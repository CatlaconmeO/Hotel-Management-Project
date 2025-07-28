<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Team;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'address',
        'phone',
        'email',
        'description',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
