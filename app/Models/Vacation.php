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
        'balance_used',
        'created_by',
        'updated_by',
        'is_active',
        'created_at',
        'updated_at',
        'notes',
    ];

    public function user() {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
    public function boss() {
        return $this->belongsTo("App\Models\User", "boss_id", "id");
    }
    public function status() {
        return $this->belongsTo("App\Models\VacationStatus", "vacation_status_id", "id");
    }
    public function createdBy() {
        return $this->belongsTo("App\Models\User", "id", "created_by");
    }
    public function updatedBy() {
        return $this->belongsTo("App\Models\User", "id", "updated_by");
    }
    public function dates() {
        return $this->hasMany(VacationDate::class, 'vacation_id', 'id');
    }
    public function approvals() {
        return $this->hasMany("App\Models\VacationApproval", 'vacation_id', 'id');
    }
    public function approvedByBoss(){
        return $this->approvals()
        ->where('user_id', $this->boss_id)
        ->exists();
    }
    public function approvedWithPermissions($route_name) {
        return $this->approvals
        ->contains(function($approval) use($route_name) {
            return $approval->user->hasPermissions($route_name);
        });
    }
    public function isSelfApprovedWithPermissions($route_name) {
        return $this->approvals
        ->where('user_id', $this->boss_id)
        ->contains(function($approval) use($route_name) {
            return $approval->user->hasPermissions($route_name);
        });
    }
}
