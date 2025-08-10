<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'room_id',
        'rating',
        'comment',
        'team_id'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

}
