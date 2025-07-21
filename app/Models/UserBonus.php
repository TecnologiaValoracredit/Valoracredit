<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'bonus_percentage',
        'bonus_amount',
        'bonus_id',
        'user_id',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación con los bonos
    public function bonus(){
        return $this->belongsTo(Bonus::class);
    }

    //Relación con el usuario
    public function user(){
        return $this->belongsTo(User::class);
    }


    //Relación con el historial de bonos
    public function bonusLogs(){
        return $this->hasMany(BonusLog::class, 'user_bonus_id', 'id');
    }
}
