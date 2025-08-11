<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id',
        'created_by',
        'created_at',
        'is_active'
    ];

    //Relacion que se tiene con las comisiones por institución 
    public function institutionCommissionPromotors(){
        return $this->hasMany(InstitutionCommissionPromotor::class, 'institution_id','id');
    }

    
    public function institutionCommissionCoordinators(){
        return $this->hasMany(InstitutionCommissionCoordinator::class, 'institution_id','id');
    }
}
