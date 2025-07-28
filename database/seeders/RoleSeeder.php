<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            array('id' => '1','name' => 'Admin','description' => 'Admin','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '2','name' => 'Gerencia Cartera','description' => 'Encargados de cartera','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '3','name' => 'Tesorería','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '4','name' => 'Administración','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '5','name' => 'Contabilidad','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '6','name' => 'Recursos Humanos','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '7','name' => 'Cartera','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '8','name' => 'Marketing','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '9','name' => 'Tecnología','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '10','name' => 'Operaciones','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '11','name' => 'Cobranza','description' => '','is_active' => '1','created_at' => '2025-01-24 17:57:35','updated_at' => '2025-01-24 17:57:35'),
            array('id' => '12','name' => 'Dirección','description' => NULL,'is_active' => '1','created_at' => '2025-02-04 11:36:57','updated_at' => '2025-05-06 06:09:34'),
            array('id' => '13','name' => 'Tesoreria/Maxxas','description' => 'Tesoreria/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:06:36','updated_at' => '2025-02-07 17:06:36'),
            array('id' => '14','name' => 'Operaciones/Maxxas','description' => 'Operaciones/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:06:45','updated_at' => '2025-02-07 17:06:45'),
            array('id' => '15','name' => 'Contador/Maxxas','description' => 'Contador/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:14:14','updated_at' => '2025-02-07 17:14:14'),
            array('id' => '16','name' => 'Facturación/Maxxas','description' => 'Facturación/Maxxas','is_active' => '1','created_at' => '2025-02-07 17:17:03','updated_at' => '2025-02-07 17:17:03'),
            array('id' => '17','name' => 'X','description' => 'X','is_active' => '1','created_at' => '2025-02-12 18:12:13','updated_at' => '2025-02-12 18:12:13'),
            array('id' => '18','name' => 'Dirección general','description' => 'Dirección general','is_active' => '1','created_at' => '2025-02-24 12:07:24','updated_at' => '2025-02-24 12:07:24')
        );

        foreach ($roles as $key => $role) {
            Role::create([
                'id' => $role["id"],
                'name' => $role["name"], 
                'description' => $role["description"], 
                'created_at' => $role["created_at"],
                'updated_at' => $role["updated_at"], 
                'is_active' => $role["is_active"], 
            ]);
        }
        //19
        Role::create([
            "name" => "Promotor",
            "description" => ""
        ]);
        //20
        Role::create([
            "name" => "Coordinador",
            "description" => ""
        ]);
        
    }
}
