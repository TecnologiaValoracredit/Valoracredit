<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;


class Menu17042026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expenses_menu = Menu::where("name", "Gastos")->where('parent_id', null)->first();

        Menu::create([
            'name' => 'Gastos recurrentes',
            'parent_id' => $expenses_menu->id,
            'position' => 9.20,
            'permission_id' => $this->getPermissionId('fixed_expenses'),
        ]);
    }

    public function getPermissionId($module_name){
        $module = PermissionModule::where("name", $module_name)->first();

        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
