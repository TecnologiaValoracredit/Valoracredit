<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HBrand;

class HBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $h_brands = array(
            array('id' => '1','name' => 'Hp','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '2','name' => 'Lenovo','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '3','name' => 'Dell','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '4','name' => 'MSI','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '5','name' => 'Apple','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '100','name' => 'Otro','created_at' => '2025-01-27 11:21:06','updated_at' => '2025-01-27 11:21:06','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '101','name' => 'Acer','created_at' => '2025-02-11 17:20:12','updated_at' => '2025-02-11 17:20:12','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '102','name' => 'XZeal','created_at' => '2025-02-11 17:28:24','updated_at' => '2025-02-11 17:28:24','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '103','name' => 'Logitech','created_at' => '2025-02-11 17:33:57','updated_at' => '2025-02-11 17:33:57','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '104','name' => 'TechZone','created_at' => '2025-02-11 17:34:02','updated_at' => '2025-02-11 17:34:02','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '105','name' => 'Steren','created_at' => '2025-02-11 17:45:24','updated_at' => '2025-02-11 17:45:24','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '106','name' => 'STUHL','created_at' => '2025-02-12 18:10:54','updated_at' => '2025-02-12 18:10:54','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '107','name' => 'Stylos','created_at' => '2025-03-04 05:58:53','updated_at' => '2025-03-04 05:58:53','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '108','name' => 'ACTECK','created_at' => '2025-05-13 05:09:26','updated_at' => '2025-05-13 05:09:26','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '109','name' => 'OFFICEMAX','created_at' => '2025-05-13 05:30:46','updated_at' => '2025-05-13 05:30:46','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '110','name' => 'MOTOROLA','created_at' => '2025-05-13 11:34:22','updated_at' => '2025-05-13 11:34:22','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '111','name' => 'ADATA','created_at' => '2025-05-19 04:27:53','updated_at' => '2025-05-19 04:27:53','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '112','name' => 'CASIO','created_at' => '2025-05-19 04:28:47','updated_at' => '2025-05-19 04:28:47','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '113','name' => 'JUMBO','created_at' => '2025-05-19 04:44:58','updated_at' => '2025-05-19 04:44:58','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '114','name' => 'HIKVISION','created_at' => '2025-05-19 04:46:40','updated_at' => '2025-05-19 04:46:40','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '115','name' => 'GRANDSTREAM','created_at' => '2025-05-19 09:33:00','updated_at' => '2025-05-19 09:33:00','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '116','name' => 'GHIA','created_at' => '2025-05-21 06:30:57','updated_at' => '2025-05-21 06:30:57','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '117','name' => 'ROYAL','created_at' => '2025-05-29 11:35:35','updated_at' => '2025-05-29 11:35:35','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
            array('id' => '118','name' => 'Genérico','created_at' => '2025-07-11 03:25:59','updated_at' => '2025-07-11 03:25:59','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL)
        );
        
        foreach ($h_brands as $key => $h_brand) {
            HBrand::create([
                'id' => $h_brand["id"],
                'name' => $h_brand["name"], 
                'created_at' => $h_brand["created_at"],
                'updated_at' => $h_brand["updated_at"], 
                'is_active' => $h_brand["is_active"], 
            ]);
        }
    }
}
