<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction02122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionFunction::create([
            'name' => 'exportContract',
            'description' => 'Exportar y ver contratos de usuario y vista previa'
        ]);
        PermissionFunction::create([
            'name' => 'downloadContract',
            'description' => 'Descargar/ver contrato'
        ]);
        PermissionFunction::create([
            'name' => 'deleteContract',
            'description' => 'Eliminar contrato de usuario'
        ]);
        PermissionFunction::create([
            'name' => 'addUserContractSigned',
            'description' => 'Agregar contrato firmado a usuario'
        ]);
    }
}
