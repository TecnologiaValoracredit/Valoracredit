<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departament;

class DepartamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departament::create([
            "name" => "Tecnología",
            "description" => "Departamento encargado de todo lo relacionado con tecnología, sistemas, redes, software, hardware y soporte técnico.",
        ]);

        Departament::create([
            "name" => "Cartera",
            "description" => "Departamento encargado de todo lo relacionado con cartera, listados, llamadas de calidad",
        ]);
    }
}
