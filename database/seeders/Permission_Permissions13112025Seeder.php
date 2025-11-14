<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionPermission;

class Permission_Permissions13112025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i= 1; $i <= 7; $i++) {
            PermissionPermission::create([
                'module_id' => '41',
                'function_id' => $i
            ]);
        }
    }
}
