<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedient extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_id',
        'client_name',
        'opening_date',
        'credit_amount',
        'pay',
        'portafolio_date',
        'institution_id',
        'anchorer_id',
        'exp_status_id', //Vigente o No vigente
        'ubi_status_id', //Safe data, no aplica, pendiente y resguardado
        'ubication_id', //Valora o fimubac
        'exp_type_id', //digital o autografa
        
        'created_by',
        'created_at',
        'is_active'
    ];

    public function institution()
    {
        return $this->belongsTo("App\Models\Institution", "institution_id", "id");
    }

    public function anchorer()
    {
        return $this->belongsTo("App\Models\Anchorer", "anchorer_id", "id");
    }

    public function expStatus()
    {
        return $this->belongsTo("App\Models\ExpStatus", "exp_status_id", "id");
    }

    public function ubiStatus()
    {
        return $this->belongsTo("App\Models\UbiStatus", "ubi_status_id", "id");
    }

    public function ubication()
    {
        return $this->belongsTo("App\Models\Ubication", "ubication_id", "id");
    }

    public function expType()
    {
        return $this->belongsTo("App\Models\ExpType", "exp_type_id", "id");
    }

    public function getTotalCountByExpTypeAndUbication($exp_tpye_id = null, $ubication_id = null)
    {
        return self::where("exp_type_id", $exp_tpye_id)->where("ubication_id", $ubication_id)->where("exp_status_id", 1)->count();
    }

    public function getTotalCountByExpTypeAndUbiStatus($exp_tpye_id = null, $ubi_status_id = null, $ubication_id = 2)
    {
        return self::where("exp_type_id", $exp_tpye_id)->where("ubi_status_id", $ubi_status_id)->where("ubication_id", $ubication_id)->where("exp_status_id", 1)->count();
    }

    public function getTotalCountNoCedidos()
    {
        return self::where("ubication_id", 2)->where("exp_status_id", 1)->count();
    }

    public function getTotalCountCedidos()
    {
        return self::where("ubication_id", 1)->where("exp_status_id", 1)->count();
    }

    public function getTotalCount()
    {
        return self::where("exp_status_id", 1)->count();
    }
}
