<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule19052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vac_menu = PermissionModule::create(['name' => 'vac', 'description' => 'Vacaciones', 'module_type_id' => 1]);
        PermissionModule::create(['name' => 'vacations', 'description' => 'Vacaciones', 'module_type_id' => 2, 'parent_id' => $vac_menu->id]);
        PermissionModule::create(['name' => 'vacation_policies', 'description' => 'Políticas de vacaciones', 'module_type_id' => 2, 'parent_id' => $vac_menu->id]);
        PermissionModule::create(['name' => 'vacation_balances', 'description' => 'Balances de vacaciones', 'module_type_id' => 2, 'parent_id' => $vac_menu->id]);
    }
}
