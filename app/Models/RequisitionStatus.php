<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionStatus extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'name',
        'description',
        //code, en_tesoreria revision_dg es para buscar estatus por codigo y no por nombre mostrable
        //color,
        'is_active',
        'created_by', 
        'updated_by',
        'notes'
    ];

}
