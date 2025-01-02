<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expedient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ExpReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expedientInstance = new Expedient();

        $general_fimubac = $this->generateGeneralReport($expedientInstance, 1);
        $general_valora = $this->generateGeneralReport($expedientInstance, 2);
        $general_reest = $this->generateGeneralReport($expedientInstance, 3);

        $no_cedidos_res = $this->generateNoCedidosReport($expedientInstance, 4);
        $no_cedidos_pen = $this->generateNoCedidosReport($expedientInstance, 1);
        $no_cedidos_na = $this->generateNoCedidosReport($expedientInstance, 3);

        $fimubac_na = $this->generateFimubacReport($expedientInstance, 3);
        $fimubac_safe = $this->generateFimubacReport($expedientInstance, 2);
        
        $report_by_institution = $this->generatePorInstitucionReport();

        return view("exp_reports.index", compact("general_fimubac", "general_valora", "general_reest", "no_cedidos_res", "no_cedidos_pen", "no_cedidos_na", "fimubac_na", "fimubac_safe", "report_by_institution"));
    }

    function generateGeneralReport($expedientInstance, $ubication)
    {
        $aut = $expedientInstance->getTotalCountByExpTypeAndUbication(2, $ubication);
        $dig = $expedientInstance->getTotalCountByExpTypeAndUbication(1, $ubication);
        $tot = $aut + $dig;
        $totalCount = $expedientInstance->getTotalCount();

        $per = $totalCount > 0 ? ($tot / $totalCount) * 100 : 0;

        return [
            'aut' => $aut,
            'dig' => $dig,
            'tot' => $tot,
            'per' => number_format($per, 2),
        ];
    }

    function generateNoCedidosReport($expedientInstance, $ubiStatus)
    {
        $aut = $expedientInstance->getTotalCountByExpTypeAndUbiStatus(2, $ubiStatus);
        $dig = $expedientInstance->getTotalCountByExpTypeAndUbiStatus(1, $ubiStatus);
        $tot = $aut + $dig;
        $totalCount = $expedientInstance->getTotalCountNoCedidos();

        $per = $totalCount > 0 ? ($tot / $totalCount) * 100 : 0;

        return [
            'aut' => $aut,
            'dig' => $dig,
            'tot' => $tot,
            'per' => number_format($per, 2),
        ];
    }

    function generateFimubacReport($expedientInstance, $ubiStatus)
    {
        $aut = $expedientInstance->getTotalCountByExpTypeAndUbiStatus(2, $ubiStatus, 1);
        $dig = $expedientInstance->getTotalCountByExpTypeAndUbiStatus(1, $ubiStatus, 1);
        $tot = $aut + $dig;
        $totalCount = $expedientInstance->getTotalCountCedidos();

        $per = $totalCount > 0 ? ($tot / $totalCount) * 100 : 0;

        return [
            'aut' => $aut,
            'dig' => $dig,
            'tot' => $tot,
            'per' => number_format($per, 2),
        ];
    }

    function generatePorInstitucionReport()
    {
        // Calcular el total global de pendientes
        $totalPendientes = DB::table('expedients')
        ->join('ubi_statuses', 'expedients.ubi_status_id', '=', 'ubi_statuses.id')
        ->where('ubi_statuses.name', 'PENDIENTE')
        ->where('expedients.ubication_id', 2) // Asegura que solo cuente los que tienen esta ubicación
        ->where('expedients.exp_status_id', 1)
        ->count();

        // Consulta principal con cálculo del porcentaje
        $institutions = DB::table('institutions')
        ->select(
            'institutions.name as name',
            DB::raw("COUNT(CASE WHEN ubi_statuses.name = 'RESGUARDADO' THEN 1 END) as resguardados"),
            DB::raw("COUNT(CASE WHEN ubi_statuses.name = 'NO APLICA' THEN 1 END) as no_aplica"),
            DB::raw("COUNT(CASE WHEN ubi_statuses.name = 'PENDIENTE' THEN 1 END) as pendiente"),
            DB::raw("(COUNT(CASE WHEN ubi_statuses.name = 'RESGUARDADO' THEN 1 END) +
                    COUNT(CASE WHEN ubi_statuses.name = 'NO APLICA' THEN 1 END) +
                    COUNT(CASE WHEN ubi_statuses.name = 'PENDIENTE' THEN 1 END)) as total_general"),

            DB::raw("CASE WHEN $totalPendientes > 0 THEN ROUND((COUNT(CASE WHEN ubi_statuses.name = 'PENDIENTE' THEN 1 END) * 100.0 / $totalPendientes),2) ELSE 0 END as porcentaje_pendiente")
        )
        ->where('expedients.ubication_id', 2)
        ->where('expedients.exp_status_id', 1)
        ->leftJoin('expedients', 'expedients.institution_id', '=', 'institutions.id')
        ->leftJoin('ubi_statuses', 'expedients.ubi_status_id', '=', 'ubi_statuses.id')
        ->groupBy('institutions.name')
        ->get();


        return $institutions;
    }

}
