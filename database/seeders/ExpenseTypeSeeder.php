<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseType;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Impuestos', 'description' => 'Gastos de impuestos'],
            ['name' => 'Gasolina', 'description' => 'Gastos de gasolina'],
            ['name' => 'TI', 'description' => 'Gastos de TI'],
            ['name' => 'Contabilidad', 'description' => 'Gastos de contabilidad'],
        ];

        foreach ($values as $key => $value) {
            ExpenseType::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
    }
}
