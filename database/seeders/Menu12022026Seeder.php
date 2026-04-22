<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;
use App\Models\PermissionPermission;

class Menu12022026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $req_menu = Menu::where("name", "Requisiciones")->where('parent_id', null)->first();

        Menu::create([
            "name" => "Globales",
            "parent_id" => $req_menu->id,
            "position" => 3.30,
            "permission_id" => $this->getPermissionId("requisition_globals"),
        ]);

        $expenses_menu = Menu::create([
            'name' => 'Gastos',
            'parent_id' => NULL,
            'position' => 9,
            'permission_id' => NULL,
        ]);

        Menu::create([
            'name' => 'Tipos de Gastos',
            'parent_id' => $expenses_menu->id,
            'position' => 9.10,
            'permission_id' => $this->getPermissionId('expense_types'),
        ]);

        //MENU DE GASTOS FIJOS COMENTADO YA QUE AUN NO ESTA TERMINADO PARA CRUD FUNCIONAL, SOLO PARA TRAER DATOS DE UN Gasto Recurrente
        // Menu::create([
        //     'name' => 'Gastos fijos',
        //     'parent_id' => $expenses_menu->id,
        //     'position' => 9.20,
        //     'permission_id' => $this->getPermissionId('fixed_expenses'),
        // ]);
    }

    public function getPermissionId($module_name){
        $module = PermissionModule::where("name", $module_name)->first();

        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
