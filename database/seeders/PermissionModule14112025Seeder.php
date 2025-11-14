<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule14112025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $personal = PermissionModule::where("name", "personal")->where("module_type_id", 1)->first();
        PermissionModule::create(["name" => "job_positions", "description" => "Puestos de trabajo", "module_type_id" => 2, "parent_id" => $personal->id]);
        
        //Seeder corregido de modulo de contratos
        PermissionModule::create(["name" => "contracts", "description" => "Contratos", "module_type_id" => 2, "parent_id" => $personal->id]);
    }
}
