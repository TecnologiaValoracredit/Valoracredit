<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\PermissionModule;
use App\DataTables\RolesDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        //obtener todos los roles, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("roles.create");
        return $dataTable->render('roles.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(RoleRequest $request)
    {
        $status = true;
		$role = null;

        $params = array_merge($request->all(), [
			'name' => $request->name,
            'descriptiom' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$role = Role::create($params);
			$message = "Rol creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'roles');
		}
        return $this->getResponse($status, $message, $role);

    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact("role"));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'descriptiom' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$role->update($params);
			$message = "Rol modificado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'roles');
		}
        return $this->getResponse($status, $message, $role);

    }

    public function show(Role $role)
    {
        $modules = PermissionModule::all();
        return view("roles.show", compact("role", "modules"));
    }

    public function destroy(Role $role)
    {
        $status = true;
        try {
            $role->update(["is_active" => false]);
            $message = "Rol desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'roles');
        }
        return $this->getResponse($status, $message);
    }

    public function savePermissions(Request $request, Role $role)
    {
        $status = true;
        try {
            $permissionsIds = array_keys($request->input('permission'));
            $role->permissionsRole()->sync($permissionsIds);
            $message = "Permisos guardados correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'roles');
        }
        return $this->getResponse($status, $message);
    }

}
