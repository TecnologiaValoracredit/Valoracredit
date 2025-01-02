<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name', 'amount','grantdate',
        'institution_id','sbranch_id', 'sstatus_id','credit_id','is_active',
        'created_by', 'updated_by'
    ];

    public function sbranch()
    {
        return $this->belongsTo('App\Models\SBranch', 's_branch_id');
    }

    public function sstatus()
    {
        return $this->belongsTo('App\Models\SStatus', 's_status_id');
    }
    
}
