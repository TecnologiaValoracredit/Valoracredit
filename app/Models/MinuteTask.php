<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'minute_id',
        'parent_task_id',
        'title',
        'description',
        'assigned_to',
        'status',
        'priority',
        'due_date',
        'progress',
        'comments',
        'completed_at',
        'created_by',
        'position',
    ];

    protected $casts = [
        'due_date'     => 'date',
        'completed_at' => 'datetime',
        'progress'     => 'integer',
        'position'     => 'integer',
    ];

    public function minute()
    {
        return $this->belongsTo(Minute::class, 'minute_id');
    }

    public function parent()
    {
        return $this->belongsTo(MinuteTask::class, 'parent_task_id');
    }

    public function children()
    {
        return $this->hasMany(MinuteTask::class, 'parent_task_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updates()
    {
        return $this->hasMany(MinuteTaskUpdate::class, 'minute_task_id');
    }

    public function isOpen(): bool
    {
        return !in_array($this->status, ['completed', 'canceled']);
    }
}
