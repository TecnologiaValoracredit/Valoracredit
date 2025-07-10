<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionPermission;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;

class Menu25062025Seeder extends MenuSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s_sales = Menu::where("name", "Ventas")->first();

        Menu::create([
            "name" => "Reporte ranking",
            "parent_id" => $s_sales->id,
            "position" => 2.7,
            "permission_id" => $this->getPermissionId("s_promotor_reports")
        ]);

    }

   
}
