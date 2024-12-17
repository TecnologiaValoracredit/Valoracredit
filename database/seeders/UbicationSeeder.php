<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ubication;

class UbicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ubication::create(["name" => "FIMUBAC"]);
        Ubication::create(["name" => "VALORA"]);
        Ubication::create(["name" => "SIN EXPEDIENTE REEST COBRANZA"]);
    }
}
