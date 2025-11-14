<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionPermission;
use App\Models\PermissionPermissionRole;

class PermissionPermissionRole13112025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['permission_id' => 180, 'role_id' => 1],
            ['permission_id' => 181, 'role_id' => 1],
            ['permission_id' => 182, 'role_id' => 1],
            ['permission_id' => 183, 'role_id' => 1],
            ['permission_id' => 184, 'role_id' => 1],
            ['permission_id' => 185, 'role_id' => 1],
            ['permission_id' => 186, 'role_id' => 1],
        ];

        foreach ($values as $key => $value){
            PermissionPermissionRole::create([
                'permission_id' => $value['permission_id'],
                'role_id' => $value['role_id'],
            ]);
        }
    }
}
