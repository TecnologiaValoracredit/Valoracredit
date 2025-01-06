<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\SSale;
use App\DataTables\SInstitutionReportDataTable;
use Illuminate\Support\Facades\Validator;

class SInstitutionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SInstitutionReportDataTable $dataTable)
    {
        $institutions = Institution::where("is_active", 1)->pluck("name", "id");
        return $dataTable->render('s_sales.s_institution_report', compact("institutions"));
    }

}
