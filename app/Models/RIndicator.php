<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RIndicator extends Model
{
    use HasFactory;
    protected $fillable = [
        'institution_id',
        'credit_id', 
        'matching_captial',
        'total_portfolio',
        'cut_date',
        'portfolio_date',
        'last_move_date',
        'upload_date',
        'is_active',
        'created_by', 'updated_by'
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution', 'institution_id');
    }
    
}
