<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'active_years',
        'days_assigned',
        'days_used',
        'days_remaining',
        'advance_days_available',
        'advance_days_used',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
