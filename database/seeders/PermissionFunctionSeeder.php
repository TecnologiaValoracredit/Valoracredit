<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permission_functions = array(
  array('id' => '1','name' => 'index','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '2','name' => 'create','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '3','name' => 'store','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '4','name' => 'edit','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '5','name' => 'update','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '6','name' => 'show','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '7','name' => 'destroy','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '8','name' => 'setNewPassword','description' => 'Permiso para cambiar la contraseña de un usuario','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '9','name' => 'changePassword','description' => 'Permiso para cambiar la contraseña de un usuario','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '10','name' => 'changeStats','description' => 'Permiso para cambiar el estado de flujo','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '11','name' => 'showIncome','description' => 'Permiso para ver ingresos','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '12','name' => 'showExpenses','description' => 'Permiso para ver egresos','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '13','name' => 'generateQrCode','description' => 'Crear qr en los activos','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '14','name' => 'exportAdminReport','description' => 'Exportar reporte administrativo a excel','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '15','name' => 'exportAdminReport','description' => 'Exportar reporte administrativo de flujos (más completo)','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '16','name' => 'uploadExpedientsAbc','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '17','name' => 'getDataAutocomplete','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '18','name' => 'exportFluxReport','description' => 'Exportar reporte de flujos ','created_at' => '2025-01-31 11:09:31','updated_at' => '2025-01-31 11:09:31'),
  array('id' => '19','name' => 'storeFromExcel','description' => 'Guardar flujo desde excel','created_at' => '2025-03-14 11:12:26','updated_at' => '2025-03-14 11:12:26'),
  array('id' => '20','name' => 'changeCarteraStatus','description' => 'Cambiar estatus en cartera','created_at' => '2025-03-14 11:12:26','updated_at' => '2025-03-14 11:12:26'),
  array('id' => '21','name' => 'createFromExcel','description' => 'Vista de importar desde excel','created_at' => '2025-03-14 11:12:26','updated_at' => '2025-03-14 11:12:26'),
  array('id' => '22','name' => 'importExcel','description' => 'Importar excel de STP','created_at' => '2025-03-14 11:12:26','updated_at' => '2025-03-14 11:12:26'),
  array('id' => '23','name' => 'getAddModal','description' => 'Ver modal de agregar','created_at' => '2025-03-14 11:12:26','updated_at' => '2025-03-14 11:12:26')
);

        foreach ($permission_functions as $key => $permission_function) {
            PermissionFunction::create([
                'id' => $permission_function["id"],
                'name' => $permission_function["name"], 
                'description' => $permission_function["description"], 
                'created_at' => $permission_function["created_at"],
                'updated_at' => $permission_function["updated_at"], 
            ]);
        }

    }
}
