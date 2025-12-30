<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;
use App\Models\Role;

class PermissionPermissionRole09122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hrAndAdminRoles = Role::whereIn('name', ['Admin', 'Recursos Humanos'])->get();
        $rolesWithoutAdminAndHr = Role::whereNotIn('name', ['Admin', 'Recursos Humanos'])->get();

        //Consigue los ids del modulo y funciones, para poder conseguir los ids de la tabla de permission permission.
        $permit_module = PermissionModule::where('name', 'permits')->first();
        $see_user_permits_function = PermissionFunction::where('name', 'seeUserPermits')->first();
        $see_all_permits_function = PermissionFunction::where('name', 'seeAllPermits')->first();

        //Consigue los ids de los permisos de ver permisos de usuario y RH, para despues removerlos de todos los permisos conseguidos
        $see_user_permits_permission = PermissionPermission::where('module_id', $permit_module->id)
        ->where('function_id', $see_user_permits_function->id)->first();
        $see_all__permits_permission = PermissionPermission::where('module_id', $permit_module->id)
        ->where('function_id', $see_all_permits_function->id)->first();

        
        $modules = PermissionModule::whereIn('name', ['permits'])->get('id');
        
        //Otorga CRUD y agrega SOLAMENTE el permiso de VER TODOS LOS PERMISOS a ADMIN Y RH
        $permissions = PermissionPermission::whereIn("module_id", $modules)->whereNotIn('id', [$see_user_permits_permission->id])->get();
        foreach ($hrAndAdminRoles as $role) {            
            foreach ($permissions as $key => $permission) {
                PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => $role->id]);
            }
        }
        
        
        //Otorga CRUD y agrega SOLAMENTE el permiso de VER PERMISOS DE USUARIO a todos los demas roles
        $permissions = PermissionPermission::whereIn("module_id", $modules)->whereNotIn('id', [$see_all__permits_permission->id])->get();
        foreach ($rolesWithoutAdminAndHr as $role) {
            foreach ($permissions as $key => $permission) {
                PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => $role->id]);
            }
        }
    }
}
