<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Departament;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Email;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("users.create");
        return $dataTable->render('users.index', compact("allowAdd"));
    }

    // Mostrar formulario de cambio de contraseña
    public function changePassword(User $user)
    {
        return view('users.changePassword', compact('user'));
    }

    public function setNewPassword(Request $request, User $user)
    {
        // Verificar que el usuario autenticado sea el mismo
        if (auth()->id() !== $user->id) {
            abort(403, 'No tienes permiso para cambiar la contraseña de este usuario.');
        }

        // Validar las contraseñas
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed|min:8',
        ]);
        

        // Verificar si la contraseña actual es correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Cambiar la contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('dashboard.index')->with('success', 'Contraseña cambiada exitosamente.');
    }

    

    public function create()
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        return view('users.create', compact('roles', 'branches', 'departaments'));
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
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        return view('users.edit', compact("user", "roles", "branches", "departaments"));
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
