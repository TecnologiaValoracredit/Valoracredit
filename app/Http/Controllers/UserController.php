<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("users.create");
        return $dataTable->render('users.index', compact("allowAdd"));
    }

    public function create()
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        return view('users.create', compact("roles"));
    }

    
    public function store(UserRequest $request)
    {
        $status = true;
		$user = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role_id" => $request->role_id,
            'is_active' => !is_null($request->is_active),
		]);
        
		try {
            $user = User::create($params);
            $message = "Usuario creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'roles');
		}
        return $this->getResponse($status, $message, $user);
        
    }
    
    public function edit(User $user)
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        return view('users.edit', compact("user", "roles"));
    }
    
    public function update(UserRequest $request, User $user)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "email" => $request->email,
            "role_id" => $request->role_id,
            'is_active' => !is_null($request->is_active),
		]);
        unset($params["password"]);
        if ($request->password) {
            $params["password"] = Hash::make($request->password);
        }

        try {
            $user->update($params);
            $message = "Usuario modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'users');
        }
        return $this->getResponse($status, $message, $user);
    
    }

    public function destroy(User $user)
    {
        $status = true;
        try {
            $user->update(["is_active" => false]);
            $message = "Usuario desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'users');
        }
        return $this->getResponse($status, $message);
    }
    
}
