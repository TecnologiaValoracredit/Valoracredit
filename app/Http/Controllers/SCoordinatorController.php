<?php

namespace App\Http\Controllers;


use App\Models\SCoordinator;
use App\Models\Role;
use App\Models\Departament;
use App\Models\Branch;
use App\Models\SBranch;
use App\Models\User;
use App\Models\Institution;

use App\Http\Requests\SCoordinatorRequest;
use App\DataTables\SCoordinatorDataTable;
use App\DataTables\InstitutionCommissionDataTable;
use App\DataTables\SUserNameDataTable;

use App\Models\PermissionModule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Hash;


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
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $isEdit = false;

        return view('s_coordinators.create', compact('roles', 'branches', 's_branches', 'departaments', 'isEdit'));
    }

    public function store(SCoordinatorRequest $request)
    {
        $status = true;
        $s_coordinator = null;
        $userParams = array_merge($request->all(), [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => 13,
            "departament_id" => 1,
            'is_active' => !is_null($request->is_active),
        ] );  

        try {
            $user = User::create($userParams);

            $params = array_merge($request->all(), [
                'commission_percentage' => $request->commission_percentage,
                's_branch_id' => $request->s_branch_id,
                'is_broker' => $request->is_broker == "on" ?? true, false,
                'user_id' => $user->id,
                'is_active' => !is_null($request->is_active),
            ]);

            $s_coordinator = SCoordinator::create($params);
            $message = "Coordinador creado correctamente";

            // dd($user, $s_coordinator, $message);

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_coordinators');
        }

        return $this->getResponse($status, $message, $s_coordinator);
    }   

    public function edit(SCoordinator $s_coordinator)
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $user = $s_coordinator->user;
        $isEdit = true;

        $institutionDataTable = new InstitutionCommissionDataTable($s_coordinator->user);
        $params = ['user' => $s_coordinator->user];
        $institutionDT = $this->getViewDataTable($institutionDataTable, 'commissions', [], 'commissions.getInstitutionCommissionDataTable', $params);

        $sUserNameDataTable = new SUserNameDataTable($s_coordinator->user);
        $params = ['user' => $s_coordinator->user];
        $sUserNameDT = $this->getViewDataTable($sUserNameDataTable, 'commissions', [], 'commissions.getSUserNameDataTable', $params);

        $institutions = Institution::where("is_active", 1)->orderBy("name", "asc")->pluck("name", "id");

        return view('s_coordinators.edit', compact("s_coordinator", "user", "roles", "branches", "s_branches", "departaments", "isEdit", "institutionDT", "institutions", "sUserNameDT"));
     
    }

    public function update(SCoordinatorRequest $request, SCoordinator $s_coordinator)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
            'is_broker' => $request->has('is_broker') ? 1 : 0, 
        ]);

        try {
            $s_coordinator->update($params);
            $s_coordinator->user->update(["name" => $params["name"]]);
            if ($params["is_active"] == 0) {
                $s_coordinator->user->update(["is_active" => false]);
            }else if ($params["is_active"] == 1) {
                $s_coordinator->user->update(["is_active" => true]);
            }
            $message = "Coordinador modificado correctamente";
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
            $s_coordinator->user->update(["is_active" => false]);
            $message = "Coordinador desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_coordinators');
        }
        return $this->getResponse($status, $message);
    }

     
   
}
