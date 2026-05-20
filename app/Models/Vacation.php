<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'boss_id',
        'total_days',
        'reason',
        'vacation_status_id',
        'days_available_before',
        'days_available_after',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'notes',
    ];

    public function user() {
        return $this->belongsTo("App\Models\User", "id", "user_id");
    }
    public function boss() {
        return $this->belongsTo("App\Models\User", "id", "boss_id");
    }
    public function status() {
        return $this->belongsTo("App\Models\VacationStatus", "id", "vacation_status_id");
    }
    public function createdBy() {
        return $this->belongsTo("App\Models\User", "id", "created_by");
    }
    public function updatedBy() {
        return $this->belongsTo("App\Models\User", "id", "updated_by");
    }
}
