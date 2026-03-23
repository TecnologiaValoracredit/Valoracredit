<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDuration extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'name',
        'days',
        'created_at',
        'updated_at',
    ];
}
