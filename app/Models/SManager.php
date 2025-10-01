<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'commission_percentage',
        's_branch_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'is_active'
    ];


    //Relacion que se tiene con usuario
    public function user(){
        return $this->belongsTo(User::class);
    }

    // //Relación que se tiene con sus nombres
    // public function coordinatorNames(){
    //     return $this->hasMany(SUserName::class, 'user_id', 'user_id');
    // }

    //Relación que se tiene con las sucursales de CrediSoft
    public function sBranch(){
        return $this->belongsTo(SBranch::class);
    }

    //Relación que se tiene con las comisiones 
    public function commisions(){
        return $this->hasMany(Commission::class,'user_id', 'user_id');
    }

    
    //Relación que se tiene con las instituciones
    public function institutionCommissions(){
        return $this->hasMany(InstitutionCommissionManager::class,"manager_id","id");
    }

    // //Relacion con ventas
    // public function s_sales(){
    //     return $this->hasMany(SSale::class,'s_coordinator_id', 'id');
    // }

    //Relación con coordinadores
    public function coordinators(){
        return $this->hasMany(SCoordinator::class,'manager_id','id');
    }
}
