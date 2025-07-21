<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'total_sales',
        'total_amount_sold',
        'beneficiary_type',
        'amount_received',
        'user_id',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relación que se tiene con los usuarios (coordinador y promnotor)
    public function user(){
        return $this->belongsTo(User::class);
    }
}
