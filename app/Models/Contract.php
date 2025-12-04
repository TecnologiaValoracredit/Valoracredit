<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contract_type_id',
        'content',
        'is_active',
    ];

    public function contractType()
    {
        return $this->belongsTo("App\Models\ContractType", "contract_type_id", "id");
    }
}
