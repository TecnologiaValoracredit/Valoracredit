<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
USE App\Models\PermissionModule;
USE App\Models\PermissionPermission;
USE App\Models\PermissionPermissionRole;
USE App\Models\PermissionFunction;

class PermissionPermissionRole20022026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = $this->getAllPermissionPermissionsFromModules(['expense_types', 'fixed_expenses']);
		foreach ($permissions as $permission) {
			PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => 1]);
		}

        $requisition_globals_permissions = $this->getPermissionPermissions(['requisition_globals'], ['changeStatus', 'updateStatus', 'send', 'sign']);
        foreach ($requisition_globals_permissions as $permission) {
            PermissionPermissionRole::create([
                'permission_id' => $permission->id,
                'role_id' => 1,
            ]);
        }
    }

    //HELPERS

    private function getPermissionPermissions($modules = [], $functions = []){
        $permission_permissions = [];
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

    private function getAllPermissionPermissionsFromModules($moduleNames = []){
        $modules = PermissionModule::whereIn('name', $moduleNames)->get('id');
        $permission_permissions = PermissionPermission::whereIn('module_id', $modules)->get();

        return $permission_permissions;
    }
}
