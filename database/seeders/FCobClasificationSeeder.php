<?php

namespace Database\Seeders;

use App\Models\FCobClasification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FCobClasificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f_cob_clasifications = array(
            array('id' => '1','name' => 'Cobranza despacho deal collection','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '2','name' => 'Cobranza institucional','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '3','name' => 'Cobranza telemarketing','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '4','name' => 'Liq. clientes','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '5','name' => 'Abono a cuenta','description' => NULL,'created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '6','name' => 'Cobranza por domiciliacion','description' => NULL,'created_at' => '2025-05-19 17:57:36','updated_at' => '2025-05-19 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '7','name' => 'Liq. por defunción','description' => NULL,'created_at' => '2025-06-13 17:57:36','updated_at' => '2025-06-13 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '8','name' => 'Cobranza despacho Kanan','description' => NULL,'created_at' => '2025-07-21 17:57:36','updated_at' => '2025-07-21 17:57:36','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL)
            );

        foreach ($f_cob_clasifications as $key => $f_cob_clasification) {
            FCobClasification::create([
                'id' => $f_cob_clasification["id"],
                'name' => $f_cob_clasification["name"], 
                'description' => $f_cob_clasification["description"], 
                'created_at' => $f_cob_clasification["created_at"],
                'updated_at' => $f_cob_clasification["updated_at"], 
                'is_active' => $f_cob_clasification["is_active"], 
            ]);
        }
    }
}
