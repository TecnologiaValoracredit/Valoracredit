<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionRow extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'requisition_id', 'amount', 'subtotal',
        'departament', 'supplier_id', 'description', 
        'unit_price', 'url','include_iva','notes', 
        'created_by','updated_by', 'is_active','created_by', 
        'updated_by','notes',
    ];

    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier", "supplier_id", "id");
    }
    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }
    public function requisitionRowOptional()
    {
        return $this->hasMany("App\Models\RequisitionRowOptional", "requisition_row_id", "id");
    }

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }
}
