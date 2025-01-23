<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FClasification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','description', 'parent_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function parent()
    {
        return $this->belongsTo("App\Models\FClasification", "parent_id", "id");
    }

}
