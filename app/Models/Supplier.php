<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function requisition_rows(){
        return $this->hasMany('App/Models/RequisitionRows', "supplier_id", "id");
    }
}
