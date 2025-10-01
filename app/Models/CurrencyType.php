<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'descriptiom',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function requisitionRows(){
        return $this->hasMany("App\Models\RequisitionRow", "currency_type_id", "id");
    }
}
