<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departament;

class DepartamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departaments = array(
            array('id' => '1','name' => 'Tecnología','description' => 'Departamento encargado de todo lo relacionado con tecnología, sistemas, redes, software, hardware y soporte técnico.','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '2','name' => 'Cartera','description' => 'Departamento encargado de todo lo relacionado con cartera, listados, llamadas de calidad','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '3','name' => 'Contaduria','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '4','name' => 'Operaciones','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '5','name' => 'Tesoreria','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '6','name' => 'Recursos Humanos','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '7','name' => 'Marketing','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '8','name' => 'Recepcionista','description' => NULL,'is_active' => '1','created_at' => '2025-02-04 11:36:17','updated_at' => '2025-02-04 11:36:17'),
            array('id' => '9','name' => 'Operaciones/Maxxas','description' => 'Operaciones/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:06:55','updated_at' => '2025-02-07 17:06:55'),
            array('id' => '10','name' => 'Tesoreria/Maxxas','description' => 'Tesoreria/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:07:03','updated_at' => '2025-02-07 17:07:03'),
            array('id' => '11','name' => 'Contador/Maxxas','description' => 'Contador/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:14:23','updated_at' => '2025-02-07 17:14:23'),
            array('id' => '12','name' => 'Facturación/Maxxas','description' => 'Facturación/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:17:10','updated_at' => '2025-02-07 17:17:10'),
            array('id' => '13','name' => 'X','description' => 'X','is_active' => '1','created_at' => '2025-02-12 18:12:45','updated_at' => '2025-02-12 18:12:45'),
            array('id' => '14','name' => 'Comercial','description' => NULL,'is_active' => '1','created_at' => '2025-03-20 10:59:40','updated_at' => '2025-03-20 10:59:40')
        );


        foreach ($departaments as $key => $departament) {
            Departament::create([
                'id' => $departament["id"],
                'name' => $departament["name"], 
                'description' => $departament["description"], 
                'created_at' => $departament["created_at"],
                'updated_at' => $departament["updated_at"], 
                'is_active' => $departament["is_active"], 
            ]);
        }

    }
}
