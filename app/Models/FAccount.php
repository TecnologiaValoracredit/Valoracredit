<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'f_company_id',
        'init_balance',
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

    // Método para obtener ingresos (con filtro de fechas opcional)
    public function getIngresosAttribute($startDate = null, $endDate = null)
    {
        $query = $this->fluxes()
        ->where('f_movement_type_id', 1); // Filtrar por tipo ingreso
        
        // Si se proporciona endDate, filtrar hasta esa fecha
        if ($endDate) {
            $endDate = Carbon::createFromFormat('d-m-y', $endDate)->format('Y-m-d');
            $query->where('accredit_date', '<=', $endDate);
        }

        // Si se proporciona startDate, filtrar desde esa fecha
        if ($startDate) {
            $startDate = Carbon::createFromFormat('d-m-y', $startDate)->format('Y-m-d');
            $query->where('accredit_date', '>=', $startDate);
        }
        $total = $query->sum('amount');
        return ( $total  + $this->init_balance);
    }

    // Método para obtener egresos (con filtro de fechas opcional)
    public function getEgresosAttribute($startDate = null, $endDate = null)
    {
        $query = $this->fluxes()
            ->where('f_movement_type_id', 2); // Filtrar por tipo egreso

        if ($endDate) {
            $endDate = Carbon::createFromFormat('d-m-y', $endDate)->format('Y-m-d');
            $query->where('accredit_date', '<=', $endDate);
        }

        // Si se proporciona startDate, filtrar desde esa fecha
        if ($startDate) {
            $startDate = Carbon::createFromFormat('d-m-y', $startDate)->format('Y-m-d');
            $query->where('accredit_date', '>=', $startDate);
        }
        return $query->sum('amount');
    }

    // Método para obtener el balance (con filtro de fechas opcional)
    public function getBalanceAttribute($startDate = null, $endDate = null)
    {
        $ingresos = $this->getIngresosAttribute($startDate, $endDate);
        $egresos = $this->getEgresosAttribute($startDate, $endDate);
        return $ingresos - $egresos;
    }
}