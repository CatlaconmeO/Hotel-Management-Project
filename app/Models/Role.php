<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name'];

    // Quan hệ tới permissions
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
    }
}
