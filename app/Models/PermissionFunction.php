<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionFunction extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function permissions()
	{
		return $this->hasMany('App\Models\Permission', 'function_id', 'id');
	}
}
