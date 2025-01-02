<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChkList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','description','is_active', 
        'created_by','updated_by'
    ];
    
    
}
