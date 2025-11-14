<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobPosition;


class JobPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // JobPosition::create([
        //     'name'=> 'Aux TI',
        //     'description' =>'Auxiliar de TI'
        // ]);

        $positions = [
            ["name" => "Analista de cartera", "description" => "Evalua el rendimiento de las inversiones", "departament_id" => "2"],
            ["name" => "Contador", "description" => "Contador general", "departament_id" => "3"],
            ["name" => "Cord Operaciones", "description" => "Coordinador de operaciones", "departament_id" => "4"],
            ["name" => "Aux Tesoreria", "description" => "Auxiliar de Tesoreria", "departament_id" => "5"],
            ["name" => "Reclutador", "description" => "Reclutador de Recursos Humanos", "departament_id" => "6"],
            ["name" => "Cord Marketing", "description" => "Coordinador de marketing", "departament_id" => "7"],
            ["name" => "Recepcionista", "description" => "Recepcionista", "departament_id" => "8"],

            ["name" => "Cord Operaciones/Maxxas", "description" => "Coordinador de operaciones de Maxxas", "departament_id" => "9"],
            ["name" => "Aux Tesoreria/Maxxas", "description" => "Auxiliar de Tesoreria de Maxxas", "departament_id" => "10"],
            ["name" => "Contador/Maxxas", "description" => "Contador general de Maxxas", "departament_id" => "11"],
            ["name" => "Aux Facturacion/Maxxas", "description" => "Auxiliar de facturacion", "departament_id" => "12"],
        ];

        foreach ($positions as $key => $value) {
            JobPosition::create([
                'name' => $value["name"],
                'description' => $value["description"],
                'departament_id' => $value["departament_id"],
            ]);
        }
    }
}
