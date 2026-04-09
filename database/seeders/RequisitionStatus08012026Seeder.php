<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequisitionStatus;

class RequisitionStatus08012026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borra todos los estatus anteriores
        RequisitionStatus::query()->delete();

        $values = [
        ["name" => "Creada", "color" => "badge-created"],
        ["name" => "Cancelada", "color" => "badge-cancelled"],

        ["name" => "Enviada a Jefe Inmediato", "color" => "badge-sent"],
        ["name" => "Devuelta por Jefe Inmediato", "color" => "badge-returned"],
        ["name" => "Rechazada por Jefe Inmediato", "color" => "badge-rejected"],
        ["name" => "Aprobada por Jefe Inmediato", "color" => "badge-approved"],

        ["name" => "Enviada a Tesoreria", "color" => "badge-sent"],
        ["name" => "En revisión - Tesoreria", "color" => "badge-review"],
        ["name" => "En espera - Tesoreria", "color" => "badge-on-hold"],
        ["name" => "Devuelta por Tesoreria", "color" => "badge-returned"],
        
        ["name" => "Enviada a Contabilidad", "color" => "badge-sent"],
        ["name" => "Poliza cargada", "color" => "badge-loaded"],
        ["name" => "Rechazada por Contabilidad", "color" => "badge-rejected"],
        ["name" => "Devuelta por Contabilidad", "color" => "badge-returned"],
        
        ["name" => "Revisión Global", "color" => "badge-global"],
        ["name" => "Devuelta de Revisión Global", "color" => "badge-returned"],
        
        ["name" => "Rechazada por Administración", "color" => "badge-rejected"],

        ["name" => "Enviada a D.G.", "color" => "badge-sent"],
        ["name" => "Lista para D.G.", "color" => "badge-ready"],
        ["name" => "En revisión - D.G.", "color" => "badge-review"],
        ["name" => "Autorizada por D.G.", "color" => "badge-authorized"],
        ["name" => "Devuelta por D.G.", "color" => "badge-returned"],
        ["name" => "Rechazada por D.G.", "color" => "badge-rejected"],

        ["name" => "Pagada", "color" => "badge-paid"],
        ];

        foreach ($values as $key => $value){
            RequisitionStatus::create([
                "name" => $value['name'],
                "color" => $value['color'],
                "is_active" => 1,
            ]);
        }
    }
}
