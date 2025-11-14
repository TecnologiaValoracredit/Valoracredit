<?php

namespace Database\Seeders;

use App\Models\Departament;
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
        Departament::create([
            'id' => 15,
            'name' => 'Administración',
            'is_active' => true,
        ]);

        $positions = [
            ["name" => "Contador",'is_active' => true, "departament_id" => "3"],
            ["name" => "Auxiliar contable administrativa", 'is_active' => true, "departament_id" => "3"],
            ["name" => "Coordinador de TI", 'is_active' => true, "departament_id" => "1"],
            ["name" => "Tesorera", 'is_active' => true, "departament_id" => "5"],
            ["name" => "Administrador de Cartera", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Analista de Cartera", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Ventas Telemarketing", 'is_active' => true, "departament_id" => "14"],
            ["name" => "Auxiliar de procesos", 'is_active' => true, "departament_id" => "4"],
            ["name" => "Coordinador de RH", 'is_active' => true, "departament_id" => "6"],
            ["name" => "Analista de crédito", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Analista de Cartera", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Auxiliar tesorería", 'is_active' => true, "departament_id" => "5"],
            ["name" => "Auxiliar contable administrativa", 'is_active' => true, "departament_id" => "3"],
            ["name" => "Gerente de ventas", 'is_active' => true, "departament_id" => "14"],
            ["name" => "Analista de pagos", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Aux contable", 'is_active' => true, "departament_id" => "3"],
            ["name" => "Asistente dirección", 'is_active' => true, "departament_id" => "15"],
            ["name" => "Validadora telefónica", 'is_active' => true, "departament_id" => "14"],
            ["name" => "Bancos", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Controlador interno", 'is_active' => true, "departament_id" => "4"],
            ["name" => "Controlador operativo", 'is_active' => true, "departament_id" => "4"],
            ["name" => "Analista de egresos", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Analista de ingresos", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Gerente de Sucursal", 'is_active' => true, "departament_id" => "15"],
            ["name" => "Ejecutiva de cobranza", 'is_active' => true, "departament_id" => "2"],
            ["name" => "Aux de TI", 'is_active' => true, "departament_id" => "1"],
            ["name" => "Vendedora", 'is_active' => true, "departament_id" => "14"],
            ["name" => "Aux administrativo y caja", 'is_active' => true, "departament_id" => "15"],
        ];

        foreach ($positions as $key => $value) {
            JobPosition::create([
                'name' => $value["name"],
                'departament_id' => $value["departament_id"],
            ]);
        }
    }
}
