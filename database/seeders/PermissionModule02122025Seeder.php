<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule02122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $personal = PermissionModule::where("name", "personal")->where("module_type_id", 1)->first();
        PermissionModule::create(["name" => "contract_types", "description" => "Tipos de contratos", "module_type_id" => 2, "parent_id" => $personal->id]);
    }
}
