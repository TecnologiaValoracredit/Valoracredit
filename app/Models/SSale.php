<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name', 'credit_amount','grant_date', 's_coordinator_id',
        'institution_id','s_branch_id', 's_status_id','credit_id','is_active',
        'created_by', 'updated_by','opening_amount', 'total_amount'
    ];

    public function sBranch()
    {
        return $this->belongsTo('App\Models\SBranch', 's_branch_id');
    }

    public function sStatus()
    {
        return $this->belongsTo('App\Models\SStatus', 's_status_id');
    }

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution', 'institution_id');
    }

    public function sCoordinator()
    {
        return $this->belongsTo('App\Models\SCoordinator', 's_coordinator_id');
    }
    
}
