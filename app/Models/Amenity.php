<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'team_id',
    ];

    /** @return BelongsTo<\App\Models\Team, self> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function roomTypes(): BelongsToMany
    {
        return $this->belongsToMany(RoomType::class, 'room_type_amenity')
            ->withTimestamps();
    }
}
