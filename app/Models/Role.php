<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Role extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isAdmin(): bool
    {
        $adminRole = $this->where(
            'name',
            '=',
            Config::get('constants.db.roles.admin')
        )->first();

        return auth()->user()->role_id === $adminRole->id;
    }
}
