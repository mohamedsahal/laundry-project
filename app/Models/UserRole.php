<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    //permssions relation
    public function permissions()
    {
        return $this->hasMany(\App\Models\UserRolePermission::class, 'role_id', 'id');
    }

    //users relation
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'role_id', 'id');
    }
}