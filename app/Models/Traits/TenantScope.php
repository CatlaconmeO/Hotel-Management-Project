<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user(); 

        if ($user && $user->hasRole('super_admin')) {
            return;
        }

        if ($user && $user->team_id) {
            $builder->where('team_id', $user->team_id);
        } else {

        }
    }
}
