<?php

namespace App\Models;

use App\Enums\MinuteTaskUpdateFieldEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteTaskUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'minute_task_id',
        'user_id',
        'field',
        'old_value',
        'new_value',
    ];

    protected $casts = [
        'field' => MinuteTaskUpdateFieldEnum::class,
    ];

    public function task()
    {
        return $this->belongsTo(MinuteTask::class, 'minute_task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
