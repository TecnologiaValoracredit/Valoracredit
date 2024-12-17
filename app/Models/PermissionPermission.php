<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionPermission extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'function_id'];

    public function permissionModule()
    {
        return $this->belongsTo("App\Models\PermissionModule", "module_id");
    }

    public function permissionFunction()
    {
        return $this->belongsTo("App\Models\PermissionFunction", "function_id");
    }
}
