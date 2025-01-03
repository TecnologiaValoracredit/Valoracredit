<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SSale;
use App\DataTables\SGeneralReportDataTable;
use Illuminate\Support\Facades\Validator;

class SGeneralReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SGeneralReportDataTable $dataTable)
    {
        return $dataTable->render('s_sales.s_general_report');
    }

}
