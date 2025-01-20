<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FClasification extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','name','description', 'parent_id',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
