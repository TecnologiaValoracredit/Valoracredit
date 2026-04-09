<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'iva_percentage',
        'total_cost',
        'reason',
        'link',
        'currency_type_id',
        'requisition_id',
        'notes',
        'requisition_row_evidence_id',
        'expense_duration_id',
        'starting_date',
        'ending_date',
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

    public function evidences(){
        return $this->hasMany(RequisitionRowEvidence::class,"requisition_row_id","id");
    }

    public function deleteEvidences(){
        $evidences = $this->evidences;

        foreach($evidences as $evidence){
            Storage::disk('public')->delete($evidence->path);
            $evidence->delete();
        }
    }
    public function getPeriod(){
        if ($this->starting_date == null && $this->ending_date == null){
            return "N/A";
        }

        $starting_date_month = date("F", strtotime($this->starting_date));
        $starting_date_year = date("Y", strtotime($this->starting_date));
        $formatted_starting_date = "{$starting_date_month} {$starting_date_year}";
        
        $ending_date_month = date("F", strtotime($this->ending_date));
        $ending_date_year = date("Y", strtotime($this->ending_date));
        $formatted_ending_date = "{$starting_date_month} {$starting_date_year}";

        if ($formatted_starting_date == $formatted_ending_date){
            return $formatted_starting_date;
        }

        return "{$formatted_starting_date} - {$formatted_ending_date}";
    }
}
