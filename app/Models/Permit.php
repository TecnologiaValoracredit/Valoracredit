<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'departament_id',
        'job_position_id',
        'boss_id',
        'hr_id',
        
        'permit_date',

        'entry_hour',
        'exit_hour',
        'pending_hours',

        'motive_id',
        'discount_characteristic_id',
        'user_observations',
        'hr_observations',
        'boss_observations',

        'permit_status_id',

        'path_user_signature',
        'path_hr_signature',
        'path_boss_signature',

        'is_signed_by_hr',
        'is_signed_by_boss',
        'is_active',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hr(){
        return $this->belongsTo(User::class, 'hr_id');
    }

    public function departament(){
        return $this->belongsTo(Departament::class, 'departament_id');
    }

    public function jobPosition(){
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }

    public function boss(){
        return $this->belongsTo(User::class, 'boss_id');
    }

    public function motive(){
        return $this->belongsTo(Motive::class, 'motive_id');
    }

    public function discountCharacteristic(){
        return $this->belongsTo(DiscountCharacteristic::class, 'discount_characteristic_id');
    }

    public function permitStatus(){
        return $this->belongsTo(PermitStatus::class, 'permit_status_id');
    }

}
