<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionLog extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'id',
        'requisition_id',
        'user_id',
        'role_id',
        'action',
        'from_status_id',
        'to_status_id',
        'notes',
        'created_at',
        'updated_at',
    ];

    public function requisition(){
        return $this->belongsTo(Requisition::class, "requisition_id", "id");
    }
    public function user(){        
        return $this->belongsTo(User::class, "user_id", "id");
    }
    public function fromStatusId(){
        return $this->belongsTo(RequisitionStatus::class, 'from_status_id', 'id');
    }
    public function toStatusId(){
        return $this->belongsTo(RequisitionStatus::class, 'to_status_id', 'id');
    }
}
