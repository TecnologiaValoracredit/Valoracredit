<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active','requisition_status_id', 'payment_type_id',
        'departament_id', 'branch_id', 'inmediate_boss_user_id', 
        'administration_user_id', 'general_direction_user_id','is_approved_inmediante_boss','is_approved_administration',
        'is_approved_general_direction', 'is_active', 'created_by', 'updated_by','notes'
    ];

    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }

    public function inmediateBossUser()
    {
        return $this->belongsTo("App/Models/User", "inmediate_boss_user_id","id");
    }

    public function administrationUser()
    {
        return $this->belongsTo("App/Models/User", "administration_user_id","id");
    }

    public function generalDirectionUser()
    {
        return $this->belongsTo("App/Models/User", "general_direction_user_id","id");
    }    

    public function paymentType()
    {
        return $this->belongsTo("App\Models\PaymentType", "payment_type_id", "id");
    }
    public function requisitionStatus()
    {
        return $this->belongsTo("App\Models\RequisitionStatus", "requisition_status_id", "id");
    }

}
