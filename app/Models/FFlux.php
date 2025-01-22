<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FFlux extends Model
{
    use HasFactory;

    protected $fillable = [
        'f_account_id', 
        'accredit_date',
        'f_beneficiary_id',
        'concept',
        'amount',
        'f_movement_type_id', 
        'notes1',
        'notes2',
        'comments',
        'f_status_id',
        'f_clasification_id',
        'f_cob_clasification_id',
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

    public function fClasification()
    {
        return $this->belongsTo("App\Models\FClasification", "f_clasification_id", "id");
    }

    public function fCobClasification()
    {
        return $this->belongsTo("App\Models\FCobClasification", "f_cob_clasification_id", "id");
    }

}
