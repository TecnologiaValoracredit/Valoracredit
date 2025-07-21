<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCoordinatorName extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'coordinator_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'is_active'
    ];

    //Relación que hay con el coordinador
    public function coorindator(){
        return $this->belongsTo(SCoordinator::class);
    }
}
