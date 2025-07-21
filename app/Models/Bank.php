<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'is_active',
        'created_by', 
        'updated_by',
    ];

    //Relacion con los detalles del banco
    public function bankDetails(){
        return $this->hasMany(BankDetail::class, 'bank_id', 'id');
    }
}
