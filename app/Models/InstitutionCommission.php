<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'percentage',
        'institution_id',
        'user_id',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación que se tiene con los usuarios (coordinador y promnotor)
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relación que se tiene con la instituciones 
    public function institution(){
        return $this->belongsTo(Institution::class);
    }
}
