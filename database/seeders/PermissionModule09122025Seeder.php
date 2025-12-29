<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule09122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permit_menu = PermissionModule::create(['name' => 'perm', 'description' => 'Permisos', 'module_type_id' => 1]);
        PermissionModule::create(['name' => 'permits', 'description' => 'Permisos', 'module_type_id' => 2, 'parent_id' => $permit_menu->id]);
    }
}
