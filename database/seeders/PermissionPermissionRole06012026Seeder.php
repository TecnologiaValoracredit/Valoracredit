<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;
use App\Models\Role;

class PermissionPermissionRole06012026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersModule = PermissionModule::where('name', 'users')->first();
        $setNewSignatureFunction = PermissionFunction::where('name', 'setNewSignature')->first();
        $setNewSignaturePermission = PermissionPermission::where('module_id', $usersModule->id)
        ->where('function_id', $setNewSignatureFunction->id)->first();

        $roles = Role::all();
        foreach ($roles as $role) {
            if ($role->name == "Admin") continue;
            PermissionPermissionRole::create([
                "permission_id" => $setNewSignaturePermission->id,
                "role_id" => $role->id,
            ]);
        }
    }
}
