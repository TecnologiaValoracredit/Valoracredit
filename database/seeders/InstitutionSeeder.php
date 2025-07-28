<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institutions = array(
        array('id' => '1','name' => 'Prueba','created_at' => '2025-01-08 09:27:03','updated_at' => '2025-01-08 09:27:03','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '2','name' => 'SECCION 38','created_at' => '2025-01-08 09:27:12','updated_at' => '2025-01-08 09:27:12','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '3','name' => 'SECCION 5','created_at' => '2025-01-08 09:27:12','updated_at' => '2025-01-08 09:27:12','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '4','name' => 'SECTOR SALUD FEDERAL COAHUILA','created_at' => '2025-01-08 09:27:12','updated_at' => '2025-01-08 09:27:12','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '5','name' => 'SECTOR SALUD FEDERAL','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '6','name' => 'AYUNTAMIENTO CENTRO TABASCO','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '7','name' => 'SECCION 35','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '8','name' => 'SECCION 21','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '9','name' => 'BAJA CALIFORNIA MAGISTERIO','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '10','name' => 'SEDUZAC ZACATECAS','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '11','name' => 'SECTOR SALUD DURANGO','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '12','name' => 'COLEGIO ANGLO ESPAÑOL AC','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '13','name' => 'BAJA CALIFORNIA GOBIERNO DEL ESTADO','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '14','name' => 'SECCION 50','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '15','name' => 'SECTOR SALUD REGULARIZADO','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '16','name' => 'TELESECUNDARIAS DURANGO','created_at' => '2025-01-08 09:27:13','updated_at' => '2025-01-08 09:27:13','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '17','name' => 'GOBIERNO TABASCO','created_at' => '2025-01-08 09:27:14','updated_at' => '2025-01-08 09:27:14','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '18','name' => 'SALUD BAJA CALIFORNIA REGULARIZADOS','created_at' => '2025-01-08 09:27:21','updated_at' => '2025-01-08 09:27:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '19','name' => 'SALUD BAJA CALIFORNIA FORMALIZADO','created_at' => '2025-01-08 09:27:21','updated_at' => '2025-01-08 09:27:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '20','name' => 'ISSSTECALI','created_at' => '2025-01-08 09:27:21','updated_at' => '2025-01-08 09:27:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '21','name' => 'SALUD BAJA CALIFORNIA FEDERAL','created_at' => '2025-01-08 09:27:21','updated_at' => '2025-01-08 09:27:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '22','name' => 'CONGRESO - PODER LEGISLATIVO DEL ESTADO DE BC','created_at' => '2025-01-08 09:27:21','updated_at' => '2025-01-08 09:27:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '23','name' => 'AYUNTAMIENTO TIJUANA 2021-2024','created_at' => '2025-01-08 09:27:21','updated_at' => '2025-01-08 09:27:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '24','name' => 'AYUNTAMIENTO MEXICALI 2021-2024','created_at' => '2025-01-08 09:27:21','updated_at' => '2025-01-08 09:27:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '25','name' => 'SECTOR SALUD FORMALIZADO','created_at' => '2025-01-08 09:27:23','updated_at' => '2025-01-08 09:27:23','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '26','name' => 'SECTOR SALUD ESTATAL','created_at' => '2025-01-08 09:27:23','updated_at' => '2025-01-08 09:27:23','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '27','name' => 'IEA-AGUASCALIENTES','created_at' => '2025-01-17 16:22:19','updated_at' => '2025-01-17 16:22:19','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '28','name' => '','created_at' => '2025-01-17 16:38:54','updated_at' => '2025-01-17 16:38:54','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '29','name' => 'SNTE 38','created_at' => '2025-06-11 08:15:17','updated_at' => '2025-06-11 08:15:17','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '30','name' => 'SNTE 21','created_at' => '2025-06-11 08:15:17','updated_at' => '2025-06-11 08:15:17','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '31','name' => 'SNTE 5','created_at' => '2025-06-11 08:15:17','updated_at' => '2025-06-11 08:15:17','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '32','name' => 'SNTE 37','created_at' => '2025-06-11 08:15:21','updated_at' => '2025-06-11 08:15:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '33','name' => 'WS PROMOTORA','created_at' => '2025-07-01 10:47:04','updated_at' => '2025-07-01 10:47:04','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '34','name' => 'MONDELEZ','created_at' => '2025-07-11 05:39:59','updated_at' => '2025-07-11 05:39:59','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL)
        ); 
        
        foreach ($institutions as $key => $institution) {
            Institution::create([
                'id' => $institution["id"],
                'name' => $institution["name"], 
                'created_at' => $institution["created_at"],
                'updated_at' => $institution["updated_at"], 
                'is_active' => $institution["is_active"], 
            ]);
        }
    }
}
