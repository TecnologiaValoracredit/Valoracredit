<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\ChkList;
use App\Models\Branch;
use App\Models\Departament;
use App\Models\EmailAccount;

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
        'departament_id',
        'branch_id'
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

    public function emailAccounts()
{
    return $this->belongsToMany(EmailAccount::class, 'email_account_user');
}

    public function role()
    {
        return $this->belongsTo("App\Models\Role", "role_id", "id");
    }

    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }
    public function supplier()
    {
        return $this->belongsTo("App\Models\supplier", "supplier_id", "id");
    }
    public function branch()
    {
        return $this->belongsTo("App\Models\Branch", "branch_id", "id");
    }
    public function chk_list()
    {
        return $this->belongsTo("App\Models\ChkList", "chk_list_id", "id");
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

    //Relacion que tiene con los detalles del banco
    public function bankDetails(){
        return $this->hasMany(BankDetail::class,"user_id","id");
    }

    //Relación que se tiene con los bonos 
    public function userBonuses(){
        return $this->hasMany(UserBonus::class,"user_id","id");
    }

    //Relación que se tiene con las instituciones para comisiones extra
    public function institutions(){
        return $this->hasMany(InstitutionCommission::class,"user_id","id");
    }

    //Relación que se tiene con las instituciones para comisiones extra
    public function sUserNames(){
        return $this->hasMany(SUserName::class,"user_id","id");
    }

    //Relación que se tiene con el promotor
    public function promotor(){
        return $this->hasOne(SPromotor::class,"user_id", "id");
    }

    //Relación que se tiene con el coordinador
    public function coordinator(){
        return $this->hasOne(SCoordinator::class,"user_id", "id");
    }

    public function activate()
    {
        $this->update(["is_active" => true]);
        if ($this->promotor != null) {
            $this->promotor->update(["is_active" => true]);
        }
        if ($this->coordinator != null) {
            $this->coordinator->update(["is_active" => true]);
        }
    }

    public function deactivate()
    {
        $this->update(["is_active" => false]);
        if ($this->promotor != null) {
            $this->promotor->update(["is_active" => false]);
        }
        if ($this->coordinator != null) {
            $this->coordinator->update(["is_active" => false]);
        }
    }


}
