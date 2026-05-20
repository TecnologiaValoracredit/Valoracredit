<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacation_id',
        'date',
        'created_at',
    ];

    public function vacation() {
        return $this->belongsTo("App\Models\Vacation", "id", "vacation_id");
    }
}
