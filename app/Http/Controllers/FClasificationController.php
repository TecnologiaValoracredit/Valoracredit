<?php

namespace App\Http\Controllers;


use App\Models\FClasification;
use App\Models\FMovementType;

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
        $f_clasifications = FClasification::where("is_active", 1)
        ->whereNull("parent_id")
        ->pluck("name", "id")
        ->prepend("Sin padre", null);
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");

        return view('f_clasifications.create', compact("f_clasifications", "f_movement_types"));
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
        $f_clasifications = FClasification::where("is_active", 1)
        ->whereNull("parent_id")
        ->pluck("name", "id")
        ->prepend("Sin padre", null);
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");

        return view('f_clasifications.edit', compact("f_clasification", "f_clasifications", "f_movement_types"));
     
    }

    public function update(FClasificationRequest $request, FClasification $f_clasification)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
        ]);
        try {
            if ($f_clasification->parent_id == null) {
                //Si el padre ahora ya no es null revisar todas las que tenian ese padre y dejarlas en null
                if ($params["parent_id"] > 0) {

                    FClasification::where("parent_id", $f_clasification->id)->update([
                        "parent_id" => null
                    ]);
                }
            }
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
