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
        //1
        Departament::create([
            "name" => "Tecnología",
            "description" => "Departamento encargado de todo lo relacionado con tecnología, sistemas, redes, software, hardware y soporte técnico.",
        ]);
        //2
        Departament::create([
            "name" => "Cartera",
            "description" => "Departamento encargado de todo lo relacionado con cartera, listados, llamadas de calidad",
        ]);
        //3
        Departament::create([
            "name" => "Contaduria",
            "description" => "",
        ]);
        //4
        Departament::create([
            "name" => "Operaciones",
            "description" => "",
        ]);
        //5
        Departament::create([
            "name" => "Tesoreria",
            "description" => "",
        ]);
        //6
        Departament::create([
            "name" => "Recursos Humanos",
            "description" => "",
        ]);
        //7
        Departament::create([
            "name" => "Marketing",
            "description" => "",
        ]);
         //8
        Departament::create([
            "name" => "Comercial",
            "description" => "",
        ]);
    }
}
