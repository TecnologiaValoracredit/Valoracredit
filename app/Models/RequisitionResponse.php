<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionResponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'requisition_status_id',
        'reason',
        'user_id',
        'requisition_id',
        'is_active',
        'created_by', 
        'updated_by',
        'notes'
    ];

    public function requisiton()
    {
        return $this->belongsTo("App\Models\Requisition", "requisition_id", "id");
    }

    public function requisitionStatus()
    {
        return $this->belongsTo("App\Models\RequisitionStatus", "requisition_status_id", "id");
    }

    public function user(){
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
