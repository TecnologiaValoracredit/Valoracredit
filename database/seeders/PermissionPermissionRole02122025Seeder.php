<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;

class PermissionPermissionRole02122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = PermissionModule::whereIn('name', ['contract_types'])->get('id');
        $permissions = PermissionPermission::whereIn("module_id", $modules)->get();

		foreach ($permissions as $key => $permission) {
			PermissionPermissionRole::create(["permission_id" => $permission->id, "role_id" => 1]);
		}
    }
}
