<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SSale;
use App\DataTables\SPromotorReportDataTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SPromotorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = ($this->getTable(2025));
        return view('s_sales.s_promotor_report', compact("table"));
    }


    public function getTable($year)
    {
        $data = SSale::select(
            's_coordinators.name as coordinator_name',
            'institutions.name as institution_name',
            DB::raw('SUM(s_sales.credit_amount) as total_sales')
        )
        ->leftJoin('s_coordinators', 's_sales.s_coordinator_id', '=', 's_coordinators.id')
        ->leftJoin('institutions', 's_sales.institution_id', '=', 'institutions.id')
        ->whereYear('s_sales.grant_date', $year ?? 2025)
        ->groupBy('s_coordinators.name', 'institutions.name')
        ->get();

        $coordinators = [];
        $institutions = [];
        $totals_by_institution = [];
        $grand_total = 0;

        // Construimos la matriz base
        foreach ($data as $row) {
            $coordinator = $row->coordinator_name;
            $institution = $row->institution_name;
            $amount = $row->total_sales;

            $coordinators[$coordinator][$institution] = $amount;
            $institutions[$institution] = true;
        }

        // Asegurar que todas las instituciones estén presentes con valor 0 si no hay ventas
        foreach ($coordinators as $coord => $sales) {
            foreach ($institutions as $inst => $_) {
                if (!isset($coordinators[$coord][$inst])) {
                    $coordinators[$coord][$inst] = 0;
                }
            }
        }

        foreach ($coordinators as $coord => $sales) {
            foreach ($sales as $institution => $amount) {
                $totals_by_institution[$institution] = ($totals_by_institution[$institution] ?? 0) + $amount;
                $grand_total += $amount;
            }
        }
        return view("s_sales.tables.s_promotor_report_table", compact("coordinators", "institutions", "totals_by_institution", "grand_total"))->render();
    }

}
