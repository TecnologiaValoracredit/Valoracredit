<?php

namespace App\Http\Controllers;


use App\Models\FClasification;
use App\Http\Requests\FClasificationRequest;
use App\DataTables\FClasificationDataTable;
use App\Models\PermissionModule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class FClasificationController extends Controller
{
    public function index(FClasificationDataTable $dataTable )
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("f_fluxes.create");
       
        return $dataTable->render('f_clasifications.index', compact("allowAdd"));
    }

    public function create()
    {
        
        return view('f_clasifications.create');
    }

    public function store(FClasificationRequest $request)
    {
        $status = true;
        $f_clasification = null;

        $params = array_merge($request->all(), [
            'f_clasifications_id' => 1,
             'is_active' => !is_null($request->is_active),
        ]);

        try {
            $f_clasification = FClasification::create($params);
            $message = "Clasificación creada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_clasifications');
        }

        return $this->getResponse($status, $message, $f_clasification);
    }   

    public function edit(FClasification $f_clasification)
    {
       
        return view('f_clasifications.edit', compact("f_clasification"));
        
     
    }

    public function update(FClasificationRequest $request, FClasification $f_clasification)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
        ]);
    
        try {
            $f_clasification->update($params);
            $message = "Clasificación modificada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_clasifications');
        }
    
        return $this->getResponse($status, $message, $f_clasification);
    }
    

    public function show(FClasification $f_clasification)
    {
    }

    public function destroy(FClasification $f_clasification)
    {
        $status = true;
        try {
            $f_clasification->update(["is_active" => false]);
            $message = "Clasificación desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_clasifications');
        }
        return $this->getResponse($status, $message);
    }
}
