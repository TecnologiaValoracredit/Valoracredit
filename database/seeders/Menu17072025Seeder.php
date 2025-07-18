<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionPermission;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;

class Menu17072025Seeder extends MenuSeeder
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
            "name" => "Reporte indicadores",
            "parent_id" => $s_sales->id,
            "position" => 2.8,
            "permission_id" => $this->getPermissionId("r_indicators")
        ]);

    }

   
}
