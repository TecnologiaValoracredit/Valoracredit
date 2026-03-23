<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionRowEvidence extends Model
{
    use HasFactory;

    protected $table = 'requisition_row_evidences';

    protected $fillable = [
        'requisition_row_id',
        'path',
        'is_active',
        'crated_at',
        'updated_at',
    ];
}
