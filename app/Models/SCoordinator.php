<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCoordinator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'id','previous_name','is_active',
        'created_by', 'updated_by'
    ];
}
