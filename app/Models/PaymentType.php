<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'id', 'description','name','is_active',
        'created_by', 'updated_by','notes'
    ];

    public function requisitions(){
        return $this->hasMany('App/Models/Requisition', "requisition_id", "id");
    }
}
