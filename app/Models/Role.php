<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PermissionModule;
use App\Models\PermissionPermission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function permissionsRole()
    {
        return $this->belongsToMany('App\Models\PermissionPermission', 'permission_permission_roles', 'role_id', 'permission_id');
    }

    public function hasPermission($permissionId)
    {
        $permissionsRole = $this->permissionsRole;
        foreach ($permissionsRole as $key => $permissionRole) {
            if ($permissionRole->id == $permissionId) {
                return true;
            }
        }
        return false;
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'role_id', 'id');
    }

}
