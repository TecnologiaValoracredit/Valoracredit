<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Importar la fachada Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Iván Rodríguez Silva",
            "email" => "tecnologia@valoracredit.mx",
            "password" => Hash::make("Valora2024"),
            "role_id" => 1,
            "departament_id" => 1,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Perla Alejandra Sauceda",
            "email" => "cartera@valoracredit.mx",
            "password" => Hash::make("Cartera2024"),
            "role_id" => 2,
            "departament_id" => 2,
            "branch_id" => 1
        ]);
        User::create([
            "name" => "Iván Alejandro Rodriguez",
            "email" => "auxtecnologia@valoracredit.mx",
            "password" => Hash::make("Asdf.357*"),
            "role_id" => 1,
            "departament_id" => 1,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Ana Karina Chapa Almaguer",
            "email" => "tesoreria@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 3,
            "departament_id" => 5,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Francisco Sánchez Flores",
            "email" => "fsanchez@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 5,
            "departament_id" => 3,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Rosa Nelly Garcia Cepeda",
            "email" => "operaciones@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 10,
            "departament_id" => 4,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Sabrina Anizul de la Cruz Leal",
            "email" => "auxtesoreria@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 3,
            "departament_id" => 5,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Flor Esthela Garcia Garcia",
            "email" => "telemarketing@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 7,
            "departament_id" => 2,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Elisa Ariana Lopez Aguilar",
            "email" => "cobranza@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 7,
            "departament_id" => 2,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Denise Idalia Gonzalez Garcia",
            "email" => "rh@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 6,
            "departament_id" => 6,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Katia Ivett Aguilar Cias",
            "email" => "analistacredito@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 10,
            "departament_id" => 4,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Ana Yareli Hernandez Hernandez",
            "email" => "coordinaciondigital@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 8,
            "departament_id" => 7,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Seydel Silvana Celeste Lopez Hugo",
            "email" => "auxcontable1@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 5,
            "departament_id" => 3,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Ramon Alberto Zapata Cruz",
            "email" => "administracioncartera@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 7,
            "departament_id" => 2,
            "branch_id" => 1
        ]);

        User::create([
            "name" => "Leticia Medina Acevedo",
            "email" => "analistacartera@valoracredit.mx",
            "password" => Hash::make("Valora2025"),
            "role_id" => 7,
            "departament_id" => 2,
            "branch_id" => 1
        ]);

        

    }
}
