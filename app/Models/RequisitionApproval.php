<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'decision',
        'notes',
        'requisition_id',
        'requisition_global_id',
        'is_valid',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
