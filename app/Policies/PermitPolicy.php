<?php

namespace App\Policies;

use App\Models\Permit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Permit $permit)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Permit $permit)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Permit $permit)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Permit $permit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Permit $permit)
    {
        //
    }

    public function edit(User $user, Permit $permit){
        //Checa si el usuario que quiere editar es el mismo que solicitó el permiso
        //Y
        //Checa si el permiso ha sido solamente creado.
        return ($user->id == $permit->user_id) 
        && ($permit->permitStatus->name == "Creado");
    }

    public function changePermitStatus(User $user, Permit $permit) {
        //Checa si el usuario es el jefe del permiso O recursos humanos
        //Y
        //Checa si el permiso fue enviado y si esta en revisión
        //Y
        //Checa si RH o Jefe Inmediato no ha autorizado aun el permiso
        $isHr = auth()->user()->hasPermissions('permits.seeAllPermits');
        $signature = 'is_signed_by_' . ($isHr ? 'hr' : 'boss');

        return (($user->id == $permit->boss_id || $user->hasPermissions('permits.seeAllPermits')) 
        && in_array($permit->permitStatus->name, ["Enviado", "En revisión"])
        && !$permit->$signature);
    }
}
