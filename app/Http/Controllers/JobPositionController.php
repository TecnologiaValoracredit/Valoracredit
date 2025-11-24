<?php

namespace App\Http\Controllers;

use App\DataTables\JobPositionsDataTable;
use App\Http\Requests\JobPositionRequest;
use App\Models\JobPosition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Departament;

class JobPositionController extends Controller
{
    //

    public function index(JobPositionsDataTable $dataTable){
        $allowAdd = auth()->user()->hasPermissions("job_positions.create");
        return $dataTable->render('job_positions.index', compact("allowAdd"));
    }
    
    public function create(){
        $departaments = Departament::where('is_active', 1)->pluck('name', 'id');
        
        return view('job_positions.create', compact('departaments'));
    }

    public function store(JobPositionRequest $request){
        $status = true;
        $job_position = null;

        $params = array_merge($request->all(), [
        'name' => $request->name,
        'description' => $request->description,
        'departament_id' => $request->departament_id,
        'is_active' => !is_null($request->is_active),
        ]);

        try {
            $job_position = JobPosition::create($params);
            $message = "Puesto de trabajo creado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'job_positions');
        }
        
        return $this->getResponse($status, $message, $job_position);
    }
    
    public function edit(JobPosition $job_position){
        $departaments = Departament::where('is_active', 1)->pluck('name', 'id');

        return view('job_positions.edit', compact('job_position', 'departaments'));
    }

    public function update(JobPositionRequest $request, JobPosition $job_position){
        $status = true;
        $message = null;

        $params = array_merge($request->all(), [
            'name' => $request->name,
            'description' => $request->description,
            'departament_id' => $request->departament_id,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $job_position->update($params);
            $message = "Puesto de trabajo modificado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'job_positions');
        }

        return $this->getResponse($status, $message, $job_position);
    }

    public function show(){

    }

    public function destroy(JobPosition $job_position){
        $status = true;
        $message = null;

        try {
            $job_position->update([
                'is_active' => false,
            ]);
            $message = "Puesto de trabajo desactivo correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'job_positions');
        }

        return $this->getResponse($status, $message, $job_position);
    }
}
