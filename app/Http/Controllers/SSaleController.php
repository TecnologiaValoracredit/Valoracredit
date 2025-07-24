<?php

namespace App\Http\Controllers;

use App\Imports\SalesImport;
use Illuminate\Http\Request;
use App\Models\SSale;
use App\DataTables\SSaleDataTable;
use Maatwebsite\Excel\Facades\Excel;
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

    public function importExcel(Request $request){
        
        try{
            Excel::import(new SalesImport, $request->file);
            return redirect()->back()->with('success','');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

}
