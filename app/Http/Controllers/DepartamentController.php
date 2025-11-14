<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\Request;
use App\Models\Departament;
use App\Models\PermissionModule;
use App\DataTables\DepartamentDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DepartamentRequest;
use ReturnTypeWillChange;

class DepartamentController extends Controller
{
    public function index(DepartamentDataTable $dataTable)
    {
        //obtener todos los departaments, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("departaments.create");
        return $dataTable->render('departaments.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('departaments.create');
    }

    public function store(DepartamentRequest $request)
    {
        $status = true;
		$departament = null;

        $params = array_merge($request->all(), [
			'name' => $request->name,
            'descriptiom' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$departament = Departament::create($params);
			$message = "Departamento creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'departaments');
		}
        return $this->getResponse($status, $message, $departament);

    }

    public function edit(Departament $departament)
    {
        return view('departaments.edit', compact("departament"));
    }

    public function update(DepartamentRequest $request, Departament $departament)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'descriptiom' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$departament->update($params);
			$message = "Departamento modificado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'departaments');
		}
        return $this->getResponse($status, $message, $departament);

    }

    public function show(Departament $departament)
    {
        $modules = PermissionModule::all();
        return view("departaments.show", compact("departament", "modules"));
    }

    public function destroy(Departament $departament)
    {
        $status = true;
        try {
            $departament->update(["is_active" => false]);
            $message = "Departamento desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'departaments');
        }
        return $this->getResponse($status, $message);
    }

    public function getJobPositions($departamentId){
       
        $jobs = JobPosition::where('departament_id', $departamentId)->get();
        return response()->json($jobs);
    }
}
