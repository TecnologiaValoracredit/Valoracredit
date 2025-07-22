<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPromotor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'commission_percentage',
        'coordinator_id',
        's_branch_id',
        'promotor_credisoft_id',
        'is_active',
        'created_by', 
        'updated_by',
    ];

     //Relacion que se tiene con usuario
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relación que se tiene con sus nombres
    public function promotorNames(){
        return $this->hasMany(SPromotorName::class, 'promotor_id', 'id');
    }

    //Relación que se tiene con las sucursales de CrediSoft
    public function sBranch(){
        return $this->belongsTo(SBranch::class);
    }

    //Relación que se tiene con las comisiones 
    public function commisions(){
        return $this->hasMany(Commission::class,'user_id', 'user_id');
    }

    
    //Relación que se tiene con las instituciones
    public function institution_commisions(){
        return $this->hasMany(InstitutionCommission::class,'user_id', 'user_id');
    }

    //Relacion con ventas
    public function s_sales(){
        return $this->hasMany(SSale::class,'s_promotor_id', 'id');
    }
}
