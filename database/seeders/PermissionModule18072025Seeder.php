<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;


class PermissionModule18072025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commissions = PermissionModule::create(["name" => "com", "description" => "Comisiones", "module_type_id" => 1]);
        PermissionModule::create(["name" => "s_coordinators",  "description" => "Coordinadores", "module_type_id" => 2, "parent_id" => $commissions->id]);
        PermissionModule::create(["name" => "s_promotors",  "description" => "Promotores", "module_type_id" => 2, "parent_id" => $commissions->id]);
        PermissionModule::create(["name" => "commissions",  "description" => "Comisiones", "module_type_id" => 2, "parent_id" => $commissions->id]);
    }
}
