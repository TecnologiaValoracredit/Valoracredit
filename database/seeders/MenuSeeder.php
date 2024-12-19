<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionPermission;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Menu::create([
            "name" => "Inicio",
            "parent_id" => null,
            "position" => 0.9,
            "permission_id" => $this->getPermissionId("dashboard")
        ]);

        //Si es un menu que tiene hijos este no tendrá permisos, ya que solo será para desplegar los hijos
        $exp = Menu::create([
            "name" => "Expedientes",
            "parent_id" => null,
            "position" => 1,
        ]);

        Menu::create([
            "name" => "Expedientes",
            "parent_id" => $exp->id,
            "position" => 1.1,
            "permission_id" => $this->getPermissionId("expedients")
        ]);

        Menu::create([
            "name" => "Reporte",
            "parent_id" => $exp->id,
            "position" => 1.2,
            "permission_id" => $this->getPermissionId("exp_reports")
        ]);
        
        //Si es un menu que tiene hijos este no tendrá permisos, ya que solo será para desplegar los hijos
        $users = Menu::create([
            "name" => "Usuarios",
            "parent_id" => null,
            "position" => 2,
        ]);

        Menu::create([
            "name" => "Roles",
            "parent_id" => $users->id,
            "position" => 2.1,
            "permission_id" => $this->getPermissionId("roles")
        ]);

        Menu::create([
            "name" => "Departamentos",
            "parent_id" => $users->id,
            "position" => 2.2,
            "permission_id" => $this->getPermissionId("departaments")
        ]);

        Menu::create([
            "name" => "Usuarios",
            "parent_id" => $users->id,
            "position" => 2.3,
            "permission_id" => $this->getPermissionId("users")
        ]);

        $req = Menu::create([
            "name" => "Requisiciones",
            "parent_id" => null,
            "position" => 3,
        ]);
        Menu::create([
            "name" => "Proveedores",
            "parent_id" => $req->id,
            "position" => 3.1,
            "permission_id" => $this->getPermissionId("suppliers")
        ]);

    }

    private function getPermissionId($module_name){
        $module = PermissionModule::where("name", $module_name)->first();
        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
