<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable =[
        'event_type',
        'title',
        'description',
        'start_date',
        'end_date',
        'all_day',
        'color',
        'user_id',
        'related_id',
        'related_type',
        'created_at',
        'updated_at',
    ];

    public function related() {
        return $this->morphTo();
    }
}
