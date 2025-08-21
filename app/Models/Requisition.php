<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'user_id',
        'requisition_status_id',
        'payment_type_id',
        'amount',
        'request_date',
        'departament_id',
        'branch_id',
        'approval_boss_id',
        'boss_approval_date',
        'approval_admin_id',
        'admin_approval_date',
        'approval_chief_id',
        'chief_approval_date',
        'is_active',
        'created_by', 
        'updated_by',
        'notes'
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function paymentType()
    {
        return $this->belongsTo("App\Models\PaymentType", "payment_type_id", "id");
    }
    public function requisitionStatus()
    {
        return $this->belongsTo("App\Models\RequisitionStatus", "requisition_status_id", "id");
    }
    public function requisitionRows()
    {
        return $this->hasMany("App\Models\RequisitionRow", "requisition_id", "id");
    }

    

}
