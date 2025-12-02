<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractVariable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key_detection',
        'type',
        'model',
        'model_column',
        'relation_name',
        'relation_column',
        'handler',
        'description',
    ];
}
