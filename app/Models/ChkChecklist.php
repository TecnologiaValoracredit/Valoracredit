<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChkChecklist extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name','is_active', 'date',
        'created_by','updated_by', 'rfc', 'credit_ammount',
        'dispersed_ammount','credit_id', 'sol_id','chk_credit_type_id',
        'exp_type_id', 'institution_id'
    ];
    public function chkLists()
    {
        return $this->belongsToMany(
            'App\Models\ChkList',  // El modelo relacionado
            'chk_checklist_lists',  // La tabla intermedia
            'chk_checklist_id',  // Clave foránea en este modelo (ChkChecklist)
            'chk_list_id'  // Clave foránea en el modelo relacionado (ChkList)
        );
        
        
    }

    public function chkCreditType()
    {
        return $this->belongsTo("App\Models\ChkCreditType", "chk_credit_type_id", "id");
    }

    
    public function institution()
    {
        return $this->belongsTo("App\Models\Institution", "institution_id", "id");
    }
    
    
    
}
