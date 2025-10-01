<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionRow extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'product',
        'product_description',
        'product_quantity',
        'product_cost',
        'has_iva',
        'total_cost',
        'reason',
        'evidence',
        'link',
        'currency_type_id',
        'requisition_id',
        'parent_id',
        'supplier_id',
        'is_active',
        'created_by', 
        'updated_by',
        'notes'
    ];

    public function currencyType()
    {
        return $this->belongsTo("App\Models\CurrencyType", "currency_type_id", "id");
    }

    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier", "supplier_id", "id");
    }

    public function requisition()
    {
        return $this->belongsTo("App\Models\Requisition", "requisition_id", "id");
    }

    public function parent(){
        return $this->belongsTo("App\Models\RequisitionRow", "parent_id", "id");
    }

    public function childs(){
        return $this->hasMany("App\Models\RequisitionRow", "parent_id", "id");
    }
}
