<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Contrato de planta', 'contract_type_id' => 1, 'content' => 'CONTENIDO PARA LABORAR DE MANERA INDEFINIDA'],
            ['name' => 'Contrato de temporada', 'contract_type_id' => 2, 'content' => 'CONTENIDO PARA LABORAR POR UNA TEMPORADA DEFINIDA'],
            ['name' => 'Contrato de planta', 'contract_type_id' => 3, 'content' => 'CONTENIDO PARA LABORAR POR UN TIEMPO DE PRUEBA'],
        ];

        foreach ($values as $key => $value) {
            Contract::create([
                'name' => $value['name'],
                'contract_type_id' => $value['contract_type_id'],
                'content' => $value['content'],
            ]);
        }
    }
}
