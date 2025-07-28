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
        $menus = array(
        array('id' => '1','name' => 'Inicio','icon' => NULL,'parent_id' => NULL,'position' => '0.90','permission_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '2','name' => 'Expedientes','icon' => NULL,'parent_id' => NULL,'position' => '1.00','permission_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '3','name' => 'Expedientes','icon' => NULL,'parent_id' => '2','position' => '1.10','permission_id' => '25','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '4','name' => 'Reporte','icon' => NULL,'parent_id' => '2','position' => '1.20','permission_id' => '29','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '5','name' => 'Checklist','icon' => NULL,'parent_id' => '2','position' => '1.30','permission_id' => '30','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '6','name' => 'Ventas','icon' => NULL,'parent_id' => NULL,'position' => '2.00','permission_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '7','name' => 'Ventas','icon' => NULL,'parent_id' => '6','position' => '2.10','permission_id' => '58','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '8','name' => 'Reporte general','icon' => NULL,'parent_id' => '6','position' => '2.30','permission_id' => '59','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '9','name' => 'Reporte por institución','icon' => NULL,'parent_id' => '6','position' => '2.40','permission_id' => '60','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '10','name' => 'Reporte mensual','icon' => NULL,'parent_id' => '6','position' => '2.50','permission_id' => '61','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '11','name' => 'Coordinadores','icon' => NULL,'parent_id' => '6','position' => '2.20','permission_id' => '119','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '12','name' => 'Reporte coordinadores','icon' => NULL,'parent_id' => '6','position' => '2.60','permission_id' => '62','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '13','name' => 'Usuarios','icon' => NULL,'parent_id' => NULL,'position' => '100.00','permission_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '14','name' => 'Roles','icon' => NULL,'parent_id' => '13','position' => '100.10','permission_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '15','name' => 'Departamentos','icon' => NULL,'parent_id' => '13','position' => '100.20','permission_id' => '16','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '16','name' => 'Usuarios','icon' => NULL,'parent_id' => '13','position' => '100.30','permission_id' => '9','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '17','name' => 'Requisiciones','icon' => NULL,'parent_id' => NULL,'position' => '3.00','permission_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '18','name' => 'Proveedores','icon' => NULL,'parent_id' => '17','position' => '3.10','permission_id' => '37','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '19','name' => 'Sucursales','icon' => NULL,'parent_id' => '17','position' => '3.20','permission_id' => '44','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '20','name' => 'Requisiciones','icon' => NULL,'parent_id' => '17','position' => '3.20','permission_id' => '51','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '21','name' => 'Flujo','icon' => NULL,'parent_id' => NULL,'position' => '4.00','permission_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '22','name' => 'Flujo','icon' => NULL,'parent_id' => '21','position' => '4.10','permission_id' => '85','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '23','name' => 'Cuentas','icon' => NULL,'parent_id' => '21','position' => '4.20','permission_id' => '92','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '24','name' => 'Beneficiarios','icon' => NULL,'parent_id' => '21','position' => '4.30','permission_id' => '99','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '25','name' => 'Clasificaciones','icon' => NULL,'parent_id' => '21','position' => '4.40','permission_id' => '112','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '26','name' => 'Reportes','icon' => NULL,'parent_id' => '21','position' => '4.50','permission_id' => '109','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '27','name' => 'Activos','icon' => NULL,'parent_id' => NULL,'position' => '5.00','permission_id' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '28','name' => 'Activos','icon' => NULL,'parent_id' => '27','position' => '5.10','permission_id' => '63','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '29','name' => 'Tipos de Activos','icon' => NULL,'parent_id' => '27','position' => '5.20','permission_id' => '70','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '30','name' => 'Marcas de Activos','icon' => NULL,'parent_id' => '27','position' => '5.30','permission_id' => '77','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
        array('id' => '31','name' => 'Reporte ranking','icon' => NULL,'parent_id' => '6','position' => '2.70','permission_id' => '133','created_at' => '2025-06-26 10:25:47','updated_at' => '2025-06-26 10:25:47'),
        array('id' => '32','name' => 'Reporte indicadores','icon' => NULL,'parent_id' => '6','position' => '2.80','permission_id' => '134','created_at' => '2025-07-18 10:33:53','updated_at' => '2025-07-18 10:33:53')
        );
        
        foreach ($menus as $key => $menu) {
            Menu::create([
                'id' => $menu["id"],
                'name' => $menu["name"], 
                'icon' => $menu["icon"], 
                'parent_id' => $menu["parent_id"], 
                'position' => $menu["position"], 
                'permission_id' => $menu["permission_id"], 
                'created_at' => $menu["created_at"],
                'updated_at' => $menu["updated_at"], 
            ]);
        }
    }

}
