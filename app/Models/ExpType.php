<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'created_at',
        'is_active'
    ];
}
