<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación con los bonus 
    public function Bonuses(){
        return $this->hasMany(Bonus::class, 'bonus_type_id', 'id');
    }
}
