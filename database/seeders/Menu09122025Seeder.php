<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;


class Menu09122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permit_menu = Menu::create([
            'name' => 'Permisos',
            'parent_id' => NULL,
            'position' => 8,
            'permission_id' => NULL,
        ]);

        Menu::create([
            'name' => 'Permisos',
            'parent_id' => $permit_menu->id,
            'position' => 8.10,
            'permission_id' => $this->getPermissionId('permits'),
        ]);
    }

    public function getPermissionId($module_name){
        $module = PermissionModule::where("name", $module_name)->first();

        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
