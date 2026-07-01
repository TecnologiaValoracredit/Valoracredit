<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birthday extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function calendarEvents(){
        return $this->morphMany(CalendarEvent::class, 'related');
    }
}
