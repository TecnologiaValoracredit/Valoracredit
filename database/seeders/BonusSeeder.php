<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bonus;

class BonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bonus::create([
            'name'=> 'Bono de venta de $100,000 al mes',
            'description'=> 'Bono cuando las ventas del mes igualan o superan los $100,000',
            'quantity_objective'=> 100000,
            'quantity_type_id'=> 1,
            'bonus_type_id'=> 1
        ]);

        
    }
}
