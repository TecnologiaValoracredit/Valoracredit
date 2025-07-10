<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule25062025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s_sales = PermissionModule::where("name", "s_sal")->where("module_type_id", 1)->first();
        PermissionModule::create(["name" => "s_promotor_reports", "module_type_id" => 2, "parent_id" => $s_sales->id]);

    }
}
