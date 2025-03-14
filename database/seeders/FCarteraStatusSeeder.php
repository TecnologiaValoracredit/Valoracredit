<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FCarteraStatus;

class FCarteraStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FCarteraStatus::create([
            "name" => "Pendiente",
        ]);
        FCarteraStatus::create([
            "name" => "Aplicado",
        ]);
    }
}
