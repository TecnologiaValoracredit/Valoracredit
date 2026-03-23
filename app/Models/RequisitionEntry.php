<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'requisition_id',
        'poliza_number',
        'path',
        'notes',
        'created_by',
    ];
}
