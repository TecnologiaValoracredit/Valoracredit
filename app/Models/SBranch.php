<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SBranch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'id','is_active',
        'created_by', 'updated_by'
    ];
}
