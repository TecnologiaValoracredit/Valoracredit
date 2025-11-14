<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractType;

class ContractTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Tiempo Indeterminado', 'description' => 'Contrato por tiempo indefinido'],
            ['name' => 'Tiempo Determinado', 'description' => 'Contrato por tiempo definido'],
            ['name' => 'Tiempo de Prueba', 'description' => 'Contrato por tiempo un tiempo de prueba'],
        ];

        foreach ($values as $key => $value) {
            ContractType::create([
                'name' => $value['name'],
                'description' => $value['description']
            ]);
        }
    }
}
