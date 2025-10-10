<?php

namespace App\Http\Controllers;

use App\DataTables\SCollaboratorDataTable;
use App\Http\Requests\SCollaboratorRequest;
use App\Models\SCollaborator;
use App\Models\Role;
use App\Models\Branch;
use App\Models\SBranch;
use App\Models\Departament;
use App\Models\User;
use App\Http\Requests\StoreSCollaboratorRequest;
use App\Http\Requests\UpdateSCollaboratorRequest;

class SCollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SCollaboratorDataTable $dataTable )
    {
        $allowAdd = auth()->user()->hasPermissions("s_collaborators.create");
       
        return $dataTable->render('s_collaborators.index', compact("allowAdd"));
    }

   
    public function create()
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $users = User::where("role_id", 20)->pluck("name","id");
        $isEdit = false;

        return view('s_collaborators.create', compact('roles', 'branches', 's_branches', 'departaments', 'isEdit', 'users'));
    }

   
    public function store(SCollaboratorRequest $request)
    {
        $status = true;
        $s_collaborator = null;
        try {
            $params = array_merge($request->all(), [
                'commission_percentage' => $request->commission_percentage ?? 0,
                's_branch_id' => $request->s_branch_id,
                'user_id' => $request->user_id,
                'is_active' => !is_null($request->is_active),
                'created_by' =>  auth()->id(),
                'updated_by' =>  auth()->id(),
            ]);

            $s_collaborator = SCollaborator::create($params);
            $message = "Colaborador creado correctamente";

            // dd($user, $s_coordinator, $message);

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_collaborators');
        }

        return $this->getResponse($status, $message, $s_collaborator);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SCollaborator  $sCollaborator
     * @return \Illuminate\Http\Response
     */
    // public function show(SCollaborator $sCollaborator)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SCollaborator  $s_collaborator
     */
    public function edit(SCollaborator $s_collaborator)
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $s_branches = SBranch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $users = User::where("role_id", 20)->pluck("name","id");

        $user = $s_collaborator->user;
        $isEdit = true;

        return view('s_collaborators.edit', compact("s_collaborator", "user", "roles", "branches", "s_branches", "departaments", "isEdit", "users"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSCollaboratorRequest  $request
     * @param  \App\Models\SCollaborator  $sCollaborator
     * @return \Illuminate\Http\Response
     */
    public function update(SCollaboratorRequest $request, SCollaborator $s_collaborator)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => $request->has('is_active') ? 1 : 0, 
            'updated_by' =>  auth()->id(),
        ]);

        try {
            $s_collaborator->update($params);
            if ($params["is_active"] == 0) {
                $s_collaborator->user->update(["is_active" => false]);
            }else if ($params["is_active"] == 1) {
                $s_collaborator->user->update(["is_active" => true]);
            }
            $message = "Colaborador modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_collaborators');
        }

        return $this->getResponse($status, $message, $s_collaborator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SCollaborator  $sCollaborator
     * @return \Illuminate\Http\Response
     */
    public function destroy(SCollaborator $s_collaborator)
    {
        $status = true;
        try {
            $s_collaborator->update(["is_active" => false]);
            $s_collaborator->user->update(["is_active" => false]);
            $message = "Colaborador desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_collaborators');
        }
        return $this->getResponse($status, $message);
    }
}
