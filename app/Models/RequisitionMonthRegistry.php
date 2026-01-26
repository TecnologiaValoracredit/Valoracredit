<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionMonthRegistry extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_index',
        'created_at',
        'updated_at',
    ];
}
