<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCollaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'commission_percentage',
        's_branch_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'is_active'
    ];

    //Relaciones 
     public function user(){
        return $this->belongsTo(User::class);
    }

     public function s_sales(){
        return $this->hasMany(SSale::class,'s_collaborator_id', 'id');
    }
}
