<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'meeting_date',
        'start_time',
        'end_time',
        'notes',
        'status',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'is_active'    => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(MinuteParticipant::class, 'minute_id');
    }

    public function tasks()
    {
        return $this->hasMany(MinuteTask::class, 'minute_id');
    }

    public function reminders()
    {
        return $this->hasMany(MinuteReminder::class, 'minute_id');
    }
}
