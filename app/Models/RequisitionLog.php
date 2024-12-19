<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionLog extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'id','is_active','created_by', 'updated_by','notes'
    ];

    public function requisition()
    {
        return $this->belongsTo("App/Model/Requisition", "requisition_id", "id");
    }
}
