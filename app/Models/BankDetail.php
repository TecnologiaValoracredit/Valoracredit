<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'bank_id',
        'account_number',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación que se tiene con usuario
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relación que se tiene con banco
    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
