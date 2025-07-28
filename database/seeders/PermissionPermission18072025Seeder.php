<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction   ;
use App\Models\PermissionPermission;

class PermissionPermission18072025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$permission_permissions = array(
  array('id' => '1','module_id' => '1','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '2','module_id' => '3','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '3','module_id' => '3','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '4','module_id' => '3','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '5','module_id' => '3','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '6','module_id' => '3','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '7','module_id' => '3','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '8','module_id' => '3','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '9','module_id' => '4','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '10','module_id' => '4','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '11','module_id' => '4','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '12','module_id' => '4','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '13','module_id' => '4','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '14','module_id' => '4','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '15','module_id' => '4','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '16','module_id' => '5','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '17','module_id' => '5','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '18','module_id' => '5','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '19','module_id' => '5','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '20','module_id' => '5','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '21','module_id' => '5','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '22','module_id' => '5','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '23','module_id' => '4','function_id' => '8','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '24','module_id' => '4','function_id' => '9','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '25','module_id' => '7','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '26','module_id' => '7','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '27','module_id' => '7','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '28','module_id' => '7','function_id' => '16','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '29','module_id' => '8','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '30','module_id' => '9','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '31','module_id' => '9','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '32','module_id' => '9','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '33','module_id' => '9','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '34','module_id' => '9','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '35','module_id' => '9','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '36','module_id' => '9','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '37','module_id' => '11','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '38','module_id' => '11','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '39','module_id' => '11','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '40','module_id' => '11','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '41','module_id' => '11','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '42','module_id' => '11','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '43','module_id' => '11','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '44','module_id' => '12','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '45','module_id' => '12','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '46','module_id' => '12','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '47','module_id' => '12','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '48','module_id' => '12','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '49','module_id' => '12','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '50','module_id' => '12','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '51','module_id' => '13','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '52','module_id' => '13','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '53','module_id' => '13','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '54','module_id' => '13','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '55','module_id' => '13','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '56','module_id' => '13','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '57','module_id' => '13','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '58','module_id' => '15','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '59','module_id' => '17','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '60','module_id' => '18','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '61','module_id' => '19','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '62','module_id' => '20','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '63','module_id' => '22','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '64','module_id' => '22','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '65','module_id' => '22','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '66','module_id' => '22','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '67','module_id' => '22','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '68','module_id' => '22','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '69','module_id' => '22','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '70','module_id' => '23','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '71','module_id' => '23','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '72','module_id' => '23','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '73','module_id' => '23','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '74','module_id' => '23','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '75','module_id' => '23','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '76','module_id' => '23','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '77','module_id' => '24','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '78','module_id' => '24','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '79','module_id' => '24','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '80','module_id' => '24','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '81','module_id' => '24','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '82','module_id' => '24','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '83','module_id' => '24','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '84','module_id' => '22','function_id' => '13','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '85','module_id' => '26','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '86','module_id' => '26','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '87','module_id' => '26','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '88','module_id' => '26','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '89','module_id' => '26','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '90','module_id' => '26','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '91','module_id' => '26','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '92','module_id' => '27','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '93','module_id' => '27','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '94','module_id' => '27','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '95','module_id' => '27','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '96','module_id' => '27','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '97','module_id' => '27','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '98','module_id' => '27','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '99','module_id' => '28','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '100','module_id' => '28','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '101','module_id' => '28','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '102','module_id' => '28','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '103','module_id' => '28','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '104','module_id' => '28','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '105','module_id' => '28','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '106','module_id' => '26','function_id' => '10','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '107','module_id' => '26','function_id' => '11','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '108','module_id' => '26','function_id' => '12','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '109','module_id' => '30','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '110','module_id' => '30','function_id' => '14','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '111','module_id' => '30','function_id' => '15','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '112','module_id' => '29','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '113','module_id' => '29','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '114','module_id' => '29','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '115','module_id' => '29','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '116','module_id' => '29','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '117','module_id' => '29','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '118','module_id' => '29','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '119','module_id' => '16','function_id' => '1','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '120','module_id' => '16','function_id' => '2','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '121','module_id' => '16','function_id' => '3','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '122','module_id' => '16','function_id' => '4','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '123','module_id' => '16','function_id' => '5','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '124','module_id' => '16','function_id' => '6','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '125','module_id' => '16','function_id' => '7','created_at' => '2025-01-24 17:57:36','updated_at' => '2025-01-24 17:57:36'),
  array('id' => '126','module_id' => '30','function_id' => '1','created_at' => '2025-01-31 11:09:31','updated_at' => '2025-01-31 11:09:31'),
  array('id' => '127','module_id' => '30','function_id' => '18','created_at' => '2025-01-31 11:09:31','updated_at' => '2025-01-31 11:09:31'),
  array('id' => '128','module_id' => '26','function_id' => '19','created_at' => '2025-03-14 11:12:36','updated_at' => '2025-03-14 11:12:36'),
  array('id' => '129','module_id' => '26','function_id' => '20','created_at' => '2025-03-14 11:12:36','updated_at' => '2025-03-14 11:12:36'),
  array('id' => '130','module_id' => '26','function_id' => '21','created_at' => '2025-03-14 11:12:36','updated_at' => '2025-03-14 11:12:36'),
  array('id' => '131','module_id' => '26','function_id' => '22','created_at' => '2025-03-14 11:12:36','updated_at' => '2025-03-14 11:12:36'),
  array('id' => '132','module_id' => '28','function_id' => '23','created_at' => '2025-03-14 11:12:36','updated_at' => '2025-03-14 11:12:36'),
  array('id' => '133','module_id' => '31','function_id' => '1','created_at' => '2025-06-26 10:25:47','updated_at' => '2025-06-26 10:25:47'),
  array('id' => '134','module_id' => '32','function_id' => '1','created_at' => '2025-07-18 10:33:53','updated_at' => '2025-07-18 10:33:53')
);

        foreach ($permission_permissions as $key => $permission_permission) {
            PermissionPermission::create([
                'id' => $permission_permission["id"],
                'module_id' => $permission_permission["module_id"], 
                'function_id' => $permission_permission["function_id"], 
                'created_at' => $permission_permission["created_at"],
                'updated_at' => $permission_permission["updated_at"], 
            ]);
        }


        //Crear permisos
		// $this->createPermissions(["s_coordinators"]);
		$this->createPermissions(["s_promotors"]);
		$this->createPermissions(["commissions"], ["exportReport"]);
		$this->createPermissions(["s_sales"], ["importExcel"], false);
		$this->createPermissions(["s_branches"]);
    }

    public function createPermissions($moduleNames = [], $functionNames = [], $addCrudFunctions = true) {
		$defaultFunctions = ["index","store","create","show","update","destroy","edit"];
		$modules = PermissionModule::where("module_type_id", 2)->whereIn("name", $moduleNames)->get();
		if($addCrudFunctions) {
			$functionNames = array_merge($defaultFunctions, $functionNames);
		}
		$functions = PermissionFunction::whereIn("name", $functionNames)->get();
		
		foreach ($modules as $key => $module) {
			foreach ($functions as $key => $function) {
				PermissionPermission::create(["module_id" => $module->id, "function_id" => $function->id]);
			}
		}
	}
}
