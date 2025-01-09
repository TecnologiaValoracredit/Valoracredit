<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'balance',
        'is_active',
        'created_by',
        'updated_by'
    ];

}
