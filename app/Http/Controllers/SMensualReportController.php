<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SSale;
use App\DataTables\SMensualReportDataTable;
use Illuminate\Support\Facades\Validator;

class SMensualReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SMensualReportDataTable $dataTable)
    {
        return $dataTable->render('s_sales.s_mensual_report');
    }

}
