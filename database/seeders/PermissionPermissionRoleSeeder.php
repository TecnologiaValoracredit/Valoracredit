<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionPermissionRole;
use App\Models\PermissionModule;
use App\Models\PermissionPermission;

class PermissionPermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //All permissions for role 1 = Admin
		$modules = PermissionModule::get('id');
        $permissions = PermissionPermission::whereIn("module_id", $modules)->get();

		foreach ($permissions as $key => $permission) {
			PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => 1]);
		}
    }
}
