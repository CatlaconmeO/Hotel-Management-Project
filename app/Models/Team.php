<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'description',
        'logo',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
