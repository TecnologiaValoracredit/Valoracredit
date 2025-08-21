<?php

namespace App\Http\Controllers;


use App\Models\SManager;
use App\Models\Role;
use App\Models\Departament;
use App\Models\Branch;
use App\Models\SBranch;
use App\Models\User;
use App\Models\Institution;

use App\Http\Requests\SManagerRequest;
use App\DataTables\SManagerDataTable;
use App\DataTables\InstitutionCommissionManagerDataTable;
use App\DataTables\SUserNameDataTable;

use App\Models\PermissionModule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Hash;


class SManagerController extends Controller
{
    public function index(SManagerDataTable $dataTable )
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("s_managers.create");

        return $dataTable->render('s_managers.index', compact("allowAdd"));
    }

    public function create()
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $users = User::where("role_id", 21)->pluck("name","id");
        $isEdit = false;

        return view('s_managers.create', compact('roles', 'branches', 's_branches', 'departaments', 'isEdit', 'users'));
    }

    public function store(SManagerRequest $request)
    {
        $status = true;
        $s_manager = null;
        try {
            $params = array_merge($request->all(), [
                'commission_percentage' => $request->commission_percentage ?? 0,
                's_branch_id' => $request->s_branch_id,
                'user_id' => $request->user_id,
                'is_active' => !is_null($request->is_active),
                'created_by' =>  auth()->id(),
                'updated_by' =>  auth()->id(),
            ]);

            $s_manager = SManager::create($params);
            $message = "Gerente creado correctamente";

            // dd($user, $s_coordinator, $message);

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_managers');
        }

        return $this->getResponse($status, $message, $s_manager);
    }

    public function edit(SManager $s_manager)
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $users = User::where("role_id", 21)->pluck("name","id");
        $user = $s_manager->user;
        $isEdit = true;

        $institutionDataTable = new InstitutionCommissionManagerDataTable($s_manager);
        $params = ['manager' => $s_manager];
        $institutionDT = $this->getViewDataTable($institutionDataTable, 'commissions', [], 'commissions.getInstitutionCommissionManagerDataTable', $params);

        $sUserNameDataTable = new SUserNameDataTable($s_manager->user);
        $params = ['user' => $s_manager->user];
        $sUserNameDT = $this->getViewDataTable($sUserNameDataTable, 'commissions', [], 'commissions.getSUserNameDataTable', $params);

        $institutions = Institution::where("is_active", 1)->orderBy("name", "asc")->pluck("name", "id");

        return view('s_managers.edit', compact("s_manager", "user", "roles", "branches", "s_branches", "departaments", "isEdit", "institutionDT", "institutions", "sUserNameDT", "users"));
     
    }

    public function update(SManagerRequest $request, SManager $s_manager)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
            'is_broker' => $request->has('is_broker') ? 1 : 0, 
            'updated_by' =>  auth()->id(),
        ]);

        try {
            $s_manager->update($params);
            if ($params["is_active"] == 0) {
                $s_manager->user->update(["is_active" => false]);
            }else if ($params["is_active"] == 1) {
                $s_manager->user->update(["is_active" => true]);
            }
            $message = "Gerente modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_managers');
        }

        return $this->getResponse($status, $message, $s_manager);
    }
    

    public function show(SManager $s_manager)
    {
    }

    public function destroy(SManager $s_manager)
    {
        $status = true;
        try {
            $s_manager->update(["is_active" => false]);
            $s_manager->user->update(["is_active" => false]);
            $message = "Gerente desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_managers');
        }
        return $this->getResponse($status, $message);
    }

     
   
}
