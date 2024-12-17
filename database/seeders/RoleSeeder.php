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
        Role::create([
            "name" => "Admin",
            "description" => "Admin"
        ]);
        Role::create([
            "name" => "Gerencia Cartera",
            "description" => "Encargados de cartera"
        ]);
    }
}
