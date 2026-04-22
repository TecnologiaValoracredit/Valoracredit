<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequisitionStatus;

class RequisitionStatus20042026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ["name" => "Creada", "color" => "badge-created"],
            ["name" => "Cancelada", "color" => "badge-cancelled"],

            ["name" => "Enviada a Jefe Inmediato", "color" => "badge-sent-boss"],
            ["name" => "Devuelta por Jefe Inmediato", "color" => "badge-returned-boss"],
            ["name" => "Rechazada por Jefe Inmediato", "color" => "badge-rejected-boss"],
            ["name" => "Aprobada por Jefe Inmediato", "color" => "badge-approved-boss"],

            ["name" => "Enviada a Tesoreria", "color" => "badge-sent-treasury"],
            ["name" => "En revisión - Tesoreria", "color" => "badge-review-treasury"],
            ["name" => "En espera - Tesoreria", "color" => "badge-on-hold-treasury"],
            ["name" => "Devuelta por Tesoreria", "color" => "badge-returned-treasury"],

            ["name" => "Enviada a Contabilidad", "color" => "badge-sent-accounting"],
            ["name" => "Poliza cargada", "color" => "badge-loaded-accounting"],
            ["name" => "Rechazada por Contabilidad", "color" => "badge-rejected-accounting"],
            ["name" => "Devuelta por Contabilidad", "color" => "badge-returned-accounting"],

            ["name" => "Revisión Global", "color" => "badge-global"],
            ["name" => "Devuelta de Revisión Global", "color" => "badge-returned-global"],

            ["name" => "Rechazada por Administración", "color" => "badge-rejected-administration"],

            ["name" => "Enviada a D.G.", "color" => "badge-sent-dg"],
            ["name" => "Lista para D.G.", "color" => "badge-ready-dg"],
            ["name" => "En revisión - D.G.", "color" => "badge-review-dg"],
            ["name" => "Autorizada por D.G.", "color" => "badge-authorized-dg"],
            ["name" => "Devuelta por D.G.", "color" => "badge-returned-dg"],
            ["name" => "Rechazada por D.G.", "color" => "badge-rejected-dg"],

            ["name" => "Pagada", "color" => "badge-paid"],
        ];

        foreach ($values as $value) {
            RequisitionStatus::where('name', $value['name'])
                ->update([
                    'color' => $value['color'],
            ]);
        }
    }
}
