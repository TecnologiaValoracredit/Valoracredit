<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'user_bonus_id',
        'amount_sold',
        'amount_paid',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación con el User Bonus
    public function UserBonus(){
        return $this->belongsTo(UserBonus::class);
    }
}
