<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionRowOptional extends Model
{
    use HasFactory;

    protected $fillable= 
    [
        'requisition_row_id','supplier'
        ,'unit_price', 'url', 'is_active',
        'created_by', 'updated_by','notes'
    ];

    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }

    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier", "supplier_id", "id");
    }
    public function requisitionRow()
    {
        return $this->belongsTo("App\Models\RequisitionRow", "requisition_row_id", "id");
    }
}
