<?php

namespace App\Http\Controllers;


use App\Models\SCoordinator;
use App\Http\Requests\SCoordinatorRequest;
use App\DataTables\SCoordinatorDataTable;
use App\Models\PermissionModule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class SCoordinatorController extends Controller
{
    public function index(SCoordinatorDataTable $dataTable )
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("s_coordinators.create");
       
        return $dataTable->render('s_coordinators.index', compact("allowAdd"));
    }

    public function create()
    {
        
        return view('s_coordinators.create');
    }

    public function store(SCoordinatorRequest $request)
    {
        $status = true;
        $s_coordinator = null;

        $params = array_merge($request->all(), [
            's_coordinator_id' => 1,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $s_coordinator = SCoordinator::create($params);
            $message = "Coordinador creado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_coordinators');
        }

        return $this->getResponse($status, $message, $s_coordinator);
    }   

    public function edit(SCoordinator $s_coordinator)
    {
       
        return view('s_coordinators.edit', compact("s_coordinator"));
        
     
    }

    public function update(SCoordinatorRequest $request, SCoordinator $s_coordinator)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
        ]);
    
        try {
            $s_coordinator->update($params);
            $message = "Clasificación modificada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_coordinators');
        }
    
        return $this->getResponse($status, $message, $s_coordinator);
    }
    

    public function show(SCoordinator $s_coordinator)
    {
    }

    public function destroy(SCoordinator $s_coordinator)
    {
        $status = true;
        try {
            $s_coordinator->update(["is_active" => false]);
            $message = "Clasificación desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_coordinators');
        }
        return $this->getResponse($status, $message);
    }
}
