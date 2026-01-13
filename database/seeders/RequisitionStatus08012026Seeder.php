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
        //Actualiza los valores previos
        $previousStatuses = RequisitionStatus::all();
        $previousStatuses[0]->update(["name" => "Creada", "color" => "badge-secondary"]);
        $previousStatuses[1]->update(["name" => "En revisión", "color" => "badge-warning"]);
        $previousStatuses[2]->update(["name" => "Autorizada", "color" => "badge-success"]);
        $previousStatuses[3]->update(["name" => "Rechazada", "color" => "badge-danger"]);

        $values = [
            ["name" => "Enviada", "color" => "badge-primary"],
            ["name" => "Devuelta", "color" => "badge-returned"],
            ["name" => "Cancelada", "color" => "badge-secondary"],
            ["name" => "En espera", "color" => "badge-on-hold"],
            ["name" => "Pagada", "color" => "badge-paid"],
            ["name" => "Pendiente de pago", "color" => "badge-payment-pending"],
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
