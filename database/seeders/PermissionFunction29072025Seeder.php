<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction29072025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionFunction::create([
            'name' => 'editCommissionPercentages',
            'description' => 'Modificar los porcentajes de comusion de los promotores/coordinadores'
        ]);
    }
}
