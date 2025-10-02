<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FExpenseType;

class FExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FExpenseType::create([
            'name'=> 'Fijo',
        ]);

        FExpenseType::create([
            'name'=> 'Variable',
        ]);

         FExpenseType::create([
            'name'=> 'No recurrete',
        ]);
    }
}
