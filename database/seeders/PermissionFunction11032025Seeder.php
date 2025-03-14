<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction11032025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionFunction::create([
            'name' => 'storeFromExcel',
            'description' => 'Guardar flujo desde excel'
        ]);
        PermissionFunction::create([
            'name' => 'changeCarteraStatus',
            'description' => 'Cambiar estatus en cartera'
        ]);
        PermissionFunction::create([
            'name' => 'createFromExcel',
            'description' => 'Vista de importar desde excel'
        ]);
        PermissionFunction::create([
            'name' => 'importExcel',
            'description' => 'Importar excel de STP'
        ]);

        PermissionFunction::create([
            'name' => 'getAddModal',
            'description' => 'Ver modal de agregar'
        ]);
    }
}
