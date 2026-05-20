<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class Menu19052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vac_menu = Menu::create([
            'name' => 'Vacaciones',
            'parent_id' => NULL,
            'position' => 10,
            'permission_id' => NULL,
        ]);

        Menu::create([
            'name' => 'Vacaciones',
            'parent_id' => $vac_menu->id,
            'position' => 10.10,
            'permission_id' => $this->getPermissionId('vacations'),
        ]);

        Menu::create([
            'name' => 'Políticas',
            'parent_id' => $vac_menu->id,
            'position' => 10.20,
            'permission_id' => $this->getPermissionId('vacation_policies'),
        ]);

        Menu::create([
            'name' => 'Balances',
            'parent_id' => $vac_menu->id,
            'position' => 10.30,
            'permission_id' => $this->getPermissionId('vacation_balances'),
        ]);
    }

    public function getPermissionId($module_name){
        $module = PermissionModule::where("name", $module_name)->first();

        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
