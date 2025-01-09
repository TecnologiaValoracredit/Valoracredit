<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'f_account_id',
        'accredit_date',
        'f_beneficiary_id',
        'concept',
        'amount',
        'f_movement_type_id',
        'account',
        'account2',
        'comments',
        'f_status_id',

        'is_active',
        'created_by',
        'updated_by',
        'notes'
    ];

    public function fAccount()
    {
        return $this->belongsTo("App\Models\FAccount", "f_account_id", "id");
    }

    public function fBeneficiary()
    {
        return $this->belongsTo("App\Models\FBeneficiary", "f_beneficiary_id", "id");
    }

    public function fStatus()
    {
        return $this->belongsTo("App\Models\FStatus", "f_status_id", "id");
    }

    public function fMovementType()
    {
        return $this->belongsTo("App\Models\FMovementType", "f_movement_type_id", "id");
    }

}
