<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contract_id',
        'initial_date',
        'final_date',
        'path_contract',
        'path_contract_signed'
    ];

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
