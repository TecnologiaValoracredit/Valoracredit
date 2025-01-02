<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChkCheckListsList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','chk_checklist_id','is_active', 'chk_list_id',
        'created_by','updated_by'
    ];
}
