<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BonusQuantityType;

class BonusQuantityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BonusQuantityType::create([
            'name'=> 'Dinero',
            'description'=> '$',
        ]);

        BonusQuantityType::create([
            'name'=> 'Porcentaje',
            'description'=> '%',
        ]);
    }
}
