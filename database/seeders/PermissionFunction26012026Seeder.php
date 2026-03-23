<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction26012026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'changeStatus', 'description' => 'Cambiar estatus'],
            ['name' => 'updateStatus', 'description' => 'Actualizar estatus'],

            ['name' => 'send', 'description' => 'Mandar'],
            ['name' => 'sign', 'description' => 'Firmar'],
            ['name' => 'deny', 'description' => 'Denegar'],
            ['name' => 'exportPdf', 'description' => 'Exportar a pdf'],

            ['name' => 'review', 'description' => 'Revisar'],
            ['name' => 'approve', 'description' => 'Aprobar'],
            
            ['name' => 'return', 'description' => 'Devolver'],
            ['name' => 'cancel', 'description' => 'Cancelar'],
            ['name' => 'chargePolicy', 'description' => 'Cargar poliza'],

            ['name' => 'payment', 'description' => 'Ver pago'],
            ['name' => 'uploadPayment', 'description' => 'Subir pago'],
            
            ['name' => 'boss', 'description' => 'Recibir acciones de Jefe Inmediato'],
            ['name' => 'treasury', 'description' => 'Recibir acciones de Tesoreria'],
            ['name' => 'accounting', 'description' => 'Recibir acciones de Contabilidad'],
            ['name' => 'administration', 'description' => 'Recibir acciones de Administración'],
            ['name' => 'dg', 'description' => 'Recibir acciones de Dirección General'],

            ['name' => 'getFields', 'description' => 'Obtener los campos de un modulo'],
            ['name' => 'adminSignature', 'description' => 'Permite firmar como todos los responsables'],
        ];

        foreach ($values as $key => $value) {
            PermissionFunction::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
    }
}
