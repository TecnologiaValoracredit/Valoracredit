<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionModule::create(["name" => "dashboard", "description" => "Inicio", "module_type_id" => 2]);
        
        $personal = PermissionModule::create(["name" => "personal", "description" => "Usuarios", "module_type_id" => 1]);
        PermissionModule::create(["name" => "roles",  "description" => "Roles", "module_type_id" => 2, "parent_id" => $personal->id]);
        PermissionModule::create(["name" => "users",  "description" => "Usuarios", "module_type_id" => 2,"parent_id" => $personal->id]);
        PermissionModule::create(["name" => "departaments",  "description" => "Departamentos", "module_type_id" => 2,"parent_id" => $personal->id]);

        $expedients = PermissionModule::create(["name" => "exp", "description" => "Expedientes", "module_type_id" => 1]);
        PermissionModule::create(["name" => "expedients",  "description" => "Expedientes", "module_type_id" => 2, "parent_id" => $expedients->id]);
        PermissionModule::create(["name" => "exp_reports",  "description" => "Reporte", "module_type_id" => 2, "parent_id" => $expedients->id]);

        $requisitions = PermissionModule::create(["name" => "req", "description" => "Requisición", "module_type_id" => 1]);
        PermissionModule::create(["name" => "suppliers",  "description" => "Proveedores", "module_type_id" => 2, "parent_id" => $requisitions->id]);

    }
}
