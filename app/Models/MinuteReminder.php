<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'minute_id',
        'minute_task_id',
        'channel',
        'recipient',
        'payload',
        'scheduled_at',
        'sent_at',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at'      => 'datetime',
    ];

    public function minute()
    {
        return $this->belongsTo(Minute::class, 'minute_id');
    }

    public function task()
    {
        return $this->belongsTo(MinuteTask::class, 'minute_task_id');
    }
}
