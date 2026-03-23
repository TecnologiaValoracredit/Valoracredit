<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'requisition_id',
        'created_at',
        'updated_at',
        'is_active',
    ];

    public function requisition(){
        return $this->belongsTo(Requisition::class, 'requisition_id', 'id');
    }
}
