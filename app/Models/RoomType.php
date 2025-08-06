<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomType extends Model
{

    protected $fillable = [
        'name',
        'description',
        'price',
        'bed_count',
        'image',
        'team_id',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /** @return BelongsTo<\App\Models\Team, self> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function amenities(): belongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'room_type_amenity')
            ->withTimestamps();
    }

}
