<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RIndicator;
use App\DataTables\RIndicatorDataTable;
use App\DataTables\RIndicatorFinalDataTable;

use Illuminate\Support\Facades\Validator;

class RIndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $rIndicatorDataTable = new RIndicatorDataTable();
        $rIndicatorDT = $this->getViewDataTable($rIndicatorDataTable, 'r_indicators', [], 'r_indicators.getRIndicatorDataTable');

        $rIndicatorFinalDataTable = new RIndicatorFinalDataTable();
        $rIndicatorFinalDT = $this->getViewDataTable($rIndicatorFinalDataTable, 'r_indicators', [], 'r_indicators.getRIndicatorFinalDataTable');

        return view('s_sales.r_indicators_report', compact('rIndicatorDT', 'rIndicatorFinalDT'));
    }

    public function getRIndicatorDataTable()
    {
        return (new RIndicatorDataTable())->render('components.datatable');
    }

     public function getRIndicatorFinalDataTable()
    {
        return (new RIndicatorFinalDataTable())->render('components.datatable');
    }

}
