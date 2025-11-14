<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;

class PermissionPermissionRole14112025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //All permissions for role 1 = Admin
		$modules = PermissionModule::whereIn('name', ['job_positions'])->get('id');
        $permissions = PermissionPermission::whereIn("module_id", $modules)->get();

		foreach ($permissions as $key => $permission) {
			PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => 1]);
		}

        // //Seeder corregido de permisos de roles para contratos
		$modules = PermissionModule::whereIn('name', ['contracts'])->get('id');
        $permissions = PermissionPermission::whereIn("module_id", $modules)->get();

		foreach ($permissions as $key => $permission) {
			PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => 1]);
		}
    }
}
