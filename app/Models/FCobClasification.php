<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCobClasification extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','name','description', 
        'previous_name',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
