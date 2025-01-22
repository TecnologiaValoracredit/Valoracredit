<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'f_company_id',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function fCompany()
    {
        return $this->belongsTo("App\Models\FCompany", "f_company_id", "id");
    }

    public function fluxes()
    {
        return $this->hasMany(FFlux::class, 'f_account_id'); 
    }

    public function getIngresosAttribute()
    {
         return $this->fluxes()
         ->where('f_movement_type_id', 1) // Filtrar por tipo ingreso
         ->sum('amount');
    }

    public function getEgresosAttribute()
    {
         return $this->fluxes()
             ->where('f_movement_type_id', 2) // Filtrar por tipo egreso
             ->sum('amount');
    }

    public function getBalanceAttribute()
    {
        $ingresos = $this->ingresos; 
        $egresos = $this->egresos;
        return $ingresos - $egresos;
    }

}
