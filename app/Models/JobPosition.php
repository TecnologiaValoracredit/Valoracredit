<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','name', 'description', 'departament_id','is_active',
        'created_by', 'updated_by'
    ];
}
