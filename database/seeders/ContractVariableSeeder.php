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
            ['name' => 'Nombre del empleado', 'key_detection' => '{{NOMBRE}}', 'model' => 'App\Models\User', 'model_column' => 'name', 'description' => 'Reemplaza la llave de deteccion por el nombre del usuario'],
            ['name' => 'CURP del empleado', 'key_detection' => '{{CURP}}', 'model' => 'App\Models\User', 'model_column' => 'curp', 'description' => 'Reemplaza la llave de deteccion por el curp del usuario'],
            ['name' => 'RFC del empleado', 'key_detection' => '{{RFC}}', 'model' => 'App\Models\User', 'model_column' => 'rfc', 'description' => 'Reemplaza la llave de deteccion por el rfc del usuario'],
            ['name' => 'Calle de la dirección del empleado', 'key_detection' => '{{CALLE}}', 'model' => 'App\Models\User', 'model_column' => 'residential_address', 'description' => 'Reemplaza la llave de deteccion por la calle de la dirección del usuario'],
            ['name' => 'Colonia de la dirección del empleado', 'key_detection' => '{{COLONIA}}', 'model' => 'App\Models\User', 'model_column' => 'colony', 'description' => 'Reemplaza la llave de deteccion por la colonia de la dirección del usuario'],
            ['name' => 'Municipio de la dirección del empleado', 'key_detection' => '{{MUNICIPIO}}', 'model' => 'App\Models\User', 'model_column' => 'municipality', 'description' => 'Reemplaza la llave de deteccion por el municipio de la dirección del usuario'],
            ['name' => 'Codigo postal de la dirección del empleado', 'key_detection' => '{{CODIGO POSTAL}}', 'model' => 'App\Models\User', 'model_column' => 'postal_code', 'description' => 'Reemplaza la llave de deteccion por el codigo postal de la dirección del usuario'],
            ['name' => 'Fecha de ingreso del empleado', 'key_detection' => '{{FECHA DE INGRESO}}', 'model' => 'App\Models\User', 'model_column' => 'entry_date', 'description' => 'Reemplaza la llave de deteccion por la fecha de ingreso del usuario'],
            ['name' => 'Fecha de nacimiento del empleado', 'key_detection' => '{{FECHA DE NACIMIENTO}}', 'model' => 'App\Models\User', 'model_column' => 'birthday', 'description' => 'Reemplaza la llave de deteccion por la fecha de nacimiento del usuario'],
            ['name' => 'Puesto de trabajo del empleado', 'key_detection' => '{{PUESTO DE TRABAJO}}', 'model' => 'App\Models\User', 'model_column' => 'job_position', 'description' => 'Reemplaza la llave de deteccion por el puesto de trabajo del usuario'],
            ['name' => 'Sueldo del empleado', 'key_detection' => '{{SUELDO MENSUAL}}', 'model' => 'App\Models\User', 'model_column' => 'salary', 'description' => 'Reemplaza la llave de deteccion por el sueldo mensual del usuario'],
        ];

        foreach ($values as $key => $value){
            ContractVariable::create([
                'name' => $value['name'],
                'key_detection' => $value['key_detection'],
                'model' => $value['model'],
                'model_column' => $value['model_column'],
                'description' => $value['description'],
            ]);
        }
    }
}
