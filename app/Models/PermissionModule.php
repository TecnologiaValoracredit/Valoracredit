<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PermissionPermission;

class PermissionModule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id', 'module_type_id'];

    public function permissions()
	{
		return $this->hasMany('App\Models\PermissionPermission', 'module_id', 'id');
	}

    public function submodules()
    {
        return $this->hasMany('App\Models\PermissionModule', "parent_id", "id");
    }

    public function hasSubmodules()
    {
        return count($this->submodules) > 0;
    }

    public function moduleType()
    {
        return $this->belongsTo("App\Models\ModuleType", "module_type_id");
    }

}
