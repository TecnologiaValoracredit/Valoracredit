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
        PermissionModule::create(["name" => "chk_checklists",  "description" => "Checklist", "module_type_id" => 2, "parent_id" => $expedients->id]);

        $requisitions = PermissionModule::create(["name" => "req", "description" => "Requisición", "module_type_id" => 1]);
        PermissionModule::create(["name" => "suppliers",  "description" => "Proveedores", "module_type_id" => 2, "parent_id" => $requisitions->id]);
        PermissionModule::create(["name" => "branches",  "description" => "Sucursales", "module_type_id" => 2, "parent_id" => $requisitions->id]);
        PermissionModule::create(["name" => "requisitions",  "description" => "Requisiciones", "module_type_id" => 2, "parent_id" => $requisitions->id]);
   
        $sales = PermissionModule::create(["name" => "s_sal", "description" => "Ventas", "module_type_id" => 1]);
        PermissionModule::create(["name" => "s_sales",  "description" => "Ventas", "module_type_id" => 2, "parent_id" => $sales->id]);
        PermissionModule::create(["name" => "s_general_reports",  "description" => "Reporte general", "module_type_id" => 2, "parent_id" => $sales->id]);
        PermissionModule::create(["name" => "s_institution_reports",  "description" => "Reporte por institución", "module_type_id" => 2, "parent_id" => $sales->id]);
        PermissionModule::create(["name" => "s_mensual_reports",  "description" => "Reporte mensual", "module_type_id" => 2, "parent_id" => $sales->id]);

        $h_hardwares = PermissionModule::create(["name" => "h_hardw", "description" => "Hardware", "module_type_id" => 1]);
        PermissionModule::create(["name" => "h_hardwares",  "description" => "Hardware", "module_type_id" => 2, "parent_id" => $h_hardwares->id]);
        PermissionModule::create(["name" => "h_device_types",  "description" => "Tipos de hardware", "module_type_id" => 2, "parent_id" => $h_hardwares->id]);
        PermissionModule::create(["name" => "h_brands",  "description" => "Marcas", "module_type_id" => 2, "parent_id" => $h_hardwares->id]);

    }
}
