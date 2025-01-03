<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SSale;
use App\DataTables\SSaleDataTable;
use Illuminate\Support\Facades\Validator;

class SSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SSaleDataTable $dataTable)
    {
        return $dataTable->render('s_sales.index');
    }

}
