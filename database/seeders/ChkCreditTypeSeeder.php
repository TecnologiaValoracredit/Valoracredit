<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChkCreditType;

class ChkCreditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChkCreditType::create([
            'name'=> 'Nuevo', 
        ]);

        ChkCreditType::create([
            'name'=> 'Reestructura',
          
        ]);
    }
}
