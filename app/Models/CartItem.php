<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'cart_id',
        'price',
        'total_price',
        'check_in_date',
        'check_out_date',
        'nights',
        'team_id'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
