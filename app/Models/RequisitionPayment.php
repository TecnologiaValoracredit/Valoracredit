<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'path',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
