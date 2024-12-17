<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'role_id',
        'departament_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo("App\Models\Role", "role_id", "id");
    }

    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }

    public function permissions()
	{
		return $this->role->permissionsRole();
	}

    public function permissionsArray()
	{
		$permissions = [];
		foreach ($this->permissions as $key => $permission) {
			$permissions[$permission->id] = $permission;
		}
		return $permissions;
	}

    //El nombre de las rutas es modulo.function
    public function hasPermissions($route_name)
	{
		$result = false;
		$permissions = $this->permissionsArray();
		foreach ($permissions as $key => $permission) {
			if($permission->permissionModule->name.".".$permission->permissionFunction->name == $route_name) {
				$result = true;
				break;
			}
		}
		return $result;
	}
}
