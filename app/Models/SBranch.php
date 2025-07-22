<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SBranch extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name', 
        'segment', 
        'accounting_account', 
        'is_active',
        'created_by', 'updated_by'
    ];

    //Relación con los coordinadores
    public function coordinators(){
        return $this->hasMany(SCoordinator::class, 's_branch_id', 'id');
    }

    //Relación con los promotores
    public function promotors(){
        return $this->hasMany(SPromotor::class, 's_branch_id', 'id');
    }
}
