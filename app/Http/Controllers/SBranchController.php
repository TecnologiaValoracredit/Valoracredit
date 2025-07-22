<?php

namespace App\Http\Controllers;


use App\Models\SBranch;
use App\Models\Role;
use App\Models\Departament;
use App\Models\Branch;
use App\Models\User;
use App\Http\Requests\SBranchRequest;
use App\DataTables\SBranchDataTable;
use App\Models\PermissionModule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Hash;


class SBranchController extends Controller
{
    public function index(SBranchDataTable $dataTable )
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("s_branches.create");
       
        return $dataTable->render('s_branches.index', compact("allowAdd"));
    }

    public function create()
    {
        
        return view('s_branches.create');
    }

    public function store(SBranchRequest $request)
    {
        // dd($request->all());
        $status = true;
        $s_branch = null;
        $params = array_merge($request->all(), [
                'commission_percentage' => $request->commission_percentage,
                's_branch_id' => $request->s_branch_id,
                'is_broker' => $request->is_broker == "on" ?? true, false,
                'is_active' => !is_null($request->is_active),
            ]);

        try {
            
            $s_branch = SBranch::create($params);
            $message = "Coordinador creado correctamente";

            // dd($user, $s_branch, $message);

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_branches');
        }

        return $this->getResponse($status, $message, $s_branch);
    }   

    public function edit(SBranch $s_branch)
    {

        return view('s_branches.edit', compact("s_branch"));
        
     
    }

    public function update(SBranchRequest $request, SBranch $s_branch)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
        ]);
    
        try {
            $s_branch->update($params);
            $message = "Clasificación modificada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_branches');
        }
    
        return $this->getResponse($status, $message, $s_branch);
    }
    

    public function show(SBranch $s_branch)
    {
    }

    public function destroy(SBranch $s_branch)
    {
        $status = true;
        try {
            $s_branch->update(["is_active" => false]);
            $message = "Clasificación desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_branches');
        }
        return $this->getResponse($status, $message);
    }
}
