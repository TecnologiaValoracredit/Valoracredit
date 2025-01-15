<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FMovementType;

class FMovementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FMovementType::create([
            "name" => "INGRESO",
        ]);
        FMovementType::create([
            "name" => "EGRESO",
        ]);
    }
}
