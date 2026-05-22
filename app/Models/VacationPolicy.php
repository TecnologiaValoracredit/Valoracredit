<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'years_from',
        'years_to',
        'days',
        'advance_days',
        'applicable_month_range',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
