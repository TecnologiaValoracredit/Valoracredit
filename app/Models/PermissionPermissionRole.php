<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionPermissionRole extends Model
{
    use HasFactory;

    protected $fillable = ['permission_id', 'role_id'];

    public function role() 
    {
        return $this->belongsTo('App\Models\Role', 'role_id', 'id');
    }

    public function permission() 
    {
        return $this->belongsTo('App\Models\PermissionPermission', 'permission_id', 'id');
    }
}
