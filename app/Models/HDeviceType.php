<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HDeviceType extends Model
{
    use HasFactory;

    protected $fillable=
    [
        'name','description',
         'created_by','created_at','is_active'
    ];
}
