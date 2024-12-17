<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expedient;
use App\DataTables\ExpedientDataTable;
use Illuminate\Support\Facades\Validator;

class ExpedientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExpedientDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("expedients.uploadExpedientsAbc");
        return $dataTable->render('expedients.index', compact("allowAdd"));
    }

   
    public function show($id)
    {
        //
    }

   
    public function update(Request $request, Expedient $expedient)
    {
        $status = true;

		try {
			$expedient->update(["ubi_status_id" => 4]);
			$message = "Expediente resguardado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'expedients');
		}
        return $this->getResponse($status, $message, $expedient);
    }

}
