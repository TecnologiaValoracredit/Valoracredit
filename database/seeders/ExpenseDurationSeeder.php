<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseDuration;

class ExpenseDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Unico', 'days' => 0],
            ['name' => 'Semanal', 'days' => 7],
            ['name' => 'Mensual', 'days' => 30],
            ['name' => 'Bimestral', 'days' => 60],
            ['name' => 'Trimestral', 'days' => 90],
            ['name' => 'Semestral', 'days' => 180],
            ['name' => 'Anual', 'days' => 365],
        ];

        foreach ($values as $key => $value) {
            ExpenseDuration::create([
                'name' => $value['name'],
                'days' => $value['days'],
            ]);
        }
    }
}
