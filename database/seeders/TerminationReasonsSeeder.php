<?php

namespace Database\Seeders;

use App\Models\TerminationReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TerminationReasonSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Renuncia voluntaria', 'description' => 'Renuncia voluntaria por parte del trabajador'],
            ['name' => 'Terminación de contrato', 'description' => 'Terminación de contrato entre la empresa y el trabajador'],
            ['name' => 'Resición de contrato', 'description' => 'Recisión de contrato'],
            ['name' => 'Jubilación', 'description' => 'Jubilación'],
            ['name' => 'Defunción', 'description' => 'Defunción'],
        ];

        foreach ($values as $key => $value) {
            TerminationReason::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }

        $volunteeredResignationId = TerminationReason::where('name', 'Renuncia voluntaria')->first()->id;

        $subValues = [
            ['name' => 'Motivos familiares/personales', 'parent_id' => $volunteeredResignationId],
            ['name' => 'Falta de prestaciones', 'parent_id' => $volunteeredResignationId],
            ['name' => 'Problemas con jefe inmediato', 'parent_id' => $volunteeredResignationId],
            ['name' => 'Ambiente laboral', 'parent_id' => $volunteeredResignationId],
            ['name' => 'Mejor oportunidad laboral', 'parent_id' => $volunteeredResignationId],
            ['name' => 'Incumplimiento con las funciones del puesto', 'parent_id' => $volunteeredResignationId],
        ];

        foreach ($subValues as $key => $subReason) {
            TerminationReason::create([
                'name' => $subReason['name'],
                'parent_id' => $subReason['parent_id'],
            ]);
        }

    }
}
