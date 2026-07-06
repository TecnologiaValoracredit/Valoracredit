<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'minute_id',
        'user_id',
        'attendance_status',
    ];

    public function minute()
    {
        return $this->belongsTo(Minute::class, 'minute_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
