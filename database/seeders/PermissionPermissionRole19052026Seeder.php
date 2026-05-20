<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;

class PermissionPermissionRole19052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = $this->getAllPermissionPermissionsFromModules(['vacations','vacation_policies', 'vacation_balances']);
		foreach ($permissions as $permission) {
			PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => 1]);
		}
    }

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
