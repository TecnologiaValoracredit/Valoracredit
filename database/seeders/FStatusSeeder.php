<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FStatus;

class FStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FStatus::create([
            "name" => "Pendiente",
        ]);
        FStatus::create([
            "name" => "Terminado",
        ]);
    }
}
