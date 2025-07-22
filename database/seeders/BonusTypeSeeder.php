<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BonusType;

class BonusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BonusType::create([
            'name'=> 'Bono de Importe de Ventas al mes',
            'description'=> 'Si el importe total de las ventas del mes de un empleado llega a cierta cantidad ',
        ]);

        BonusType::create([
            'name'=> 'Bono para Tecnología',
            'description'=> 'Para el increible equipo de tecnología, no hace falta que hagan nada, solo sean felices ',
        ]);
    }
}
