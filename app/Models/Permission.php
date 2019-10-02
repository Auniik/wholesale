<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name', 'permission_name', 'group_name'
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
