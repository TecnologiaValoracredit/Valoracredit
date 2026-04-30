<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequisitionGlobalStatus;

class RequisitionGlobalStatus27042026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Revisada por D.G.', 'description' => 'Revisada por D.G., en espera de subir comprobantes para finalizar la global', 'badge' => 'badge-reviewed-dg'],
        ];

        foreach($values as $key => $value){
            RequisitionGlobalStatus::create([
                'name' => $value['name'],
                'description' => $value['description'],
                'badge' => $value['badge'],
            ]);
        }
    }
}
