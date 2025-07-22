<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SUserName extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'is_active'
    ];

    //Relación que hay con el usuario
    public function user(){
        return $this->belongsTo(User::class);
    }
}
