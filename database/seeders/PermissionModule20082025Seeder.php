<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule20082025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commission = PermissionModule::where("name", "com")->where("module_type_id", 1)->first();
        PermissionModule::create(["name" => "s_managers", "description" => "Managers de la sucursal", "module_type_id" => 2, "parent_id" => $commission->id]);

    }
}
