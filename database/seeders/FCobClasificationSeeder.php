<?php

namespace Database\Seeders;

use App\Models\FCobClasification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FCobClasificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FCobClasification::create([
            "name" => "Cobranza despacho",
        ]);
        FCobClasification::create([
            "name" => "Cobranza institucional",
        ]);
        FCobClasification::create([
            "name" => "Cobranza telemarketing",
        ]);
        FCobClasification::create([
            "name" => "Liq. clientes",
        ]);
    }
}
