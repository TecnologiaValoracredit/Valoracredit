<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;

class PermissionPermissionRole28052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::where('name', '!=', 'Admin')->get();

        $vacationsCrudPermissionPermissions = $this->getPermissionPermissions(['vacations'], ['send', 'changeStatus', 'approve', 'deny', 'exportPdf', 'cancel']);

        foreach ($roles as $role) {
            foreach ($vacationsCrudPermissionPermissions as $key => $permission) {
                PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => $role->id]);
            }
        }

        $hrRole = Role::where('name', '=', 'Recursos Humanos')->where('is_active', '=', true)->first();
        $seeAllVacationsPermissionPermission = $this->getPermissionPermissions(['vacations'], ['seeAllVacations'], false);

        foreach ($seeAllVacationsPermissionPermission as $key => $permission) {
            PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => $hrRole->id]);
        }

        $vacationBalancesAndPoliciesPermissionPermissions = $this->getPermissionPermissions(['vacation_balances', 'vacation_policies']);
        foreach ($vacationBalancesAndPoliciesPermissionPermissions as $key => $permission) {
            PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => $hrRole->id]);
        }
    }

    private function getPermissionPermissions($modules = [], $functions = [], $addCrud = true){
        $permission_permissions = [];
        
        $defaultFunctions = ["index","store","create","show","update","destroy","edit"];
        if ($addCrud) {
            $functions = array_merge($defaultFunctions, $functions);
        }

        $modules = PermissionModule::where('module_type_id', 2)->whereIn('name', $modules)->get();
        $functions = PermissionFunction::whereIn('name', $functions)->get();

        foreach ($modules as $key => $module) {
            foreach ($functions as $key => $function) {
                $permission_permission = PermissionPermission::where('module_id', $module->id)->where('function_id', $function->id)->first();
                array_push($permission_permissions, $permission_permission);
            }
        }

        return $permission_permissions;
    }
}
