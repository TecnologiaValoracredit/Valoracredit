<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1//
        Role::create([
            "name" => "Admin",
            "description" => "Admin"
        ]);
        //2//
        Role::create([
            "name" => "Gerencia Cartera",
            "description" => "Encargados de cartera"
        ]);
        //3//
        Role::create([
            "name" => "Tesorería",
            "description" => ""
        ]);
        //4//
        Role::create([
            "name" => "Administración",
            "description" => ""
        ]);
        //5//
        Role::create([
            "name" => "Contabilidad",
            "description" => ""
        ]);
        //6//
        Role::create([
            "name" => "Recursos Humanos",
            "description" => ""
        ]);
        //7//
        Role::create([
            "name" => "Cartera",
            "description" => ""
        ]);
        //8//
        Role::create([
            "name" => "Marketing",
            "description" => ""
        ]);
        //9//
        Role::create([
            "name" => "Tecnología",
            "description" => ""
        ]);
        //10//
        Role::create([
            "name" => "Operaciones",
            "description" => ""
        ]);
        //11//
        Role::create([
            "name" => "Cobranza",
            "description" => ""
        ]);

        //12
        Role::create([
            "name" => "Promotor",
            "description" => ""
        ]);
        //13
        Role::create([
            "name" => "Coordinador",
            "description" => ""
        ]);
        
    }
}
