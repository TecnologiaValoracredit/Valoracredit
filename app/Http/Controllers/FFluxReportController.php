<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\FFluxExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FClasification;
use App\Models\FFlux;
use App\Models\FAccount;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FFluxReportController extends Controller
{

    public function index()
    {
        // Calcular el primer día del mes actual
        $firstDayOfMonth = new \DateTime('first day of this month');
        // Calcular el último día del mes actual
        $lastDayOfMonth = new \DateTime('last day of this month');
        // Formatear las fechas como YYYY-MM-DD (formato requerido por input type="date")
        $startDate = $firstDayOfMonth->format('Y-m-d');
        $endDate = $lastDayOfMonth->format('Y-m-d');

        return view("f_flux_reports.index", compact("startDate", "endDate"));
    }

    public function exportAdminReport(Request $request)
    { 
        $startDate = $request->input('start_date'); // Obtener la fecha de inicio desde la solicitud
        $endDate = $request->input('end_date'); // Obtener la fecha de fin desde la solicitud
    
        // Validar las fechas (opcional)
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Obtener los datos procesados (usando el query anterior)
        $processedData = $this->getProcessedData($startDate, $endDate);
        
        $clasifications = FClasification::where("is_active", 1)->get();
        $activeAccounts = FAccount::where("is_active", 1)->get();

        return Excel::download(new FFluxExport($processedData, $clasifications, $activeAccounts, $startDate, $endDate), 'flux_summary.xlsx');
    }

    protected function getProcessedData($startDate, $endDate)
    {
        $fluxes = FFlux::select(
            'accredit_date',
            'f_clasification_id',
            'f_movement_type_id',
            \DB::raw('SUM(amount) as total_amount')
        )
        ->whereBetween('accredit_date', [$startDate, $endDate]) // Filtrar por rango de fechas
        ->where('is_active', 1)
        ->groupBy('accredit_date', 'f_clasification_id', 'f_movement_type_id')
        ->get();

        // Obtener todas las clasificaciones con sus nombres
        $clasifications = FClasification::all()->keyBy('id');
        
        $processedData = [];

        // Calcular el total general de todos los montos
        $totalGeneral = 0;

        foreach ($fluxes as $flux) {
            $date = Carbon::parse($flux->accredit_date)->format('d-m-y'); // Formato: "01-ene-25"
            $clasificationId = $flux->f_clasification_id;
            $movementType = $flux->f_movement_type_id; // 1 = Ingreso, 2 = Egreso (ajusta según tu caso)
            $amount = $flux->total_amount;

            // Sumar al total general
            $totalGeneral += $amount;

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

        // Calcular el total de cada clasificación y agregar una columna de totales y porcentaje de participación
        foreach ($processedData as $clasificationName => $dates) {
            $total = 0;

            // Sumar los montos de todas las fechas y tipos de movimiento
            foreach ($dates as $date => $movementTypes) {
                foreach ($movementTypes as $movementType => $amount) {
                    $total += $amount;
                }
            }

            // Agregar el total como una nueva columna en los datos procesados
            $processedData[$clasificationName]['Total Mes'] = $total;

            // Calcular el porcentaje de participación respecto al total general
            $porcentajeParticipacion = ($totalGeneral != 0) ? ($total / $totalGeneral) * 100 : 0;

            // Agregar el porcentaje como una nueva columna en los datos procesados
            $processedData[$clasificationName]['% Participación'] = round($porcentajeParticipacion, 2) . '%';
        }

        return $processedData;
    }
}
