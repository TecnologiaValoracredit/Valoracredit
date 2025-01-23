<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\FFluxExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FClasification;
use App\Models\FFlux;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FFluxAdminReportController extends Controller
{
    public function exportAdminReport()
    {
        // Obtener los datos procesados (usando el query anterior)
        $processedData = $this->getProcessedData();
        $clasifications = FClasification::all();

        return Excel::download(new FFluxExport($processedData, $clasifications), 'flux_summary.xlsx');
    }

    protected function getProcessedData()
    {
        $fluxes = FFlux::select(
            'accredit_date',
            'f_clasification_id',
            'f_movement_type_id',
            \DB::raw('SUM(amount) as total_amount')
        )
        ->whereMonth('accredit_date', 1) // Filtrar solo enero
        ->whereYear('accredit_date', 2025) // Año 2025
        ->groupBy('accredit_date', 'f_clasification_id', 'f_movement_type_id')
        ->get();
    
        // Obtener todas las clasificaciones con sus nombres
        $clasifications = FClasification::all()->keyBy('id');
        
        // Procesar los datos para sumar los montos de los hijos a los padres
        $processedData = [];
        
        foreach ($fluxes as $flux) {
            $date = Carbon::parse($flux->accredit_date)->format('d-m-y'); // Formato: "01-ene-25"
            $clasificationId = $flux->f_clasification_id;
            $movementType = $flux->f_movement_type_id; // 1 = Ingreso, 2 = Egreso (ajusta según tu caso)
            $amount = $flux->total_amount;
        
            // Si no tiene clasificación, lo agrupamos bajo "Sin Clasificación"
            if (is_null($clasificationId)) {
                $clasificationId = 'sin_clasificacion';
                $clasificationName = 'Sin Clasificación';
                $clasification = null; // No hay clasificación asociada
            } else {
                // Obtener la clasificación actual
                $clasification = $clasifications[$clasificationId] ?? null;
                $clasificationName = $clasification ? $clasification->name : 'Desconocido';

                if ($clasification && $clasification->parent_id) {
                    $clasificationName .= '-'; // Agregar sufijo para diferenciar
                }
            }
            // Guardar el monto para el hijo (si es hijo)
            if (!isset($processedData[$clasificationName][$date][$movementType])) {
                $processedData[$clasificationName][$date][$movementType] = 0;
            }
            $processedData[$clasificationName][$date][$movementType] += $amount;
        
            // Si tiene un padre, sumar el monto al padre (solo si es un hijo)
            if ($clasification && $clasification->parent_id) {
                $parentId = $clasification->parent_id;
                $parentName = $clasifications[$parentId]->name;
        
                if (!isset($processedData[$parentName][$date][$movementType])) {
                    $processedData[$parentName][$date][$movementType] = 0;
                }
                $processedData[$parentName][$date][$movementType] += $amount;
            }
        }
        
        // Asegurarse de que todas las clasificaciones (padres e hijos) estén en los datos procesados
        foreach ($clasifications as $clasification) {
            $clasificationName = $clasification->name;
        
            // Si es un hijo, agregar un sufijo para diferenciarlo del padre
                if ($clasification->parent_id) {
                    $clasificationName .= '-'; // Agregar sufijo para diferenciar
                }

            // Si la clasificación no está en los datos procesados, agregarla con valores en 0
            if (!isset($processedData[$clasificationName])) {
                $processedData[$clasificationName] = [];
            }
        }

        return $processedData;
    }
}
