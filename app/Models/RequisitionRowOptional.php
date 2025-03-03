<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionRowOptional extends Model
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
    public function requisitionRow()
    {
        return $this->belongsTo("App\Models\RequisitionRow", "requisition_row_id", "id");
    }

   
}
