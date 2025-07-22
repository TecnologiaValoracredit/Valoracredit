<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'objective',
        'bonus_quantity_type_id',
        'bonus_type_id',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación con los tipos de bonos
    public function bonusType(){
        return $this->belongsTo(BonusType::class);
    }

    //Relación con los user_bonus
    public function userBonuses(){
        return $this->hasMany(UserBonus::class, 'bonus_id', 'id');
    }
}
