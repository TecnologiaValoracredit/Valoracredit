<?php

namespace App\Http\Controllers;
use App\Models\SCoordinator;
use App\Models\SPromotor;
use App\Models\Role;
use App\Models\Departament;
use App\Models\Branch;
use App\Models\SBranch;
use App\Models\User;
use App\Models\PermissionModule;
use Illuminate\Support\Facades\Hash;
use App\DataTables\SPromotorDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SPromotorRequest;
use Illuminate\Http\Request;

use App\Models\Institution;

use App\DataTables\SCoordinatorDataTable;
use App\DataTables\InstitutionCommissionDataTable;
use App\DataTables\SUserNameDataTable;

class SPromotorController extends Controller
{
    public function index(SPromotorDataTable $dataTable )
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("s_promotors.create");
       
        return $dataTable->render('s_promotors.index', compact("allowAdd"));
    }

    public function create()
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $s_coordinators = SCoordinator::where("is_active", 1)
                                        ->with('user')
                                        ->get()
                                        ->pluck('user.name', 'id');

        $isEdit = false;

        
        return view('s_promotors.create', compact('roles', 'branches', 's_branches','departaments', 's_coordinators', 'isEdit'));

    }

    public function store(SPromotorRequest $request)
    {
        $status = true;
        $s_promotor = null;

        $userParams = array_merge($request->all(), [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => 12,
            'is_active' => !is_null($request->is_active),
        ] );  

        try {
            $user = User::create($userParams);

            $params = array_merge($request->all(), [
                'commission_percentage' => $request->commission_percentage,
                's_branch_id' => $request->s_branch_id,
                'user_id' => $user->id,
                's_coordinator_id' => $request->s_coordinator_id,
                'is_active' => !is_null($request->is_active),
            ]);

            $s_promotor = SPromotor::create($params);
            $message = "Coordinador creado correctamente";

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_promotors');
        }

        return $this->getResponse($status, $message, $s_promotor);
    }   

    public function edit(SPromotor $s_promotor)
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $s_coordinators = SCoordinator::where("is_active", 1)
                                        ->with('user')
                                        ->get()
                                        ->pluck('user.name', 'id');

        $isEdit = true;

        $institutionDataTable = new InstitutionCommissionDataTable($s_promotor->user);
        $params = ['user' => $s_promotor->user];
        $institutionDT = $this->getViewDataTable($institutionDataTable, 'commissions', [], 'commissions.getInstitutionCommissionDataTable', $params);

        $sUserNameDataTable = new SUserNameDataTable($s_promotor->user);
        $params = ['user' => $s_promotor->user];
        $sUserNameDT = $this->getViewDataTable($sUserNameDataTable, 'commissions', [], 'commissions.getSUserNameDataTable', $params);

        $institutions = Institution::where("is_active", 1)->orderBy("name", "asc")->pluck("name", "id");

        return view('s_promotors.edit', compact("s_promotor", 'roles', 'branches', 's_branches','departaments', 'isEdit', 'institutionDT', 'sUserNameDT', 'institutions', 's_coordinators'));
        
     
    }

    public function update(SPromotorRequest $request, SPromotor $s_promotor)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
        ]);
    
        try {
            $s_promotor->update($params);
            $s_promotor->user->update(["name" => $params["name"]]);
            if ($params["is_active"] == 0) {
                $s_promotor->user->update(["is_active" => false]);
            }else if ($params["is_active"] == 1) {
                $s_promotor->user->update(["is_active" => true]);
            }
            $message = "Clasificación modificada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_promotors');
        }
    
        return $this->getResponse($status, $message, $s_promotor);
    }
    

    public function show(SPromotor $s_promotor)
    {
    }

    public function destroy(SPromotor $s_promotor)
    {
        $status = true;
        try {
            $s_promotor->update(["is_active" => false]);
            $s_promotor->user->update(["is_active" => false]);
            $message = "Clasificación desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_promotors');
        }
        return $this->getResponse($status, $message);
    }
}
