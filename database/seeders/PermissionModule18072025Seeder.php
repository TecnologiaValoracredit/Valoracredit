<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;


class PermissionModule18072025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_modules = array(
  array('id' => '1','name' => 'dashboard','description' => 'Inicio','module_type_id' => '2','parent_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '2','name' => 'personal','description' => 'Usuarios','module_type_id' => '1','parent_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '3','name' => 'roles','description' => 'Roles','module_type_id' => '2','parent_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '4','name' => 'users','description' => 'Usuarios','module_type_id' => '2','parent_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '5','name' => 'departaments','description' => 'Departamentos','module_type_id' => '2','parent_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '6','name' => 'exp','description' => 'Expedientes','module_type_id' => '1','parent_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '7','name' => 'expedients','description' => 'Expedientes','module_type_id' => '2','parent_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '8','name' => 'exp_reports','description' => 'Reporte','module_type_id' => '2','parent_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '9','name' => 'chk_checklists','description' => 'Checklist','module_type_id' => '2','parent_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '10','name' => 'req','description' => 'Requisición','module_type_id' => '1','parent_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '11','name' => 'suppliers','description' => 'Proveedores','module_type_id' => '2','parent_id' => '10','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '12','name' => 'branches','description' => 'Sucursales','module_type_id' => '2','parent_id' => '10','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '13','name' => 'requisitions','description' => 'Requisiciones','module_type_id' => '2','parent_id' => '10','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '14','name' => 's_sal','description' => 'Ventas','module_type_id' => '1','parent_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '15','name' => 's_sales','description' => 'Ventas','module_type_id' => '2','parent_id' => '14','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '16','name' => 's_coordinators','description' => 'Coordinadores','module_type_id' => '2','parent_id' => '14','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '17','name' => 's_general_reports','description' => 'Reporte general','module_type_id' => '2','parent_id' => '14','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '18','name' => 's_institution_reports','description' => 'Reporte por institución','module_type_id' => '2','parent_id' => '14','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '19','name' => 's_mensual_reports','description' => 'Reporte mensual','module_type_id' => '2','parent_id' => '14','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '20','name' => 's_coordinator_reports','description' => 'Reporte coordinadores','module_type_id' => '2','parent_id' => '14','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '21','name' => 'h_hardw','description' => 'Hardware','module_type_id' => '1','parent_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '22','name' => 'h_hardwares','description' => 'Hardware','module_type_id' => '2','parent_id' => '21','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '23','name' => 'h_device_types','description' => 'Tipos de hardware','module_type_id' => '2','parent_id' => '21','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '24','name' => 'h_brands','description' => 'Marcas','module_type_id' => '2','parent_id' => '21','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '25','name' => 'f_flu','description' => 'Flujo','module_type_id' => '1','parent_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '26','name' => 'f_fluxes','description' => 'Flujo','module_type_id' => '2','parent_id' => '25','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '27','name' => 'f_accounts','description' => 'Cuentas','module_type_id' => '2','parent_id' => '25','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '28','name' => 'f_beneficiaries','description' => 'Beneficiarios','module_type_id' => '2','parent_id' => '25','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '29','name' => 'f_clasifications','description' => 'Clasificaciones','module_type_id' => '2','parent_id' => '25','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '30','name' => 'f_flux_reports','description' => 'Clasificaciones','module_type_id' => '2','parent_id' => '25','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '31','name' => 's_promotor_reports','description' => 'Reporte rankings','module_type_id' => '2','parent_id' => '14','created_at' => '2025-06-26 10:25:47','updated_at' => '2025-06-26 10:25:47'),
  array('id' => '32','name' => 'r_indicators','description' => 'Reporte indicadores','module_type_id' => '2','parent_id' => '14','created_at' => '2025-07-18 10:33:53','updated_at' => '2025-07-18 10:33:53')
);
        foreach ($permission_modules as $key => $permission_module) {
            PermissionModule::create([
                'id' => $permission_module["id"],
                'name' => $permission_module["name"], 
                'description' => $permission_module["description"], 
                'module_type_id' => $permission_module["module_type_id"], 
                'parent_id' => $permission_module["parent_id"], 
                'created_at' => $permission_module["created_at"],
                'updated_at' => $permission_module["updated_at"], 
            ]);
        }
        $commissions = PermissionModule::create(["name" => "com", "description" => "Comisiones", "module_type_id" => 1]);
        PermissionModule::create(["name" => "s_coordinators",  "description" => "Coordinadores", "module_type_id" => 2, "parent_id" => $commissions->id]);
        PermissionModule::create(["name" => "s_promotors",  "description" => "Promotores", "module_type_id" => 2, "parent_id" => $commissions->id]);
        PermissionModule::create(["name" => "commissions",  "description" => "Comisiones", "module_type_id" => 2, "parent_id" => $commissions->id]);

        $s_sales = PermissionModule::where("name", "s_sal")->where("module_type_id", 1)->first();
        PermissionModule::create(["name" => "s_branches",  "description" => "Sucursales dadas de alta en CrediSoft", "module_type_id" => 2, "parent_id" => $s_sales->id]);

    }
}
