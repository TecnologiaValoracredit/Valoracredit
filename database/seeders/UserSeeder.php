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
            "email" => "tecnologia@vaoracredit.mx",
            "password" => Hash::make("Valora2024"),
            "role_id" => 1,
            "departament_id" => 1
        ]);

        User::create([
            "name" => "Perla Alejandra Sauceda",
            "email" => "cartera@valoracredit.mx",
            "password" => Hash::make("Cartera2024"),
            "role_id" => 2,
            "departament_id" => 2
        ]);
    }
}
