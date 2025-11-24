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
        'bank_id',
        'bank_account',
        'is_active',
        'role_id',
        'departament_id', // Se debe eliminar el department y conectarlo al position
        'branch_id',
        'boss_id',
        'phone',
        'emergency_phone',
        'birthday',
        'entry_date',
        // 'extension',
        'position_id',
        'salary',
        'path_ine',
        'path_curp', 
        'path_address',
        'path_birth_document',
        'path_account_status',
        'path_rfc',
        'path_nss',
        'curp',
        'rfc',
        'nss',
        'employee_number',
        'birthplace',
        'gender_id',
        'civil_status_id',
        'residential_address',
        'colony',
        'municipality',
        'postal_code',
        'other_benefits',
        'interbank_code',
        'plastic_number',
        'infonavit_credit_number',
        'discount_factor',
        'fonacot_credit_number',
        'food_pension',
        'termination_date',
        'termination_reason_id',
        'termination_description',
        'is_replacing_on_hired',
        'replacement_for_id',
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

    public function boss(){
        return $this->belongsTo("App\Models\User", "boss_id", "id");
    }

    public function employees(){
        return $this->hasMany("App\Models\User", "boss_id", "id");
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

    //Relacion que tiene con el gerente
    public function manager(){
        return $this->hasOne(SManager::class,"user_id", "id");
    }

    //Relacion que tiene con colaborador
    public function collaborator(){
        return $this->hasOne(SCollaborator::class, "user_id", "id");
    }

    //RPuesto de trabajo 
    public function jobPosition(){
        return $this->hasOne(JobPosition::class, "position_id", "id");
    }

    public function getUserTypeAttribute()
    {

        if($this->manager){
            return 'Gerente';
        }
        elseif($this->coordinator != null || $this->promotor != null && $this->coordinator != null){
            if($this->coordinator->is_broker){
                return 'Broker';
            }
            return 'Coordinador';
        }else{
            return 'Promotor';
        }

        return 'NA';
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
