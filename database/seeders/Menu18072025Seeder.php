<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionPermission;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;

class Menu18072025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Menu::where("position" , 2.2)->delete();


        $commission = Menu::create([
            "name" => "Comisiones",
            "parent_id" => null,
            "position" => 6,
        ]);
        Menu::create([
            "name" => "Coordinadores",
            "parent_id" => $commission->id,
            "position" => 6.1,
            "permission_id" => $this->getPermissionId(module_name: "s_coordinators")
        ]);

        Menu::create([
            "name" => "Promotores",
            "parent_id" => $commission->id,
            "position" => 6.2,
            "permission_id" => $this->getPermissionId("s_promotors")
        ]);

        Menu::create([
            "name" => "Comisiones",
            "parent_id" => $commission->id,
            "position" => 6.3,
            "permission_id" => $this->getPermissionId("commissions")
        ]);
        
        $s_sales = Menu::where("name", "Ventas")->first();
        Menu::create([
            "name" => "Sucursales CrediSoft",
            "parent_id" => $s_sales->id,
            "position" => 2.8,
            "permission_id" => $this->getPermissionId("s_branches")
        ]);

    }
    public function getPermissionId($module_name){
        $module = PermissionModule::where("name", $module_name)->first();

        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
