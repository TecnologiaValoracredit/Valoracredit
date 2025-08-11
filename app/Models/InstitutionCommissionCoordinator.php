<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionCommissionCoordinator extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'percentage',
        'institution_id',
        'coordinator_id',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación que se tiene con los usuarios (coordinador y promnotor)
    public function coordinator(){
        return $this->belongsTo(SCoordinator::class);
    }

    //Relación que se tiene con la instituciones 
    public function institution(){
        return $this->belongsTo(Institution::class);
    }
}
