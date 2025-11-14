<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionModule;
use App\Models\PermissionPermission;
use App\Models\PermissionFunction;


class Menu13112025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = Menu::where('name', 'Usuarios')->first();

        Menu::create([
            'name' => 'Contratos',
            'parent_id' => $users->id,
            'position' => 100.40,
            'permission_id' => $this->getPermissionId('contracts'),
        ]);
    }
        public function getPermissionId($module_name){
        $module = PermissionModule::where("name", $module_name)->first();

        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
