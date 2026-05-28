<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacation_id',
        'user_id',
        'decision',
        'notes',
        'created_at',
        'updated_at',
    ];

    public function vacation() {
        return $this->belongsTo("App\Models\Vacation", "id", "vacation_id");
    }
    public function user() {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
