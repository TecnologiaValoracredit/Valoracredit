<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HDeviceType;

class HDeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $h_device_types = array(
  array('id' => '1','name' => 'Laptop','description' => 'Computadora portátil','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '2','name' => 'Pc','description' => 'Computadora de escritorio','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '3','name' => 'Celular','description' => 'Telefono inteligente','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '4','name' => 'Mouse','description' => 'Mouse','created_at' => '2025-02-11 16:48:42','updated_at' => '2025-02-11 17:17:41','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '5','name' => 'Teclado','description' => 'Teclado','created_at' => '2025-02-11 16:48:50','updated_at' => '2025-02-11 17:17:46','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '6','name' => 'Monitor','description' => 'Monitor','created_at' => '2025-02-11 16:49:00','updated_at' => '2025-02-11 17:17:38','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '7','name' => 'Silla sin cabecera','description' => 'Silla con llantas sin cabecera','created_at' => '2025-02-12 18:10:41','updated_at' => '2025-02-12 18:10:41','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '8','name' => 'Silla con cabecera','description' => 'Silla con cabecera','created_at' => '2025-02-12 18:22:59','updated_at' => '2025-02-12 18:22:59','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '9','name' => 'Escritorio Central','description' => 'Escritorio Central','created_at' => '2025-02-12 18:26:31','updated_at' => '2025-02-12 18:27:08','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '10','name' => 'Silla de plastico','description' => 'Silla de plastico duro','created_at' => '2025-02-13 09:29:50','updated_at' => '2025-02-13 09:29:50','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '11','name' => 'Escritorio Oficina','description' => 'Escritorio Oficina','created_at' => '2025-02-14 10:56:37','updated_at' => '2025-02-14 10:56:37','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '12','name' => 'Tarjeta acceso','description' => 'Tarjeta acceso elevador','created_at' => '2025-02-17 11:14:46','updated_at' => '2025-02-17 11:14:46','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '13','name' => 'Audifonos','description' => 'Audifonos de diadema','created_at' => '2025-03-03 09:37:11','updated_at' => '2025-03-03 09:37:11','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '14','name' => 'USB','description' => 'USB','created_at' => '2025-03-04 05:58:45','updated_at' => '2025-03-04 05:58:45','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '15','name' => 'CARGADOR LAPTOP','description' => '.','created_at' => '2025-05-13 04:50:21','updated_at' => '2025-05-13 04:50:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '16','name' => 'GRAPADORA','description' => '.','created_at' => '2025-05-13 05:30:24','updated_at' => '2025-05-13 05:30:24','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '17','name' => 'PERFORADORA','description' => '.','created_at' => '2025-05-13 05:32:58','updated_at' => '2025-05-13 05:32:58','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '18','name' => 'CALCULADORA','description' => '.','created_at' => '2025-05-13 06:06:44','updated_at' => '2025-05-13 06:06:44','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '19','name' => 'CARGADOR CELULAR','description' => '.','created_at' => '2025-05-13 11:35:46','updated_at' => '2025-05-13 11:35:46','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '20','name' => 'ADAPTADOR INTERNET','description' => '.','created_at' => '2025-05-13 11:39:18','updated_at' => '2025-05-13 11:39:18','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '21','name' => 'ADAPTADOR','description' => '.','created_at' => '2025-05-13 11:49:55','updated_at' => '2025-05-13 11:49:55','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '22','name' => 'TOKEN BBVA','description' => '.','created_at' => '2025-05-14 03:52:30','updated_at' => '2025-05-14 03:52:30','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '23','name' => 'TOKEN SANTANDER','description' => '.','created_at' => '2025-05-14 03:52:41','updated_at' => '2025-05-14 03:52:41','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '24','name' => 'INTERFONO','description' => '.','created_at' => '2025-05-19 04:46:21','updated_at' => '2025-05-19 04:46:21','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '25','name' => 'CONMUTADOR','description' => '.','created_at' => '2025-05-19 09:33:38','updated_at' => '2025-05-19 09:33:38','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '26','name' => 'MOCHILA','description' => '.','created_at' => '2025-05-29 11:17:26','updated_at' => '2025-05-29 11:17:26','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '27','name' => 'TECLADO NUMERICO','description' => '.','created_at' => '2025-05-29 11:19:14','updated_at' => '2025-05-29 11:19:14','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '28','name' => 'Teclado tablet','description' => 'Teclado para bluetooth/alámbrico pequeño y ligero para tablet','created_at' => '2025-07-11 03:29:15','updated_at' => '2025-07-11 03:29:15','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '29','name' => 'Mouse tablet','description' => 'Mouse pequeño bluetoooth para tablet','created_at' => '2025-07-11 03:29:59','updated_at' => '2025-07-11 03:29:59','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '30','name' => 'Tablet','description' => 'Tablet','created_at' => '2025-07-11 03:30:42','updated_at' => '2025-07-11 03:30:42','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
  array('id' => '31','name' => 'Cargador tablet','description' => 'Cargador para tablet','created_at' => '2025-07-11 03:44:45','updated_at' => '2025-07-11 03:44:45','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL)
);

        foreach ($h_device_types as $key => $h_device_type) {
            HDeviceType::create([
                'id' => $h_device_type["id"],
                'name' => $h_device_type["name"], 
                'description' => $h_device_type["description"], 
                'created_at' => $h_device_type["created_at"],
                'updated_at' => $h_device_type["updated_at"], 
                'is_active' => $h_device_type["is_active"], 
            ]);
        }

    }
}
