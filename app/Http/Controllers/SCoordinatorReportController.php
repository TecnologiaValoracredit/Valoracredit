<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SSale;
use App\DataTables\SCoordinatorReportDataTable;
use Illuminate\Support\Facades\Validator;

class SCoordinatorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SCoordinatorReportDataTable $dataTable)
    {
        return $dataTable->render('s_sales.s_coordinator_report');
    }

}
