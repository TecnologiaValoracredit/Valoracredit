<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            "id" => 1,
            "name" => "ValoraCredit",
            "location" => 'Carr Nacional No. 5002, Villas La Rioja, 64988 Monterrey, N.L. Torre B, Piso 7, 708'
        ]);

        Company::create([
            "id" => 2,
            "name" => "Grupo Maxas",
            "location" => 'Carr Nacional No. 5002, Villas La Rioja, 64988 Monterrey, N.L. Torre B, Piso 7, 709'
        ]);
    }
}
