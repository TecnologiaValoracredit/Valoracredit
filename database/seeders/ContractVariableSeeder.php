<?php

namespace Database\Seeders;

use App\Models\ContractVariable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractVariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $values = [

            // ------- DIRECTOS -------
            ['name' => 'Nombre del empleado', 'key_detection' => '{{NOMBRE}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'name', 'description' => 'Nombre del usuario'],

            ['name' => 'CURP del empleado', 'key_detection' => '{{CURP}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'curp', 'description' => 'CURP del usuario'],

            ['name' => 'RFC del empleado', 'key_detection' => '{{RFC}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'rfc', 'description' => 'RFC del usuario'],

            ['name' => 'Calle', 'key_detection' => '{{CALLE}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'residential_address', 'description' => 'Calle del usuario'],

            ['name' => 'Colonia', 'key_detection' => '{{COLONIA}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'colony', 'description' => 'Colonia del usuario'],

            ['name' => 'Municipio', 'key_detection' => '{{MUNICIPIO}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'municipality', 'description' => 'Municipio del usuario'],

            ['name' => 'Código Postal', 'key_detection' => '{{CODIGO POSTAL}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'postal_code', 'description' => 'C.P. del usuario'],

            ['name' => 'Fecha de ingreso', 'key_detection' => '{{FECHA DE INGRESO}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'entry_date', 'description' => 'Fecha de ingreso'],

            ['name' => 'Fecha de nacimiento', 'key_detection' => '{{FECHA DE NACIMIENTO}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'birthday', 'description' => 'Fecha de nacimiento'],

            ['name' => 'Sueldo mensual', 'key_detection' => '{{SUELDO MENSUAL}}',
                'model' => 'App\Models\User', 'type' => 'column',
                'model_column' => 'salary', 'description' => 'Sueldo mensual'],


            // ------- RELACIONADOS -------
            ['name' => 'Puesto de trabajo', 'key_detection' => '{{PUESTO DE TRABAJO}}',
                'model' => 'App\Models\User', 'type' => 'relation',
                'relation_name' => 'jobPosition', 'relation_column' => 'name',
                'description' => 'Nombre del puesto del usuario'],
        ];

        foreach ($values as $value) {
            ContractVariable::create($value);
        }

    }
}
