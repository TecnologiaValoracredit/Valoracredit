<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminationReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(TerminationReason::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TerminationReason::class, 'parent_id');
    }

    public function hasChildren()
    {
        return $this->children()->exists();
    }

}
