<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'is_active','requisition_status_id', 'payment_type_id', 'application_date',
        'departament_id', 'branch_id','supplier_id', 'inmediate_boss_user_id', 
        'administration_user_id', 'general_direction_user_id','is_approved_inmediante_boss','is_approved_administration',
        'is_approved_general_direction', 'is_active', 'created_by', 'updated_by','notes', 'created_at'
    ];


    public function branch()
    {
        return $this->belongsTo("App\Models\Branch", "branch_id", "id");
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }

    public function requisitionRowOptionals()
    {
        return $this->hasMany(RequisitionRowOptional::class, 'requisition_id', 'id');
    }

    
    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier", "supplier_id", "id");
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
        public function rows()
    {
        return $this->hasMany(RequisitionRow::class);
    }

    public function requisitionRowOptional()
    {
        return $this->hasMany(RequisitionRowOptional::class);
    }
    


    public function requisitionRows()
    {
        return $this->hasMany(RequisitionRow::class);
    }

    

}
