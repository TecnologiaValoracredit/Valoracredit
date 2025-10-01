<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule21082025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requisition = PermissionModule::where("name", "req")->where("module_type_id", 1)->first();
        PermissionModule::create(["name" => "requisition_rows", "description" => "Productos de requisición", "module_type_id" => 2, "parent_id" => $requisition->id]);

    }
}
