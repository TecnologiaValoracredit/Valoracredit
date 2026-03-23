<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule20022026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expenses_menu = PermissionModule::create(['name' => 'expenses', 'description' => 'Gastos', 'module_type_id' => 1]);
        PermissionModule::create(['name' => 'expense_types', 'description' => 'Tipos de Gastos', 'module_type_id' => 2, 'parent_id' => $expenses_menu->id]);
        PermissionModule::create(['name' => 'fixed_expenses', 'description' => 'Gastos fijos', 'module_type_id' => 2, 'parent_id' => $expenses_menu->id]);
    }
}
