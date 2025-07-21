<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SPromotorName extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'promotor_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'is_active'
    ];
}
